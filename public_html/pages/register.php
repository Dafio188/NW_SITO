<?php 
require_once __DIR__.'/../includes/auth.php';
$auth = getAuth();
$error = '';
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$auth->checkCsrf($_POST['csrf_token'] ?? '')) {
        $error = 'Token CSRF non valido.';
    } else {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        if (!$name || !$email || !$password) {
            $error = 'Tutti i campi sono obbligatori.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Email non valida.';
        } elseif ($auth->register($name, $email, $password)) {
            $success = true;
        } else {
            $error = 'Email già registrata.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Registrati - AstroGuida</title>
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
    <h1>Crea un nuovo account</h1>
    <p>Registrati per prenotare servizi e accedere alla gallery completa.</p>
</section>
<section>
    <?php if($error): ?><div style="color:#FF453A;"> <?= htmlspecialchars($error) ?> </div><?php endif; ?>
    <?php if($success): ?><div style="color:#30D158;">Registrazione completata! <a href="/login">Accedi</a></div><?php else: ?>
    <form class="card" method="post" action="">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($auth->csrfToken()) ?>">
        <label>Nome e Cognome<br><input class="form-input" type="text" name="name" required></label><br>
        <label>Email<br><input class="form-input" type="email" name="email" required></label><br>
        <label>Password<br><input class="form-input" type="password" name="password" required></label><br>
        <button class="btn btn-primary" type="submit">Registrati</button>
    </form>
    <?php endif; ?>
    <p>Hai già un account? <a href="/login">Accedi</a></p>
</section>
<footer>
    &copy; <?php echo date('Y'); ?> AstroGuida.com - Tutti i diritti riservati
</footer>
</body>
</html> 