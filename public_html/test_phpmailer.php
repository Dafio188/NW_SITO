<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
echo '<h2>Test PHPMailer</h2>';
try {
    require_once __DIR__ . '/includes/PHPMailer/src/Exception.php';
    require_once __DIR__ . '/includes/PHPMailer/src/PHPMailer.php';
    require_once __DIR__ . '/includes/PHPMailer/src/SMTP.php';
    echo '<p style="color:green">PHPMailer caricato correttamente!</p>';
} catch (Throwable $e) {
    echo '<p style="color:red">Errore: ' . htmlspecialchars($e->getMessage()) . '</p>';
} 