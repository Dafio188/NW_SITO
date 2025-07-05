<?php
require_once __DIR__ . '/../../includes/config.php';
?><!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servizi - <?= SITE_NAME ?></title>
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
        <section class="services">
            <h1>I nostri servizi</h1>
            <ul>
                <li>Esperienze di osservazione guidata del cielo</li>
                <li>Astrofotografia professionale</li>
                <li>Turismo astronomico in Puglia</li>
                <li>Consulenza e formazione astronomica</li>
                <li>Eventi e serate a tema</li>
            </ul>
        </section>
    </main>
    <footer>
        <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?> - Tutti i diritti riservati</p>
    </footer>
</body>
</html> 