<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once __DIR__.'/includes/auth.php';
require_once __DIR__.'/includes/database.php';
require_once __DIR__.'/includes/reset_token.php';
$error = '';
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Inserisci un indirizzo email valido.';
    } else {
        $db = (new Database(DB_PATH))->pdo();
        $stmt = $db->prepare('SELECT id FROM users WHERE email=?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $token = generateResetToken($email, $db);
            $reset_link = 'https://www.astroguida.com/new_password.php?token=' . urlencode($token);
            // Invia email reale (PHPMailer consigliato, qui placeholder)
            mail($email, 'Reset password AstroGuida', "Clicca qui per reimpostare la password: $reset_link");
        }
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Reset Password - AstroGuida</title>
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
    <h1>Recupera password</h1>
    <p>Inserisci la tua email, riceverai un link per reimpostare la password.</p>
</section>
<section>
    <?php if($error): ?><div style="color:#FF453A;"> <?= htmlspecialchars($error) ?> </div><?php endif; ?>
    <?php if($success): ?><div style="color:#30D158;">Se l'email è registrata riceverai un link per il reset.</div><?php else: ?>
    <form class="card" method="post" action="">
        <label>Email<br><input class="form-input" type="email" name="email" required></label><br>
        <button class="btn btn-primary" type="submit">Invia link reset</button>
    </form>
    <?php endif; ?>
</section>
<footer>
    &copy; <?php echo date('Y'); ?> AstroGuida.com - Tutti i diritti riservati
</footer>
</body>
</html> 