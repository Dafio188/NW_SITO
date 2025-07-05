<?php
require_once __DIR__ . '/../../includes/config.php';
$db = getDb();
$search = trim($_GET['search'] ?? '');
$category = trim($_GET['category'] ?? '');
$sql = 'SELECT * FROM gallery_images WHERE 1';
$params = [];
if ($search) {
    $sql .= ' AND (title LIKE ? OR description LIKE ?)';
    $params[] = "%$search%";
    $params[] = "%$search%";
}
if ($category) {
    $sql .= ' AND (description LIKE ? OR title LIKE ?)';
    $params[] = "%$category%";
    $params[] = "%$category%";
}
$sql .= ' ORDER BY id DESC';
$images = $db->prepare($sql);
$images->execute($params);
$images = $images->fetchAll();
$categories = ['galassia','nebulosa','ammasso','luna','pianeta'];
?><!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - AstroGuida</title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <script defer src="/assets/js/main.js"></script>
    <style>
        .gallery-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px,1fr)); gap: 18px; margin: 32px 0; }
        .gallery-grid img { width: 100%; border-radius: 12px; box-shadow: var(--shadow-soft); cursor: pointer; transition: transform 0.2s; }
        .gallery-grid img:hover { transform: scale(1.04); box-shadow: var(--shadow-medium); }
        .lightbox { display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.9); align-items:center; justify-content:center; z-index:1000; }
        .lightbox img { max-width:90vw; max-height:90vh; border-radius:16px; }
        .lightbox.active { display:flex; }
        .gallery-filters {margin:24px 0;text-align:center;}
        .gallery-filters input, .gallery-filters select {padding:8px 12px;margin:0 8px 0 0;}
    </style>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const imgs = document.querySelectorAll('.gallery-grid img');
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightbox-img');
        imgs.forEach(img => {
            img.addEventListener('click', () => {
                lightboxImg.src = img.src;
                lightbox.classList.add('active');
            });
        });
        lightbox.addEventListener('click', () => {
            lightbox.classList.remove('active');
            lightboxImg.src = '';
        });
    });
    </script>
</head>
<body>
    <header>
        <img src="/assets/images/logo/logo.png" alt="AstroGuida Logo" style="height:48px;">
        <nav>
            <a href="/">Home</a>
            <a href="/gallery">Gallery</a>
            <a href="/booking">Prenota</a>
            <a href="/login">Login</a>
        </nav>
    </header>
    <section class="hero">
        <h1>Gallery Astrofotografica</h1>
        <p>Scopri le nostre foto astronomiche e lasciati ispirare dal cielo.</p>
    </section>
    <section>
        <div class="gallery-grid">
            <!-- Qui verranno mostrate le immagini dinamicamente -->
            <img src="/assets/images/gallery/sample1.jpg" alt="Foto astronomica 1" loading="lazy" style="max-width:220px;border-radius:12px;margin:8px;">
            <img src="/assets/images/gallery/sample2.jpg" alt="Foto astronomica 2" loading="lazy" style="max-width:220px;border-radius:12px;margin:8px;">
            <img src="/assets/images/gallery/sample3.jpg" alt="Foto astronomica 3" loading="lazy" style="max-width:220px;border-radius:12px;margin:8px;">
        </div>
    </section>
    <footer>
        &copy; <?php echo date('Y'); ?> AstroGuida.com - Tutti i diritti riservati
    </footer>
</body>
</html> 