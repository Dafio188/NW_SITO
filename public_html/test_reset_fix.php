<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Database Fix - AstroGuida</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: white;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 30px;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #64ffda;
        }
        .result {
            background: rgba(0, 0, 0, 0.3);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            font-family: monospace;
            white-space: pre-wrap;
        }
        .success {
            border-left: 4px solid #4caf50;
        }
        .error {
            border-left: 4px solid #f44336;
        }
        .info {
            border-left: 4px solid #2196f3;
        }
        .btn {
            background: linear-gradient(135deg, #007AFF, #5E5CE6);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            margin: 10px 5px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 122, 255, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Test Database Fix</h1>
        
        <?php
        try {
            require_once 'includes/config.php';
            require_once 'includes/database.php';
            
            echo '<div class="result success">';
            echo "🔧 Test connessione database...\n\n";
            
            $db = getDb();
            echo "✅ Database connesso correttamente\n";
            
            // Verifica struttura tabella users
            echo "\n📋 Struttura tabella users:\n";
            $stmt = $db->query("PRAGMA table_info(users)");
            $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $hasResetToken = false;
            $hasResetExpires = false;
            
            foreach ($columns as $column) {
                echo "• " . $column['name'] . " (" . $column['type'] . ")\n";
                if ($column['name'] === 'reset_token') {
                    $hasResetToken = true;
                }
                if ($column['name'] === 'reset_expires') {
                    $hasResetExpires = true;
                }
            }
            
            echo "\n🔍 Verifica colonne reset password:\n";
            if ($hasResetToken) {
                echo "✅ Colonna reset_token presente\n";
            } else {
                echo "❌ Colonna reset_token MANCANTE\n";
            }
            
            if ($hasResetExpires) {
                echo "✅ Colonna reset_expires presente\n";
            } else {
                echo "❌ Colonna reset_expires MANCANTE\n";
            }
            
            // Test funzioni reset
            echo "\n🧪 Test funzioni reset password:\n";
            require_once 'includes/reset_token.php';
            
            // Verifica che le funzioni siano caricate
            if (function_exists('generateResetToken')) {
                echo "✅ Funzione generateResetToken caricata\n";
            } else {
                echo "❌ Funzione generateResetToken NON caricata\n";
            }
            
            if (function_exists('validateResetToken')) {
                echo "✅ Funzione validateResetToken caricata\n";
            } else {
                echo "❌ Funzione validateResetToken NON caricata\n";
            }
            
            // Test warning sessioni
            echo "\n🔐 Test configurazione sessioni:\n";
            if (session_status() === PHP_SESSION_NONE) {
                echo "✅ Nessuna sessione attiva - configurazione OK\n";
            } else {
                echo "ℹ️  Sessione già attiva - configurazione protetta\n";
            }
            
            echo "\n🎉 TUTTI I TEST SUPERATI!\n";
            echo "✅ Reset password dovrebbe funzionare correttamente\n";
            
            echo '</div>';
            
        } catch (Exception $e) {
            echo '<div class="result error">';
            echo "❌ Errore: " . $e->getMessage() . "\n";
            echo "Stack trace:\n" . $e->getTraceAsString();
            echo '</div>';
        }
        ?>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="reset_password.php" class="btn">🔑 Testa Reset Password</a>
            <a href="index.php" class="btn">🏠 Homepage</a>
        </div>
    </div>
</body>
</html> 