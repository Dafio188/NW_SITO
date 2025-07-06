<?php
// Pagina cancellazione pagamento PayPal
require_once __DIR__ . '/includes/config.php';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento Annullato - AstroGuida</title>
    <link rel="icon" href="/favicon.jpg" type="image/jpeg">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 2rem;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .cancel-container {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 3rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }
        
        .cancel-icon {
            font-size: 5rem;
            margin-bottom: 1rem;
            color: #ffc107;
        }
        
        .cancel-title {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #ffc107;
        }
        
        .actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }
        
        .btn {
            padding: 1rem 2rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #64ffda, #007aff);
            color: white;
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="cancel-container">
        <div class="cancel-icon">⚠️</div>
        <h1 class="cancel-title">Pagamento Annullato</h1>
        
        <p>Il pagamento è stato annullato. La tua prenotazione è ancora in attesa di pagamento.</p>
        
        <p>Puoi riprovare il pagamento in qualsiasi momento per confermare la prenotazione.</p>
        
        <div class="actions">
            <a href="/?page=booking" class="btn btn-primary">🔄 Riprova Pagamento</a>
            <a href="/" class="btn btn-secondary">🏠 Torna alla Home</a>
        </div>
    </div>
</body>
</html> 