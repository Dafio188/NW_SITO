<?php
// Configurazione base AstroGuida
// Copia questo file in config.php e modifica i valori secondo necessità

define('SITE_NAME', 'AstroGuida');
define('BASE_URL', 'https://tuodominio.com/');
define('DB_PATH', __DIR__.'/../data/astroguida.sqlite');
define('SQLITE_PATH', DB_PATH);
define('UPLOADS_DIR', __DIR__.'/../uploads/');
define('GALLERY_DIR', __DIR__.'/../uploads/gallery/');
define('AVATAR_DIR', __DIR__.'/../uploads/avatars/');
define('ADMIN_EMAIL', 'admin@tuodominio.com');

define('SITE_EMAIL', 'info@tuodominio.com');

define('DOCS_DIR', UPLOADS_DIR . 'documents/');

// Configurazione SMTP (inserisci le tue credenziali)
define('SMTP_HOST', 'smtp.tuohosting.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'info@tuodominio.com');
define('SMTP_PASS', 'LA_TUA_PASSWORD_EMAIL');
define('SMTP_SECURE', 'tls');

// Sicurezza - solo se sessione non è già attiva
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', 1);
    ini_set('session.use_strict_mode', 1);
}
?> 