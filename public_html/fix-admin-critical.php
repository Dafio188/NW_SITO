<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fix Admin Critico - AstroGuida</title>
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
            max-width: 800px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 40px;
            backdrop-filter: blur(20px);
        }
        h1, h2 { color: #64ffda; }
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
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
        code {
            background: rgba(255, 255, 255, 0.1);
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚨 Fix Critico Amministratore</h1>
        
        <?php
        require_once __DIR__ . '/includes/config.php';
        
        if (!$pdo) {
            echo '<div class="status error">❌ Database non disponibile</div>';
            exit;
        }
        
        echo '<h2>🔧 1. Elimina e Ricrea Utente Admin</h2>';
        
        try {
            // Elimina utente admin esistente
            $stmt = $pdo->prepare("DELETE FROM users WHERE email = ?");
            $stmt->execute(['admin@astroguida.com']);
            echo '<div class="status warning">⚠️ Utente admin esistente eliminato</div>';
            
            // Crea nuovo utente admin con password corretta
            $password_hash = password_hash('admin', PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("
                INSERT INTO users (email, password, name, role, created_at) 
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                'admin@astroguida.com',
                $password_hash,
                'Amministratore AstroGuida',
                'admin',
                date('Y-m-d H:i:s')
            ]);
            
            echo '<div class="status success">✅ Nuovo utente admin creato</div>';
            
            // Verifica password
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute(['admin@astroguida.com']);
            $admin = $stmt->fetch();
            
            if ($admin && password_verify('admin', $admin['password'])) {
                echo '<div class="status success">✅ Password verificata correttamente</div>';
            } else {
                echo '<div class="status error">❌ Errore verifica password</div>';
            }
            
        } catch (Exception $e) {
            echo '<div class="status error">❌ Errore: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
        
        echo '<h2>🔧 2. Test Login Diretto</h2>';
        
        // Test login diretto
        if (isset($_POST['test_login'])) {
            try {
                require_once __DIR__ . '/includes/auth.php';
                $auth = getAuth();
                
                $login_result = $auth->login('admin@astroguida.com', 'admin');
                
                if ($login_result) {
                    echo '<div class="status success">✅ Login test RIUSCITO</div>';
                    echo '<div class="status info">Session user_id: ' . ($_SESSION['user_id'] ?? 'Non impostato') . '</div>';
                    echo '<div class="status info">Session user_role: ' . ($_SESSION['user_role'] ?? 'Non impostato') . '</div>';
                } else {
                    echo '<div class="status error">❌ Login test FALLITO</div>';
                }
            } catch (Exception $e) {
                echo '<div class="status error">❌ Errore login test: ' . htmlspecialchars($e->getMessage()) . '</div>';
            }
        }
        
        echo '<form method="post">';
        echo '<button type="submit" name="test_login" class="btn">🧪 Test Login Admin</button>';
        echo '</form>';
        
        echo '<h2>🔧 3. Verifica Accesso Admin</h2>';
        
        // Verifica se l'utente è loggato
        if (isset($_SESSION['user_id'])) {
            echo '<div class="status success">✅ Utente loggato - ID: ' . $_SESSION['user_id'] . '</div>';
            
            if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                echo '<div class="status success">✅ Ruolo admin confermato</div>';
                echo '<div class="status info">Puoi accedere alla dashboard admin</div>';
            } else {
                echo '<div class="status warning">⚠️ Ruolo non admin: ' . ($_SESSION['user_role'] ?? 'Non impostato') . '</div>';
            }
        } else {
            echo '<div class="status warning">⚠️ Nessun utente loggato</div>';
        }
        
        echo '<h2>🔧 4. Fix Immediato Sistema Auth</h2>';
        
        if (isset($_POST['fix_auth'])) {
            try {
                // Forza login admin
                $_SESSION['user_id'] = $admin['id'];
                $_SESSION['user_role'] = 'admin';
                $_SESSION['user_name'] = 'Amministratore AstroGuida';
                
                echo '<div class="status success">✅ Sessione admin forzata</div>';
                echo '<div class="status info">Ora puoi accedere alla dashboard</div>';
            } catch (Exception $e) {
                echo '<div class="status error">❌ Errore fix auth: ' . htmlspecialchars($e->getMessage()) . '</div>';
            }
        }
        
        echo '<form method="post">';
        echo '<button type="submit" name="fix_auth" class="btn btn-danger">🔧 Forza Login Admin</button>';
        echo '</form>';
        
        echo '<h2>📋 5. Credenziali Finali</h2>';
        echo '<div class="status info">';
        echo '<strong>Email:</strong> <code>admin@astroguida.com</code><br>';
        echo '<strong>Password:</strong> <code>admin</code><br>';
        echo '<strong>Ruolo:</strong> <code>admin</code>';
        echo '</div>';
        
        echo '<h2>🚀 6. Test Accessi</h2>';
        echo '<a href="/?page=login" class="btn">🔐 Vai al Login</a>';
        echo '<a href="/admin/" class="btn">🎛️ Dashboard Admin</a>';
        echo '<a href="/admin/streaming-settings.php" class="btn">🎥 Gestione Streaming</a>';
        echo '<a href="/?page=dashboard" class="btn">📊 Dashboard Utente</a>';
        
        ?>
        
        <div style="text-align: center; margin-top: 30px; color: #666;">
            <small>Fix completato - <?= date('Y-m-d H:i:s') ?></small>
        </div>
    </div>
</body>
</html> 