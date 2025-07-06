<?php
require_once __DIR__ . '/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer-master/src/SMTP.php';
require_once __DIR__ . '/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailService {
    private $mailer;
    
    public function __construct() {
        $this->mailer = new PHPMailer(true);
        $this->configureMailer();
    }
    
    private function configureMailer() {
        try {
            // Prova prima con SMTP se configurato
            if ($this->isSmtpConfigured()) {
                $this->mailer->isSMTP();
                $this->mailer->Host = 'smtp.gmail.com'; // Cambia con il tuo SMTP
                $this->mailer->SMTPAuth = true;
                $this->mailer->Username = 'your-email@gmail.com'; // Cambia con la tua email
                $this->mailer->Password = 'your-app-password'; // Cambia con la tua password app
                $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $this->mailer->Port = 587;
                
                // Test connessione SMTP
                $this->mailer->SMTPDebug = 0; // Disabilita debug
                
            } else {
                // Fallback a PHP mail() se SMTP non configurato
                $this->mailer->isMail();
                error_log("EmailService: Usando PHP mail() come fallback");
            }
            
            // Configurazione mittente
            $this->mailer->setFrom('noreply@astroguida.com', 'AstroGuida');
            $this->mailer->isHTML(true);
            $this->mailer->CharSet = 'UTF-8';
            
        } catch (Exception $e) {
            error_log("Errore configurazione email: " . $e->getMessage());
            // Fallback a PHP mail() in caso di errore
            try {
                $this->mailer->isMail();
                $this->mailer->setFrom('noreply@astroguida.com', 'AstroGuida');
                $this->mailer->isHTML(true);
                $this->mailer->CharSet = 'UTF-8';
                error_log("EmailService: Fallback a PHP mail() attivato");
            } catch (Exception $e2) {
                error_log("Errore anche con fallback mail(): " . $e2->getMessage());
            }
        }
    }
    
    /**
     * Verifica se SMTP è configurato correttamente
     */
    private function isSmtpConfigured() {
        // Verifica se le credenziali SMTP sono configurate
        // In un ambiente reale, queste dovrebbero essere in un file di configurazione
        $smtp_host = 'smtp.gmail.com';
        $smtp_user = 'your-email@gmail.com';
        $smtp_pass = 'your-app-password';
        
        // Se le credenziali sono ancora quelle di default, usa il fallback
        if ($smtp_user === 'your-email@gmail.com' || $smtp_pass === 'your-app-password') {
            return false;
        }
        
        return true;
    }
    
    /**
     * Invia email di conferma registrazione
     */
    public function sendRegistrationConfirmation($userEmail, $userName) {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($userEmail, $userName);
            
            $this->mailer->Subject = '🌟 Benvenuto in AstroGuida!';
            
            $htmlBody = $this->getRegistrationTemplate($userName);
            $this->mailer->Body = $htmlBody;
            
            // Versione testo
            $this->mailer->AltBody = $this->getRegistrationTextVersion($userName);
            
            $result = $this->mailer->send();
            
            if ($result) {
                error_log("Email registrazione inviata a: $userEmail");
                return true;
            }
            
        } catch (Exception $e) {
            error_log("Errore invio email registrazione: " . $e->getMessage());
            return false;
        }
        
        return false;
    }
    
    /**
     * Invia email di conferma pagamento
     */
    public function sendPaymentConfirmation($userEmail, $userName, $bookingDetails) {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($userEmail, $userName);
            
            $this->mailer->Subject = '✅ Pagamento Confermato - AstroGuida';
            
            $htmlBody = $this->getPaymentTemplate($userName, $bookingDetails);
            $this->mailer->Body = $htmlBody;
            
            // Versione testo
            $this->mailer->AltBody = $this->getPaymentTextVersion($userName, $bookingDetails);
            
            $result = $this->mailer->send();
            
            if ($result) {
                error_log("Email pagamento inviata a: $userEmail");
                return true;
            }
            
        } catch (Exception $e) {
            error_log("Errore invio email pagamento: " . $e->getMessage());
            return false;
        }
        
        return false;
    }
    
    /**
     * Invia email di conferma prenotazione
     */
    public function sendBookingConfirmation($userEmail, $userName, $bookingDetails) {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($userEmail, $userName);
            
            $this->mailer->Subject = '📅 Prenotazione Confermata - AstroGuida';
            
            $htmlBody = $this->getBookingTemplate($userName, $bookingDetails);
            $this->mailer->Body = $htmlBody;
            
            // Versione testo
            $this->mailer->AltBody = $this->getBookingTextVersion($userName, $bookingDetails);
            
            $result = $this->mailer->send();
            
            if ($result) {
                error_log("Email prenotazione inviata a: $userEmail");
                return true;
            }
            
        } catch (Exception $e) {
            error_log("Errore invio email prenotazione: " . $e->getMessage());
            return false;
        }
        
        return false;
    }
    
    /**
     * Template HTML per email registrazione
     */
    private function getRegistrationTemplate($userName) {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <style>
                body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; margin: 0; padding: 0; background: #f8f9fa; }
                .container { max-width: 600px; margin: 0 auto; background: white; }
                .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2rem; text-align: center; }
                .content { padding: 2rem; }
                .footer { background: #f8f9fa; padding: 1rem; text-align: center; font-size: 0.9rem; color: #6c757d; }
                .button { display: inline-block; background: #007aff; color: white; padding: 1rem 2rem; text-decoration: none; border-radius: 8px; margin: 1rem 0; }
                .highlight { color: #007aff; font-weight: bold; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>🌟 Benvenuto in AstroGuida!</h1>
                    <p>La tua avventura tra le stelle inizia qui</p>
                </div>
                
                <div class='content'>
                    <h2>Ciao " . htmlspecialchars($userName) . "! 👋</h2>
                    
                    <p>Grazie per esserti registrato su <strong>AstroGuida</strong>! Siamo entusiasti di averti nella nostra community di appassionati di astronomia.</p>
                    
                    <h3>🚀 Cosa puoi fare ora:</h3>
                    <ul>
                        <li><strong>🔭 Prenota un'esperienza</strong> - Scegli tra osservazioni guidate, workshop di astrofotografia e tour astronomici</li>
                        <li><strong>🖼️ Esplora la Gallery</strong> - Scopri le nostre migliori foto astronomiche</li>
                        <li><strong>🌌 Live Sky</strong> - Guarda il cielo in diretta streaming</li>
                        <li><strong>📚 Impara</strong> - Accedi ai nostri contenuti educativi</li>
                    </ul>
                    
                    <div style='text-align: center; margin: 2rem 0;'>
                        <a href='" . SITE_URL . "/?page=dashboard' class='button'>🎯 Vai alla Dashboard</a>
                    </div>
                    
                    <div style='background: #e3f2fd; padding: 1.5rem; border-radius: 8px; margin: 1.5rem 0;'>
                        <h4>💡 Suggerimento:</h4>
                        <p>Per la migliore esperienza di osservazione, ti consigliamo di prenotare durante le notti di luna nuova per un cielo più buio e stellato!</p>
                    </div>
                    
                    <p>Se hai domande o hai bisogno di aiuto, non esitare a contattarci.</p>
                    
                    <p>Buona esplorazione! 🌟</p>
                    <p><strong>Il Team AstroGuida</strong></p>
                </div>
                
                <div class='footer'>
                    <p>&copy; " . date('Y') . " AstroGuida - Tutti i diritti riservati</p>
                    <p>📍 Cassano delle Murge, Puglia | 📧 info@astroguida.com</p>
                </div>
            </div>
        </body>
        </html>";
    }
    
    /**
     * Template HTML per email pagamento
     */
    private function getPaymentTemplate($userName, $bookingDetails) {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <style>
                body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; margin: 0; padding: 0; background: #f8f9fa; }
                .container { max-width: 600px; margin: 0 auto; background: white; }
                .header { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; padding: 2rem; text-align: center; }
                .content { padding: 2rem; }
                .footer { background: #f8f9fa; padding: 1rem; text-align: center; font-size: 0.9rem; color: #6c757d; }
                .booking-details { background: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin: 1.5rem 0; }
                .amount { font-size: 1.5rem; color: #28a745; font-weight: bold; }
                .status { background: #d4edda; color: #155724; padding: 0.5rem 1rem; border-radius: 20px; display: inline-block; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>✅ Pagamento Confermato!</h1>
                    <p>La tua prenotazione è stata completata con successo</p>
                </div>
                
                <div class='content'>
                    <h2>Grazie " . htmlspecialchars($userName) . "! 🎉</h2>
                    
                    <p>Il tuo pagamento è stato elaborato con successo. La tua prenotazione è ora <span class='status'>✅ CONFERMATA</span></p>
                    
                    <div class='booking-details'>
                        <h3>📋 Dettagli Prenotazione:</h3>
                        <p><strong>Codice:</strong> " . htmlspecialchars($bookingDetails['booking_id']) . "</p>
                        <p><strong>Servizio:</strong> " . htmlspecialchars($bookingDetails['service_name']) . "</p>
                        <p><strong>Data:</strong> " . date('d/m/Y', strtotime($bookingDetails['booking_date'])) . "</p>
                        <p><strong>Orario:</strong> " . htmlspecialchars($bookingDetails['booking_time'] ?? 'Da definire') . "</p>
                        <p><strong>Partecipanti:</strong> " . htmlspecialchars($bookingDetails['participants']) . "</p>
                        <p><strong>Importo Pagato:</strong> <span class='amount'>€" . number_format($bookingDetails['total_amount'], 2) . "</span></p>
                    </div>
                    
                    <h3>📞 Prossimi Passi:</h3>
                    <ul>
                        <li>Ti contatteremo entro 24 ore per confermare i dettagli</li>
                        <li>Riceverai istruzioni specifiche per il punto di incontro</li>
                        <li>Controlla la tua dashboard per aggiornamenti</li>
                    </ul>
                    
                    <div style='background: #fff3cd; padding: 1.5rem; border-radius: 8px; margin: 1.5rem 0;'>
                        <h4>🌟 Preparati per l'esperienza:</h4>
                        <p>Porta abiti caldi, una torcia con luce rossa e tanta curiosità per le stelle!</p>
                    </div>
                    
                    <p>Non vediamo l'ora di condividere con te la bellezza dell'universo! 🌌</p>
                    <p><strong>Il Team AstroGuida</strong></p>
                </div>
                
                <div class='footer'>
                    <p>&copy; " . date('Y') . " AstroGuida - Tutti i diritti riservati</p>
                    <p>📍 Cassano delle Murge, Puglia | 📧 info@astroguida.com</p>
                </div>
            </div>
        </body>
        </html>";
    }
    
    /**
     * Template HTML per email prenotazione
     */
    private function getBookingTemplate($userName, $bookingDetails) {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <style>
                body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; margin: 0; padding: 0; background: #f8f9fa; }
                .container { max-width: 600px; margin: 0 auto; background: white; }
                .header { background: linear-gradient(135deg, #007aff 0%, #5856d6 100%); color: white; padding: 2rem; text-align: center; }
                .content { padding: 2rem; }
                .footer { background: #f8f9fa; padding: 1rem; text-align: center; font-size: 0.9rem; color: #6c757d; }
                .booking-details { background: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin: 1.5rem 0; }
                .payment-link { background: #007aff; color: white; padding: 1rem 2rem; text-decoration: none; border-radius: 8px; display: inline-block; margin: 1rem 0; }
                .amount { font-size: 1.5rem; color: #007aff; font-weight: bold; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>📅 Prenotazione Ricevuta!</h1>
                    <p>Completa il pagamento per confermare</p>
                </div>
                
                <div class='content'>
                    <h2>Ciao " . htmlspecialchars($userName) . "! 👋</h2>
                    
                    <p>Abbiamo ricevuto la tua prenotazione. Per completare il processo, effettua il pagamento sicuro tramite PayPal.</p>
                    
                    <div class='booking-details'>
                        <h3>📋 Dettagli Prenotazione:</h3>
                        <p><strong>Codice:</strong> " . htmlspecialchars($bookingDetails['booking_id']) . "</p>
                        <p><strong>Servizio:</strong> " . htmlspecialchars($bookingDetails['service_name']) . "</p>
                        <p><strong>Data:</strong> " . date('d/m/Y', strtotime($bookingDetails['booking_date'])) . "</p>
                        <p><strong>Orario:</strong> " . htmlspecialchars($bookingDetails['booking_time'] ?? 'Da definire') . "</p>
                        <p><strong>Partecipanti:</strong> " . htmlspecialchars($bookingDetails['participants']) . "</p>
                        <p><strong>Importo:</strong> <span class='amount'>€" . number_format($bookingDetails['total_amount'], 2) . "</span></p>
                    </div>
                    
                    <div style='text-align: center; margin: 2rem 0;'>
                        <a href='" . SITE_URL . "/paypal-payment.php?booking_id=" . urlencode($bookingDetails['booking_id']) . "&amount=" . $bookingDetails['total_amount'] . "' class='payment-link'>
                            💳 Paga Ora con PayPal
                        </a>
                    </div>
                    
                    <p><strong>Importante:</strong> La prenotazione sarà confermata solo dopo il pagamento completato.</p>
                    
                    <p>Grazie per aver scelto AstroGuida! 🌟</p>
                    <p><strong>Il Team AstroGuida</strong></p>
                </div>
                
                <div class='footer'>
                    <p>&copy; " . date('Y') . " AstroGuida - Tutti i diritti riservati</p>
                    <p>📍 Cassano delle Murge, Puglia | 📧 info@astroguida.com</p>
                </div>
            </div>
        </body>
        </html>";
    }
    
    /**
     * Versioni testo delle email
     */
    private function getRegistrationTextVersion($userName) {
        return "
        Benvenuto in AstroGuida!
        
        Ciao " . $userName . "!
        
        Grazie per esserti registrato su AstroGuida! Siamo entusiasti di averti nella nostra community.
        
        Cosa puoi fare ora:
        - Prenota un'esperienza astronomica
        - Esplora la nostra gallery
        - Guarda il cielo in diretta
        - Accedi ai contenuti educativi
        
        Visita la tua dashboard: " . SITE_URL . "/?page=dashboard
        
        Il Team AstroGuida
        ";
    }
    
    private function getPaymentTextVersion($userName, $bookingDetails) {
        return "
        Pagamento Confermato!
        
        Grazie " . $userName . "!
        
        Il tuo pagamento è stato elaborato con successo.
        
        Dettagli:
        - Codice: " . $bookingDetails['booking_id'] . "
        - Servizio: " . $bookingDetails['service_name'] . "
        - Data: " . date('d/m/Y', strtotime($bookingDetails['booking_date'])) . "
        - Importo: €" . number_format($bookingDetails['total_amount'], 2) . "
        
        Ti contatteremo entro 24 ore per i dettagli.
        
        Il Team AstroGuida
        ";
    }
    
    private function getBookingTextVersion($userName, $bookingDetails) {
        return "
        Prenotazione Ricevuta!
        
        Ciao " . $userName . "!
        
        Abbiamo ricevuto la tua prenotazione.
        
        Dettagli:
        - Codice: " . $bookingDetails['booking_id'] . "
        - Servizio: " . $bookingDetails['service_name'] . "
        - Data: " . date('d/m/Y', strtotime($bookingDetails['booking_date'])) . "
        - Importo: €" . number_format($bookingDetails['total_amount'], 2) . "
        
        Completa il pagamento per confermare:
        " . SITE_URL . "/paypal-payment.php?booking_id=" . urlencode($bookingDetails['booking_id']) . "
        
        Il Team AstroGuida
        ";
    }
}

// Funzione helper per ottenere l'istanza del servizio email
function getEmailService() {
    return new EmailService();
}
?> 