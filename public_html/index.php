<?php
// TEST: verifica esecuzione PHP
// Decommenta la riga sotto per testare solo l'output
// echo "INDEX PHP OK"; exit;

// Routing dinamico AstroGuida
require_once __DIR__ . '/includes/config.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$page = $_GET['page'] ?? 'home';
$allowed = ['home','gallery','booking','login','register','dashboard','admin'];
if(!in_array($page,$allowed)) $page = 'home';
$filepath = __DIR__ . "/pages/{$page}.php";
if (file_exists($filepath)) {
    include $filepath;
} else {
    echo '<h1>Errore 404</h1><p>Pagina non trovata.</p>';
} 