<?php
// Test per verificare se le pagine Gallery, Chi Siamo, Contatti funzionano
echo "=== TEST FAVICON FIX ===\n\n";

$pages_to_test = [
    'gallery' => 'Gallery',
    'about' => 'Chi Siamo', 
    'contact' => 'Contatti'
];

foreach ($pages_to_test as $page => $title) {
    echo "Testing $title ($page)...\n";
    
    // Simula il caricamento della pagina
    ob_start();
    $error = false;
    
    try {
        $_GET['page'] = $page;
        include __DIR__ . "/pages/$page.php";
        $output = ob_get_contents();
        
        if (empty($output)) {
            echo "❌ ERRORE: Output vuoto per $title\n";
            $error = true;
        } else {
            echo "✅ OK: $title caricata correttamente\n";
            
            // Verifica se contiene il favicon corretto
            if (strpos($output, '/favicon.jpg') !== false) {
                echo "✅ OK: Favicon corretto trovato\n";
            } else {
                echo "❌ ERRORE: Favicon non trovato o sbagliato\n";
                $error = true;
            }
        }
    } catch (Exception $e) {
        echo "❌ ERRORE: " . $e->getMessage() . "\n";
        $error = true;
    }
    
    ob_end_clean();
    echo "\n";
}

echo "=== FINE TEST ===\n";
?> 