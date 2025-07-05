<?php
// Diagnosi Completa AstroGuida
header("Content-Type: text/html; charset=UTF-8");
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$timestamp = date('Y-m-d H:i:s');
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnosi Completa - AstroGuida</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: rgba(255,255,255,0.1);
            padding: 30px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }
        h1, h2 { color: #64ffda; margin-bottom: 20px; }
        .section { background: rgba(0,0,0,0.2); padding: 20px; border-radius: 10px; margin: 20px 0; }
        .success { color: #30d158; }
        .error { color: #ff453a; }
        .warning { color: #ff9f0a; }
        .info { color: #64ffda; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { padding: 10px; border: 1px solid rgba(255,255,255,0.2); text-align: left; }
        th { background: rgba(0,0,0,0.3); }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #007AFF;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin: 5px;
            transition: all 0.3s ease;
        }
        .btn:hover { background: #0056b3; transform: translateY(-2px); }
        pre { background: rgba(0,0,0,0.3); padding: 15px; border-radius: 5px; overflow-x: auto; font-size: 12px; }
        .timestamp { font-family: monospace; color: #64ffda; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Diagnosi Completa AstroGuida</h1>
        <p class="timestamp">Generato il: <?= $timestamp ?></p>
        
        <!-- Test File Esistenti -->
        <div class="section">
            <h2>📁 File Index Esistenti</h2>
            <?php
            $index_files = ['index.php', 'index.html', 'index.htm'];
            echo "<table>";
            echo "<tr><th>File</th><th>Esiste</th><th>Dimensione</th><th>Ultima Modifica</th><th>Priorità Server</th></tr>";
            
            foreach ($index_files as $i => $file) {
                $exists = file_exists($file);
                $size = $exists ? filesize($file) : 0;
                $mtime = $exists ? date('Y-m-d H:i:s', filemtime($file)) : 'N/A';
                $priority = $i + 1;
                $status_class = $exists ? ($file === 'index.php' ? 'success' : 'error') : 'warning';
                
                echo "<tr class='$status_class'>";
                echo "<td><strong>$file</strong></td>";
                echo "<td>" . ($exists ? '✅ SÌ' : '❌ NO') . "</td>";
                echo "<td>" . ($exists ? number_format($size) . ' bytes' : 'N/A') . "</td>";
                echo "<td>$mtime</td>";
                echo "<td>Priorità $priority</td>";
                echo "</tr>";
            }
            echo "</table>";
            
            if (file_exists('index.html')) {
                echo "<p class='error'><strong>⚠️ PROBLEMA IDENTIFICATO:</strong> index.html esiste e ha priorità su index.php!</p>";
            } else {
                echo "<p class='success'>✅ Nessun conflitto di file index rilevato.</p>";
            }
            ?>
        </div>

        <!-- Test Pagine -->
        <div class="section">
            <h2>📄 Pagine del Sito</h2>
            <?php
            $pages = [
                'home' => 'pages/home.php',
                'services' => 'pages/services.php',
                'gallery' => 'pages/gallery.php',
                'login' => 'pages/login.php',
                'register' => 'pages/register.php',
                'booking' => 'pages/booking.php'
            ];
            
            echo "<table>";
            echo "<tr><th>Pagina</th><th>File Principale</th><th>File Redirect</th><th>Dimensione</th><th>Status</th></tr>";
            
            foreach ($pages as $page => $main_file) {
                $main_exists = file_exists($main_file);
                $redirect_file = $page . '.php';
                $redirect_exists = file_exists($redirect_file);
                $main_size = $main_exists ? filesize($main_file) : 0;
                
                echo "<tr>";
                echo "<td><strong>$page</strong></td>";
                echo "<td>" . ($main_exists ? "✅ $main_file" : "❌ $main_file") . "</td>";
                echo "<td>" . ($redirect_exists ? "✅ $redirect_file" : "❌ $redirect_file") . "</td>";
                echo "<td>" . number_format($main_size) . " bytes</td>";
                
                if ($main_exists && $redirect_exists) {
                    echo "<td class='success'>✅ Completo</td>";
                } elseif ($main_exists) {
                    echo "<td class='warning'>⚠️ Manca redirect</td>";
                } else {
                    echo "<td class='error'>❌ Manca file principale</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
            ?>
        </div>

        <!-- Test Routing -->
        <div class="section">
            <h2>🔗 Test Routing</h2>
            <?php
            $current_page = $_GET['page'] ?? 'home';
            echo "<p><strong>Pagina corrente:</strong> <span class='info'>$current_page</span></p>";
            
            $test_urls = [
                '/' => 'Homepage',
                '/?page=services' => 'Servizi (parametro)',
                '/services' => 'Servizi (diretto)',
                '/?page=gallery' => 'Gallery (parametro)',
                '/gallery' => 'Gallery (diretto)',
                '/?page=login' => 'Login (parametro)',
                '/login' => 'Login (diretto)'
            ];
            
            echo "<table>";
            echo "<tr><th>URL</th><th>Descrizione</th><th>Test</th></tr>";
            
            foreach ($test_urls as $url => $desc) {
                echo "<tr>";
                echo "<td><code>$url</code></td>";
                echo "<td>$desc</td>";
                echo "<td><a href='$url' class='btn' target='_blank'>Testa</a></td>";
                echo "</tr>";
            }
            echo "</table>";
            ?>
        </div>

        <!-- Test Server -->
        <div class="section">
            <h2>🖥️ Informazioni Server</h2>
            <table>
                <tr><td><strong>Server Software</strong></td><td><?= $_SERVER['SERVER_SOFTWARE'] ?? 'N/A' ?></td></tr>
                <tr><td><strong>PHP Version</strong></td><td><?= phpversion() ?></td></tr>
                <tr><td><strong>Document Root</strong></td><td><?= $_SERVER['DOCUMENT_ROOT'] ?? 'N/A' ?></td></tr>
                <tr><td><strong>Script Name</strong></td><td><?= $_SERVER['SCRIPT_NAME'] ?? 'N/A' ?></td></tr>
                <tr><td><strong>Request URI</strong></td><td><?= $_SERVER['REQUEST_URI'] ?? 'N/A' ?></td></tr>
                <tr><td><strong>HTTP Host</strong></td><td><?= $_SERVER['HTTP_HOST'] ?? 'N/A' ?></td></tr>
                <tr><td><strong>User Agent</strong></td><td><?= substr($_SERVER['HTTP_USER_AGENT'] ?? 'N/A', 0, 100) ?>...</td></tr>
            </table>
        </div>

        <!-- Test .htaccess -->
        <div class="section">
            <h2>⚙️ Configurazione .htaccess</h2>
            <?php
            if (file_exists('.htaccess')) {
                $htaccess_content = file_get_contents('.htaccess');
                $htaccess_size = filesize('.htaccess');
                echo "<p class='success'>✅ File .htaccess trovato ($htaccess_size bytes)</p>";
                
                // Verifica regole specifiche
                $rules = [
                    'RewriteEngine On' => 'Rewrite Engine',
                    'DirectoryIndex' => 'Directory Index',
                    'RewriteRule.*services' => 'Redirect Services',
                    'RewriteRule.*gallery' => 'Redirect Gallery',
                    'Cache-Control' => 'Headers Cache'
                ];
                
                echo "<table>";
                echo "<tr><th>Regola</th><th>Status</th></tr>";
                
                foreach ($rules as $pattern => $name) {
                    $found = preg_match("/$pattern/i", $htaccess_content);
                    $status = $found ? "<span class='success'>✅ Presente</span>" : "<span class='error'>❌ Mancante</span>";
                    echo "<tr><td>$name</td><td>$status</td></tr>";
                }
                echo "</table>";
                
                echo "<h3>Contenuto .htaccess:</h3>";
                echo "<pre>" . htmlspecialchars($htaccess_content) . "</pre>";
            } else {
                echo "<p class='error'>❌ File .htaccess non trovato!</p>";
            }
            ?>
        </div>

        <!-- Test CSS -->
        <div class="section">
            <h2>🎨 Test CSS</h2>
            <?php
            $css_file = 'assets/css/main.css';
            if (file_exists($css_file)) {
                $css_size = filesize($css_file);
                echo "<p class='success'>✅ File CSS trovato ($css_size bytes)</p>";
                
                $css_content = file_get_contents($css_file);
                $css_checks = [
                    'auth-container' => 'Stili Autenticazione',
                    'header' => 'Stili Header',
                    'cosmic-text-bright' => 'Testo Cosmico',
                    'backdrop-filter' => 'Glassmorphism'
                ];
                
                echo "<table>";
                echo "<tr><th>Stile</th><th>Status</th></tr>";
                
                foreach ($css_checks as $pattern => $name) {
                    $found = strpos($css_content, $pattern) !== false;
                    $status = $found ? "<span class='success'>✅ Presente</span>" : "<span class='error'>❌ Mancante</span>";
                    echo "<tr><td>$name</td><td>$status</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<p class='error'>❌ File CSS non trovato!</p>";
            }
            ?>
        </div>

        <!-- Soluzioni Suggerite -->
        <div class="section">
            <h2>💡 Soluzioni Suggerite</h2>
            
            <?php if (file_exists('index.html')): ?>
            <div class="error">
                <h3>🚨 Problema Principale: index.html esiste</h3>
                <p>Il server sta servendo index.html invece di index.php.</p>
                <p><strong>Soluzione:</strong></p>
                <ol>
                    <li>Eliminare il file index.html dal server</li>
                    <li>Oppure rinominarlo in backup-index.html</li>
                    <li>Verificare che il file .htaccess abbia DirectoryIndex corretto</li>
                </ol>
            </div>
            <?php endif; ?>
            
            <div class="info">
                <h3>🔧 Passi per Risolvere:</h3>
                <ol>
                    <li><strong>Cancella cache browser:</strong> Ctrl+F5 o modalità incognito</li>
                    <li><strong>Verifica file sul server:</strong> Assicurati che tutti i file siano caricati</li>
                    <li><strong>Controlla .htaccess:</strong> Verifica che le regole di redirect funzionino</li>
                    <li><strong>Test URL diretti:</strong> Prova gli URL specifici sopra</li>
                </ol>
            </div>
        </div>

        <!-- Link Rapidi -->
        <div class="section">
            <h2>🔗 Link Rapidi per Test</h2>
            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                <a href="/" class="btn">🏠 Homepage</a>
                <a href="/?page=services" class="btn">🛠️ Servizi</a>
                <a href="/?page=gallery" class="btn">🖼️ Gallery</a>
                <a href="/?page=login" class="btn">🔐 Login</a>
                <a href="/cache-test.php" class="btn">🧪 Cache Test</a>
                <a href="/check-index.php" class="btn">📋 Check Index</a>
                <a href="javascript:location.reload(true)" class="btn">🔄 Ricarica</a>
            </div>
        </div>
    </div>

    <script>
        console.log('🌟 Diagnosi AstroGuida');
        console.log('Timestamp:', '<?= $timestamp ?>');
        console.log('User Agent:', navigator.userAgent);
        console.log('URL corrente:', window.location.href);
        console.log('Referrer:', document.referrer);
        
        // Test AJAX per verificare routing
        function testUrl(url) {
            fetch(url)
                .then(response => {
                    console.log(`Test ${url}:`, response.status, response.statusText);
                    return response.text();
                })
                .then(data => {
                    console.log(`Contenuto ${url}:`, data.substring(0, 100) + '...');
                })
                .catch(error => {
                    console.error(`Errore ${url}:`, error);
                });
        }
        
        // Test automatico URL
        ['/', '/?page=services', '/services', '/?page=gallery', '/gallery'].forEach(testUrl);
    </script>
</body>
</html> 