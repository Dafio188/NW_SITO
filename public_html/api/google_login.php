<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/google_oauth_config.php';
$state = bin2hex(random_bytes(16));
$_SESSION['google_oauth_state'] = $state;
$params = [
    'client_id' => GOOGLE_CLIENT_ID,
    'redirect_uri' => GOOGLE_REDIRECT_URI,
    'response_type' => 'code',
    'scope' => 'openid email profile',
    'state' => $state,
    'access_type' => 'online',
    'prompt' => 'select_account'
];
$url = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);
header('Location: ' . $url);
exit; 