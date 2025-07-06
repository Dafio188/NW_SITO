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
    <title>📧 Gestione Contatti - Admin AstroGuida</title>
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
        
        .message-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border-left: 4px solid #64ffda;
            transition: all 0.3s ease;
        }
        
        .message-card:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        
        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .message-from {
            color: #64ffda;
            font-weight: bold;
            font-size: 1.1rem;
        }
        
        .message-date {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
        }
        
        .message-subject {
            color: #fff;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        
        .message-content {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
            margin-bottom: 1rem;
        }
        
        .message-actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            font-weight: bold;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 0.9rem;
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
        
        .btn-success {
            background: linear-gradient(135deg, #34c759, #30a14e);
            color: white;
        }
        
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        
        .status-new {
            background: #ff9500;
            color: white;
        }
        
        .status-read {
            background: #34c759;
            color: white;
        }
        
        .status-replied {
            background: #007aff;
            color: white;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #64ffda;
        }
        
        .stat-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📧 Gestione Messaggi Contatti</h1>
            <div class="nav-links">
                <a href="/?page=admin_dashboard">🏠 Dashboard Admin</a>
                <a href="/?page=contact">👁️ Form Contatti</a>
                <a href="/?page=logout">🚪 Logout</a>
            </div>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">12</div>
                <div class="stat-label">Messaggi Totali</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">3</div>
                <div class="stat-label">Non Letti</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">7</div>
                <div class="stat-label">Risposti</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">2</div>
                <div class="stat-label">Oggi</div>
            </div>
        </div>
        
        <div class="card">
            <h2>📬 Messaggi Recenti</h2>
            
            <div class="message-card">
                <div class="message-header">
                    <div>
                        <div class="message-from">Marco Rossi</div>
                        <div style="font-size: 0.9rem; color: rgba(255, 255, 255, 0.7);">marco.rossi@email.com</div>
                    </div>
                    <div style="text-align: right;">
                        <div class="message-date">15/12/2024 14:30</div>
                        <span class="status-badge status-new">NUOVO</span>
                    </div>
                </div>
                <div class="message-subject">Richiesta prenotazione osservazione</div>
                <div class="message-content">
                    Salve, sono interessato a prenotare una serata di osservazione per il prossimo weekend. 
                    Siamo un gruppo di 4 persone, tutti principianti. Potreste darmi informazioni sui costi e disponibilità?
                </div>
                <div class="message-actions">
                    <button class="btn btn-primary">📧 Rispondi</button>
                    <button class="btn btn-success">✅ Segna come Letto</button>
                    <button class="btn btn-danger">🗑️ Elimina</button>
                </div>
            </div>
            
            <div class="message-card">
                <div class="message-header">
                    <div>
                        <div class="message-from">Anna Bianchi</div>
                        <div style="font-size: 0.9rem; color: rgba(255, 255, 255, 0.7);">anna.bianchi@gmail.com</div>
                    </div>
                    <div style="text-align: right;">
                        <div class="message-date">14/12/2024 09:15</div>
                        <span class="status-badge status-replied">RISPOSTO</span>
                    </div>
                </div>
                <div class="message-subject">Corso di astrofotografia</div>
                <div class="message-content">
                    Buongiorno, vorrei sapere se organizzate corsi di astrofotografia per principianti. 
                    Ho una reflex ma non ho mai fotografato il cielo. Grazie!
                </div>
                <div class="message-actions">
                    <button class="btn btn-primary">📧 Rispondi</button>
                    <button class="btn btn-success">✅ Segna come Letto</button>
                    <button class="btn btn-danger">🗑️ Elimina</button>
                </div>
            </div>
            
            <div class="message-card">
                <div class="message-header">
                    <div>
                        <div class="message-from">Giuseppe Verdi</div>
                        <div style="font-size: 0.9rem; color: rgba(255, 255, 255, 0.7);">g.verdi@outlook.com</div>
                    </div>
                    <div style="text-align: right;">
                        <div class="message-date">13/12/2024 16:45</div>
                        <span class="status-badge status-read">LETTO</span>
                    </div>
                </div>
                <div class="message-subject">Complimenti per il servizio</div>
                <div class="message-content">
                    Volevo ringraziarvi per la bellissima serata di osservazione di sabato scorso. 
                    È stata un'esperienza fantastica, torneremo sicuramente!
                </div>
                <div class="message-actions">
                    <button class="btn btn-primary">📧 Rispondi</button>
                    <button class="btn btn-success">✅ Segna come Letto</button>
                    <button class="btn btn-danger">🗑️ Elimina</button>
                </div>
            </div>
        </div>
        
        <div class="card">
            <h2>⚙️ Azioni Rapide</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                <button class="btn btn-primary">✅ Segna Tutti Come Letti</button>
                <button class="btn btn-primary">📊 Statistiche Dettagliate</button>
                <button class="btn btn-primary">📋 Esporta Messaggi</button>
                <button class="btn btn-danger">🗑️ Elimina Vecchi Messaggi</button>
            </div>
        </div>
    </div>
</body>
</html> 