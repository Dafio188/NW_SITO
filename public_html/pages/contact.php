<?php
require_once __DIR__ . '/../../includes/config.php';
?><!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contatti - <?= SITE_NAME ?></title>
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
        <section class="contact">
            <h1>Contattaci</h1>
            <form method="post" action="#">
                <label for="name">Nome</label><br>
                <input type="text" id="name" name="name" class="form-input"><br><br>
                <label for="email">Email</label><br>
                <input type="email" id="email" name="email" class="form-input"><br><br>
                <label for="message">Messaggio</label><br>
                <textarea id="message" name="message" class="form-input" rows="5"></textarea><br><br>
                <button type="submit" class="btn btn-primary">Invia</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?> - Tutti i diritti riservati</p>
    </footer>
</body>
</html> 