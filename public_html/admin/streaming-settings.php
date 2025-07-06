<?php
/**
 * Dashboard Amministratore - Gestione Streaming
 */
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/streaming.php';

// Verifica autenticazione admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /?page=login');
    exit;
}

$success_message = '';
$error_message = '';

// Gestione form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'update_streaming_url':
                $new_url = trim($_POST['streaming_url'] ?? '');
                
                if (empty($new_url)) {
                    $error_message = 'URL streaming non può essere vuoto';
                } elseif ($streamingManager->updateStreamingUrl($new_url)) {
                    $success_message = 'URL streaming aggiornato con successo!';
                } else {
                    $error_message = 'Errore nell\'aggiornamento dell\'URL streaming';
                }
                break;
                
            case 'save_settings':
                $settings = [
                    'streaming_title' => trim($_POST['streaming_title'] ?? ''),
                    'streaming_description' => trim($_POST['streaming_description'] ?? ''),
                    'streaming_location' => trim($_POST['streaming_location'] ?? ''),
                    'streaming_autoplay' => isset($_POST['streaming_autoplay']) ? '1' : '0',
                    'streaming_mute' => isset($_POST['streaming_mute']) ? '1' : '0'
                ];
                
                if ($streamingManager->saveStreamingSettings($settings)) {
                    $success_message = 'Impostazioni streaming salvate con successo!';
                } else {
                    $error_message = 'Errore nel salvataggio delle impostazioni';
                }
                break;
        }
    }
}

// Recupera impostazioni correnti
$current_url = $streamingManager->getStreamingUrl();
$streaming_status = $streamingManager->getStreamingStatus();
$settings = $streamingManager->getStreamingSettings();

// Valori default
$streaming_title = $settings['streaming_title'] ?? 'Cielo di Cassano delle Murge';
$streaming_description = $settings['streaming_description'] ?? 'Streaming live del cielo notturno';
$streaming_location = $settings['streaming_location'] ?? 'Cassano delle Murge, Puglia';
$streaming_autoplay = ($settings['streaming_autoplay'] ?? '1') === '1';
$streaming_mute = ($settings['streaming_mute'] ?? '1') === '1';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Streaming - Admin | AstroGuida</title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="icon" href="/favicon.jpg">
    
    <style>
        .admin-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 120px 20px 40px;
        }
        
        .admin-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .admin-nav {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-bottom: 40px;
        }
        
        .admin-nav a {
            padding: 12px 24px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: #f5f5f7;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .admin-nav a:hover,
        .admin-nav a.active {
            background: rgba(0, 122, 255, 0.2);
            border-color: rgba(0, 122, 255, 0.4);
        }
        
        .settings-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .settings-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 30px;
            backdrop-filter: blur(20px);
        }
        
        .status-indicator {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        .status-live {
            background: #ff0000;
            color: white;
            animation: pulse 2s infinite;
        }
        
        .status-offline {
            background: #666;
            color: white;
        }
        
        .status-error {
            background: #ff6b6b;
            color: white;
        }
        
        .preview-container {
            width: 100%;
            aspect-ratio: 16/9;
            border-radius: 16px;
            overflow: hidden;
            background: #000;
            margin: 20px 0;
        }
        
        .preview-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
        
        .form-section {
            margin-bottom: 30px;
        }
        
        .form-section h3 {
            color: #f5f5f7;
            margin-bottom: 15px;
            font-size: 18px;
        }
        
        .checkbox-group {
            display: flex;
            gap: 20px;
            margin-top: 15px;
        }
        
        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .checkbox-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
        }
        
        .url-input {
            position: relative;
        }
        
        .url-input input {
            padding-right: 100px;
        }
        
        .url-validate {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 6px;
        }
        
        .url-valid {
            background: #4caf50;
            color: white;
        }
        
        .url-invalid {
            background: #f44336;
            color: white;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        @media (max-width: 768px) {
            .settings-grid {
                grid-template-columns: 1fr;
            }
            
            .admin-nav {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <div class="stellar-background">
        <div class="stars"></div>
        <div class="nebula"></div>
        <div class="cosmic-particles"></div>
    </div>

    <div class="admin-container">
        <!-- Header -->
        <div class="admin-header">
            <h1 class="text-4xl font-bold text-white mb-4">
                🎥 Gestione Streaming
            </h1>
            <p class="text-silver text-lg">
                Configura e gestisci lo streaming YouTube del cielo di Cassano
            </p>
        </div>

        <!-- Navigation -->
        <div class="admin-nav">
            <a href="/admin/" class="nav-link">📊 Dashboard</a>
            <a href="/admin/streaming-settings.php" class="nav-link active">🎥 Streaming</a>
            <a href="/admin/users.php" class="nav-link">👥 Utenti</a>
            <a href="/admin/bookings.php" class="nav-link">📅 Prenotazioni</a>
            <a href="/" class="nav-link">🏠 Sito</a>
        </div>

        <!-- Messaggi -->
        <?php if ($success_message): ?>
            <div class="alert alert-success mb-6">
                ✅ <?= htmlspecialchars($success_message) ?>
            </div>
        <?php endif; ?>
        
        <?php if ($error_message): ?>
            <div class="alert alert-error mb-6">
                ❌ <?= htmlspecialchars($error_message) ?>
            </div>
        <?php endif; ?>

        <!-- Stato Streaming -->
        <div class="settings-card mb-8">
            <h2 class="text-2xl font-bold text-white mb-4">📡 Stato Streaming</h2>
            
            <div class="status-indicator status-<?= $streaming_status['status'] ?>">
                <div class="live-dot"></div>
                <?= htmlspecialchars($streaming_status['message']) ?>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                <div class="bg-blue-500/20 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-cyan">LIVE</div>
                    <div class="text-silver text-sm">Stato Corrente</div>
                </div>
                <div class="bg-green-500/20 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-green">24/7</div>
                    <div class="text-silver text-sm">Disponibilità</div>
                </div>
                <div class="bg-purple-500/20 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-purple">HD</div>
                    <div class="text-silver text-sm">Qualità</div>
                </div>
            </div>
        </div>

        <!-- Configurazione -->
        <div class="settings-grid">
            <!-- URL Streaming -->
            <div class="settings-card">
                <h2 class="text-2xl font-bold text-white mb-4">🔗 URL Streaming</h2>
                
                <form method="post" class="space-y-4">
                    <input type="hidden" name="action" value="update_streaming_url">
                    
                    <div class="form-section">
                        <label for="streaming_url" class="form-label">URL YouTube Live</label>
                        <div class="url-input">
                            <input type="url" 
                                   id="streaming_url" 
                                   name="streaming_url" 
                                   value="<?= htmlspecialchars($current_url) ?>" 
                                   class="form-input" 
                                   placeholder="https://youtube.com/live/..." 
                                   required>
                            <div class="url-validate url-valid" id="url-status">✓ Valido</div>
                        </div>
                        <p class="text-silver text-sm mt-2">
                            Inserisci l'URL completo del tuo streaming YouTube Live
                        </p>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-full">
                        🔄 Aggiorna URL
                    </button>
                </form>
                
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-white mb-2">URL Corrente:</h3>
                    <div class="bg-gray-800 p-3 rounded-lg">
                        <code class="text-cyan text-sm break-all">
                            <?= htmlspecialchars($current_url) ?>
                        </code>
                    </div>
                </div>
            </div>

            <!-- Impostazioni Avanzate -->
            <div class="settings-card">
                <h2 class="text-2xl font-bold text-white mb-4">⚙️ Impostazioni</h2>
                
                <form method="post" class="space-y-4">
                    <input type="hidden" name="action" value="save_settings">
                    
                    <div class="form-section">
                        <label for="streaming_title" class="form-label">Titolo Streaming</label>
                        <input type="text" 
                               id="streaming_title" 
                               name="streaming_title" 
                               value="<?= htmlspecialchars($streaming_title) ?>" 
                               class="form-input">
                    </div>
                    
                    <div class="form-section">
                        <label for="streaming_description" class="form-label">Descrizione</label>
                        <textarea id="streaming_description" 
                                  name="streaming_description" 
                                  rows="3" 
                                  class="form-input"><?= htmlspecialchars($streaming_description) ?></textarea>
                    </div>
                    
                    <div class="form-section">
                        <label for="streaming_location" class="form-label">Località</label>
                        <input type="text" 
                               id="streaming_location" 
                               name="streaming_location" 
                               value="<?= htmlspecialchars($streaming_location) ?>" 
                               class="form-input">
                    </div>
                    
                    <div class="form-section">
                        <h3>Opzioni Riproduzione</h3>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <input type="checkbox" 
                                       id="streaming_autoplay" 
                                       name="streaming_autoplay" 
                                       <?= $streaming_autoplay ? 'checked' : '' ?>>
                                <label for="streaming_autoplay" class="text-silver">Autoplay</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" 
                                       id="streaming_mute" 
                                       name="streaming_mute" 
                                       <?= $streaming_mute ? 'checked' : '' ?>>
                                <label for="streaming_mute" class="text-silver">Muto</label>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-success w-full">
                        💾 Salva Impostazioni
                    </button>
                </form>
            </div>
        </div>

        <!-- Anteprima -->
        <div class="settings-card">
            <h2 class="text-2xl font-bold text-white mb-4">👁️ Anteprima Streaming</h2>
            
            <div class="preview-container">
                <iframe src="<?= htmlspecialchars($streamingManager->getEmbedUrl()) ?>" 
                        allowfullscreen>
                </iframe>
            </div>
            
            <div class="text-center mt-4">
                <a href="/?page=live-sky" target="_blank" class="btn btn-secondary">
                    🔗 Vedi Pagina Live
                </a>
            </div>
        </div>

        <!-- Istruzioni -->
        <div class="settings-card">
            <h2 class="text-2xl font-bold text-white mb-4">📖 Istruzioni</h2>
            
            <div class="space-y-4 text-silver">
                <div>
                    <h3 class="text-white font-semibold mb-2">🎥 Come ottenere l'URL YouTube Live:</h3>
                    <ol class="list-decimal list-inside space-y-1 ml-4">
                        <li>Vai su YouTube Studio</li>
                        <li>Clicca su "Crea" → "Trasmetti dal vivo"</li>
                        <li>Copia l'URL della diretta (formato: youtube.com/live/...)</li>
                        <li>Incolla l'URL nel campo sopra</li>
                    </ol>
                </div>
                
                <div>
                    <h3 class="text-white font-semibold mb-2">🔧 Compatibilità Hosting Aruba:</h3>
                    <ul class="list-disc list-inside space-y-1 ml-4">
                        <li>Sistema ottimizzato per hosting Linux</li>
                        <li>Database SQLite per massima compatibilità</li>
                        <li>Nessuna configurazione server richiesta</li>
                        <li>Aggiornamenti in tempo reale</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Validazione URL in tempo reale
        document.getElementById('streaming_url').addEventListener('input', function() {
            const url = this.value;
            const status = document.getElementById('url-status');
            
            if (url.includes('youtube.com') || url.includes('youtu.be')) {
                status.className = 'url-validate url-valid';
                status.textContent = '✓ Valido';
            } else {
                status.className = 'url-validate url-invalid';
                status.textContent = '✗ Non valido';
            }
        });
        
        // Auto-refresh status ogni 30 secondi
        setInterval(function() {
            fetch('/admin/streaming-status.php')
                .then(response => response.json())
                .then(data => {
                    const statusElement = document.querySelector('.status-indicator');
                    statusElement.className = 'status-indicator status-' + data.status;
                    statusElement.innerHTML = '<div class="live-dot"></div>' + data.message;
                })
                .catch(error => console.log('Errore aggiornamento status:', error));
        }, 30000);
    </script>
</body>
</html> 