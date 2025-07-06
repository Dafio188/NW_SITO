<?php
echo "<h1>Test PHP - AstroGuida</h1>";
echo "<p>Timestamp: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>PHP Version: " . phpversion() . "</p>";

// Test config.php
echo "<h2>Test Config</h2>";
$config_path = __DIR__ . "/includes/config.php";
if (file_exists($config_path)) {
    echo "✅ Config trovato<br>";
    try {
        require_once $config_path;
        echo "✅ Config caricato<br>";
        echo "SITE_NAME: " . (defined('SITE_NAME') ? SITE_NAME : 'Non definito') . "<br>";
    } catch (Exception $e) {
        echo "❌ Errore caricamento config: " . $e->getMessage() . "<br>";
    }
} else {
    echo "❌ Config non trovato: {$config_path}<br>";
}

// Test pagine
echo "<h2>Test Pagine</h2>";
$pages = ['home', 'services', 'gallery', 'about', 'contact'];
foreach ($pages as $page) {
    $filepath = __DIR__ . "/pages/{$page}.php";
    echo "{$page}.php: " . (file_exists($filepath) ? "✅" : "❌") . "<br>";
}

// Link di test
echo "<h2>Link di Test</h2>";
echo "<a href='/?page=services'>Servizi</a><br>";
echo "<a href='/?page=gallery'>Gallery</a><br>";
echo "<a href='/?page=about'>Chi Siamo</a><br>";
echo "<a href='/?page=contact'>Contatti</a><br>";
?> 