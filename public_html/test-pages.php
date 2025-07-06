<?php
// Test per verificare che tutte le pagine funzionino
echo "<h1>Test Pagine AstroGuida</h1>";
echo "<p>Verifica che tutte le pagine siano accessibili:</p>";

$pages = [
    'home' => 'Homepage',
    'services' => 'Servizi', 
    'gallery' => 'Gallery',
    'about' => 'Chi Siamo',
    'contact' => 'Contatti',
    'live-sky' => 'Live Sky',
    'booking' => 'Prenotazioni',
    'login' => 'Login',
    'register' => 'Registrazione'
];

echo "<ul>";
foreach ($pages as $page => $title) {
    $filepath = __DIR__ . "/pages/{$page}.php";
    $status = file_exists($filepath) ? "✅ Esiste" : "❌ Mancante";
    $url = "/?page={$page}";
    echo "<li><strong>{$title}</strong> ({$page}.php): {$status} - <a href='{$url}' target='_blank'>Testa</a></li>";
}
echo "</ul>";

echo "<h2>Test Config.php</h2>";
$config_path = __DIR__ . "/includes/config.php";
if (file_exists($config_path)) {
    echo "✅ Config.php trovato in: {$config_path}";
    require_once $config_path;
    echo "<br>✅ SITE_NAME: " . (defined('SITE_NAME') ? SITE_NAME : 'Non definito');
    echo "<br>✅ BASE_URL: " . (defined('BASE_URL') ? BASE_URL : 'Non definito');
} else {
    echo "❌ Config.php non trovato in: {$config_path}";
}

echo "<h2>Test Database</h2>";
$db_path = __DIR__ . "/data/astroguida.sqlite";
if (file_exists($db_path)) {
    echo "✅ Database trovato in: {$db_path}";
    echo "<br>Dimensione: " . filesize($db_path) . " bytes";
} else {
    echo "❌ Database non trovato in: {$db_path}";
}

echo "<h2>Test CSS</h2>";
$css_path = __DIR__ . "/assets/css/main.css";
if (file_exists($css_path)) {
    echo "✅ CSS trovato in: {$css_path}";
    echo "<br>Dimensione: " . filesize($css_path) . " bytes";
} else {
    echo "❌ CSS non trovato in: {$css_path}";
}

echo "<p><strong>Timestamp:</strong> " . date('Y-m-d H:i:s') . "</p>";
?> 