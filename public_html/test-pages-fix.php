<?php
echo "<h1>Test Pagine AstroGuida - Fix Session</h1>";
echo "<p>Verifica che tutte le pagine si carichino senza errori dopo il fix delle sessioni</p>";

// Test 1: Config e sessione
echo "<h2>1. Test Config e Sessione</h2>";
try {
    require_once __DIR__ . '/includes/config.php';
    echo "✅ Config.php caricato<br>";
    echo "Sessione attiva: " . (session_status() === PHP_SESSION_ACTIVE ? "✅ Sì" : "❌ No") . "<br>";
    echo "Session ID: " . session_id() . "<br>";
} catch (Exception $e) {
    echo "❌ Errore: " . $e->getMessage() . "<br>";
}

// Test 2: Pagine esistenti
echo "<h2>2. Test Pagine Esistenti</h2>";
$pages = [
    'home' => 'Homepage',
    'services' => 'Servizi',
    'gallery' => 'Gallery', 
    'about' => 'Chi Siamo',
    'contact' => 'Contatti',
    'live-sky' => 'Live Sky',
    'login' => 'Login',
    'register' => 'Registrazione'
];

foreach ($pages as $page => $title) {
    $filepath = __DIR__ . "/pages/{$page}.php";
    $exists = file_exists($filepath);
    echo "{$title}: " . ($exists ? "✅ Esiste" : "❌ Mancante");
    
    if ($exists) {
        // Test caricamento pagina
        ob_start();
        $error = false;
        try {
            include $filepath;
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
        $output = ob_get_clean();
        
        if ($error) {
            echo " - ❌ Errore: " . $error;
        } else {
            echo " - ✅ Caricabile";
        }
    }
    
    echo " - <a href='/?page={$page}' target='_blank'>Testa</a><br>";
}

// Test 3: Variabili di sessione
echo "<h2>3. Test Variabili Sessione</h2>";
echo "user_id: " . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'Non impostato') . "<br>";
echo "user_name: " . (isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Non impostato') . "<br>";
echo "user_role: " . (isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'Non impostato') . "<br>";

// Test 4: CSS e Assets
echo "<h2>4. Test Assets</h2>";
$assets = [
    'assets/css/main.css' => 'CSS Principale',
    'assets/images/logo/astroguida-logo.jpg' => 'Logo',
    'fotoastronomia/m31.jpg' => 'Immagine M31'
];

foreach ($assets as $path => $name) {
    $fullpath = __DIR__ . '/' . $path;
    echo "{$name}: " . (file_exists($fullpath) ? "✅ Esiste" : "❌ Mancante") . "<br>";
}

echo "<hr>";
echo "<h2>Link Diretti per Test</h2>";
echo "<ul>";
echo "<li><a href='/?page=services' target='_blank'>Servizi</a></li>";
echo "<li><a href='/?page=gallery' target='_blank'>Gallery</a></li>";
echo "<li><a href='/?page=about' target='_blank'>Chi Siamo</a></li>";
echo "<li><a href='/?page=contact' target='_blank'>Contatti</a></li>";
echo "<li><a href='/?page=live-sky' target='_blank'>Live Sky</a></li>";
echo "</ul>";

echo "<p><strong>Timestamp:</strong> " . date('Y-m-d H:i:s') . "</p>";

// Test per verificare che le pagine problematiche ora funzionino
echo "=== TEST CORREZIONE PAGINE ===\n\n";

// Disabilita output degli errori per il test
error_reporting(0);

$pages_to_test = [
    'gallery' => 'Gallery',
    'about' => 'Chi Siamo',
    'contact' => 'Contatti'
];

foreach ($pages_to_test as $page => $title) {
    echo "Testing $title ($page)...\n";
    
    // Pulisce il buffer di output
    ob_clean();
    ob_start();
    
    try {
        // Simula la richiesta GET
        $_GET['page'] = $page;
        
        // Testa l'include della pagina
        include __DIR__ . "/pages/$page.php";
        
        $output = ob_get_contents();
        
        if (strlen($output) > 1000) {
            echo "✅ OK: $title caricata correttamente (" . strlen($output) . " caratteri)\n";
        } else {
            echo "❌ ERRORE: $title output troppo breve\n";
        }
        
    } catch (Exception $e) {
        echo "❌ ERRORE: " . $e->getMessage() . "\n";
    } catch (Error $e) {
        echo "❌ ERRORE FATALE: " . $e->getMessage() . "\n";
    }
    
    ob_end_clean();
    echo "\n";
}

// Test configurazione database
echo "Testing configurazione database...\n";
require_once __DIR__ . '/includes/config.php';

if (isset($pdo) && $pdo !== null) {
    echo "✅ OK: Database PDO inizializzato correttamente\n";
} else {
    echo "❌ ERRORE: Database PDO non disponibile\n";
}

// Test streaming manager
require_once __DIR__ . '/includes/streaming.php';
if (isset($streamingManager) && $streamingManager !== null) {
    echo "✅ OK: StreamingManager inizializzato correttamente\n";
} else {
    echo "⚠️ WARNING: StreamingManager non disponibile (fallback attivo)\n";
}

echo "\n=== FINE TEST ===\n";
?> 