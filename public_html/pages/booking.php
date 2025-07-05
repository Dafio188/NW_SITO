<?php
require_once __DIR__ . '/../includes/config.php';

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
        // Simulazione salvataggio prenotazione
        $booking_id = 'AG' . date('Ymd') . rand(1000, 9999);
        
        // In produzione: salvare nel database e inviare email
        $success_message = "Prenotazione inviata con successo! Codice prenotazione: $booking_id. Ti contatteremo entro 24 ore per la conferma.";
        
        // Reset form
        $_POST = [];
    }
}

// Servizi disponibili
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
?><!DOCTYPE html>
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
    <link rel="icon" href="/assets/images/logo/astroguida-logo.jpg">
</head>
<body>
    <div class="stellar-background">
        <div class="stars"></div>
        <div class="nebula"></div>
        <div class="cosmic-particles"></div>
    </div>

    <div class="main-container">
        <!-- Header -->
        <header class="header">
            <div class="header-content">
                <div class="logo">
                    <img src="/assets/images/logo/astroguida-logo.jpg" alt="AstroGuida Logo" class="logo-image">
                    <span class="logo-text">AstroGuida</span>
                </div>
                
                <nav class="nav">
                    <a href="/" class="nav-link">Home</a>
                    <a href="/?page=services" class="nav-link">Servizi</a>
                    <a href="/?page=gallery" class="nav-link">Gallery</a>
                    <a href="/?page=about" class="nav-link">Chi Siamo</a>
                    <a href="/?page=contact" class="nav-link">Contatti</a>
                    <a href="/?page=live-sky" class="nav-link">🔴 Live</a>
                </nav>

                <div class="header-actions">
                    <a href="/?page=booking" class="btn btn-primary btn-sm active">
                        🚀 Prenota
                    </a>
                    <a href="/?page=login" class="btn btn-ghost btn-sm">
                        👤 Login
                    </a>
                </div>
            </div>
        </header>

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

        <!-- Selezione Servizio -->
        <section class="section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Scegli il Tuo Servizio</h2>
                    <p class="section-subtitle">
                        Seleziona l'esperienza che preferisci
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <?php foreach ($services as $key => $service): ?>
                        <div class="service-card" data-service="<?= $key ?>">
                            <div class="service-icon"><?= $service['icon'] ?></div>
                            <h3 class="service-title"><?= $service['name'] ?></h3>
                            <div class="service-price">€<?= $service['price'] ?></div>
                            <div class="service-duration"><?= $service['duration'] ?></div>
                            <p class="service-description"><?= $service['description'] ?></p>
                            <div class="service-participants">
                                Max <?= $service['max_participants'] ?> persone
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
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
                                        <select id="participants" name="participants" class="form-select" required>
                                            <?php for ($i = 1; $i <= 8; $i++): ?>
                                                <option value="<?= $i ?>" <?= ($_POST['participants'] ?? 1) == $i ? 'selected' : '' ?>>
                                                    <?= $i ?> <?= $i === 1 ? 'persona' : 'persone' ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
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
                            
                            <div class="mt-6 p-4 bg-gradient-primary rounded-lg">
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
    
    <style>
        /* Stili Sistema Prenotazioni */
        .service-card {
            background: rgba(42, 42, 42, 0.8);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .service-card:hover {
            border-color: rgba(100, 255, 218, 0.5);
            transform: translateY(-2px);
        }
        
        .service-card.selected {
            border-color: #64ffda;
            background: rgba(100, 255, 218, 0.1);
        }
        
        .service-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .service-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            margin-bottom: 0.5rem;
        }
        
        .service-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #64ffda;
            margin-bottom: 0.5rem;
        }
        
        .service-duration {
            color: #a855f7;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        
        .service-description {
            color: #94a3b8;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        
        .service-participants {
            color: #f59e0b;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .booking-form .card {
            background: rgba(26, 26, 26, 0.9);
            backdrop-filter: blur(15px);
        }
        
        .summary-item {
            text-align: center;
        }
        
        .summary-label {
            color: #94a3b8;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        
        .summary-value {
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .service-card {
                padding: 1rem;
            }
            
            .service-icon {
                font-size: 2rem;
            }
            
            .service-title {
                font-size: 1rem;
            }
            
            .service-price {
                font-size: 1.3rem;
            }
        }
    </style>
</body>
</html> 