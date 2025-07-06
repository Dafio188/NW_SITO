<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';

$auth = getAuth();

// Verifica autenticazione SICURA
if (!$auth->isLogged()) {
    header('Location: /?page=login');
    exit;
}

$user = $auth->currentUser();

// Verifica che l'utente sia un array valido
if (!is_array($user)) {
    header('Location: /?page=login');
    exit;
}

// Funzione sicura per htmlspecialchars
function safeHtml($value, $default = '') {
    return htmlspecialchars($value ?? $default, ENT_QUOTES, 'UTF-8');
}

// Variabili sicure
$userName = $user['name'] ?? 'Utente';
$userEmail = $user['email'] ?? 'email@esempio.com';
$userRole = $user['role'] ?? 'user';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Utente - <?= SITE_NAME ?></title>
    <link rel="icon" href="/favicon.jpg" type="image/jpeg">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 80px 0 0 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }
        
        main {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .dashboard {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            text-align: center;
        }
        
        h1 {
            color: #2c3e50;
            margin-bottom: 1rem;
            font-size: 2.5rem;
        }
        
        .user-info {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 15px;
            margin: 1.5rem 0;
        }
        
        .user-info p {
            margin: 0.5rem 0;
            font-size: 1.1rem;
            color: #6c757d;
        }
        
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .action-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 15px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        
        .action-card h3 {
            margin: 0 0 0.5rem 0;
            font-size: 1.2rem;
        }
        
        .action-card p {
            margin: 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }
        
        footer {
            text-align: center;
            padding: 2rem;
            color: rgba(255,255,255,0.8);
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    
    <main>
        <section class="dashboard">
            <h1>👋 Benvenuto, <?= safeHtml($userName) ?>!</h1>
            
            <div class="user-info">
                <p><strong>Email:</strong> <?= safeHtml($userEmail) ?></p>
                <p><strong>Ruolo:</strong> <?= safeHtml(ucfirst($userRole)) ?></p>
                <p><strong>Ultimo accesso:</strong> <?= date('d/m/Y H:i') ?></p>
            </div>
            
            <div class="quick-actions">
                <a href="/?page=gallery" class="action-card">
                    <h3>🖼️ Gallery</h3>
                    <p>Esplora le foto astronomiche</p>
                </a>
                
                <a href="/?page=user_bookings" class="action-card">
                    <h3>📅 Le Mie Prenotazioni</h3>
                    <p>Visualizza le tue prenotazioni</p>
                </a>
                
                <a href="/?page=booking" class="action-card">
                    <h3>🚀 Prenota</h3>
                    <p>Prenota nuova esperienza</p>
                </a>
                
                <a href="/?page=live-sky" class="action-card">
                    <h3>🌌 Live Sky</h3>
                    <p>Guarda il cielo in diretta</p>
                </a>
                
                <a href="/?page=contact" class="action-card">
                    <h3>📞 Contatti</h3>
                    <p>Contattaci per informazioni</p>
                </a>
            </div>
        </section>
    </main>
    
    <footer>
        <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?> - Tutti i diritti riservati</p>
    </footer>
</body>
</html> 