<?php 
require_once __DIR__.'/../includes/auth.php';
$auth = getAuth();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$auth->checkCsrf($_POST['csrf_token'] ?? '')) {
        $error = 'Token CSRF non valido.';
    } elseif (!$auth->checkRateLimit($_POST['email'] ?? '')) {
        $error = 'Troppi tentativi, riprova tra qualche minuto.';
    } else {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        if ($auth->login($email, $password)) {
            header('Location: /dashboard');
            exit;
        } else {
            $error = 'Email o password errati.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Login - AstroGuida</title>
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
    <h1>Accedi al tuo account</h1>
    <p>Effettua il login per gestire le tue prenotazioni e la gallery.</p>
</section>
<section>
    <?php if($error): ?><div style="color:#FF453A;"> <?= htmlspecialchars($error) ?> </div><?php endif; ?>
    <form class="card" method="post" action="">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($auth->csrfToken()) ?>">
        <label>Email<br><input class="form-input" type="email" name="email" required></label><br>
        <label>Password<br><input class="form-input" type="password" name="password" required></label><br>
        <button class="btn btn-primary" type="submit">Accedi</button>
        <a href="/api/google_login.php" class="btn btn-primary" style="background:#fff;color:#333;border:1px solid #ccc;margin-top:12px;display:inline-block;">Accedi con Google</a>
    </form>
    <p><a href="/reset_password.php">Password dimenticata?</a></p>
    <p>Non hai un account? <a href="/register">Registrati</a></p>
</section>
<footer>
    &copy; <?php echo date('Y'); ?> AstroGuida.com - Tutti i diritti riservati
</footer>
</body>
</html> 