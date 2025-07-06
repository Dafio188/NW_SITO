<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';

$auth = getAuth();

// Verifica autenticazione SICURA
if (!$auth->isLogged()) {
    header('Location: /?page=login');
    exit;
}

$user = $auth->user();

// Verifica che l'utente sia un array valido e sia admin
if (!is_array($user) || ($user['role'] ?? '') !== 'admin') {
    header('Location: /?page=login');
    exit;
}

// Funzione sicura per htmlspecialchars
function safeHtml($value, $default = '') {
    return htmlspecialchars($value ?? $default, ENT_QUOTES, 'UTF-8');
}

// Variabili sicure
$userName = $user['name'] ?? 'Amministratore';
$userEmail = $user['email'] ?? 'admin@astroguida.com';

// Statistiche Dashboard REALI
try {
    require_once __DIR__ . '/../includes/database.php';
    $db = getDb();
    
    // Conta utenti
    $stmt = $db->query("SELECT COUNT(*) as total FROM users");
    $totalUsers = $stmt->fetch()['total'] ?? 0;
    
    $stmt = $db->query("SELECT COUNT(*) as total FROM users WHERE role = 'admin'");
    $totalAdmins = $stmt->fetch()['total'] ?? 0;
    
    $stmt = $db->query("SELECT COUNT(*) as total FROM users WHERE role = 'user'");
    $totalRegularUsers = $stmt->fetch()['total'] ?? 0;
    
    // Conta prenotazioni (se tabella esiste)
    try {
        $stmt = $db->query("SELECT COUNT(*) as total FROM bookings");
        $totalBookings = $stmt->fetch()['total'] ?? 0;
    } catch (Exception $e) {
        $totalBookings = 0;
    }
    
    // Ultimi utenti registrati CON DETTAGLI
    $stmt = $db->query("SELECT name, email, role, created_at FROM users ORDER BY created_at DESC LIMIT 10");
    $recentUsers = $stmt->fetchAll();
    
    // Tutti gli utenti per gestione
    $stmt = $db->query("SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC");
    $allUsers = $stmt->fetchAll();
    
} catch (Exception $e) {
    $totalUsers = 0;
    $totalAdmins = 0;
    $totalRegularUsers = 0;
    $totalBookings = 0;
    $recentUsers = [];
    $allUsers = [];
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🛡️ Dashboard Amministratore - <?= SITE_NAME ?></title>
    <link rel="icon" href="/favicon.jpg" type="image/jpeg">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            color: #fff;
        }
        
        .admin-header {
            background: rgba(0, 0, 0, 0.3);
            padding: 1rem 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .admin-header-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .admin-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #64ffda;
            margin: 0;
        }
        
        .admin-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .admin-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #64ffda, #007aff);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
        }
        
        .admin-nav {
            display: flex;
            gap: 1rem;
            margin-left: 2rem;
        }
        
        .admin-nav a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        .admin-nav a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #64ffda;
        }
        
        main {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .welcome-section {
            text-align: center;
            margin-bottom: 3rem;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .welcome-section h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #64ffda, #007aff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: #64ffda;
        }
        
        .stat-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
        }
        
        .admin-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }
        
        .admin-section {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .section-title {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: #64ffda;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .users-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        
        .users-table th,
        .users-table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .users-table th {
            background: rgba(255, 255, 255, 0.05);
            color: #64ffda;
            font-weight: bold;
        }
        
        .users-table tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }
        
        .role-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .role-admin {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
        }
        
        .role-user {
            background: linear-gradient(135deg, #4ecdc4, #44a08d);
            color: white;
        }
        
        .admin-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }
        
        .admin-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            display: block;
            text-align: center;
        }
        
        .admin-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            color: white;
            text-decoration: none;
        }
        
        .admin-card h3 {
            margin: 0 0 1rem 0;
            font-size: 1.3rem;
        }
        
        .admin-card p {
            margin: 0;
            opacity: 0.9;
            font-size: 0.95rem;
        }
        
        .admin-card .icon {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        
        .recent-users {
            list-style: none;
            padding: 0;
            max-height: 400px;
            overflow-y: auto;
        }
        
        .recent-users li {
            background: rgba(255, 255, 255, 0.05);
            padding: 1rem;
            margin-bottom: 0.5rem;
            border-radius: 10px;
            border-left: 4px solid #64ffda;
        }
        
        .user-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .user-details {
            flex: 1;
        }
        
        .user-name {
            font-weight: bold;
            color: #64ffda;
        }
        
        .user-email {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }
        
        .user-date {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.8rem;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            display: inline-block;
            font-weight: bold;
            transition: all 0.3s ease;
            cursor: pointer;
            text-align: center;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #007aff, #0056b3);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 122, 255, 0.3);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #ff3b30, #d70015);
            color: white;
        }
        
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 59, 48, 0.3);
        }
        
        .system-info {
            background: rgba(255, 255, 255, 0.05);
            padding: 1rem;
            border-radius: 10px;
            margin-top: 1rem;
        }
        
        .system-info h4 {
            color: #64ffda;
            margin-bottom: 0.5rem;
        }
        
        .system-info p {
            margin: 0.25rem 0;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
        }
        
        @media (max-width: 768px) {
            .admin-header-content {
                flex-direction: column;
                gap: 1rem;
            }
            
            .admin-nav {
                margin-left: 0;
            }
            
            main {
                padding: 1rem;
            }
            
            .admin-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
        }
    </style>
</head>
<body>
    <!-- Header Amministratore -->
    <header class="admin-header">
        <div class="admin-header-content">
            <div style="display: flex; align-items: center;">
                <h1 class="admin-title">🛡️ Dashboard Amministratore</h1>
                <nav class="admin-nav">
                    <a href="/">🏠 Sito</a>
                    <a href="/?page=dashboard">👤 Dashboard Utente</a>
                    <a href="/?page=logout">🚪 Logout</a>
                </nav>
            </div>
            <div class="admin-user">
                <div class="admin-avatar">
                    <?= strtoupper(substr($userName, 0, 1)) ?>
                </div>
                <div>
                    <div style="font-weight: bold;"><?= safeHtml($userName) ?></div>
                    <div style="font-size: 0.8rem; color: rgba(255, 255, 255, 0.7);"><?= safeHtml($userEmail) ?></div>
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- Sezione Benvenuto -->
        <div class="welcome-section">
            <h1>🎯 Pannello di Controllo AstroGuida</h1>
            <p>Benvenuto, <strong><?= safeHtml($userName) ?></strong>! Da qui puoi gestire tutto il sito.</p>
        </div>

        <!-- Statistiche Principali -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-number"><?= $totalUsers ?></div>
                <div class="stat-label">Utenti Totali</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🛡️</div>
                <div class="stat-number"><?= $totalAdmins ?></div>
                <div class="stat-label">Amministratori</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🌟</div>
                <div class="stat-number"><?= $totalRegularUsers ?></div>
                <div class="stat-label">Utenti Normali</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">📅</div>
                <div class="stat-number"><?= $totalBookings ?></div>
                <div class="stat-label">Prenotazioni</div>
            </div>
        </div>

        <!-- Azioni Amministrative -->
        <div class="admin-actions">
            <a href="/?page=admin_gallery" class="admin-card">
                <div class="icon">🖼️</div>
                <h3>Gestisci Gallery</h3>
                <p>Aggiungi, modifica o rimuovi immagini dalla gallery astrofotografica</p>
            </a>
            <a href="/?page=admin_bookings" class="admin-card">
                <div class="icon">📅</div>
                <h3>Gestisci Prenotazioni</h3>
                <p>Visualizza e gestisci tutte le prenotazioni dei servizi</p>
            </a>
            <a href="/?page=admin_services" class="admin-card">
                <div class="icon">🛠️</div>
                <h3>Gestisci Servizi</h3>
                <p>Modifica i servizi offerti e i relativi prezzi</p>
            </a>
            <a href="/?page=admin_contacts" class="admin-card">
                <div class="icon">📧</div>
                <h3>Messaggi Contatti</h3>
                <p>Visualizza i messaggi ricevuti dal form contatti</p>
            </a>
        </div>

        <!-- Griglia Principale -->
        <div class="admin-grid">
            <!-- Ultimi Utenti Registrati -->
            <div class="admin-section">
                <h2 class="section-title">
                    <span>👥</span> Ultimi Utenti Registrati
                </h2>
                <?php if (!empty($recentUsers)): ?>
                    <ul class="recent-users">
                        <?php foreach ($recentUsers as $recentUser): ?>
                            <li>
                                <div class="user-info">
                                    <div class="user-details">
                                        <div class="user-name"><?= safeHtml($recentUser['name']) ?></div>
                                        <div class="user-email"><?= safeHtml($recentUser['email']) ?></div>
                                        <div class="user-date">
                                            <?= date('d/m/Y H:i', strtotime($recentUser['created_at'])) ?>
                                        </div>
                                    </div>
                                    <div class="role-badge <?= $recentUser['role'] === 'admin' ? 'role-admin' : 'role-user' ?>">
                                        <?= $recentUser['role'] === 'admin' ? 'ADMIN' : 'USER' ?>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p style="text-align: center; color: rgba(255, 255, 255, 0.6);">
                        Nessun utente registrato
                    </p>
                <?php endif; ?>
            </div>

            <!-- Informazioni Sistema -->
            <div class="admin-section">
                <h2 class="section-title">
                    <span>⚙️</span> Informazioni Sistema
                </h2>
                <div class="system-info">
                    <h4>🌐 Stato Sito</h4>
                    <p><strong>Versione:</strong> 1.0.0</p>
                    <p><strong>PHP:</strong> <?= phpversion() ?></p>
                    <p><strong>Database:</strong> SQLite</p>
                    <p><strong>Hosting:</strong> Aruba Linux</p>
                    <p><strong>Ultimo accesso admin:</strong> <?= date('d/m/Y H:i') ?></p>
                </div>
                
                <div class="system-info">
                    <h4>📊 Statistiche Rapide</h4>
                    <p><strong>Spazio utilizzato:</strong> ~<?= round(disk_total_space('.') / 1024 / 1024 / 1024, 2) ?>GB</p>
                    <p><strong>Memoria PHP:</strong> <?= ini_get('memory_limit') ?></p>
                    <p><strong>Tempo esecuzione:</strong> <?= ini_get('max_execution_time') ?>s</p>
                </div>
            </div>
        </div>

        <!-- Gestione Utenti Completa -->
        <div class="admin-section">
            <h2 class="section-title">
                <span>🗂️</span> Gestione Utenti Completa
            </h2>
            <?php if (!empty($allUsers)): ?>
                <div style="overflow-x: auto;">
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Ruolo</th>
                                <th>Registrato</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allUsers as $userData): ?>
                                <tr>
                                    <td><?= safeHtml($userData['id']) ?></td>
                                    <td><?= safeHtml($userData['name']) ?></td>
                                    <td><?= safeHtml($userData['email']) ?></td>
                                    <td>
                                        <span class="role-badge <?= $userData['role'] === 'admin' ? 'role-admin' : 'role-user' ?>">
                                            <?= $userData['role'] === 'admin' ? 'ADMIN' : 'USER' ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($userData['created_at'])) ?></td>
                                    <td>
                                        <?php if ($userData['role'] !== 'admin' || $userData['id'] != $user['id']): ?>
                                            <button class="btn btn-primary" style="font-size: 0.8rem; padding: 0.5rem;">
                                                ✏️ Modifica
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p style="text-align: center; color: rgba(255, 255, 255, 0.6);">
                    Nessun utente trovato
                </p>
            <?php endif; ?>
        </div>

        <!-- Azioni Rapide -->
        <div class="admin-section">
            <h2 class="section-title">
                <span>⚡</span> Azioni Rapide
            </h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <button class="btn btn-primary" onclick="location.reload();">
                    🔄 Ricarica Dashboard
                </button>
                <button class="btn btn-primary" onclick="window.open('/', '_blank');">
                    🌐 Visualizza Sito
                </button>
                <button class="btn btn-danger" onclick="if(confirm('Sei sicuro di voler uscire?')) window.location.href='/?page=logout';">
                    🚪 Logout
                </button>
            </div>
        </div>
    </main>
</body>
</html> 