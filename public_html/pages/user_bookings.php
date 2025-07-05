<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../../includes/auth.php';
$auth = getAuth();
if (!$auth->isLogged()) {
    header('Location: /?page=login');
    exit;
}
$user = $auth->currentUser();
$db = getDb();
$bookings = $db->prepare('SELECT * FROM bookings WHERE user_id = ? ORDER BY booking_date DESC');
$bookings->execute([$user['id']]);
$bookings = $bookings->fetchAll();
?><!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le mie prenotazioni - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <script src="/assets/js/main.js" defer></script>
    <style>
        table {width:100%;border-collapse:collapse;margin:24px 0;}
        th,td {padding:8px 12px;border:1px solid #333;background:rgba(30,30,30,0.7);}
        th {background:var(--space-gray);}
    </style>
</head>
<body>
    <header>
        <img src="/mio_logo.jpg" alt="Logo <?= SITE_NAME ?>" style="height:60px;">
        <nav>
            <a href="/">Home</a>
            <a href="/?page=user_dashboard">Dashboard</a>
            <a href="/?page=user_bookings">Le mie prenotazioni</a>
            <a href="/?page=user_profile">Profilo</a>
            <a href="/?page=logout">Logout</a>
        </nav>
    </header>
    <main>
        <section class="user-bookings">
            <h1>Le mie prenotazioni</h1>
            <table>
                <tr><th>ID</th><th>Servizio</th><th>Data</th><th>Stato</th></tr>
                <?php foreach($bookings as $b): ?>
                <tr>
                    <td><?= $b['id'] ?></td>
                    <td><?= htmlspecialchars($b['service_name']) ?></td>
                    <td><?= htmlspecialchars($b['booking_date']) ?></td>
                    <td><?= htmlspecialchars($b['status']) ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </section>
    </main>
    <footer>
        <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?> - Tutti i diritti riservati</p>
    </footer>
</body>
</html> 