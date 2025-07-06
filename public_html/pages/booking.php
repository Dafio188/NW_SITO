<?php
require_once __DIR__ . '/../includes/config.php';

// Servizi disponibili - DEFINITI PRIMA DEL CONTROLLO POST
$services = [
    'osservazione' => [
        'name' => 'Osservazione Guidata',
        'price' => 45,
        'duration' => '2-3 ore',
        'description' => 'Serata di osservazione del cielo con telescopi professionali',
        'icon' => '🔭',
        'max_participants' => 8
    ],
    'astrofotografia' => [
        'name' => 'Workshop Astrofotografia',
        'price' => 89,
        'duration' => '3-4 ore',
        'description' => 'Impara a fotografare il cielo con la tua camera',
        'icon' => '📸',
        'max_participants' => 6
    ],
    'turismo' => [
        'name' => 'Turismo Astronomico',
        'price' => 120,
        'duration' => '4-5 ore',
        'description' => 'Tour completo con osservazione e astrofotografia',
        'icon' => '🌟',
        'max_participants' => 8
    ],
    'corso' => [
        'name' => 'Corso di Astronomia',
        'price' => 200,
        'duration' => '2 giorni',
        'description' => 'Corso teorico e pratico di astronomia',
        'icon' => '🎓',
        'max_participants' => 12
    ]
];

// Orari disponibili
$time_slots = [
    'sera' => [
        '20:00' => 'Tramonto (20:00)',
        '21:00' => 'Serale (21:00)',
        '22:00' => 'Notte (22:00)'
    ],
    'notte' => [
        '23:00' => 'Tarda notte (23:00)',
        '00:00' => 'Mezzanotte (00:00)',
        '01:00' => 'Notte fonda (01:00)'
    ]
];

// Gestione invio prenotazione
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $service = trim($_POST['service'] ?? '');
    $date = trim($_POST['date'] ?? '');
    $time = trim($_POST['time'] ?? '');
    $participants = (int)($_POST['participants'] ?? 1);
    $message = trim($_POST['message'] ?? '');
    
    // Validazione
    if (empty($name) || empty($email) || empty($service) || empty($date)) {
        $error_message = 'Tutti i campi obbligatori devono essere compilati.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Indirizzo email non valido.';
    } elseif ($participants < 1 || $participants > 8) {
        $error_message = 'Il numero di partecipanti deve essere tra 1 e 8.';
    } else {
        // Salvataggio prenotazione nel database
        try {
            require_once __DIR__ . '/../includes/database.php';
            require_once __DIR__ . '/../includes/auth.php';
            
            $db = getDb();
            $auth = getAuth();
            
            // Genera ID prenotazione unico
            $booking_id = 'AG' . date('Ymd') . rand(1000, 9999);
            
            // Determina user_id se utente loggato
            $user_id = null;
            if ($auth->isLogged()) {
                $user = $auth->user();
                $user_id = $user['id'] ?? null;
            }
            
            // Calcola prezzo totale
            $service_price = $services[$service]['price'] ?? 50;
            $total_amount = $service_price * $participants;
            
            // Verifica se la tabella ha la colonna booking_id
            $columns = $db->query("PRAGMA table_info(bookings)")->fetchAll();
            $has_booking_id = false;
            $has_total_amount = false;
            foreach ($columns as $col) {
                if ($col['name'] === 'booking_id') $has_booking_id = true;
                if ($col['name'] === 'total_amount') $has_total_amount = true;
            }
            
            if ($has_booking_id && $has_total_amount) {
                // Nuova struttura completa
                $stmt = $db->prepare("
                    INSERT INTO bookings (
                        booking_id, user_id, name, email, phone, service_name, 
                        booking_date, booking_time, participants, message, status, total_amount
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', ?)
                ");
                
                $service_name = $services[$service]['name'] ?? $service;
                
                $stmt->execute([
                    $booking_id, $user_id, $name, $email, $phone, 
                    $service_name, $date, $time, $participants, $message, $total_amount
                ]);
            } else {
                // Struttura vecchia - adatta i campi
                $contact_info = json_encode([
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'participants' => $participants,
                    'message' => $message,
                    'time' => $time
                ]);
                
                $stmt = $db->prepare("
                    INSERT INTO bookings (
                        user_id, service_name, booking_date, contact_info, status
                    ) VALUES (?, ?, ?, ?, 'pending')
                ");
                
                $stmt->execute([
                    $user_id, $service_name, $date, $contact_info
                ]);
                
                // Genera booking_id basato sull'ID inserito
                $booking_id = 'AG' . date('Ymd') . str_pad($db->lastInsertId(), 4, '0', STR_PAD_LEFT);
            }
            
            $success_message = "Prenotazione salvata! Codice: $booking_id";
            $success_booking_id = $booking_id;
            $success_amount = $total_amount;
            $success_service = $service;
            
            // Invio email di conferma prenotazione
            try {
                require_once __DIR__ . '/../includes/email_service.php';
                $emailService = getEmailService();
                
                $bookingDetails = [
                    'booking_id' => $booking_id,
                    'service_name' => $service_name,
                    'booking_date' => $date,
                    'booking_time' => $time,
                    'participants' => $participants,
                    'total_amount' => $total_amount
                ];
                
                $emailService->sendBookingConfirmation($email, $name, $bookingDetails);
                
            } catch (Exception $e) {
                error_log("Errore invio email prenotazione: " . $e->getMessage());
                // Non bloccare il processo se l'email fallisce
            }
            
            // Reset form
            $_POST = [];
            
        } catch (Exception $e) {
            $error_message = "Errore nel salvataggio della prenotazione: " . $e->getMessage();
            error_log("Errore prenotazione: " . $e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prenota la Tua Esperienza Stellare | AstroGuida</title>
    <meta name="description" content="Prenota la tua esperienza astronomica con AstroGuida. Scegli tra osservazioni guidate, workshop di astrofotografia e tour astronomici in Puglia.">
    <meta name="keywords" content="prenotazione, astronomia, astrofotografia, turismo astronomico, osservazione guidata, puglia">
    
    <!-- Open Graph -->
    <meta property="og:title" content="Prenota la Tua Esperienza Stellare | AstroGuida">
    <meta property="og:description" content="Prenota la tua esperienza astronomica personalizzata">
    <meta property="og:image" content="/assets/images/logo/astroguida-logo.jpg">
    <meta property="og:url" content="<?= SITE_URL ?>/?page=booking">
    <meta property="og:type" content="website">
    
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="icon" href="/favicon.jpg" type="image/jpeg">
    
    <!-- CSS Personalizzato per Form Booking -->
    <style>
        /* Miglioramenti UI Form Booking */
        .custom-select-wrapper {
            position: relative;
            display: block;
        }
        
        .form-select-modern {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(100, 255, 218, 0.3);
            border-radius: 12px;
            padding: 1rem 3rem 1rem 1rem;
            color: white;
            font-size: 1rem;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .form-select-modern:focus {
            outline: none;
            border-color: #64ffda;
            box-shadow: 0 0 0 3px rgba(100, 255, 218, 0.2);
            background: rgba(255, 255, 255, 0.15);
        }
        
        .form-select-modern:hover {
            border-color: rgba(100, 255, 218, 0.5);
            background: rgba(255, 255, 255, 0.15);
        }
        
        .select-arrow {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64ffda;
            pointer-events: none;
            font-size: 0.8rem;
            transition: transform 0.3s ease;
        }
        
        .custom-select-wrapper:hover .select-arrow {
            transform: translateY(-50%) scale(1.1);
        }
        
        /* Miglioramento Select Servizio */
        .form-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(100, 255, 218, 0.3);
            border-radius: 12px;
            padding: 1rem 3rem 1rem 1rem;
            color: white;
            font-size: 1rem;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2364ffda' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 1rem center;
            background-repeat: no-repeat;
            background-size: 1rem;
        }
        
        /* FIX CRITICO: Opzioni dropdown visibili */
        .form-select option {
            background: #1a1a2e !important;
            color: white !important;
            padding: 0.5rem !important;
        }
        
        .form-select optgroup {
            background: #0f3460 !important;
            color: #64ffda !important;
            font-weight: bold !important;
        }
        
        .form-select-modern option {
            background: #1a1a2e !important;
            color: white !important;
            padding: 0.5rem !important;
        }
        
        .form-select-modern optgroup {
            background: #0f3460 !important;
            color: #64ffda !important;
            font-weight: bold !important;
        }
        
        .form-select:focus {
            outline: none;
            border-color: #64ffda;
            box-shadow: 0 0 0 3px rgba(100, 255, 218, 0.2);
            background: rgba(255, 255, 255, 0.15);
        }
        
        .form-select:hover {
            border-color: rgba(100, 255, 218, 0.5);
            background: rgba(255, 255, 255, 0.15);
        }
        
        /* Miglioramento Textarea */
        .form-textarea {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(100, 255, 218, 0.3);
            border-radius: 12px;
            padding: 1rem;
            color: white;
            font-size: 1rem;
            width: 100%;
            resize: vertical;
            min-height: 120px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            font-family: inherit;
        }
        
        .form-textarea:focus {
            outline: none;
            border-color: #64ffda;
            box-shadow: 0 0 0 3px rgba(100, 255, 218, 0.2);
            background: rgba(255, 255, 255, 0.15);
        }
        
        .form-textarea:hover {
            border-color: rgba(100, 255, 218, 0.5);
            background: rgba(255, 255, 255, 0.15);
        }
        
        .form-textarea::placeholder {
            color: rgba(255, 255, 255, 0.5);
            font-style: italic;
        }
        
        /* Miglioramento Input */
        .form-input {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(100, 255, 218, 0.3);
            border-radius: 12px;
            padding: 1rem;
            color: white;
            font-size: 1rem;
            width: 100%;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .form-input:focus {
            outline: none;
            border-color: #64ffda;
            box-shadow: 0 0 0 3px rgba(100, 255, 218, 0.2);
            background: rgba(255, 255, 255, 0.15);
        }
        
        .form-input:hover {
            border-color: rgba(100, 255, 218, 0.5);
            background: rgba(255, 255, 255, 0.15);
        }
        
        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        
        /* Label migliorati */
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #64ffda;
            font-weight: 600;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Card migliorati */
        .card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(100, 255, 218, 0.2);
            border-radius: 20px;
            padding: 2rem;
            backdrop-filter: blur(15px);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            border-color: rgba(100, 255, 218, 0.4);
            background: rgba(255, 255, 255, 0.08);
            transform: translateY(-2px);
        }
        
        /* Animazioni */
        @keyframes glow {
            0%, 100% { box-shadow: 0 0 5px rgba(100, 255, 218, 0.5); }
            50% { box-shadow: 0 0 20px rgba(100, 255, 218, 0.8); }
        }
        
        .stellar-glow:hover {
            animation: glow 2s infinite;
        }
        
        /* Responsive miglioramenti */
        @media (max-width: 768px) {
            .form-select-modern, .form-select, .form-input, .form-textarea {
                font-size: 16px; /* Previene zoom su iOS */
            }
        }
        
        /* Card PayPal migliorata */
        .paypal-card {
            background: linear-gradient(135deg, rgba(100, 255, 218, 0.1), rgba(0, 122, 255, 0.1));
            border: 1px solid rgba(100, 255, 218, 0.3);
            border-radius: 16px;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .paypal-card:hover {
            border-color: rgba(100, 255, 218, 0.5);
            background: linear-gradient(135deg, rgba(100, 255, 218, 0.15), rgba(0, 122, 255, 0.15));
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="stellar-background">
        <div class="stars"></div>
        <div class="nebula"></div>
        <div class="cosmic-particles"></div>
    </div>

    <div class="main-container">
        <!-- Header -->
        <?php include __DIR__ . '/../includes/header.php'; ?>

        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="hero-content text-center">
                    <h1 class="hero-title">
                        Prenota la Tua Esperienza Stellare
                    </h1>
                    <p class="hero-subtitle">
                        Scegli il servizio perfetto per te e inizia il tuo viaggio 
                        alla scoperta dell'universo con i nostri esperti.
                    </p>
                </div>
            </div>
        </section>

        <!-- Messaggi -->
        <?php if ($success_message): ?>
            <section class="section">
                <div class="container">
                    <div class="alert alert-success max-w-2xl mx-auto">
                        ✅ <?= htmlspecialchars($success_message) ?>
                        
                        <?php if (isset($success_booking_id) && isset($success_amount)): ?>
                            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.2);">
                                <h4 style="margin-bottom: 1rem; color: #64ffda;">💳 Completa il Pagamento</h4>
                                <p style="margin-bottom: 1rem;">Per confermare la prenotazione, effettua il pagamento sicuro tramite PayPal:</p>
                                <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                                    <a href="/paypal-payment.php?booking_id=<?= urlencode($success_booking_id) ?>&amount=<?= $success_amount ?>&service=<?= urlencode($success_service) ?>" 
                                       style="background: #0070ba; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-flex; align-items: center; gap: 0.5rem;">
                                        🛡️ Paga €<?= number_format($success_amount, 2) ?> con PayPal
                                    </a>
                                    <span style="color: rgba(255,255,255,0.7); font-size: 0.9rem; align-self: center;">
                                        Pagamento sicuro • La prenotazione sarà confermata dopo il pagamento
                                    </span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <section class="section">
                <div class="container">
                    <div class="alert alert-error max-w-2xl mx-auto">
                        ❌ <?= htmlspecialchars($error_message) ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <!-- Calendario Disponibilità -->
        <section class="section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">📅 Controlla Disponibilità</h2>
                    <p class="section-subtitle">
                        Visualizza le date disponibili e scegli quella perfetta per te
                    </p>
                </div>
                
                <div id="booking-calendar" class="mb-8">
                    <?php
                    require_once __DIR__ . '/../includes/booking_calendar.php';
                    $calendar = getBookingCalendar();
                    
                    // Mostra CSS
                    echo $calendar->getCalendarCSS();
                    
                    // Mostra calendario per mese corrente
                    echo $calendar->generateCalendarHTML(date('Y'), date('n'));
                    
                    // Mostra JavaScript
                    echo $calendar->getCalendarJS();
                    ?>
                </div>
                
                <div id="availability-info" class="mb-6"></div>
            </div>
        </section>

        <!-- Form di Prenotazione -->
        <section class="section">
            <div class="container">
                <div class="max-w-4xl mx-auto">
                    <form method="post" class="booking-form">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Colonna Sinistra - Dati Personali -->
                            <div class="card">
                                <h3 class="text-xl font-semibold text-white mb-6">👤 Dati Personali</h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label for="name" class="form-label">Nome e Cognome *</label>
                                        <input type="text" 
                                               id="name" 
                                               name="name" 
                                               class="form-input" 
                                               required 
                                               value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="email" class="form-label">Email *</label>
                                            <input type="email" 
                                                   id="email" 
                                                   name="email" 
                                                   class="form-input" 
                                                   required 
                                                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                                        </div>
                                        <div>
                                            <label for="phone" class="form-label">Telefono</label>
                                            <input type="tel" 
                                                   id="phone" 
                                                   name="phone" 
                                                   class="form-input" 
                                                   value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label for="participants" class="form-label">Numero Partecipanti *</label>
                                        <div class="custom-select-wrapper">
                                            <select id="participants" name="participants" class="form-select-modern" required>
                                                <?php for ($i = 1; $i <= 8; $i++): ?>
                                                    <option value="<?= $i ?>" <?= ($_POST['participants'] ?? 1) == $i ? 'selected' : '' ?>>
                                                        <?= $i ?> <?= $i === 1 ? 'persona' : 'persone' ?>
                                                    </option>
                                                <?php endfor; ?>
                                            </select>
                                            <div class="select-arrow">▼</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Colonna Destra - Dettagli Prenotazione -->
                            <div class="card">
                                <h3 class="text-xl font-semibold text-white mb-6">📅 Dettagli Prenotazione</h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label for="service" class="form-label">Servizio *</label>
                                        <select id="service" name="service" class="form-select" required>
                                            <option value="">Seleziona un servizio</option>
                                            <?php foreach ($services as $key => $service): ?>
                                                <option value="<?= $key ?>" 
                                                        data-price="<?= $service['price'] ?>"
                                                        data-max="<?= $service['max_participants'] ?>"
                                                        <?= ($_POST['service'] ?? '') === $key ? 'selected' : '' ?>>
                                                    <?= $service['icon'] ?> <?= $service['name'] ?> - €<?= $service['price'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="date" class="form-label">Data Preferita *</label>
                                            <input type="date" 
                                                   id="date" 
                                                   name="date" 
                                                   class="form-input" 
                                                   required 
                                                   min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                                                   value="<?= htmlspecialchars($_POST['date'] ?? '') ?>">
                                        </div>
                                        <div>
                                            <label for="time" class="form-label">Orario Preferito</label>
                                            <select id="time" name="time" class="form-select">
                                                <option value="">Seleziona orario</option>
                                                <optgroup label="Serata">
                                                    <?php foreach ($time_slots['sera'] as $value => $label): ?>
                                                        <option value="<?= $value ?>" <?= ($_POST['time'] ?? '') === $value ? 'selected' : '' ?>>
                                                            <?= $label ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </optgroup>
                                                <optgroup label="Notte">
                                                    <?php foreach ($time_slots['notte'] as $value => $label): ?>
                                                        <option value="<?= $value ?>" <?= ($_POST['time'] ?? '') === $value ? 'selected' : '' ?>>
                                                            <?= $label ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label for="message" class="form-label">Note Aggiuntive</label>
                                        <textarea id="message" 
                                                  name="message" 
                                                  rows="4" 
                                                  class="form-textarea" 
                                                  placeholder="Richieste speciali, domande, esperienza precedente..."><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Riepilogo Prenotazione -->
                        <div class="card mt-8">
                            <h3 class="text-xl font-semibold text-white mb-6">💰 Riepilogo Prenotazione</h3>
                            
                            <div id="booking-summary" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="summary-item">
                                    <div class="summary-label">Servizio Selezionato</div>
                                    <div id="summary-service" class="summary-value">Nessun servizio selezionato</div>
                                </div>
                                <div class="summary-item">
                                    <div class="summary-label">Prezzo per Persona</div>
                                    <div id="summary-price" class="summary-value">€0</div>
                                </div>
                                <div class="summary-item">
                                    <div class="summary-label">Totale</div>
                                    <div id="summary-total" class="summary-value text-cyan text-xl font-bold">€0</div>
                                </div>
                            </div>
                            
                            <div class="mt-6 p-4 paypal-card">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-semibold text-white">💳 Modalità di Pagamento</h4>
                                        <p class="text-white text-sm">
                                            Acconto 30% richiesto per confermare la prenotazione. 
                                            Il resto si paga il giorno dell'attività.
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-white text-sm">Acconto Richiesto</div>
                                        <div id="summary-deposit" class="text-white text-lg font-bold">€0</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Termini e Invio -->
                        <div class="card mt-8">
                            <div class="space-y-6">
                                <div class="flex items-start">
                                    <input type="checkbox" 
                                           id="terms" 
                                           name="terms" 
                                           class="mt-1 mr-3" 
                                           required>
                                    <label for="terms" class="text-silver text-sm">
                                        Accetto i <a href="/?page=terms" class="text-cyan hover:text-white">Termini di Servizio</a> 
                                        e la <a href="/?page=privacy" class="text-cyan hover:text-white">Privacy Policy</a> di AstroGuida. 
                                        Comprendo che la prenotazione sarà confermata solo dopo il pagamento dell'acconto.
                                    </label>
                                </div>
                                
                                <div class="flex items-start">
                                    <input type="checkbox" 
                                           id="newsletter" 
                                           name="newsletter" 
                                           class="mt-1 mr-3">
                                    <label for="newsletter" class="text-silver text-sm">
                                        Desidero ricevere aggiornamenti su eventi astronomici e offerte speciali (facoltativo)
                                    </label>
                                </div>
                                
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-lg stellar-glow">
                                        🚀 Invia Prenotazione
                                    </button>
                                    <p class="text-silver text-sm mt-4">
                                        Ti contatteremo entro 24 ore per confermare la disponibilità 
                                        e inviarti le istruzioni per il pagamento.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- Informazioni Aggiuntive -->
        <section class="section">
            <div class="container">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="card text-center">
                        <div class="w-16 h-16 bg-gradient-primary rounded-full mx-auto mb-4 flex items-center justify-center text-white text-2xl">
                            📞
                        </div>
                        <h3 class="font-semibold text-white mb-2">Prenotazione Telefonica</h3>
                        <p class="text-silver text-sm mb-4">
                            Preferisci prenotare per telefono? Chiamaci!
                        </p>
                        <a href="tel:+393123456789" class="btn btn-secondary btn-sm">
                            📞 +39 312 345 6789
                        </a>
                    </div>
                    
                    <div class="card text-center">
                        <div class="w-16 h-16 bg-gradient-cosmic rounded-full mx-auto mb-4 flex items-center justify-center text-white text-2xl">
                            🌙
                        </div>
                        <h3 class="font-semibold text-white mb-2">Condizioni Meteo</h3>
                        <p class="text-silver text-sm mb-4">
                            In caso di maltempo, rimandiamo senza costi aggiuntivi
                        </p>
                        <a href="/?page=faq" class="btn btn-secondary btn-sm">
                            ❓ Scopri di Più
                        </a>
                    </div>
                    
                    <div class="card text-center">
                        <div class="w-16 h-16 bg-gradient-success rounded-full mx-auto mb-4 flex items-center justify-center text-white text-2xl">
                            🎁
                        </div>
                        <h3 class="font-semibold text-white mb-2">Regala un'Esperienza</h3>
                        <p class="text-silver text-sm mb-4">
                            Sorprendi qualcuno con un gift card AstroGuida
                        </p>
                        <a href="/?page=contact" class="btn btn-secondary btn-sm">
                            💝 Info Gift Card
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-content">
                <div class="footer-grid">
                    <div class="footer-section">
                        <div class="flex items-center mb-4">
                            <div class="logo-icon mr-3">
                                <img src="/assets/images/logo/astroguida-logo.jpg" alt="AstroGuida Logo">
                            </div>
                            <h3 class="text-xl font-bold">AstroGuida</h3>
                        </div>
                        <p>
                            La tua guida professionale per esplorare l'universo. 
                            Astrofotografia e turismo astronomico in Puglia.
                        </p>
                    </div>
                    
                    <div class="footer-section">
                        <h3>Servizi</h3>
                        <ul class="space-y-2">
                            <li><a href="/?page=services#astrofotografia">Astrofotografia</a></li>
                            <li><a href="/?page=services#turismo">Turismo Astronomico</a></li>
                            <li><a href="/?page=services#osservazione">Osservazione Guidata</a></li>
                            <li><a href="/?page=services#corsi">Corsi di Astronomia</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-section">
                        <h3>Info Utili</h3>
                        <ul class="space-y-2">
                            <li><a href="/?page=gallery">Gallery</a></li>
                            <li><a href="/?page=about">Chi Siamo</a></li>
                            <li><a href="/?page=contact">Contatti</a></li>
                            <li><a href="/?page=faq">FAQ</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-section">
                        <h3>Seguici</h3>
                        <div class="flex space-x-4 mb-4">
                            <a href="#" class="text-silver hover:text-white">📘 Facebook</a>
                            <a href="#" class="text-silver hover:text-white">📷 Instagram</a>
                        </div>
                        <p class="text-silver text-sm">
                            📧 info@astroguida.com<br>
                            📱 +39 123 456 7890
                        </p>
                    </div>
                </div>
                
                <div class="footer-bottom">
                    <p>&copy; <?= date('Y') ?> AstroGuida. Tutti i diritti riservati.</p>
                </div>
            </div>
        </footer>
    </div>

    <script src="/assets/js/stellar-animations.js"></script>
    <script>
        // Inizializza animazioni stellari
        document.addEventListener('DOMContentLoaded', function() {
            const stellarAnimations = new StellarAnimations();
            stellarAnimations.init();
            
            // Inizializza sistema prenotazioni
            initBookingSystem();
        });

        function initBookingSystem() {
            const serviceCards = document.querySelectorAll('.service-card');
            const serviceSelect = document.getElementById('service');
            const participantsSelect = document.getElementById('participants');
            
            // Gestione selezione servizio dalle card
            serviceCards.forEach(card => {
                card.addEventListener('click', function() {
                    const service = this.dataset.service;
                    
                    // Rimuovi selezione da tutte le card
                    serviceCards.forEach(c => c.classList.remove('selected'));
                    
                    // Seleziona questa card
                    this.classList.add('selected');
                    
                    // Aggiorna select
                    serviceSelect.value = service;
                    
                    // Aggiorna riepilogo
                    updateBookingSummary();
                });
            });
            
            // Gestione cambio servizio da select
            serviceSelect.addEventListener('change', function() {
                const service = this.value;
                
                // Aggiorna card selection
                serviceCards.forEach(card => {
                    card.classList.toggle('selected', card.dataset.service === service);
                });
                
                // Aggiorna limite partecipanti
                updateParticipantsLimit();
                
                // Aggiorna riepilogo
                updateBookingSummary();
            });
            
            // Gestione cambio partecipanti
            participantsSelect.addEventListener('change', updateBookingSummary);
            
            // Aggiorna riepilogo iniziale
            updateBookingSummary();
        }
        
        function updateParticipantsLimit() {
            const serviceSelect = document.getElementById('service');
            const participantsSelect = document.getElementById('participants');
            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
            
            if (selectedOption && selectedOption.dataset.max) {
                const maxParticipants = parseInt(selectedOption.dataset.max);
                const currentValue = parseInt(participantsSelect.value);
                
                // Rimuovi opzioni esistenti
                participantsSelect.innerHTML = '';
                
                // Aggiungi nuove opzioni fino al limite
                for (let i = 1; i <= Math.min(maxParticipants, 8); i++) {
                    const option = document.createElement('option');
                    option.value = i;
                    option.textContent = i + (i === 1 ? ' persona' : ' persone');
                    if (i === currentValue && i <= maxParticipants) {
                        option.selected = true;
                    }
                    participantsSelect.appendChild(option);
                }
                
                // Se il valore corrente supera il limite, seleziona il massimo
                if (currentValue > maxParticipants) {
                    participantsSelect.value = maxParticipants;
                }
            }
        }
        
        function updateBookingSummary() {
            const serviceSelect = document.getElementById('service');
            const participantsSelect = document.getElementById('participants');
            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
            
            const summaryService = document.getElementById('summary-service');
            const summaryPrice = document.getElementById('summary-price');
            const summaryTotal = document.getElementById('summary-total');
            const summaryDeposit = document.getElementById('summary-deposit');
            
            if (selectedOption && selectedOption.value) {
                const serviceName = selectedOption.textContent.split(' - ')[0];
                const price = parseInt(selectedOption.dataset.price);
                const participants = parseInt(participantsSelect.value);
                const total = price * participants;
                const deposit = Math.ceil(total * 0.3); // 30% acconto
                
                summaryService.textContent = serviceName;
                summaryPrice.textContent = '€' + price;
                summaryTotal.textContent = '€' + total;
                summaryDeposit.textContent = '€' + deposit;
            } else {
                summaryService.textContent = 'Nessun servizio selezionato';
                summaryPrice.textContent = '€0';
                summaryTotal.textContent = '€0';
                summaryDeposit.textContent = '€0';
            }
        }
    </script>
</body>
</html> 