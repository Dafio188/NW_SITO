<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';

$auth = getAuth();

// Verifica autenticazione admin
if (!$auth->isLogged()) {
    header('Location: /?page=login');
    exit;
}

$user = $auth->user();
if (!is_array($user) || ($user['role'] ?? '') !== 'admin') {
    header('Location: /?page=login');
    exit;
}

require_once __DIR__ . '/../includes/database.php';
$db = getDb();

// Gestione azioni
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && isset($_POST['booking_id'])) {
        $booking_id = (int)$_POST['booking_id'];
        $action = $_POST['action'];
        
        try {
            switch ($action) {
                case 'confirm':
                    $db->prepare("UPDATE bookings SET status = 'confirmed' WHERE id = ?")->execute([$booking_id]);
                    $message = "✅ Prenotazione confermata con successo!";
                    break;
                case 'cancel':
                    $db->prepare("UPDATE bookings SET status = 'cancelled' WHERE id = ?")->execute([$booking_id]);
                    $message = "❌ Prenotazione annullata.";
                    break;
                case 'delete':
                    $db->prepare("DELETE FROM bookings WHERE id = ?")->execute([$booking_id]);
                    $message = "🗑️ Prenotazione eliminata.";
                    break;
                case 'payment_received':
                    $db->prepare("UPDATE bookings SET payment_status = 'completed', status = 'confirmed' WHERE id = ?")->execute([$booking_id]);
                    $message = "💰 Pagamento registrato e prenotazione confermata!";
                    break;
            }
        } catch (Exception $e) {
            $message = "❌ Errore: " . $e->getMessage();
        }
    }
}

// Recupera prenotazioni
try {
    $stmt = $db->query("
        SELECT b.*, u.name as user_name, u.email as user_email
        FROM bookings b 
        LEFT JOIN users u ON b.user_id = u.id 
        ORDER BY b.created_at DESC
    ");
    $bookings = $stmt->fetchAll();
} catch (Exception $e) {
    $bookings = [];
    $message = "❌ Errore nel caricamento prenotazioni: " . $e->getMessage();
}

// Statistiche
$stats = [
    'total' => count($bookings),
    'pending' => count(array_filter($bookings, fn($b) => $b['status'] === 'pending')),
    'confirmed' => count(array_filter($bookings, fn($b) => $b['status'] === 'confirmed')),
    'cancelled' => count(array_filter($bookings, fn($b) => $b['status'] === 'cancelled')),
];

// Calendario - prenotazioni per mese corrente
$current_month = date('Y-m');
$calendar_bookings = array_filter($bookings, fn($b) => strpos($b['booking_date'], $current_month) === 0);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📅 Gestione Prenotazioni - Admin AstroGuida</title>
    <link rel="icon" href="/favicon.jpg" type="image/jpeg">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            color: #fff;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .header {
            background: rgba(0, 0, 0, 0.3);
            padding: 1rem 0;
            margin-bottom: 2rem;
            border-radius: 15px;
            backdrop-filter: blur(10px);
        }
        
        .header h1 {
            margin: 0;
            text-align: center;
            color: #64ffda;
            font-size: 2rem;
        }
        
        .nav-links {
            text-align: center;
            margin-top: 1rem;
        }
        
        .nav-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            margin: 0 1rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .nav-links a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #64ffda;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #64ffda;
        }
        
        .stat-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }
        
        .card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .booking-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border-left: 4px solid #64ffda;
            transition: all 0.3s ease;
        }
        
        .booking-card:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        
        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .booking-id {
            color: #64ffda;
            font-weight: bold;
            font-size: 1.1rem;
        }
        
        .booking-date {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
        }
        
        .booking-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .booking-field {
            color: rgba(255, 255, 255, 0.8);
        }
        
        .booking-field strong {
            color: #fff;
        }
        
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        
        .status-pending { background: #ff9500; color: white; }
        .status-confirmed { background: #34c759; color: white; }
        .status-cancelled { background: #ff3b30; color: white; }
        
        .booking-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }
        
        .btn-confirm { background: #34c759; color: white; }
        .btn-cancel { background: #ff9500; color: white; }
        .btn-delete { background: #ff3b30; color: white; }
        .btn-payment { background: #007aff; color: white; }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
        
        .message {
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            background: rgba(52, 199, 89, 0.2);
            border: 1px solid #34c759;
            color: #34c759;
        }
        
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        
        .calendar-day {
            background: rgba(255, 255, 255, 0.05);
            padding: 1rem;
            text-align: center;
            min-height: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        .calendar-day.has-booking {
            background: rgba(100, 255, 218, 0.2);
            border: 1px solid #64ffda;
        }
        
        .calendar-day-number {
            font-weight: bold;
            color: #fff;
        }
        
        .calendar-bookings {
            font-size: 0.8rem;
            color: #64ffda;
        }
        
        @media (max-width: 768px) {
            .container { padding: 1rem; }
            .booking-info { grid-template-columns: 1fr; }
            .booking-actions { flex-direction: column; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📅 Gestione Prenotazioni AstroGuida</h1>
            <div class="nav-links">
                <a href="/?page=admin_dashboard">🏠 Dashboard Admin</a>
                <a href="/?page=booking">👁️ Form Prenotazioni</a>
                <a href="/?page=logout">🚪 Logout</a>
            </div>
        </div>
        
        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        
        <!-- Statistiche -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?= $stats['total'] ?></div>
                <div class="stat-label">Prenotazioni Totali</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $stats['pending'] ?></div>
                <div class="stat-label">In Attesa</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $stats['confirmed'] ?></div>
                <div class="stat-label">Confermate</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $stats['cancelled'] ?></div>
                <div class="stat-label">Annullate</div>
            </div>
        </div>
        
        <!-- Calendario Mensile -->
        <div class="card">
            <h2>📅 Calendario <?= date('F Y') ?></h2>
            <div class="calendar-grid">
                <?php
                $days = ['Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab', 'Dom'];
                foreach ($days as $day) {
                    echo "<div class='calendar-day'><strong>$day</strong></div>";
                }
                
                $first_day = date('Y-m-01');
                $last_day = date('Y-m-t');
                $start_day = date('N', strtotime($first_day));
                
                // Giorni vuoti inizio mese
                for ($i = 1; $i < $start_day; $i++) {
                    echo "<div class='calendar-day'></div>";
                }
                
                // Giorni del mese
                for ($day = 1; $day <= date('t'); $day++) {
                    $current_date = date('Y-m-') . sprintf('%02d', $day);
                    $day_bookings = array_filter($calendar_bookings, fn($b) => $b['booking_date'] === $current_date);
                    $booking_count = count($day_bookings);
                    
                    $class = $booking_count > 0 ? 'calendar-day has-booking' : 'calendar-day';
                    echo "<div class='$class'>";
                    echo "<div class='calendar-day-number'>$day</div>";
                    if ($booking_count > 0) {
                        echo "<div class='calendar-bookings'>$booking_count prenotazioni</div>";
                    }
                    echo "</div>";
                }
                ?>
            </div>
        </div>
        
        <!-- Lista Prenotazioni -->
        <div class="card">
            <h2>📋 Tutte le Prenotazioni</h2>
            
            <?php if (empty($bookings)): ?>
                <p style="text-align: center; color: rgba(255, 255, 255, 0.6);">
                    Nessuna prenotazione trovata.
                </p>
            <?php else: ?>
                <?php foreach ($bookings as $booking): ?>
                    <div class="booking-card">
                        <div class="booking-header">
                            <div class="booking-id">
                                <?= htmlspecialchars($booking['booking_id'] ?? "ID-{$booking['id']}") ?>
                            </div>
                            <div class="booking-date">
                                <?= date('d/m/Y H:i', strtotime($booking['created_at'])) ?>
                            </div>
                        </div>
                        
                        <div class="booking-info">
                            <div class="booking-field">
                                <strong>Cliente:</strong> <?= htmlspecialchars($booking['name']) ?>
                            </div>
                            <div class="booking-field">
                                <strong>Email:</strong> <?= htmlspecialchars($booking['email']) ?>
                            </div>
                            <div class="booking-field">
                                <strong>Telefono:</strong> <?= htmlspecialchars($booking['phone'] ?? 'Non fornito') ?>
                            </div>
                            <div class="booking-field">
                                <strong>Servizio:</strong> <?= htmlspecialchars($booking['service_name']) ?>
                            </div>
                            <div class="booking-field">
                                <strong>Data:</strong> <?= htmlspecialchars($booking['booking_date']) ?>
                            </div>
                            <div class="booking-field">
                                <strong>Orario:</strong> <?= htmlspecialchars($booking['booking_time'] ?? 'Non specificato') ?>
                            </div>
                            <div class="booking-field">
                                <strong>Partecipanti:</strong> <?= (int)$booking['participants'] ?>
                            </div>
                            <div class="booking-field">
                                <strong>Totale:</strong> €<?= number_format($booking['total_amount'] ?? 0, 2) ?>
                            </div>
                        </div>
                        
                        <?php if (!empty($booking['message'])): ?>
                            <div class="booking-field" style="margin-top: 1rem;">
                                <strong>Note:</strong> <?= htmlspecialchars($booking['message']) ?>
                            </div>
                        <?php endif; ?>
                        
                        <div style="margin-top: 1rem; display: flex; justify-content: space-between; align-items: center;">
                            <span class="status-badge status-<?= $booking['status'] ?>">
                                <?= strtoupper($booking['status']) ?>
                            </span>
                            
                            <div class="booking-actions">
                                <?php if ($booking['status'] === 'pending'): ?>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                                        <button type="submit" name="action" value="confirm" class="btn btn-confirm">
                                            ✅ Conferma
                                        </button>
                                    </form>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                                        <button type="submit" name="action" value="payment_received" class="btn btn-payment">
                                            💰 Pagamento Ricevuto
                                        </button>
                                    </form>
                                <?php endif; ?>
                                
                                <?php if ($booking['status'] !== 'cancelled'): ?>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                                        <button type="submit" name="action" value="cancel" class="btn btn-cancel">
                                            ❌ Annulla
                                        </button>
                                    </form>
                                <?php endif; ?>
                                
                                <form method="post" style="display: inline;" onsubmit="return confirm('Sei sicuro di voler eliminare questa prenotazione?')">
                                    <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                                    <button type="submit" name="action" value="delete" class="btn btn-delete">
                                        🗑️ Elimina
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html> 