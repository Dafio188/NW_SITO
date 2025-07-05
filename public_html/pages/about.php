<?php
require_once __DIR__ . '/../../includes/config.php';
?><!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi siamo - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>
    <header>
        <img src="/mio_logo.jpg" alt="Logo <?= SITE_NAME ?>" style="height:60px;">
        <nav>
            <a href="/">Home</a>
            <a href="/?page=gallery">Gallery</a>
            <a href="/?page=services">Servizi</a>
            <a href="/?page=booking">Prenota</a>
            <a href="/?page=about">Chi siamo</a>
            <a href="/?page=contact">Contatti</a>
        </nav>
    </header>
    <main>
        <section class="about">
            <h1>Chi siamo</h1>
            <p>Siamo appassionati di astronomia, astrofotografia e divulgazione scientifica. Il nostro obiettivo è portare le meraviglie del cielo a tutti, attraverso eventi, servizi e tecnologia, con un approccio professionale e accessibile.</p>
        </section>
    </main>
    <footer>
        <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?> - Tutti i diritti riservati</p>
    </footer>
</body>
</html> 