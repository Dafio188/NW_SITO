<?php
// Logout AstroGuida
require_once __DIR__ . '/../includes/config.php';

// Distruggi la sessione
session_unset();
session_destroy();

// Elimina il cookie di sessione
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Redirect alla home
header('Location: /?page=home');
exit;
?> 