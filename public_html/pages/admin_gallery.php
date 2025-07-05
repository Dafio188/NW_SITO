<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/auth.php';
$auth = getAuth();
if (!$auth->isLogged() || $auth->currentUser()['role'] !== 'admin') {
    header('Location: /?page=login');
    exit;
}
$db = getDb();
// Azione elimina
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $img = $db->query('SELECT filename FROM gallery_images WHERE id = '.$id)->fetch();
    if ($img) {
        @unlink(__DIR__ . '/../../fotoastronomia/' . $img['filename']);
        $db->prepare('DELETE FROM gallery_images WHERE id = ?')->execute([$id]);
    }
    header('Location: /?page=admin_gallery');
    exit;
}
$images = $db->query('SELECT * FROM gallery_images ORDER BY id DESC')->fetchAll();
?><!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Gallery - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <style>
        .gallery-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px,1fr)); gap: 14px; margin: 32px 0; }
        .gallery-grid img { width: 100%; border-radius: 8px; box-shadow: var(--shadow-soft); }
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
        <section class="admin-gallery">
            <h1>Gestione Gallery</h1>
            <div class="gallery-grid">
                <?php foreach($images as $img): ?>
                    <div>
                        <img src="/fotoastronomia/<?= htmlspecialchars($img['filename']) ?>" alt="Foto">
                        <div class="actions">
                            <a href="?page=admin_gallery&delete=<?= $img['id'] ?>" onclick="return confirm('Eliminare immagine?')">Elimina</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?> - Tutti i diritti riservati</p>
    </footer>
</body>
</html> 