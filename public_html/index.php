<?php
// Routing dinamico AstroGuida con Design System Mac-inspired
require_once __DIR__ . '/includes/config.php';

// Headers anti-cache per sviluppo
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Configurazione errori per sviluppo
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Routing delle pagine
$page = $_GET['page'] ?? 'home';
$allowed = [
    'home', 'gallery', 'booking', 'login', 'register', 'dashboard', 'admin', 'admin_dashboard',
    'services', 'live-sky', 'about', 'contact', 'faq', 'privacy', 'terms',
    'reset_password', 'new_password', 'logout',
    // Pagine Admin
    'admin_bookings', 'admin_gallery', 'admin_services', 'admin_contacts',
    'user_bookings'
];

if (!in_array($page, $allowed)) {
    $page = 'home';
}

$filepath = __DIR__ . "/pages/{$page}.php";

if (file_exists($filepath)) {
    include $filepath;
} else {
    // Pagina 404 con design system
    http_response_code(404);
    ?>
    <!DOCTYPE html>
    <html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>404 - Pagina Non Trovata | AstroGuida</title>
        <link rel="stylesheet" href="/assets/css/main.css">
        <link rel="icon" href="/favicon.jpg">
    </head>
    <body>
        <div class="main-container">
            <div class="flex items-center justify-center min-h-screen">
                <div class="card text-center max-w-md">
                    <div class="text-6xl mb-6">🌌</div>
                    <h1 class="text-4xl font-bold text-white mb-4">404</h1>
                    <h2 class="text-xl text-silver mb-6">Pagina Non Trovata</h2>
                    <p class="text-silver mb-8">
                        La pagina che stai cercando sembra essere persa nello spazio infinito.
                    </p>
                    <div class="flex gap-4 justify-center flex-wrap">
                        <a href="/" class="btn btn-primary">
                            🏠 Torna Home
                        </a>
                        <a href="/services" class="btn btn-secondary">
                            🌟 Vedi Servizi
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/stellar-animations.js"></script>
    </body>
    </html>
    <?php
} 