<?php /* Admin Dashboard AstroGuida */ ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin - AstroGuida</title>
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
    <h1>Dashboard Amministratore</h1>
    <p>Gestisci utenti, prenotazioni e gallery dal pannello di controllo.</p>
</section>
<section>
    <div class="card">
        <h2>Gestione rapida</h2>
        <ul>
            <li><a href="#">Gestione utenti</a></li>
            <li><a href="#">Gestione prenotazioni</a></li>
            <li><a href="#">Gestione gallery</a></li>
            <li><a href="#">Configurazioni sito</a></li>
        </ul>
    </div>
</section>
<footer>
    &copy; <?php echo date('Y'); ?> AstroGuida.com - Tutti i diritti riservati
</footer>
</body>
</html> 