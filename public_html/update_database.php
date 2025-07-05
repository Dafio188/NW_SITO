<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiornamento Database - AstroGuida</title>
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
            margin: 10px 0;
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 122, 255, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Aggiornamento Database AstroGuida</h1>
        
        <?php
        if (isset($_GET['update']) && $_GET['update'] === 'true') {
            echo '<div class="result">';
            
            try {
                require_once 'includes/config.php';
                require_once 'includes/database.php';
                
                echo "🔧 Aggiornamento database AstroGuida...\n\n";
                
                $db = getDb();
                
                // Verifica se le colonne esistono già
                $stmt = $db->query("PRAGMA table_info(users)");
                $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                $hasResetToken = false;
                $hasResetExpires = false;
                
                foreach ($columns as $column) {
                    if ($column['name'] === 'reset_token') {
                        $hasResetToken = true;
                    }
                    if ($column['name'] === 'reset_expires') {
                        $hasResetExpires = true;
                    }
                }
                
                // Aggiungi colonne se mancanti
                if (!$hasResetToken) {
                    $db->exec("ALTER TABLE users ADD COLUMN reset_token TEXT");
                    echo "✅ Colonna reset_token aggiunta\n";
                } else {
                    echo "ℹ️  Colonna reset_token già presente\n";
                }
                
                if (!$hasResetExpires) {
                    $db->exec("ALTER TABLE users ADD COLUMN reset_expires DATETIME");
                    echo "✅ Colonna reset_expires aggiunta\n";
                } else {
                    echo "ℹ️  Colonna reset_expires già presente\n";
                }
                
                echo "\n🎉 Database aggiornato con successo!\n";
                echo "✅ Reset password ora funzionante\n";
                echo "\n🔗 Puoi ora testare il reset password: <a href='reset_password.php' style='color: #64ffda;'>reset_password.php</a>\n";
                
                echo '</div>';
                
            } catch (Exception $e) {
                echo '<div class="result error">';
                echo "❌ Errore: " . $e->getMessage() . "\n";
                echo '</div>';
            }
        } else {
            ?>
            <div class="result info">
                <strong>Questo script aggiorna il database per supportare il reset password.</strong>
                
                Aggiunge le colonne mancanti:
                • reset_token - per il token di reset
                • reset_expires - per la scadenza del token
                
                Clicca il pulsante per eseguire l'aggiornamento.
            </div>
            
            <form method="GET">
                <input type="hidden" name="update" value="true">
                <button type="submit" class="btn">🚀 Aggiorna Database</button>
            </form>
            
            <div class="result">
                <strong>Dopo l'aggiornamento:</strong>
                1. Il reset password funzionerà correttamente
                2. Potrai testarlo su reset_password.php
                3. Riceverai email con il link per reimpostare la password
            </div>
            <?php
        }
        ?>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="index.php" style="color: #64ffda; text-decoration: none;">← Torna alla Homepage</a>
        </div>
    </div>
</body>
</html> 