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
    <title>🖼️ Gestione Gallery - Admin AstroGuida</title>
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
        
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            display: inline-block;
            font-weight: bold;
            transition: all 0.3s ease;
            cursor: pointer;
            margin: 0.5rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #64ffda, #007aff);
            color: #1a1a2e;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(100, 255, 218, 0.3);
        }
        
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .gallery-item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 1rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 1rem;
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
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid rgba(100, 255, 218, 0.3);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 1rem;
        }
        
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #64ffda;
            box-shadow: 0 0 0 3px rgba(100, 255, 218, 0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🖼️ Gestione Gallery Astrofotografica</h1>
            <div class="nav-links">
                <a href="/?page=admin_dashboard">🏠 Dashboard Admin</a>
                <a href="/?page=gallery">👁️ Visualizza Gallery</a>
                <a href="/?page=logout">🚪 Logout</a>
            </div>
        </div>
        
        <div class="card">
            <h2>📤 Aggiungi Nuova Immagine</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="image">Seleziona Immagine</label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                </div>
                <div class="form-group">
                    <label for="title">Titolo</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="description">Descrizione</label>
                    <textarea id="description" name="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="category">Categoria</label>
                    <select id="category" name="category" style="width: 100%; padding: 0.75rem; border: 2px solid rgba(100, 255, 218, 0.3); border-radius: 8px; background: rgba(255, 255, 255, 0.1); color: white;">
                        <option value="deep-sky">Deep Sky</option>
                        <option value="planetary">Planetaria</option>
                        <option value="milky-way">Via Lattea</option>
                        <option value="landscape">Paesaggio</option>
                        <option value="equipment">Strumentazione</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">📤 Carica Immagine</button>
            </form>
        </div>
        
        <div class="card">
            <h2>🖼️ Immagini Esistenti</h2>
            <div class="gallery-grid">
                <div class="gallery-item">
                    <img src="/assets/images/gallery/sample1.jpg" alt="Nebulosa di Orione">
                    <h3>Nebulosa di Orione</h3>
                    <p>Ripresa con telescopio rifrattore 80mm</p>
                    <div>
                        <button class="btn btn-primary">✏️ Modifica</button>
                        <button class="btn" style="background: #ff3b30; color: white;">🗑️ Elimina</button>
                    </div>
                </div>
                
                <div class="gallery-item">
                    <img src="/assets/images/gallery/sample2.jpg" alt="Via Lattea">
                    <h3>Via Lattea - Puglia</h3>
                    <p>Panorama notturno dalle Murge</p>
                    <div>
                        <button class="btn btn-primary">✏️ Modifica</button>
                        <button class="btn" style="background: #ff3b30; color: white;">🗑️ Elimina</button>
                    </div>
                </div>
                
                <div class="gallery-item">
                    <img src="/assets/images/gallery/sample3.jpg" alt="Giove">
                    <h3>Giove e le sue Lune</h3>
                    <p>Ripresa planetaria con webcam</p>
                    <div>
                        <button class="btn btn-primary">✏️ Modifica</button>
                        <button class="btn" style="background: #ff3b30; color: white;">🗑️ Elimina</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <h2>⚙️ Impostazioni Gallery</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                <button class="btn btn-primary">🔄 Rigenera Miniature</button>
                <button class="btn btn-primary">📊 Statistiche Visualizzazioni</button>
                <button class="btn btn-primary">🗂️ Organizza Categorie</button>
                <button class="btn btn-primary">💾 Backup Gallery</button>
            </div>
        </div>
    </div>
</body>
</html> 