<?php
// Sistema PayPal per pagamenti prenotazioni AstroGuida
require_once __DIR__ . '/includes/config.php';

// Configurazione PayPal
$paypal_email = 'fio.davide@gmail.com';
$paypal_sandbox = false; // true per test, false per produzione
$paypal_url = $paypal_sandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';

// Recupera dati prenotazione
$booking_id = $_GET['booking_id'] ?? '';
$amount = $_GET['amount'] ?? 0;
$service_name = $_GET['service'] ?? '';

if (empty($booking_id) || $amount <= 0) {
    header('Location: /?page=booking&error=invalid_payment_data');
    exit;
}

// Verifica prenotazione nel database
try {
    require_once __DIR__ . '/includes/database.php';
    $db = getDb();
    
    $stmt = $db->prepare("SELECT * FROM bookings WHERE booking_id = ? AND status = 'pending'");
    $stmt->execute([$booking_id]);
    $booking = $stmt->fetch();
    
    if (!$booking) {
        header('Location: /?page=booking&error=booking_not_found');
        exit;
    }
    
} catch (Exception $e) {
    header('Location: /?page=booking&error=database_error');
    exit;
}

// URL di ritorno
$return_url = SITE_URL . '/paypal-success.php';
$cancel_url = SITE_URL . '/paypal-cancel.php';
$notify_url = SITE_URL . '/paypal-ipn.php';

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento PayPal - AstroGuida</title>
    <link rel="icon" href="/favicon.jpg" type="image/jpeg">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 2rem;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .payment-container {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }
        
        .payment-title {
            font-size: 2rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #64ffda, #007aff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .booking-details {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 1.5rem;
            margin: 1.5rem 0;
            text-align: left;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin: 0.5rem 0;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .detail-row:last-child {
            border-bottom: none;
            font-weight: bold;
            font-size: 1.2rem;
            color: #64ffda;
        }
        
        .paypal-button {
            background: #0070ba;
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 1rem 0;
            width: 100%;
        }
        
        .paypal-button:hover {
            background: #005ea6;
            transform: translateY(-2px);
        }
        
        .security-info {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 1rem;
        }
        
        .cancel-link {
            display: inline-block;
            margin-top: 1rem;
            color: #64ffda;
            text-decoration: none;
        }
        
        .cancel-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <h1 class="payment-title">💳 Pagamento Sicuro</h1>
        
        <p>Completa il pagamento per confermare la tua prenotazione</p>
        
        <div class="booking-details">
            <div class="detail-row">
                <span>Codice Prenotazione:</span>
                <span><?= htmlspecialchars($booking_id) ?></span>
            </div>
            <div class="detail-row">
                <span>Servizio:</span>
                <span><?= htmlspecialchars($booking['service_name']) ?></span>
            </div>
            <div class="detail-row">
                <span>Data:</span>
                <span><?= htmlspecialchars($booking['booking_date']) ?></span>
            </div>
            <div class="detail-row">
                <span>Partecipanti:</span>
                <span><?= $booking['participants'] ?> persone</span>
            </div>
            <div class="detail-row">
                <span>Totale da Pagare:</span>
                <span>€<?= number_format($amount, 2) ?></span>
            </div>
        </div>
        
        <!-- Form PayPal -->
        <form action="<?= $paypal_url ?>" method="post">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="business" value="<?= $paypal_email ?>">
            <input type="hidden" name="item_name" value="AstroGuida - <?= htmlspecialchars($booking['service_name']) ?>">
            <input type="hidden" name="item_number" value="<?= htmlspecialchars($booking_id) ?>">
            <input type="hidden" name="amount" value="<?= $amount ?>">
            <input type="hidden" name="currency_code" value="EUR">
            <input type="hidden" name="return" value="<?= $return_url ?>">
            <input type="hidden" name="cancel_return" value="<?= $cancel_url ?>">
            <input type="hidden" name="notify_url" value="<?= $notify_url ?>">
            <input type="hidden" name="custom" value="<?= $booking_id ?>">
            
            <button type="submit" class="paypal-button">
                🛡️ Paga con PayPal - €<?= number_format($amount, 2) ?>
            </button>
        </form>
        
        <div class="security-info">
            🔒 Pagamento sicuro tramite PayPal<br>
            Non conserviamo i tuoi dati di pagamento
        </div>
        
        <a href="/?page=booking" class="cancel-link">← Torna alle prenotazioni</a>
    </div>
</body>
</html> 