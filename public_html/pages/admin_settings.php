<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/auth.php';
$auth = getAuth();
if (!$auth->isLogged() || $auth->currentUser()['role'] !== 'admin') {
    header('Location: /?page=login');
    exit;
}
$db = getDb();
// Salva impostazioni
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $k => $v) {
        $stmt = $db->prepare('INSERT OR REPLACE INTO settings (setting_key, setting_value) VALUES (?, ?)');
        $stmt->execute([$k, $v]);
    }
    header('Location: /?page=admin_settings&ok=1');
    exit;
}
$settings = $db->query('SELECT * FROM settings')->fetchAll(PDO::FETCH_KEY_PAIR);
?><!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurazioni Sito - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <style>
        form {max-width:500px;margin:32px auto;}
        label {font-weight:600;}
        input[type=text],textarea {width:100%;padding:8px 12px;margin-bottom:12px;}
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
        <section class="admin-settings">
            <h1>Configurazioni Sito</h1>
            <?php if(isset($_GET['ok'])): ?><div style="color:#30D158;">Impostazioni salvate!</div><?php endif; ?>
            <form method="post">
                <label for="site_title">Titolo sito</label>
                <input type="text" id="site_title" name="site_title" value="<?= htmlspecialchars($settings['site_title'] ?? SITE_NAME) ?>">
                <label for="site_email">Email contatto</label>
                <input type="text" id="site_email" name="site_email" value="<?= htmlspecialchars($settings['site_email'] ?? SITE_EMAIL) ?>">
                <label for="site_description">Descrizione</label>
                <textarea id="site_description" name="site_description"><?= htmlspecialchars($settings['site_description'] ?? '') ?></textarea>
                <button type="submit" class="btn btn-primary">Salva</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?> - Tutti i diritti riservati</p>
    </footer>
</body>
</html> 