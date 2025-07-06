<?php
// Pagina successo pagamento PayPal
require_once __DIR__ . '/includes/config.php';

$payment_status = $_GET['st'] ?? '';
$booking_id = $_GET['cm'] ?? ''; // custom field
$transaction_id = $_GET['tx'] ?? '';
$amount = $_GET['amt'] ?? 0;

// Verifica e aggiorna prenotazione
if ($payment_status === 'Completed' && !empty($booking_id)) {
    try {
        require_once __DIR__ . '/includes/database.php';
        $db = getDb();
        
        // Aggiorna status prenotazione
        $stmt = $db->prepare("
            UPDATE bookings 
            SET status = 'confirmed', payment_status = 'completed', transaction_id = ? 
            WHERE booking_id = ?
        ");
        $stmt->execute([$transaction_id, $booking_id]);
        
        // Recupera dettagli prenotazione per email
        $stmt = $db->prepare("SELECT * FROM bookings WHERE booking_id = ?");
        $stmt->execute([$booking_id]);
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Invio email di conferma pagamento
        if ($booking) {
            try {
                require_once __DIR__ . '/includes/email_service.php';
                $emailService = getEmailService();
                
                $bookingDetails = [
                    'booking_id' => $booking['booking_id'],
                    'service_name' => $booking['service_name'],
                    'booking_date' => $booking['booking_date'],
                    'booking_time' => $booking['booking_time'],
                    'participants' => $booking['participants'],
                    'total_amount' => $booking['total_amount']
                ];
                
                $emailService->sendPaymentConfirmation($booking['email'], $booking['name'], $bookingDetails);
                
            } catch (Exception $e) {
                error_log("Errore invio email pagamento: " . $e->getMessage());
            }
        }
        
    } catch (Exception $e) {
        error_log("Errore aggiornamento prenotazione: " . $e->getMessage());
    }
}

$success = true;
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento Completato - AstroGuida</title>
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
        
        .success-container {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 3rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }
        
        .success-icon {
            font-size: 5rem;
            margin-bottom: 1rem;
            color: #28a745;
        }
        
        .success-title {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #28a745;
        }
        
        .booking-confirmed {
            background: rgba(40, 167, 69, 0.1);
            border: 1px solid #28a745;
            border-radius: 15px;
            padding: 2rem;
            margin: 2rem 0;
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
        }
        
        .actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }
        
        .btn {
            padding: 1rem 2rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #64ffda, #007aff);
            color: white;
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon">✅</div>
        <h1 class="success-title">Pagamento Completato!</h1>
        
        <p>La tua prenotazione è stata confermata con successo.</p>
        
        <?php if (isset($booking) && $booking): ?>
            <div class="booking-confirmed">
                <h3>📅 Dettagli Prenotazione Confermata</h3>
                <div class="detail-row">
                    <span>Codice Prenotazione:</span>
                    <span><strong><?= htmlspecialchars($booking['booking_id']) ?></strong></span>
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
                    <span>Orario:</span>
                    <span><?= htmlspecialchars($booking['booking_time'] ?? 'Da definire') ?></span>
                </div>
                <div class="detail-row">
                    <span>Partecipanti:</span>
                    <span><?= $booking['participants'] ?> persone</span>
                </div>
                <div class="detail-row">
                    <span>Stato:</span>
                    <span style="color: #28a745; font-weight: bold;">CONFERMATA</span>
                </div>
                <?php if (!empty($transaction_id)): ?>
                <div class="detail-row">
                    <span>ID Transazione:</span>
                    <span><?= htmlspecialchars($transaction_id) ?></span>
                </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <div style="background: rgba(255, 255, 255, 0.05); padding: 1.5rem; border-radius: 10px; margin: 2rem 0;">
            <h4>📧 Prossimi Passi</h4>
            <p>• Riceverai un'email di conferma entro 24 ore</p>
            <p>• Ti contatteremo per confermare i dettagli dell'esperienza</p>
            <p>• Conserva il codice prenotazione per future comunicazioni</p>
        </div>
        
        <div class="actions">
            <a href="/?page=user_bookings" class="btn btn-primary">📅 Le Mie Prenotazioni</a>
            <a href="/" class="btn btn-secondary">🏠 Torna alla Home</a>
        </div>
    </div>
</body>
</html> 