<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/database.php';

$auth = getAuth();

// Verifica autenticazione
if (!$auth->isLogged()) {
    header('Location: /?page=login');
    exit;
}

$user = $auth->currentUser();
$userId = $user['id'];

// DEBUG: Aggiungi informazioni di debug
$debug_info = [];
$debug_info['user_id'] = $userId;
$debug_info['user_email'] = $user['email'];

// Recupera prenotazioni dell'utente
try {
    $db = getDb();
    
    // Prima verifica la struttura della tabella
    $columns = $db->query("PRAGMA table_info(bookings)")->fetchAll();
    $debug_info['table_columns'] = array_column($columns, 'name');
    
    // Verifica se ci sono prenotazioni in generale
    $total_bookings = $db->query("SELECT COUNT(*) as count FROM bookings")->fetch();
    $debug_info['total_bookings_in_db'] = $total_bookings['count'];
    
    // Query per recuperare le prenotazioni - versione migliorata
    $stmt = $db->prepare("
        SELECT * FROM bookings 
        WHERE (user_id = ? OR email = ?) 
        ORDER BY 
            CASE 
                WHEN booking_date IS NOT NULL THEN booking_date 
                ELSE created_at 
            END DESC,
            created_at DESC
    ");
    
    $stmt->execute([$userId, $user['email']]);
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $debug_info['bookings_found'] = count($bookings);
    $debug_info['query_params'] = [$userId, $user['email']];
    
    // Se non trova prenotazioni, prova query alternative
    if (empty($bookings)) {
        // Prova solo con user_id
        $stmt2 = $db->prepare("SELECT * FROM bookings WHERE user_id = ?");
        $stmt2->execute([$userId]);
        $bookings_by_user = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        $debug_info['bookings_by_user_id'] = count($bookings_by_user);
        
        // Prova solo con email
        $stmt3 = $db->prepare("SELECT * FROM bookings WHERE email = ?");
        $stmt3->execute([$user['email']]);
        $bookings_by_email = $stmt3->fetchAll(PDO::FETCH_ASSOC);
        $debug_info['bookings_by_email'] = count($bookings_by_email);
        
        // Usa il risultato migliore
        if (!empty($bookings_by_user)) {
            $bookings = $bookings_by_user;
        } elseif (!empty($bookings_by_email)) {
            $bookings = $bookings_by_email;
        }
    }
    
    // Statistiche
    $totalBookings = count($bookings);
    $pendingBookings = count(array_filter($bookings, fn($b) => ($b['status'] ?? 'pending') === 'pending'));
    $confirmedBookings = count(array_filter($bookings, fn($b) => ($b['status'] ?? 'pending') === 'confirmed'));
    $totalSpent = array_sum(array_column(array_filter($bookings, fn($b) => ($b['status'] ?? 'pending') === 'confirmed'), 'total_amount'));
    
    // Separa prenotazioni per stato
    $upcomingBookings = array_filter($bookings, fn($b) => 
        ($b['status'] ?? 'pending') === 'confirmed' && 
        ($b['booking_date'] ?? '') >= date('Y-m-d')
    );
    $pastBookings = array_filter($bookings, fn($b) => 
        ($b['status'] ?? 'pending') === 'confirmed' && 
        ($b['booking_date'] ?? '') < date('Y-m-d')
    );
    $pendingBookingsArray = array_filter($bookings, fn($b) => ($b['status'] ?? 'pending') === 'pending');
    
} catch (Exception $e) {
    error_log("Errore recupero prenotazioni utente: " . $e->getMessage());
    $debug_info['error'] = $e->getMessage();
    $bookings = [];
    $upcomingBookings = [];
    $pastBookings = [];
    $pendingBookingsArray = [];
    $totalBookings = $pendingBookings = $confirmedBookings = $totalSpent = 0;
}

// Funzione per ottenere icona servizio
function getServiceIcon($serviceName) {
    $icons = [
        'Osservazione Guidata' => '🔭',
        'Workshop Astrofotografia' => '📸',
        'Turismo Astronomico' => '🌟',
        'Corso di Astronomia' => '🎓'
    ];
    return $icons[$serviceName] ?? '🌌';
}

// Funzione per ottenere colore status
function getStatusColor($status) {
    $colors = [
        'pending' => ['bg' => 'rgba(255, 193, 7, 0.1)', 'border' => '#ffc107', 'text' => '#ffc107'],
        'confirmed' => ['bg' => 'rgba(40, 167, 69, 0.1)', 'border' => '#28a745', 'text' => '#28a745'],
        'cancelled' => ['bg' => 'rgba(220, 53, 69, 0.1)', 'border' => '#dc3545', 'text' => '#dc3545']
    ];
    return $colors[$status] ?? $colors['pending'];
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Prenotazioni - AstroGuida</title>
    <meta name="description" content="Gestisci le tue prenotazioni astronomiche con AstroGuida">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="icon" href="/favicon.jpg" type="image/jpeg">
    
    <style>
        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .dashboard-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .dashboard-title {
            font-size: 3rem;
            font-weight: bold;
            background: linear-gradient(135deg, #64ffda 0%, #007aff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
        }
        
        .dashboard-subtitle {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.8);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }
        
        .stat-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            backdrop-filter: blur(15px);
            border: 1px solid rgba(100, 255, 218, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #64ffda, #007aff);
            border-radius: 20px 20px 0 0;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        
        .stat-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #64ffda;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1rem;
        }
        
        .bookings-section {
            margin-bottom: 3rem;
        }
        
        .section-title {
            font-size: 2rem;
            font-weight: bold;
            color: white;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .booking-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(15px);
            border: 1px solid rgba(100, 255, 218, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .booking-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 6px;
            background: linear-gradient(135deg, #64ffda, #007aff);
        }
        
        .booking-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }
        
        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .booking-service {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .service-icon {
            font-size: 2.5rem;
            background: rgba(100, 255, 218, 0.1);
            padding: 0.5rem;
            border-radius: 12px;
            border: 1px solid rgba(100, 255, 218, 0.3);
        }
        
        .service-name {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
        }
        
        .booking-status {
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .booking-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .detail-item {
            background: rgba(255, 255, 255, 0.05);
            padding: 1rem;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .detail-label {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 0.5rem;
        }
        
        .detail-value {
            font-size: 1.1rem;
            font-weight: bold;
            color: #64ffda;
        }
        
        .booking-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .btn-action {
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #007aff, #0056b3);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 122, 255, 0.4);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #28a745, #1e7e34);
            color: white;
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.4);
        }
        
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: rgba(255, 255, 255, 0.6);
        }
        
        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        
        .empty-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #64ffda;
            margin-bottom: 1rem;
        }
        
        .debug-info {
            background: rgba(255, 193, 7, 0.1);
            border: 1px solid #ffc107;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 2rem;
            color: #ffc107;
            font-family: monospace;
            font-size: 0.9rem;
        }
        
        .quick-actions {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-top: 3rem;
        }
        
        .quick-action {
            background: linear-gradient(135deg, rgba(100, 255, 218, 0.1), rgba(0, 122, 255, 0.1));
            padding: 1.5rem 2rem;
            border-radius: 16px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            transition: all 0.3s ease;
            border: 1px solid rgba(100, 255, 218, 0.3);
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .quick-action:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
        }
        
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 1rem;
            }
            
            .dashboard-title {
                font-size: 2rem;
            }
            
            .booking-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .booking-details {
                grid-template-columns: 1fr;
            }
            
            .booking-actions {
                flex-direction: column;
            }
            
            .quick-actions {
                flex-direction: column;
                align-items: center;
            }
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
        <?php include __DIR__ . '/../includes/header.php'; ?>

        <div class="dashboard-container">
            <!-- Header -->
            <div class="dashboard-header">
                <h1 class="dashboard-title">🌟 La Tua Dashboard Stellare</h1>
                <p class="dashboard-subtitle">
                    Benvenuto, <?= htmlspecialchars($user['name']) ?>! Gestisci le tue avventure astronomiche
                </p>
            </div>

            <!-- DEBUG INFO -->
            <?php if (isset($_GET['debug'])): ?>
            <div class="debug-info">
                <h3>🔍 Informazioni Debug:</h3>
                <pre><?php print_r($debug_info); ?></pre>
            </div>
            <?php endif; ?>

            <!-- Statistiche -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">📊</div>
                    <div class="stat-number"><?= $totalBookings ?></div>
                    <div class="stat-label">Prenotazioni Totali</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">⏳</div>
                    <div class="stat-number"><?= $pendingBookings ?></div>
                    <div class="stat-label">In Attesa</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">✅</div>
                    <div class="stat-number"><?= $confirmedBookings ?></div>
                    <div class="stat-label">Confermate</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">💰</div>
                    <div class="stat-number">€<?= number_format($totalSpent, 2) ?></div>
                    <div class="stat-label">Spesa Totale</div>
                </div>
            </div>

            <!-- Prenotazioni In Attesa -->
            <?php if (!empty($pendingBookingsArray)): ?>
            <div class="bookings-section">
                <h2 class="section-title">⏳ Prenotazioni In Attesa di Pagamento</h2>
                <?php foreach ($pendingBookingsArray as $booking): ?>
                    <?php $statusColor = getStatusColor($booking['status'] ?? 'pending'); ?>
                    <div class="booking-card">
                        <div class="booking-header">
                            <div class="booking-service">
                                <div class="service-icon"><?= getServiceIcon($booking['service_name'] ?? '') ?></div>
                                <div class="service-name"><?= htmlspecialchars($booking['service_name'] ?? 'Servizio Non Specificato') ?></div>
                            </div>
                            <div class="booking-status" style="background: <?= $statusColor['bg'] ?>; border: 1px solid <?= $statusColor['border'] ?>; color: <?= $statusColor['text'] ?>;">
                                In Attesa
                            </div>
                        </div>
                        
                        <div class="booking-details">
                            <div class="detail-item">
                                <div class="detail-label">📅 Data</div>
                                <div class="detail-value"><?= $booking['booking_date'] ? date('d/m/Y', strtotime($booking['booking_date'])) : 'Da definire' ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">🕒 Orario</div>
                                <div class="detail-value"><?= $booking['booking_time'] ?? 'Da definire' ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">👥 Partecipanti</div>
                                <div class="detail-value"><?= $booking['participants'] ?? 1 ?> persone</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">💰 Importo</div>
                                <div class="detail-value">€<?= number_format($booking['total_amount'] ?? 0, 2) ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">🎫 Codice</div>
                                <div class="detail-value"><?= $booking['booking_id'] ?? 'N/A' ?></div>
                            </div>
                        </div>
                        
                        <div class="booking-actions">
                            <a href="/paypal-payment.php?booking_id=<?= urlencode($booking['booking_id']) ?>&amount=<?= $booking['total_amount'] ?>" class="btn-action btn-primary">
                                💳 Completa Pagamento
                            </a>
                            <a href="/?page=contact" class="btn-action btn-success">
                                📞 Contatta Supporto
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Prenotazioni Future -->
            <?php if (!empty($upcomingBookings)): ?>
            <div class="bookings-section">
                <h2 class="section-title">🚀 Prossime Avventure</h2>
                <?php foreach ($upcomingBookings as $booking): ?>
                    <?php $statusColor = getStatusColor($booking['status'] ?? 'confirmed'); ?>
                    <div class="booking-card">
                        <div class="booking-header">
                            <div class="booking-service">
                                <div class="service-icon"><?= getServiceIcon($booking['service_name'] ?? '') ?></div>
                                <div class="service-name"><?= htmlspecialchars($booking['service_name'] ?? 'Servizio Non Specificato') ?></div>
                            </div>
                            <div class="booking-status" style="background: <?= $statusColor['bg'] ?>; border: 1px solid <?= $statusColor['border'] ?>; color: <?= $statusColor['text'] ?>;">
                                Confermata
                            </div>
                        </div>
                        
                        <div class="booking-details">
                            <div class="detail-item">
                                <div class="detail-label">📅 Data</div>
                                <div class="detail-value"><?= $booking['booking_date'] ? date('d/m/Y', strtotime($booking['booking_date'])) : 'Da definire' ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">🕒 Orario</div>
                                <div class="detail-value"><?= $booking['booking_time'] ?? 'Da definire' ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">👥 Partecipanti</div>
                                <div class="detail-value"><?= $booking['participants'] ?? 1 ?> persone</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">💰 Importo</div>
                                <div class="detail-value">€<?= number_format($booking['total_amount'] ?? 0, 2) ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">🎫 Codice</div>
                                <div class="detail-value"><?= $booking['booking_id'] ?? 'N/A' ?></div>
                            </div>
                        </div>
                        
                        <?php if (!empty($booking['message'])): ?>
                        <div class="detail-item" style="margin-bottom: 1rem;">
                            <div class="detail-label">📝 Note</div>
                            <div class="detail-value"><?= htmlspecialchars($booking['message']) ?></div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="booking-actions">
                            <a href="/?page=contact" class="btn-action btn-success">
                                📞 Contatta Supporto
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Prenotazioni Passate -->
            <?php if (!empty($pastBookings)): ?>
            <div class="bookings-section">
                <h2 class="section-title">📚 Avventure Passate</h2>
                <?php foreach (array_slice($pastBookings, 0, 3) as $booking): // Mostra solo le ultime 3 ?>
                    <?php $statusColor = getStatusColor($booking['status'] ?? 'confirmed'); ?>
                    <div class="booking-card" style="opacity: 0.8;">
                        <div class="booking-header">
                            <div class="booking-service">
                                <div class="service-icon"><?= getServiceIcon($booking['service_name'] ?? '') ?></div>
                                <div class="service-name"><?= htmlspecialchars($booking['service_name'] ?? 'Servizio Non Specificato') ?></div>
                            </div>
                            <div class="booking-status" style="background: <?= $statusColor['bg'] ?>; border: 1px solid <?= $statusColor['border'] ?>; color: <?= $statusColor['text'] ?>;">
                                Completata
                            </div>
                        </div>
                        
                        <div class="booking-details">
                            <div class="detail-item">
                                <div class="detail-label">📅 Data</div>
                                <div class="detail-value"><?= $booking['booking_date'] ? date('d/m/Y', strtotime($booking['booking_date'])) : 'N/A' ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">🕒 Orario</div>
                                <div class="detail-value"><?= $booking['booking_time'] ?? 'N/A' ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">👥 Partecipanti</div>
                                <div class="detail-value"><?= $booking['participants'] ?? 1 ?> persone</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">💰 Importo</div>
                                <div class="detail-value">€<?= number_format($booking['total_amount'] ?? 0, 2) ?></div>
                            </div>
                        </div>
                        
                        <div class="booking-actions">
                            <a href="/?page=services" class="btn-action btn-primary">
                                🔄 Prenota Ancora
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Stato Vuoto -->
            <?php if (empty($bookings)): ?>
            <div class="empty-state">
                <div class="empty-icon">🌟</div>
                <h3 class="empty-title">Nessuna Prenotazione Trovata</h3>
                <p>Non hai ancora effettuato prenotazioni.</p>
                <p>Inizia la tua avventura astronomica!</p>
                <div style="margin-top: 2rem;">
                    <a href="/?page=services" class="btn-action btn-primary">
                        🚀 Prenota Ora
                    </a>
                </div>
                <br>
                <p><small><a href="?debug=1" style="color: #64ffda;">Mostra info debug</a></small></p>
            </div>
            <?php endif; ?>
            
            <!-- Azioni Rapide -->
            <div class="quick-actions">
                <a href="/?page=services" class="quick-action">
                    <span style="font-size: 1.5rem;">🚀</span>
                    Nuova Prenotazione
                </a>
                <a href="/?page=gallery" class="quick-action">
                    <span style="font-size: 1.5rem;">📸</span>
                    Galleria Astronomica
                </a>
                <a href="/?page=profile" class="quick-action">
                    <span style="font-size: 1.5rem;">👤</span>
                    Gestisci Profilo
                </a>
            </div>
        </div>

        <?php include __DIR__ . '/../includes/footer.php'; ?>
    </div>

    <script>
        // Animazioni al caricamento
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.booking-card, .stat-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html> 