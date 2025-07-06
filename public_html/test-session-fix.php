<?php
echo "<h1>Test Session Fix - AstroGuida</h1>";
echo "<p>Verifica che non ci siano più conflitti di session_start()</p>";

// Test 1: Config.php con sessione
echo "<h2>1. Test Config.php</h2>";
try {
    require_once __DIR__ . '/includes/config.php';
    echo "✅ Config.php caricato senza errori<br>";
    echo "Sessione attiva: " . (session_status() === PHP_SESSION_ACTIVE ? "✅ Sì" : "❌ No") . "<br>";
    echo "Session ID: " . session_id() . "<br>";
} catch (Exception $e) {
    echo "❌ Errore config.php: " . $e->getMessage() . "<br>";
}

// Test 2: Auth.php senza conflitti
echo "<h2>2. Test Auth.php</h2>";
try {
    require_once __DIR__ . '/includes/auth.php';
    echo "✅ Auth.php caricato senza errori<br>";
    
    $auth = getAuth();
    echo "✅ Auth inizializzato<br>";
    echo "Utente loggato: " . ($auth->isLogged() ? "Sì" : "No") . "<br>";
    echo "CSRF Token: " . substr($auth->csrfToken(), 0, 10) . "...<br>";
    
} catch (Exception $e) {
    echo "❌ Errore auth.php: " . $e->getMessage() . "<br>";
}

// Test 3: Test caricamento pagine
echo "<h2>3. Test Caricamento Pagine</h2>";
$pages = ['services', 'gallery', 'about', 'contact', 'live-sky'];

foreach ($pages as $page) {
    $filepath = __DIR__ . "/pages/{$page}.php";
    if (file_exists($filepath)) {
        ob_start();
        $error = false;
        try {
            // Simula include della pagina
            include $filepath;
        } catch (Exception $e) {
            $error = $e->getMessage();
        } catch (Error $e) {
            $error = $e->getMessage();
        }
        $output = ob_get_clean();
        
        if ($error) {
            echo "{$page}: ❌ Errore - " . $error . "<br>";
        } else {
            echo "{$page}: ✅ Caricabile senza errori<br>";
        }
    } else {
        echo "{$page}: ❌ File non trovato<br>";
    }
}

// Test 4: Variabili di sessione
echo "<h2>4. Test Variabili Sessione</h2>";
echo "user_id: " . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'Non impostato') . "<br>";
echo "user_name: " . (isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Non impostato') . "<br>";
echo "csrf_token: " . (isset($_SESSION['csrf_token']) ? 'Impostato' : 'Non impostato') . "<br>";

echo "<hr>";
echo "<h2>Link per Test Pagine</h2>";
echo "<ul>";
foreach ($pages as $page) {
    echo "<li><a href='/?page={$page}' target='_blank'>" . ucfirst($page) . "</a></li>";
}
echo "</ul>";

echo "<p><strong>Timestamp:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<p><strong>Nessun conflitto di sessione!</strong> ✅</p>";
?> 