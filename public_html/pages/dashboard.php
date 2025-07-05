<?php 
require_once __DIR__.'/../includes/auth.php';
$auth = getAuth();
$auth->requireLogin();
$user = $auth->user();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Dashboard - AstroGuida</title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <script defer src="/assets/js/main.js"></script>
</head>
<body>
<header>
    <img src="/assets/images/logo/logo.png" alt="AstroGuida Logo" style="height:48px;">
    <nav>
        <a href="/">Home</a>
        <a href="/gallery">Gallery</a>
        <a href="/booking">Prenota</a>
        <a href="/login">Login</a>
    </nav>
</header>
<section class="hero">
    <h1>Dashboard Utente</h1>
    <p>Benvenuto, <b><?= htmlspecialchars($user['name']) ?></b>! Qui puoi gestire le tue prenotazioni e il profilo.</p>
</section>
<section>
    <div class="card">
        <h2>Le tue prenotazioni</h2>
        <ul>
            <li>Nessuna prenotazione trovata (demo)</li>
        </ul>
        <a class="btn btn-primary" href="/booking">Prenota un nuovo servizio</a>
    </div>
    <div class="card" style="margin-top:24px;">
        <h2>Profilo</h2>
        <p>Email: <?= htmlspecialchars($user['email']) ?></p>
        <a href="/logout">Logout</a>
    </div>
</section>
<footer>
    &copy; <?php echo date('Y'); ?> AstroGuida.com - Tutti i diritti riservati
</footer>
</body>
</html> 