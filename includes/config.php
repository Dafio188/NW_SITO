<?php
// Configurazione base AstroGuida

// Avvia la sessione se non è già avviata
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('SQLITE_PATH', __DIR__ . '/../data/astroguida.sqlite');
define('DB_PATH', __DIR__ . '/../data/astroguida.sqlite'); // Alias per compatibilità

define('BASE_URL', 'https://astroguida.com/');
define('SITE_URL', 'https://astroguida.com'); // Senza slash finale per compatibilità
define('SITE_NAME', 'AstroGuida');
define('SITE_EMAIL', 'info@astroguida.com');

define('UPLOADS_DIR', __DIR__ . '/../uploads/');
define('GALLERY_DIR', UPLOADS_DIR . 'gallery/');
define('AVATAR_DIR', UPLOADS_DIR . 'avatars/');
define('DOCS_DIR', UPLOADS_DIR . 'documents/');

define('SMTP_HOST', 'smtps.aruba.it');
define('SMTP_PORT', 465);
define('SMTP_USER', 'info@astroguida.com');
define('SMTP_PASS', '');
define('SMTP_SECURE', 'ssl');

// Sicurezza
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.use_strict_mode', 1); 