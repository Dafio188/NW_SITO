<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../../includes/auth.php';
$auth = getAuth();
$success = false;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    if (!$email) {
        $error = 'Inserisci la tua email.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email non valida.';
    } else {
        // Qui si dovrebbe inviare l'email di reset
        $success = true;
    }
}
?><!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - <?= SITE_NAME ?></title>
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
        <section class="reset-password">
            <h1>Reset Password</h1>
            <?php if($error): ?><div class="error" style="color:#FF453A;"> <?= htmlspecialchars($error) ?> </div><?php endif; ?>
            <?php if($success): ?><div class="success" style="color:#30D158;">Se l'email è registrata riceverai le istruzioni per il reset.</div><?php else: ?>
            <form method="post" action="">
                <label for="email">Email</label><br>
                <input type="email" id="email" name="email" class="form-input" required><br><br>
                <button type="submit" class="btn btn-primary">Invia richiesta</button>
            </form>
            <?php endif; ?>
        </section>
    </main>
    <footer>
        <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?> - Tutti i diritti riservati</p>
    </footer>
</body>
</html> 