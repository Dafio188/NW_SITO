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
    
} catch (Exception $e) {
    error_log("Errore recupero prenotazioni utente: " . $e->getMessage());
    $debug_info['error'] = $e->getMessage();
    $bookings = [];
    $totalBookings = $pendingBookings = $confirmedBookings = $totalSpent = 0;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le Mie Prenotazioni - AstroGuida</title>
    <meta name="description" content="Visualizza e gestisci le tue prenotazioni per esperienze astronomiche con AstroGuida">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="icon" href="/favicon.jpg" type="image/jpeg">
    
    <style>
        .bookings-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .debug-info {
            background: rgba(255, 193, 7, 0.1);
            border: 1px solid #ffc107;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 2rem;
            color: #ffc107;
            font-family: monospace;
            font-size: 0.9rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(100, 255, 218, 0.2);
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #64ffda;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }
        
        .bookings-list {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(100, 255, 218, 0.2);
        }
        
        .booking-item {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border-left: 4px solid #64ffda;
            transition: all 0.3s ease;
        }
        
        .booking-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }
        
        .booking-item.pending {
            border-left-color: #ffc107;
        }
        
        .booking-item.confirmed {
            border-left-color: #28a745;
        }
        
        .booking-item.cancelled {
            border-left-color: #dc3545;
            opacity: 0.7;
        }
        
        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .booking-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: white;
        }
        
        .booking-status {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-pending {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
            border: 1px solid #ffc107;
        }
        
        .status-confirmed {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
            border: 1px solid #28a745;
        }
        
        .status-cancelled {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
            border: 1px solid #dc3545;
        }
        
        .booking-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .booking-detail {
            color: rgba(255, 255, 255, 0.8);
        }
        
        .booking-detail strong {
            color: #64ffda;
        }
        
        .booking-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .btn-small {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .btn-primary-small {
            background: #007aff;
            color: white;
        }
        
        .btn-primary-small:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }
        
        .btn-success-small {
            background: #28a745;
            color: white;
        }
        
        .btn-success-small:hover {
            background: #1e7e34;
            transform: translateY(-2px);
        }
        
        .no-bookings {
            text-align: center;
            padding: 3rem;
            color: rgba(255, 255, 255, 0.6);
        }
        
        .no-bookings h3 {
            color: #64ffda;
            margin-bottom: 1rem;
        }
        
        @media (max-width: 768px) {
            .bookings-container {
                padding: 1rem;
            }
            
            .booking-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .booking-actions {
                flex-direction: column;
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

        <div class="bookings-container">
            <!-- Header -->
            <div class="section-header text-center mb-8">
                <h1 class="section-title">📅 Le Mie Prenotazioni</h1>
                <p class="section-subtitle">
                    Gestisci le tue esperienze astronomiche con AstroGuida
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
                    <div class="stat-number"><?= $totalBookings ?></div>
                    <div class="stat-label">Prenotazioni Totali</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?= $pendingBookings ?></div>
                    <div class="stat-label">In Attesa</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?= $confirmedBookings ?></div>
                    <div class="stat-label">Confermate</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">€<?= number_format($totalSpent, 2) ?></div>
                    <div class="stat-label">Spesa Totale</div>
                </div>
            </div>

            <!-- Lista Prenotazioni -->
            <div class="bookings-list">
                <h2 class="text-2xl font-bold text-white mb-6">🗓️ Cronologia Prenotazioni</h2>
                
                <?php if (empty($bookings)): ?>
                    <div class="no-bookings">
                        <h3>🌟 Nessuna Prenotazione Trovata</h3>
                        <p>Non hai ancora effettuato prenotazioni.</p>
                        <p>Inizia la tua avventura astronomica!</p>
                        <a href="/?page=services" class="btn-primary-small" style="display: inline-block; margin-top: 1rem;">
                            Prenota Ora
                        </a>
                        <br><br>
                        <p><small><a href="?debug=1" style="color: #64ffda;">Mostra info debug</a></small></p>
                    </div>
                <?php else: ?>
                    <?php foreach ($bookings as $booking): ?>
                        <div class="booking-item <?= $booking['status'] ?? 'pending' ?>">
                            <div class="booking-header">
                                <div class="booking-title">
                                    <?= htmlspecialchars($booking['service_name'] ?? 'Servizio Non Specificato') ?>
                                </div>
                                <div class="booking-status status-<?= $booking['status'] ?? 'pending' ?>">
                                    <?= ucfirst($booking['status'] ?? 'pending') ?>
                                </div>
                            </div>
                            
                            <div class="booking-details">
                                <div class="booking-detail">
                                    <strong>📅 Data:</strong><br>
                                    <?= $booking['booking_date'] ? date('d/m/Y', strtotime($booking['booking_date'])) : 'Non specificata' ?>
                                </div>
                                <div class="booking-detail">
                                    <strong>🕒 Orario:</strong><br>
                                    <?= $booking['booking_time'] ?? 'Non specificato' ?>
                                </div>
                                <div class="booking-detail">
                                    <strong>👥 Partecipanti:</strong><br>
                                    <?= $booking['participants'] ?? 1 ?>
                                </div>
                                <div class="booking-detail">
                                    <strong>💰 Importo:</strong><br>
                                    €<?= number_format($booking['total_amount'] ?? 0, 2) ?>
                                </div>
                                <div class="booking-detail">
                                    <strong>🎫 Codice:</strong><br>
                                    <?= $booking['booking_id'] ?? 'N/A' ?>
                                </div>
                                <div class="booking-detail">
                                    <strong>�� Email:</strong><br>
                                    <?= htmlspecialchars($booking['email'] ?? 'N/A') ?>
                                </div>
                            </div>
                            
                            <?php if (!empty($booking['message'])): ?>
                                <div class="booking-detail">
                                    <strong>📝 Note:</strong><br>
                                    <?= htmlspecialchars($booking['message']) ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="booking-actions">
                                <?php if (($booking['status'] ?? 'pending') === 'pending'): ?>
                                    <a href="/?page=booking&booking_id=<?= $booking['booking_id'] ?>" class="btn-primary-small">
                                        💳 Completa Pagamento
                                    </a>
                                <?php endif; ?>
                                
                                <a href="/?page=contact" class="btn-success-small">
                                    📞 Contatta Supporto
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <!-- Azioni Rapide -->
            <div class="text-center mt-8">
                <a href="/?page=services" class="btn btn-primary btn-lg mr-4">
                    🚀 Nuova Prenotazione
                </a>
                <a href="/?page=profile" class="btn btn-secondary btn-lg">
                    👤 Gestisci Profilo
                </a>
            </div>
        </div>

        <?php include __DIR__ . '/../includes/footer.php'; ?>
    </div>
</body>
</html> 