<?php
// Configurazione base AstroGuida

define('SQLITE_PATH', __DIR__ . '/../data/astroguida.sqlite');

define('BASE_URL', 'https://astroguida.com/');
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