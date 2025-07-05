<?php
require_once __DIR__ . '/../../includes/config.php';
?><!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Sky Cassano delle Murge - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <style>
        .live-embed {max-width:800px;margin:32px auto;display:block;}
        .meteo-box {background:rgba(0,0,0,0.3);padding:16px;border-radius:12px;margin:24px auto;max-width:400px;text-align:center;}
        .archive {margin:32px auto;max-width:800px;}
        .archive h2 {margin-bottom:12px;}
        .archive-list {display:flex;flex-wrap:wrap;gap:16px;}
        .archive-list iframe {width:320px;height:180px;}
    </style>
</head>
<body>
    <header>
        <img src="/mio_logo.jpg" alt="Logo <?= SITE_NAME ?>" style="height:60px;">
        <nav>
            <a href="/">Home</a>
            <a href="/?page=live_sky">Live Sky</a>
            <a href="/?page=gallery">Gallery</a>
            <a href="/?page=services">Servizi</a>
            <a href="/?page=booking">Prenota</a>
            <a href="/?page=about">Chi siamo</a>
            <a href="/?page=contact">Contatti</a>
        </nav>
    </header>
    <main>
        <section class="live-stream">
            <h1>Live Sky Cassano delle Murge</h1>
            <iframe class="live-embed" src="https://www.youtube.com/embed/live_stream?channel=YOUR_CHANNEL_ID&autoplay=1" frameborder="0" allowfullscreen></iframe>
            <div class="meteo-box">
                <h2>Meteo Cassano delle Murge</h2>
                <p>Condizioni meteo in tempo reale (integrazione API meteo qui)</p>
            </div>
        </section>
        <section class="archive">
            <h2>Archivio Streaming Precedenti</h2>
            <div class="archive-list">
                <!-- Sostituisci con ID video reali -->
                <iframe src="https://www.youtube.com/embed/VIDEO_ID_1" frameborder="0" allowfullscreen></iframe>
                <iframe src="https://www.youtube.com/embed/VIDEO_ID_2" frameborder="0" allowfullscreen></iframe>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?> - Tutti i diritti riservati</p>
    </footer>
</body>
</html> 