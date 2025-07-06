<?php
// Script per aggiornare tutti i favicon con il logo personalizzato
echo "<h1>🎨 Aggiornamento Favicon - Logo Personalizzato</h1>";

$files_to_update = [
    'pages/services.php',
    'pages/live-sky.php', 
    'pages/home.php',
    'pages/login.php',
    'pages/register.php',
    'pages/gallery.php',
    'pages/about.php',
    'pages/contact.php',
    'index.php'
];

echo "<h2>📝 File da Aggiornare:</h2>";
foreach ($files_to_update as $file) {
    $filepath = __DIR__ . '/' . $file;
    if (file_exists($filepath)) {
        $content = file_get_contents($filepath);
        $updated = str_replace('/favicon.ico', '/favicon.jpg', $content);
        
        if ($content !== $updated) {
            file_put_contents($filepath, $updated);
            echo "✅ {$file} - Favicon aggiornato<br>";
        } else {
            echo "ℹ️ {$file} - Già aggiornato<br>";
        }
    } else {
        echo "❌ {$file} - File non trovato<br>";
    }
}

echo "<h2>🖼️ Favicon Configurati:</h2>";
echo "<ul>";
echo "<li>✅ Favicon principale: <code>/favicon.jpg</code></li>";
echo "<li>ℹ️ Dimensione: " . (file_exists(__DIR__ . '/favicon.jpg') ? round(filesize(__DIR__ . '/favicon.jpg')/1024) . 'KB' : 'File non trovato') . "</li>";
echo "</ul>";

echo "<h2>🌐 Supporto Browser:</h2>";
echo "<div style='background: #1a1a2e; padding: 15px; border-radius: 8px; color: #f5f5f7;'>";
echo "Il tuo logo personalizzato ora apparirà in:<br>";
echo "• Tab del browser ✅<br>";
echo "• Preferiti/Bookmark ✅<br>";
echo "• Cronologia browser ✅<br>";
echo "• App mobile (se salvata) ✅<br>";
echo "</div>";

echo "<h2>📱 Test Favicon:</h2>";
echo "<p>Ricarica la pagina per vedere il nuovo favicon!</p>";
echo "<p><strong>Nota:</strong> Potrebbe essere necessario svuotare la cache del browser per vedere immediatamente il cambiamento.</p>";

echo "<hr>";
echo "<p><strong>Completato:</strong> " . date('Y-m-d H:i:s') . "</p>";
?> 