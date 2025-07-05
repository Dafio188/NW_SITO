<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/auth.php';
$auth = getAuth();
if (!$auth->isLogged()) {
    header('Location: /?page=login');
    exit;
}
$user = $auth->currentUser();
?><!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Utente - <?= SITE_NAME ?></title>
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
            <a href="/?page=user_dashboard">Dashboard</a>
            <a href="/?page=logout">Logout</a>
        </nav>
    </header>
    <main>
        <section class="dashboard">
            <h1>Benvenuto, <?= htmlspecialchars($user['name']) ?></h1>
            <p>Email: <?= htmlspecialchars($user['email']) ?></p>
            <p>Ruolo: <?= htmlspecialchars($user['role']) ?></p>
        </section>
    </main>
    <footer>
        <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?> - Tutti i diritti riservati</p>
    </footer>
</body>
</html> 