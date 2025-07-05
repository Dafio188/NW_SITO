<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/auth.php';
$auth = getAuth();
if (!$auth->isLogged() || $auth->currentUser()['role'] !== 'admin') {
    header('Location: /?page=login');
    exit;
}
$db = getDb();
// Azioni: elimina/cambia stato
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $db->prepare('DELETE FROM bookings WHERE id = ?')->execute([$id]);
    header('Location: /?page=admin_bookings');
    exit;
}
if (isset($_GET['status']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $status = $_GET['status'];
    if (in_array($status, ['pending','confirmed','cancelled'])) {
        $db->prepare('UPDATE bookings SET status = ? WHERE id = ?')->execute([$status, $id]);
    }
    header('Location: /?page=admin_bookings');
    exit;
}
$bookings = $db->query('SELECT b.*, u.name as user_name FROM bookings b LEFT JOIN users u ON b.user_id = u.id ORDER BY b.id DESC')->fetchAll();
?><!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Prenotazioni - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <style>
        table {width:100%;border-collapse:collapse;margin:24px 0;}
        th,td {padding:8px 12px;border:1px solid #333;background:rgba(30,30,30,0.7);}
        th {background:var(--space-gray);}
        .actions a {margin:0 4px;}
    </style>
</head>
<body>
    <header>
        <img src="/mio_logo.jpg" alt="Logo <?= SITE_NAME ?>" style="height:60px;">
        <nav>
            <a href="/">Home</a>
            <a href="/?page=admin_dashboard">Admin</a>
            <a href="/?page=logout">Logout</a>
        </nav>
    </header>
    <main>
        <section class="admin-bookings">
            <h1>Gestione Prenotazioni</h1>
            <table>
                <tr><th>ID</th><th>Utente</th><th>Servizio</th><th>Data</th><th>Stato</th><th>Azioni</th></tr>
                <?php foreach($bookings as $b): ?>
                <tr>
                    <td><?= $b['id'] ?></td>
                    <td><?= htmlspecialchars($b['user_name']) ?></td>
                    <td><?= htmlspecialchars($b['service_name']) ?></td>
                    <td><?= htmlspecialchars($b['booking_date']) ?></td>
                    <td><?= htmlspecialchars($b['status']) ?></td>
                    <td class="actions">
                        <a href="?page=admin_bookings&status=confirmed&id=<?= $b['id'] ?>">Conferma</a>
                        <a href="?page=admin_bookings&status=cancelled&id=<?= $b['id'] ?>">Annulla</a>
                        <a href="?page=admin_bookings&delete=<?= $b['id'] ?>" onclick="return confirm('Eliminare prenotazione?')">Elimina</a>
                    </td>
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