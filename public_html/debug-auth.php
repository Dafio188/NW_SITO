<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Autenticazione - AstroGuida</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #1a1a2e;
            color: #f5f5f7;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 40px;
            backdrop-filter: blur(20px);
        }
        h1, h2, h3 { color: #64ffda; }
        .status {
            padding: 15px;
            border-radius: 10px;
            margin: 15px 0;
            font-weight: 500;
        }
        .success { background: rgba(76, 175, 80, 0.2); border: 1px solid #4caf50; color: #4caf50; }
        .error { background: rgba(244, 67, 54, 0.2); border: 1px solid #f44336; color: #f44336; }
        .info { background: rgba(33, 150, 243, 0.2); border: 1px solid #2196f3; color: #2196f3; }
        .warning { background: rgba(255, 193, 7, 0.2); border: 1px solid #ffc107; color: #ffc107; }
        .debug-section {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
        }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        code {
            background: rgba(255, 255, 255, 0.1);
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #007aff;
            color: white;
            text-decoration: none;
            border-radius: 12px;
            margin: 10px 10px 10px 0;
            transition: all 0.3s ease;
        }
        .btn:hover { background: #0056b3; transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Debug Completo Autenticazione</h1>
        
        <?php
        require_once __DIR__ . '/includes/config.php';
        
        echo '<div class="debug-section">';
        echo '<h2>📋 1. Stato Configurazione</h2>';
        
        // Test database
        if ($pdo) {
            echo '<div class="status success">✅ Database PDO: Connesso</div>';
            
            // Verifica tabelle
            try {
                $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'");
                $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
                echo '<div class="status info">📊 Tabelle trovate: ' . implode(', ', $tables) . '</div>';
                
                if (in_array('users', $tables)) {
                    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
                    $count = $stmt->fetch();
                    echo '<div class="status info">👥 Utenti nel database: ' . $count['count'] . '</div>';
                } else {
                    echo '<div class="status error">❌ Tabella users non trovata</div>';
                }
            } catch (Exception $e) {
                echo '<div class="status error">❌ Errore verifica tabelle: ' . htmlspecialchars($e->getMessage()) . '</div>';
            }
        } else {
            echo '<div class="status error">❌ Database PDO: Non connesso</div>';
        }
        
        // Test sessioni
        echo '<h3>🔒 Stato Sessione</h3>';
        echo '<div class="status info">Session ID: ' . session_id() . '</div>';
        echo '<div class="status info">Session Status: ' . session_status() . '</div>';
        
        if (isset($_SESSION['user_id'])) {
            echo '<div class="status success">✅ user_id in sessione: ' . $_SESSION['user_id'] . '</div>';
        } else {
            echo '<div class="status warning">⚠️ user_id non trovato in sessione</div>';
        }
        
        if (isset($_SESSION['user_role'])) {
            echo '<div class="status success">✅ user_role in sessione: ' . $_SESSION['user_role'] . '</div>';
        } else {
            echo '<div class="status warning">⚠️ user_role non trovato in sessione</div>';
        }
        
        echo '</div>';
        
        // Test sistema Auth
        echo '<div class="debug-section">';
        echo '<h2>🔐 2. Sistema Autenticazione</h2>';
        
        try {
            require_once __DIR__ . '/includes/auth.php';
            $auth = getAuth();
            
            if ($auth) {
                echo '<div class="status success">✅ Classe Auth: Inizializzata</div>';
                
                $isLogged = $auth->isLogged();
                echo '<div class="status ' . ($isLogged ? 'success' : 'warning') . '">';
                echo ($isLogged ? '✅' : '⚠️') . ' Utente loggato: ' . ($isLogged ? 'Sì' : 'No');
                echo '</div>';
                
                if ($isLogged) {
                    $user = $auth->user();
                    if ($user) {
                        echo '<div class="status success">✅ Dati utente recuperati:</div>';
                        echo '<div class="status info">';
                        echo 'ID: ' . $user['id'] . '<br>';
                        echo 'Nome: ' . htmlspecialchars($user['name']) . '<br>';
                        echo 'Email: ' . htmlspecialchars($user['email']) . '<br>';
                        echo 'Ruolo: ' . htmlspecialchars($user['role']) . '<br>';
                        echo '</div>';
                    } else {
                        echo '<div class="status error">❌ Impossibile recuperare dati utente</div>';
                    }
                }
            } else {
                echo '<div class="status error">❌ Classe Auth: Non inizializzata</div>';
            }
        } catch (Exception $e) {
            echo '<div class="status error">❌ Errore Auth: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
        
        echo '</div>';
        
        // Test utenti nel database
        echo '<div class="debug-section">';
        echo '<h2>👥 3. Utenti nel Database</h2>';
        
        if ($pdo) {
            try {
                $stmt = $pdo->query("SELECT id, name, email, role, created_at FROM users ORDER BY id");
                $users = $stmt->fetchAll();
                
                if (empty($users)) {
                    echo '<div class="status warning">⚠️ Nessun utente trovato nel database</div>';
                } else {
                    echo '<div class="status success">✅ Trovati ' . count($users) . ' utenti:</div>';
                    
                    foreach ($users as $user) {
                        $roleClass = $user['role'] === 'admin' ? 'error' : 'info';
                        echo '<div class="status ' . $roleClass . '">';
                        echo 'ID: ' . $user['id'] . ' | ';
                        echo 'Nome: ' . htmlspecialchars($user['name']) . ' | ';
                        echo 'Email: ' . htmlspecialchars($user['email']) . ' | ';
                        echo 'Ruolo: ' . strtoupper($user['role']);
                        echo '</div>';
                    }
                }
                
                // Test password admin
                $stmt = $pdo->prepare("SELECT password FROM users WHERE email = ?");
                $stmt->execute(['admin@astroguida.com']);
                $admin = $stmt->fetch();
                
                if ($admin) {
                    $passwordCheck = password_verify('admin', $admin['password']);
                    echo '<div class="status ' . ($passwordCheck ? 'success' : 'error') . '">';
                    echo ($passwordCheck ? '✅' : '❌') . ' Password admin verificata: ' . ($passwordCheck ? 'Corretta' : 'Errata');
                    echo '</div>';
                } else {
                    echo '<div class="status error">❌ Utente admin non trovato</div>';
                }
                
            } catch (Exception $e) {
                echo '<div class="status error">❌ Errore query utenti: ' . htmlspecialchars($e->getMessage()) . '</div>';
            }
        }
        
        echo '</div>';
        
        // Test errori PHP
        echo '<div class="debug-section">';
        echo '<h2>🐛 4. Test Errori PHP</h2>';
        
        // Test htmlspecialchars con null
        echo '<h3>Test htmlspecialchars:</h3>';
        $test_null = null;
        $test_string = "Test String";
        
        echo '<div class="status info">Test con null: ';
        try {
            $result = htmlspecialchars($test_null);
            echo 'OK - Risultato: "' . $result . '"';
        } catch (Exception $e) {
            echo 'ERRORE - ' . $e->getMessage();
        }
        echo '</div>';
        
        echo '<div class="status info">Test con stringa: ';
        try {
            $result = htmlspecialchars($test_string);
            echo 'OK - Risultato: "' . $result . '"';
        } catch (Exception $e) {
            echo 'ERRORE - ' . $e->getMessage();
        }
        echo '</div>';
        
        // Test versione PHP
        echo '<div class="status info">Versione PHP: ' . PHP_VERSION . '</div>';
        
        echo '</div>';
        
        // Test streaming
        echo '<div class="debug-section">';
        echo '<h2>🎥 5. Sistema Streaming</h2>';
        
        try {
            require_once __DIR__ . '/includes/streaming.php';
            
            if (isset($streamingManager) && $streamingManager) {
                echo '<div class="status success">✅ StreamingManager: Inizializzato</div>';
                
                $url = $streamingManager->getStreamingUrl();
                echo '<div class="status info">URL Streaming: ' . htmlspecialchars($url) . '</div>';
                
                $status = $streamingManager->getStreamingStatus();
                echo '<div class="status info">Stato: ' . htmlspecialchars($status['message']) . '</div>';
            } else {
                echo '<div class="status warning">⚠️ StreamingManager: Non disponibile (fallback attivo)</div>';
            }
        } catch (Exception $e) {
            echo '<div class="status error">❌ Errore Streaming: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
        
        echo '</div>';
        
        // Azioni rapide
        echo '<div class="debug-section">';
        echo '<h2>🚀 6. Azioni Rapide</h2>';
        echo '<a href="/admin-setup.php" class="btn">🔧 Setup Admin</a>';
        echo '<a href="/?page=login" class="btn">🔐 Test Login</a>';
        echo '<a href="/?page=dashboard" class="btn">📊 Dashboard</a>';
        echo '<a href="/admin/streaming-settings.php" class="btn">🎥 Streaming Admin</a>';
        echo '</div>';
        
        ?>
        
        <div style="text-align: center; margin-top: 30px; color: #666;">
            <small>Debug completato - <?= date('Y-m-d H:i:s') ?></small>
        </div>
    </div>
</body>
</html> 