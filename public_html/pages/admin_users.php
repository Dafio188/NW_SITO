<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/auth.php';
$auth = getAuth();
if (!$auth->isLogged() || $auth->currentUser()['role'] !== 'admin') {
    header('Location: /?page=login');
    exit;
}
$db = getDb();
// Azioni: elimina/promuovi/demote
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($id !== $auth->currentUser()['id']) {
        $db->prepare('DELETE FROM users WHERE id = ?')->execute([$id]);
    }
    header('Location: /?page=admin_users');
    exit;
}
if (isset($_GET['promote'])) {
    $id = (int)$_GET['promote'];
    $db->prepare("UPDATE users SET role = 'admin' WHERE id = ?")->execute([$id]);
    header('Location: /?page=admin_users');
    exit;
}
if (isset($_GET['demote'])) {
    $id = (int)$_GET['demote'];
    if ($id !== $auth->currentUser()['id']) {
        $db->prepare("UPDATE users SET role = 'user' WHERE id = ?")->execute([$id]);
    }
    header('Location: /?page=admin_users');
    exit;
}
$users = $db->query('SELECT * FROM users ORDER BY id DESC')->fetchAll();
?><!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Utenti - <?= SITE_NAME ?></title>
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
        <section class="admin-users">
            <h1>Gestione Utenti</h1>
            <table>
                <tr><th>ID</th><th>Nome</th><th>Email</th><th>Ruolo</th><th>Azioni</th></tr>
                <?php foreach($users as $u): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><?= htmlspecialchars($u['name']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= htmlspecialchars($u['role']) ?></td>
                    <td class="actions">
                        <?php if($u['role'] === 'user'): ?>
                            <a href="?page=admin_users&promote=<?= $u['id'] ?>">Promuovi admin</a>
                        <?php elseif($u['role'] === 'admin' && $u['id'] !== $auth->currentUser()['id']): ?>
                            <a href="?page=admin_users&demote=<?= $u['id'] ?>">Rendi utente</a>
                        <?php endif; ?>
                        <?php if($u['id'] !== $auth->currentUser()['id']): ?>
                            <a href="?page=admin_users&delete=<?= $u['id'] ?>" onclick="return confirm('Eliminare utente?')">Elimina</a>
                        <?php endif; ?>
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