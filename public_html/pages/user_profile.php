<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/auth.php';
$auth = getAuth();
if (!$auth->isLogged()) {
    header('Location: /?page=login');
    exit;
}
$user = $auth->currentUser();
$db = getDb();
$error = '';
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';
    if (!$name) {
        $error = 'Il nome è obbligatorio.';
    } elseif ($password && $password !== $password2) {
        $error = 'Le password non coincidono.';
    } else {
        $params = [$name, $user['id']];
        $db->prepare('UPDATE users SET name = ? WHERE id = ?')->execute($params);
        if ($password) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $db->prepare('UPDATE users SET password = ? WHERE id = ?')->execute([$hash, $user['id']]);
        }
        $success = true;
        $user = $auth->currentUser();
    }
}
?><!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilo Utente - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <script src="/assets/js/main.js" defer></script>
</head>
<body>
    <header>
        <img src="/mio_logo.jpg" alt="Logo <?= SITE_NAME ?>" style="height:60px;">
        <nav>
            <a href="/">Home</a>
            <a href="/?page=user_dashboard">Dashboard</a>
            <a href="/?page=user_profile">Profilo</a>
            <a href="/?page=logout">Logout</a>
        </nav>
    </header>
    <main>
        <section class="user-profile">
            <h1>Profilo Utente</h1>
            <?php if($error): ?><div class="error" style="color:#FF453A;"> <?= htmlspecialchars($error) ?> </div><?php endif; ?>
            <?php if($success): ?><div class="success" style="color:#30D158;">Profilo aggiornato!</div><?php endif; ?>
            <form method="post">
                <label for="name">Nome</label><br>
                <input type="text" id="name" name="name" class="form-input" value="<?= htmlspecialchars($user['name']) ?>" required><br><br>
                <label for="email">Email</label><br>
                <input type="email" id="email" name="email" class="form-input" value="<?= htmlspecialchars($user['email']) ?>" disabled><br><br>
                <label for="password">Nuova password (opzionale)</label><br>
                <input type="password" id="password" name="password" class="form-input"><br><br>
                <label for="password2">Ripeti nuova password</label><br>
                <input type="password" id="password2" name="password2" class="form-input"><br><br>
                <button type="submit" class="btn btn-primary">Salva modifiche</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?> - Tutti i diritti riservati</p>
    </footer>
</body>
</html> 