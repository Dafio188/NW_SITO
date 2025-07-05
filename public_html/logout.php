<?php
require_once __DIR__.'/includes/auth.php';
$auth = getAuth();
$auth->logout();
header('Location: /login');
exit; 