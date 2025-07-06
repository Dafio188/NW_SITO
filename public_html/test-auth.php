<?php
echo "<h1>Test Autenticazione AstroGuida</h1>";
echo "<p>Test per verificare che auth.php funzioni correttamente</p>";

// Test 1: Config.php
echo "<h2>1. Test Config.php</h2>";
try {
    require_once __DIR__ . '/includes/config.php';
    echo "✅ Config.php caricato<br>";
    echo "SQLITE_PATH: " . (defined('SQLITE_PATH') ? SQLITE_PATH : 'Non definito') . "<br>";
    echo "DB_PATH: " . (defined('DB_PATH') ? DB_PATH : 'Non definito') . "<br>";
    echo "SITE_NAME: " . (defined('SITE_NAME') ? SITE_NAME : 'Non definito') . "<br>";
} catch (Exception $e) {
    echo "❌ Errore config.php: " . $e->getMessage() . "<br>";
}

// Test 2: Database.php
echo "<h2>2. Test Database.php</h2>";
try {
    require_once __DIR__ . '/includes/database.php';
    echo "✅ Database.php caricato<br>";
    
    $db = getDb();
    echo "✅ Database connesso<br>";
    
    // Test query
    $stmt = $db->prepare("SELECT name FROM sqlite_master WHERE type='table'");
    $stmt->execute();
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Tabelle trovate: " . implode(', ', $tables) . "<br>";
    
} catch (Exception $e) {
    echo "❌ Errore database.php: " . $e->getMessage() . "<br>";
}

// Test 3: Auth.php
echo "<h2>3. Test Auth.php</h2>";
try {
    require_once __DIR__ . '/includes/auth.php';
    echo "✅ Auth.php caricato<br>";
    
    $auth = getAuth();
    echo "✅ Auth inizializzato<br>";
    echo "Utente loggato: " . ($auth->isLogged() ? "Sì" : "No") . "<br>";
    echo "CSRF Token: " . substr($auth->csrfToken(), 0, 10) . "...<br>";
    
} catch (Exception $e) {
    echo "❌ Errore auth.php: " . $e->getMessage() . "<br>";
}

// Test 4: File esistenti
echo "<h2>4. Test File Esistenti</h2>";
$files = [
    'includes/config.php',
    'includes/database.php', 
    'includes/auth.php',
    'data/astroguida.sqlite'
];

foreach ($files as $file) {
    $path = __DIR__ . '/' . $file;
    echo "{$file}: " . (file_exists($path) ? "✅ Esiste" : "❌ Mancante") . "<br>";
}

echo "<hr>";
echo "<p><strong>Timestamp:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<p><strong>Server:</strong> " . $_SERVER['HTTP_HOST'] . "</p>";
echo "<p><strong>Path:</strong> " . __DIR__ . "</p>";
?> 