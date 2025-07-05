<?php
require_once __DIR__.'/includes/database.php';
require_once __DIR__.'/includes/reset_token.php';
$error = '';
$success = false;
$token = $_GET['token'] ?? '';
$db = (new Database(DB_PATH))->pdo();
$user = $token ? validateResetToken($token, $db) : null;
if (!$user) {
    $error = 'Token non valido o scaduto.';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    if (strlen($password) < 6) {
        $error = 'La password deve essere di almeno 6 caratteri.';
    } else {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $db->prepare('UPDATE users SET password=?, reset_token=NULL, reset_expires=NULL WHERE id=?');
        $stmt->execute([$hash, $user['id']]);
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Nuova Password - AstroGuida</title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <script defer src="/assets/js/main.js"></script>
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
    <h1>Imposta nuova password</h1>
    <p>Inserisci la nuova password per il tuo account.</p>
</section>
<section>
    <?php if($error): ?><div style="color:#FF453A;"> <?= htmlspecialchars($error) ?> </div><?php endif; ?>
    <?php if($success): ?><div style="color:#30D158;">Password aggiornata! <a href="/login">Accedi</a></div><?php elseif($user): ?>
    <form class="card" method="post" action="">
        <label>Nuova password<br><input class="form-input" type="password" name="password" required></label><br>
        <button class="btn btn-primary" type="submit">Aggiorna password</button>
    </form>
    <?php endif; ?>
</section>
<footer>
    &copy; <?php echo date('Y'); ?> AstroGuida.com - Tutti i diritti riservati
</footer>
</body>
</html> 