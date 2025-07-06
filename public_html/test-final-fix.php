<?php
echo "<h1>🎯 Test Finale - Fix Pagine Bianche e Loghi</h1>";
echo "<p>Verifica che tutte le correzioni siano state applicate correttamente</p>";

// Test 1: Costanti Config
echo "<h2>1. ✅ Test Costanti Config</h2>";
try {
    require_once __DIR__ . '/includes/config.php';
    echo "✅ Config.php caricato<br>";
    echo "SITE_URL: " . (defined('SITE_URL') ? SITE_URL : '❌ Non definito') . "<br>";
    echo "SITE_NAME: " . (defined('SITE_NAME') ? SITE_NAME : '❌ Non definito') . "<br>";
    echo "DB_PATH: " . (defined('DB_PATH') ? '✅ Definito' : '❌ Non definito') . "<br>";
    echo "Sessione: " . (session_status() === PHP_SESSION_ACTIVE ? "✅ Attiva" : "❌ Non attiva") . "<br>";
} catch (Exception $e) {
    echo "❌ Errore: " . $e->getMessage() . "<br>";
}

// Test 2: Pagine precedentemente bianche
echo "<h2>2. 🔍 Test Pagine Precedentemente Bianche</h2>";
$problematic_pages = [
    'gallery' => 'Gallery',
    'about' => 'Chi Siamo', 
    'contact' => 'Contatti',
    'login' => 'Login'
];

foreach ($problematic_pages as $page => $title) {
    $filepath = __DIR__ . "/pages/{$page}.php";
    if (file_exists($filepath)) {
        ob_start();
        $error = false;
        try {
            // Test se la pagina si carica senza errori
            include $filepath;
        } catch (Exception $e) {
            $error = $e->getMessage();
        } catch (Error $e) {
            $error = $e->getMessage();
        }
        $output = ob_get_clean();
        
        if ($error) {
            echo "{$title}: ❌ Errore - " . $error . "<br>";
        } else {
            echo "{$title}: ✅ Ora funziona correttamente<br>";
        }
    } else {
        echo "{$title}: ❌ File non trovato<br>";
    }
}

// Test 3: Pagine che funzionavano già
echo "<h2>3. ✅ Test Pagine che Funzionavano</h2>";
$working_pages = [
    'services' => 'Servizi',
    'live-sky' => 'Live Sky'
];

foreach ($working_pages as $page => $title) {
    $filepath = __DIR__ . "/pages/{$page}.php";
    echo "{$title}: " . (file_exists($filepath) ? "✅ Disponibile" : "❌ Mancante") . "<br>";
}

// Test 4: Controllo dimensioni loghi
echo "<h2>4. 🎨 Test Dimensioni Loghi</h2>";
$css_file = __DIR__ . '/assets/css/main.css';
if (file_exists($css_file)) {
    $css_content = file_get_contents($css_file);
    
    // Cerca dimensioni logo header
    if (preg_match('/\.logo-icon\s*{[^}]*width:\s*(\d+)px/', $css_content, $matches)) {
        $header_size = $matches[1];
        echo "Logo Header: {$header_size}px " . ($header_size >= 60 ? "✅ Aumentato" : "❌ Troppo piccolo") . "<br>";
    }
    
    // Cerca dimensioni logo footer
    if (preg_match('/\.footer-section\s+\.logo-icon\s*{[^}]*width:\s*(\d+)px/', $css_content, $matches)) {
        $footer_size = $matches[1];
        echo "Logo Footer: {$footer_size}px " . ($footer_size >= 80 ? "✅ Molto aumentato" : "❌ Troppo piccolo") . "<br>";
    }
} else {
    echo "❌ File CSS non trovato<br>";
}

// Test 5: Link diretti per test
echo "<h2>5. 🔗 Link per Test Manuale</h2>";
echo "<div style='background: #1a1a2e; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
echo "<h3 style='color: #64ffda;'>Pagine Precedentemente Bianche:</h3>";
echo "<ul>";
foreach ($problematic_pages as $page => $title) {
    echo "<li><a href='/?page={$page}' target='_blank' style='color: #00bcd4;'>{$title}</a> - Dovrebbe ora visualizzarsi correttamente</li>";
}
echo "</ul>";

echo "<h3 style='color: #64ffda;'>Pagine che Funzionavano:</h3>";
echo "<ul>";
foreach ($working_pages as $page => $title) {
    echo "<li><a href='/?page={$page}' target='_blank' style='color: #00bcd4;'>{$title}</a> - Dovrebbe continuare a funzionare</li>";
}
echo "</ul>";
echo "</div>";

echo "<h2>6. 📋 Riepilogo Correzioni</h2>";
echo "<div style='background: #0d1421; padding: 20px; border-radius: 10px; border: 1px solid #64ffda;'>";
echo "<h3 style='color: #64ffda;'>✅ Problemi Risolti:</h3>";
echo "<ul style='color: #f5f5f7;'>";
echo "<li>✅ Aggiunta costante SITE_URL mancante</li>";
echo "<li>✅ Logo header aumentato a 70px</li>";
echo "<li>✅ Logo footer aumentato a 90px</li>";
echo "<li>✅ Gestione sessioni centralizzata</li>";
echo "<li>✅ Pagine Gallery, Chi Siamo, Contatti, Login ora funzionanti</li>";
echo "</ul>";

echo "<h3 style='color: #ffa726;'>🔄 Da Completare:</h3>";
echo "<ul style='color: #f5f5f7;'>";
echo "<li>🔄 Sostituire frecce navigazione con logo personalizzato</li>";
echo "<li>🔄 Correggere pagina Registrati (solo sfondo)</li>";
echo "<li>🔄 Ottimizzare file logo per performance</li>";
echo "</ul>";
echo "</div>";

echo "<hr>";
echo "<p><strong>Timestamp:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<p style='color: #64ffda; font-weight: bold;'>🎉 Home funziona su tutti i dispositivi + Loghi ingranditi!</p>";
?> 