<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';

$auth = getAuth();

// Verifica autenticazione admin
if (!$auth->isLogged()) {
    header('Location: /?page=login');
    exit;
}

$user = $auth->user();
if (!is_array($user) || ($user['role'] ?? '') !== 'admin') {
    header('Location: /?page=login');
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🛠️ Gestione Servizi - Admin AstroGuida</title>
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
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .header {
            background: rgba(0, 0, 0, 0.3);
            padding: 1rem 0;
            margin-bottom: 2rem;
            border-radius: 15px;
            backdrop-filter: blur(10px);
        }
        
        .header h1 {
            margin: 0;
            text-align: center;
            color: #64ffda;
            font-size: 2rem;
        }
        
        .nav-links {
            text-align: center;
            margin-top: 1rem;
        }
        
        .nav-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            margin: 0 1rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .nav-links a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #64ffda;
        }
        
        .card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .service-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .service-card:hover {
            transform: translateY(-5px);
            border-color: rgba(100, 255, 218, 0.3);
        }
        
        .service-icon {
            font-size: 3rem;
            text-align: center;
            margin-bottom: 1rem;
        }
        
        .service-title {
            color: #64ffda;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        
        .service-price {
            color: #fff;
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 1rem;
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
            margin: 0.25rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #64ffda, #007aff);
            color: #1a1a2e;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(100, 255, 218, 0.3);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #ff3b30, #d70015);
            color: white;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #64ffda;
            font-weight: bold;
        }
        
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid rgba(100, 255, 218, 0.3);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 1rem;
        }
        
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #64ffda;
            box-shadow: 0 0 0 3px rgba(100, 255, 218, 0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🛠️ Gestione Servizi AstroGuida</h1>
            <div class="nav-links">
                <a href="/?page=admin_dashboard">🏠 Dashboard Admin</a>
                <a href="/?page=services">👁️ Visualizza Servizi</a>
                <a href="/?page=logout">🚪 Logout</a>
            </div>
        </div>
        
        <div class="card">
            <h2>➕ Aggiungi Nuovo Servizio</h2>
            <form action="" method="post">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="name">Nome Servizio</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Prezzo (€)</label>
                        <input type="number" id="price" name="price" step="0.01" required>
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="duration">Durata</label>
                        <input type="text" id="duration" name="duration" placeholder="es: 2-3 ore">
                    </div>
                    <div class="form-group">
                        <label for="max_participants">Max Partecipanti</label>
                        <input type="number" id="max_participants" name="max_participants" min="1" max="20">
                    </div>
                </div>
                <div class="form-group">
                    <label for="description">Descrizione</label>
                    <textarea id="description" name="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="icon">Icona (emoji)</label>
                    <input type="text" id="icon" name="icon" placeholder="🔭">
                </div>
                <button type="submit" class="btn btn-primary">➕ Aggiungi Servizio</button>
            </form>
        </div>
        
        <div class="card">
            <h2>🛠️ Servizi Esistenti</h2>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">🔭</div>
                    <div class="service-title">Osservazione Guidata</div>
                    <div class="service-price">€45 per persona</div>
                    <p>Serata di osservazione del cielo con telescopi professionali</p>
                    <div>
                        <strong>Durata:</strong> 2-3 ore<br>
                        <strong>Max partecipanti:</strong> 8
                    </div>
                    <div style="margin-top: 1rem;">
                        <button class="btn btn-primary">✏️ Modifica</button>
                        <button class="btn btn-danger">🗑️ Elimina</button>
                    </div>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">📸</div>
                    <div class="service-title">Workshop Astrofotografia</div>
                    <div class="service-price">€89 per persona</div>
                    <p>Impara a fotografare il cielo con la tua camera</p>
                    <div>
                        <strong>Durata:</strong> 3-4 ore<br>
                        <strong>Max partecipanti:</strong> 6
                    </div>
                    <div style="margin-top: 1rem;">
                        <button class="btn btn-primary">✏️ Modifica</button>
                        <button class="btn btn-danger">🗑️ Elimina</button>
                    </div>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">🌟</div>
                    <div class="service-title">Turismo Astronomico</div>
                    <div class="service-price">€120 per persona</div>
                    <p>Tour completo con osservazione e astrofotografia</p>
                    <div>
                        <strong>Durata:</strong> 4-5 ore<br>
                        <strong>Max partecipanti:</strong> 8
                    </div>
                    <div style="margin-top: 1rem;">
                        <button class="btn btn-primary">✏️ Modifica</button>
                        <button class="btn btn-danger">🗑️ Elimina</button>
                    </div>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">🎓</div>
                    <div class="service-title">Corso di Astronomia</div>
                    <div class="service-price">€200 per persona</div>
                    <p>Corso teorico e pratico di astronomia</p>
                    <div>
                        <strong>Durata:</strong> 2 giorni<br>
                        <strong>Max partecipanti:</strong> 12
                    </div>
                    <div style="margin-top: 1rem;">
                        <button class="btn btn-primary">✏️ Modifica</button>
                        <button class="btn btn-danger">🗑️ Elimina</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <h2>⚙️ Impostazioni Servizi</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                <button class="btn btn-primary">💰 Aggiorna Prezzi</button>
                <button class="btn btn-primary">📊 Statistiche Prenotazioni</button>
                <button class="btn btn-primary">🗂️ Organizza Categorie</button>
                <button class="btn btn-primary">📋 Esporta Lista</button>
            </div>
        </div>
    </div>
</body>
</html> 