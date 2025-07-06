<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Amministratore - AstroGuida</title>
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
        h1 {
            text-align: center;
            color: #64ffda;
            margin-bottom: 30px;
        }
        .status {
            padding: 15px;
            border-radius: 10px;
            margin: 15px 0;
            font-weight: 500;
        }
        .success {
            background: rgba(76, 175, 80, 0.2);
            border: 1px solid #4caf50;
            color: #4caf50;
        }
        .error {
            background: rgba(244, 67, 54, 0.2);
            border: 1px solid #f44336;
            color: #f44336;
        }
        .info {
            background: rgba(33, 150, 243, 0.2);
            border: 1px solid #2196f3;
            color: #2196f3;
        }
        .warning {
            background: rgba(255, 193, 7, 0.2);
            border: 1px solid #ffc107;
            color: #ffc107;
        }
        .credentials {
            background: rgba(0, 122, 255, 0.1);
            border: 1px solid rgba(0, 122, 255, 0.3);
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
        }
        .credentials h3 {
            color: #64ffda;
            margin-top: 0;
        }
        .cred-item {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .cred-item:last-child {
            border-bottom: none;
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
        .btn:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }
        .btn-success {
            background: #28a745;
        }
        .btn-success:hover {
            background: #1e7e34;
        }
        code {
            background: rgba(255, 255, 255, 0.1);
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
        }
        .user-list {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 15px;
            margin: 15px 0;
        }
        .user-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .user-item:last-child {
            border-bottom: none;
        }
        .user-role {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }
        .role-admin {
            background: #ff4757;
            color: white;
        }
        .role-user {
            background: #3742fa;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 Setup Amministratore AstroGuida</h1>
        
        <?php
        require_once __DIR__ . '/includes/config.php';
        
        if (!$pdo) {
            echo '<div class="status error">❌ ERRORE: Database non disponibile</div>';
            exit;
        }
        
        try {
            // Verifica se esiste l'utente admin
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute(['admin@astroguida.com']);
            $admin_user = $stmt->fetch();
            
            if ($admin_user) {
                echo '<div class="status success">✅ Utente amministratore trovato</div>';
                
                // Verifica password
                if (password_verify('admin', $admin_user['password'])) {
                    echo '<div class="status success">✅ Password corretta</div>';
                } else {
                    echo '<div class="status warning">⚠️ Password non corretta, aggiorno...</div>';
                    $new_password = password_hash('admin', PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $stmt->execute([$new_password, $admin_user['id']]);
                    echo '<div class="status success">✅ Password aggiornata</div>';
                }
                
                // Verifica ruolo admin
                if ($admin_user['role'] !== 'admin') {
                    echo '<div class="status warning">⚠️ Ruolo non admin, aggiorno...</div>';
                    $stmt = $pdo->prepare("UPDATE users SET role = 'admin' WHERE id = ?");
                    $stmt->execute([$admin_user['id']]);
                    echo '<div class="status success">✅ Ruolo aggiornato ad admin</div>';
                }
                
            } else {
                echo '<div class="status warning">⚠️ Utente admin non trovato, lo creo...</div>';
                
                // Crea utente admin
                $password_hash = password_hash('admin', PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("
                    INSERT INTO users (email, password, name, role, created_at) 
                    VALUES (?, ?, ?, ?, ?)
                ");
                $stmt->execute([
                    'admin@astroguida.com',
                    $password_hash,
                    'Amministratore',
                    'admin',
                    date('Y-m-d H:i:s')
                ]);
                
                echo '<div class="status success">✅ Utente admin creato con successo!</div>';
            }
            
            // Credenziali admin
            echo '<div class="credentials">';
            echo '<h3>🔑 Credenziali Amministratore</h3>';
            echo '<div class="cred-item"><strong>Email:</strong> <code>admin@astroguida.com</code></div>';
            echo '<div class="cred-item"><strong>Password:</strong> <code>admin</code></div>';
            echo '<div class="cred-item"><strong>Ruolo:</strong> <code>admin</code></div>';
            echo '</div>';
            
            // Statistiche database
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
            $count = $stmt->fetch();
            
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM users WHERE role = 'admin'");
            $admin_count = $stmt->fetch();
            
            echo '<div class="status info">';
            echo "📊 Statistiche Database: {$count['total']} utenti totali, {$admin_count['total']} amministratori";
            echo '</div>';
            
            // Lista utenti
            echo '<h3>👥 Lista Utenti</h3>';
            $stmt = $pdo->query("SELECT id, email, name, role, created_at FROM users ORDER BY id");
            $users = $stmt->fetchAll();
            
            echo '<div class="user-list">';
            foreach ($users as $user) {
                $role_class = $user['role'] === 'admin' ? 'role-admin' : 'role-user';
                echo '<div class="user-item">';
                echo '<div>';
                echo '<strong>' . htmlspecialchars($user['name']) . '</strong><br>';
                echo '<small>' . htmlspecialchars($user['email']) . '</small>';
                echo '</div>';
                echo '<div class="user-role ' . $role_class . '">' . strtoupper($user['role']) . '</div>';
                echo '</div>';
            }
            echo '</div>';
            
        } catch (Exception $e) {
            echo '<div class="status error">❌ ERRORE: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
        ?>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="/?page=login" class="btn">🔐 Vai al Login</a>
            <a href="/admin/" class="btn btn-success">🎛️ Dashboard Admin</a>
            <a href="/admin/streaming-settings.php" class="btn">🎥 Gestione Streaming</a>
        </div>
        
        <div style="text-align: center; margin-top: 20px; color: #666;">
            <small>
                Dopo aver verificato le credenziali, puoi eliminare questo file per sicurezza.<br>
                File: <code>/admin-setup.php</code>
            </small>
        </div>
    </div>
</body>
</html> 