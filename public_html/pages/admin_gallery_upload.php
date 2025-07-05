<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/auth.php';
$auth = getAuth();
if (!$auth->isLogged() || $auth->currentUser()['role'] !== 'admin') {
    header('Location: /?page=login');
    exit;
}
$db = getDb();
$error = '';
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $file = $_FILES['image'];
    $title = trim($_POST['title'] ?? '');
    $allowed = ['jpg','jpeg','png','webp'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $error = 'Errore upload file.';
    } elseif (!in_array($ext, $allowed)) {
        $error = 'Formato non supportato.';
    } elseif ($file['size'] > 5*1024*1024) {
        $error = 'File troppo grande (max 5MB).';
    } else {
        $basename = uniqid('img_') . '.' . $ext;
        $dest = __DIR__ . '/../../fotoastronomia/' . $basename;
        if (move_uploaded_file($file['tmp_name'], $dest)) {
            $db->prepare('INSERT INTO gallery_images (filename, title, file_size) VALUES (?, ?, ?)')
                ->execute([$basename, $title, $file['size']]);
            $success = true;
        } else {
            $error = 'Impossibile salvare il file.';
        }
    }
}
?><!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Immagine Gallery - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <style>
        form {max-width:400px;margin:32px auto;}
        label {font-weight:600;}
        input[type=text],input[type=file] {width:100%;padding:8px 12px;margin-bottom:12px;}
    </style>
</head>
<body>
    <header>
        <img src="/mio_logo.jpg" alt="Logo <?= SITE_NAME ?>" style="height:60px;">
        <nav>
            <a href="/">Home</a>
            <a href="/?page=admin_dashboard">Admin</a>
            <a href="/?page=admin_gallery">Gestione gallery</a>
            <a href="/?page=logout">Logout</a>
        </nav>
    </header>
    <main>
        <section class="admin-gallery-upload">
            <h1>Upload Immagine Gallery</h1>
            <?php if($error): ?><div class="error" style="color:#FF453A;"> <?= htmlspecialchars($error) ?> </div><?php endif; ?>
            <?php if($success): ?><div class="success" style="color:#30D158;">Immagine caricata con successo!</div><?php endif; ?>
            <form method="post" enctype="multipart/form-data">
                <label for="title">Titolo</label>
                <input type="text" id="title" name="title" required>
                <label for="image">Immagine (jpg, png, webp, max 5MB)</label>
                <input type="file" id="image" name="image" accept="image/*" required>
                <button type="submit" class="btn btn-primary">Carica</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?> - Tutti i diritti riservati</p>
    </footer>
</body>
</html> 