<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/google_oauth_config.php';
require_once __DIR__.'/../includes/auth.php';
if (!isset($_GET['code'], $_GET['state']) || $_GET['state'] !== ($_SESSION['google_oauth_state'] ?? '')) {
    exit('Errore stato OAuth.');
}
// Scambia code per access token con cURL
$token_url = 'https://oauth2.googleapis.com/token';
$data = [
    'code' => $_GET['code'],
    'client_id' => GOOGLE_CLIENT_ID,
    'client_secret' => GOOGLE_CLIENT_SECRET,
    'redirect_uri' => GOOGLE_REDIRECT_URI,
    'grant_type' => 'authorization_code'
];
$ch = curl_init($token_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
$response = curl_exec($ch);
if ($response === false) exit('Errore token Google (cURL).');
curl_close($ch);
$token = json_decode($response, true);
if (!isset($token['access_token'])) exit('Errore access token Google.');
// Ottieni info utente con cURL
$ch = curl_init('https://www.googleapis.com/oauth2/v2/userinfo?access_token=' . $token['access_token']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$info = curl_exec($ch);
curl_close($ch);
$userinfo = json_decode($info, true);
if (!$userinfo || !isset($userinfo['email'])) exit('Errore dati Google.');
// Crea/collega utente in DB
$auth = getAuth();
$db = (new Database(DB_PATH))->pdo();
$stmt = $db->prepare('SELECT * FROM users WHERE email = ?');
$stmt->execute([$userinfo['email']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    // Nuovo utente
    $stmt = $db->prepare('INSERT INTO users (name, email, google_id, avatar, role) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([
        $userinfo['name'] ?? $userinfo['email'],
        $userinfo['email'],
        $userinfo['id'],
        $userinfo['picture'] ?? '',
        'user'
    ]);
    $user_id = $db->lastInsertId();
} else {
    $user_id = $user['id'];
}
$_SESSION['user_id'] = $user_id;
$_SESSION['user_role'] = $user['role'] ?? 'user';
header('Location: /dashboard');
exit; 