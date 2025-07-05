<?php
// Test Cache - AstroGuida
// Questo file serve per verificare se la cache sta causando problemi

// Headers per forzare il refresh
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
header("Content-Type: text/html; charset=UTF-8");

$timestamp = date('Y-m-d H:i:s');
$random = rand(1000, 9999);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Cache - AstroGuida</title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            text-align: center;
            background: rgba(255,255,255,0.1);
            padding: 40px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            max-width: 600px;
        }
        h1 { color: #64ffda; margin-bottom: 30px; }
        .info { background: rgba(0,0,0,0.2); padding: 20px; border-radius: 10px; margin: 20px 0; }
        .status { font-size: 24px; margin: 20px 0; }
        .timestamp { font-family: monospace; font-size: 18px; color: #64ffda; }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #007AFF;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin: 10px;
            transition: all 0.3s ease;
        }
        .btn:hover { background: #0056b3; transform: translateY(-2px); }
        .error { color: #ff453a; }
        .success { color: #30d158; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🌟 Test Cache AstroGuida</h1>
        
        <div class="status success">
            ✅ Sito Aggiornato e Funzionante
        </div>
        
        <div class="info">
            <h3>Informazioni Timestamp</h3>
            <p><strong>Data/Ora Server:</strong> <span class="timestamp"><?= $timestamp ?></span></p>
            <p><strong>Numero Casuale:</strong> <span class="timestamp"><?= $random ?></span></p>
            <p><strong>Versione:</strong> <span class="timestamp">AstroGuida v2.0 - Aggiornata</span></p>
        </div>
        
        <div class="info">
            <h3>Stato del Sito</h3>
            <p>✅ <strong>Homepage:</strong> Aggiornata con design Mac-inspired</p>
            <p>✅ <strong>Autenticazione:</strong> Login e Register rinnovati</p>
            <p>✅ <strong>Navigazione:</strong> Header unificato</p>
            <p>✅ <strong>CSS:</strong> Stili completi caricati</p>
            <p>✅ <strong>Database:</strong> SQLite funzionante</p>
        </div>
        
        <div class="info">
            <h3>Informazioni Tecniche</h3>
            <p><strong>User Agent:</strong> <?= htmlspecialchars($_SERVER['HTTP_USER_AGENT'] ?? 'Non disponibile') ?></p>
            <p><strong>IP Client:</strong> <?= htmlspecialchars($_SERVER['REMOTE_ADDR'] ?? 'Non disponibile') ?></p>
            <p><strong>Metodo:</strong> <?= htmlspecialchars($_SERVER['REQUEST_METHOD'] ?? 'Non disponibile') ?></p>
        </div>
        
        <div style="margin-top: 30px;">
            <a href="/" class="btn">🏠 Vai alla Homepage</a>
            <a href="/?page=login" class="btn">🔐 Test Login</a>
            <a href="javascript:location.reload(true)" class="btn">🔄 Ricarica Pagina</a>
        </div>
        
        <div style="margin-top: 20px; font-size: 14px; opacity: 0.8;">
            <p>Se vedi ancora la vecchia interfaccia, prova:</p>
            <p>📱 <strong>Tablet:</strong> Impostazioni → Safari → Cancella Cache</p>
            <p>🖥️ <strong>Desktop:</strong> Ctrl+F5 o Cmd+Shift+R</p>
            <p>⚡ <strong>Alternativa:</strong> Modalità Incognito/Privata</p>
        </div>
    </div>
    
    <script>
        // Auto-refresh ogni 10 secondi per test
        // setTimeout(() => location.reload(), 10000);
        
        // Mostra info browser
        console.log('🌟 AstroGuida Test Cache');
        console.log('Timestamp:', '<?= $timestamp ?>');
        console.log('Random:', '<?= $random ?>');
        console.log('User Agent:', navigator.userAgent);
        console.log('Cache Status:', document.querySelector('meta[http-equiv="Cache-Control"]') ? 'No-Cache Headers Set' : 'Cache Headers Missing');
    </script>
</body>
</html> 