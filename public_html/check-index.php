<?php
// File di controllo per verificare quale index viene servito
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
    <title>Controllo Index - AstroGuida</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(255,255,255,0.1);
            padding: 40px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }
        h1 { color: #64ffda; text-align: center; margin-bottom: 30px; }
        .info { background: rgba(0,0,0,0.2); padding: 20px; border-radius: 10px; margin: 20px 0; }
        .success { color: #30d158; }
        .error { color: #ff453a; }
        .warning { color: #ff9f0a; }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #007AFF;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin: 5px;
            transition: all 0.3s ease;
        }
        .btn:hover { background: #0056b3; transform: translateY(-2px); }
        pre { background: rgba(0,0,0,0.3); padding: 15px; border-radius: 5px; overflow-x: auto; }
        .timestamp { font-family: monospace; color: #64ffda; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Controllo Index Files</h1>
        
        <div class="info">
            <h3>Timestamp Corrente</h3>
            <p class="timestamp"><?= $timestamp ?></p>
        </div>
        
        <div class="info">
            <h3>File Esistenti</h3>
            <?php
            $files = [
                'index.php' => 'File PHP principale (CORRETTO)',
                'index.html' => 'File HTML statico (PROBLEMA)',
                'index.htm' => 'File HTM alternativo'
            ];
            
            foreach ($files as $file => $description) {
                $exists = file_exists($file);
                $color = $exists ? ($file === 'index.php' ? 'success' : 'error') : 'warning';
                $status = $exists ? '✅ ESISTE' : '❌ NON ESISTE';
                echo "<p class='$color'><strong>$file:</strong> $status - $description</p>";
                
                if ($exists && $file !== 'index.php') {
                    echo "<p class='error'>⚠️ Questo file potrebbe causare problemi!</p>";
                }
            }
            ?>
        </div>
        
        <div class="info">
            <h3>Informazioni Server</h3>
            <p><strong>SERVER_NAME:</strong> <?= htmlspecialchars($_SERVER['SERVER_NAME'] ?? 'N/A') ?></p>
            <p><strong>REQUEST_URI:</strong> <?= htmlspecialchars($_SERVER['REQUEST_URI'] ?? 'N/A') ?></p>
            <p><strong>SCRIPT_NAME:</strong> <?= htmlspecialchars($_SERVER['SCRIPT_NAME'] ?? 'N/A') ?></p>
            <p><strong>HTTP_HOST:</strong> <?= htmlspecialchars($_SERVER['HTTP_HOST'] ?? 'N/A') ?></p>
        </div>
        
        <div class="info">
            <h3>Test URL</h3>
            <p>Prova questi URL per verificare:</p>
            <a href="/" class="btn">🏠 Homepage (/)</a>
            <a href="/index.php" class="btn">📄 index.php</a>
            <a href="/index.html" class="btn">📄 index.html</a>
            <a href="/cache-test.php" class="btn">🔧 Cache Test</a>
        </div>
        
        <div class="info">
            <h3>Priorità File Server</h3>
            <p>I server web seguono questa priorità:</p>
            <pre>
1. index.html (priorità massima)
2. index.htm
3. index.php
4. index.cgi
5. default.html
            </pre>
            <p class="error">Se esiste index.html, viene servito quello invece di index.php!</p>
        </div>
        
        <div class="info">
            <h3>Soluzioni</h3>
            <ol>
                <li><strong>Eliminare index.html</strong> dal server (se esiste)</li>
                <li><strong>Modificare .htaccess</strong> per forzare index.php</li>
                <li><strong>Rinominare index.html</strong> in backup-index.html</li>
                <li><strong>Configurare DirectoryIndex</strong> nel server</li>
            </ol>
        </div>
    </div>
</body>
</html> 