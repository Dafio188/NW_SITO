<?php /* Live Sky AstroGuida */
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/streaming.php';

// Ottieni dati streaming dinamici con fallback
if ($streamingManager) {
    $streaming_url = $streamingManager->getStreamingUrl();
    $embed_url = $streamingManager->getEmbedUrl();
    $streaming_status = $streamingManager->getStreamingStatus();
    $streaming_settings = $streamingManager->getStreamingSettings();
    
    // Impostazioni streaming
    $streaming_title = $streaming_settings['streaming_title'] ?? 'Cielo di Cassano delle Murge';
    $streaming_description = $streaming_settings['streaming_description'] ?? 'Streaming live del cielo notturno';
    $streaming_location = $streaming_settings['streaming_location'] ?? 'Cassano delle Murge, Puglia';
} else {
    // Fallback quando il database non è disponibile
    $streaming_url = 'https://youtube.com/live/54O7rq5ZweY';
    $embed_url = 'https://www.youtube.com/embed/54O7rq5ZweY?autoplay=1&mute=1';
    $streaming_status = ['status' => 'offline', 'message' => 'Streaming offline - Lavori in corso'];
    $streaming_title = 'Cielo di Cassano delle Murge';
    $streaming_description = 'Streaming live del cielo notturno';
    $streaming_location = 'Cassano delle Murge, Puglia';
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Sky - Streaming del Cielo in Tempo Reale | AstroGuida</title>
    <meta name="description" content="Osserva il cielo notturno di Cassano delle Murge in tempo reale con la nostra webcam astronomica. Streaming 24/7 con dati meteo.">
    
    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/main.css">
    
    <!-- Favicon -->
    <link rel="icon" href="/favicon.jpg">
    
    <!-- Open Graph -->
    <meta property="og:title" content="Live Sky - Streaming del Cielo | AstroGuida">
    <meta property="og:description" content="Osserva il cielo notturno in tempo reale con la nostra webcam astronomica">
    <meta property="og:image" content="/assets/images/live-sky-preview.jpg">
    <meta property="og:url" content="https://astroguida.com/?page=live-sky">
    
    <style>
        .live-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 120px 20px 40px;
        }
        
        .live-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .live-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #ff0000;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }
        
        .live-dot {
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
            animation: pulse 1s infinite;
        }
        
        .stream-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .stream-main {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 20px;
            backdrop-filter: blur(20px);
        }
        
        .stream-video {
            width: 100%;
            aspect-ratio: 16/9;
            border-radius: 16px;
            overflow: hidden;
            background: #000;
            margin-bottom: 20px;
        }
        
        .stream-video iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
        
        .stream-info {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 20px;
            backdrop-filter: blur(20px);
        }
        
        .weather-card {
            background: rgba(0, 122, 255, 0.1);
            border: 1px solid rgba(0, 122, 255, 0.2);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .weather-current {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .weather-icon {
            font-size: 48px;
        }
        
        .weather-temp {
            font-size: 32px;
            font-weight: 700;
            color: #64ffda;
        }
        
        .weather-desc {
            color: #f5f5f7;
            font-size: 16px;
        }
        
        .weather-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 15px;
        }
        
        .weather-item {
            text-align: center;
            padding: 10px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
        }
        
        .weather-item-label {
            font-size: 12px;
            color: #a1a1aa;
            margin-bottom: 5px;
        }
        
        .weather-item-value {
            font-size: 16px;
            font-weight: 600;
            color: #f5f5f7;
        }
        
        .archive-section {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 40px;
        }
        
        .archive-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .archive-item {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .archive-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }
        
        .archive-thumbnail {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64ffda;
            font-size: 48px;
        }
        
        .archive-content {
            padding: 20px;
        }
        
        .archive-title {
            font-size: 18px;
            font-weight: 600;
            color: #f5f5f7;
            margin-bottom: 10px;
        }
        
        .archive-date {
            font-size: 14px;
            color: #a1a1aa;
            margin-bottom: 15px;
        }
        
        .archive-description {
            font-size: 14px;
            color: #d1d5db;
            line-height: 1.5;
        }
        
        @media (max-width: 768px) {
            .stream-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .weather-details {
                grid-template-columns: 1fr;
            }
            
            .archive-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Header -->
        <?php 
        $current_page = 'live-sky';
        include __DIR__ . '/../includes/header.php'; 
        ?>

        <!-- Main Content -->
        <div class="live-container">
            <!-- Header -->
            <div class="live-header">
                <div class="live-status status-<?= $streaming_status['status'] ?>">
                    <div class="live-dot"></div>
                    <?= htmlspecialchars($streaming_status['message']) ?>
                </div>
                <h1 class="text-4xl font-bold text-white mb-4">
                    🌌 Streaming Live del Cielo
                </h1>
                <p class="text-lg text-silver max-w-2xl mx-auto">
                    Osserva in tempo reale il cielo notturno di Cassano delle Murge con la nostra webcam astronomica professionale. 
                    Streaming 24/7 con dati meteo aggiornati.
                </p>
            </div>

            <!-- Stream Grid -->
            <div class="stream-grid">
                <!-- Main Stream -->
                <div class="stream-main">
                    <div class="stream-video">
                        <!-- Streaming YouTube Dinamico -->
                        <iframe 
                            src="<?= htmlspecialchars($embed_url) ?>" 
                            title="<?= htmlspecialchars($streaming_title) ?>"
                            allowfullscreen>
                        </iframe>
                    </div>
                    
                    <div class="stream-controls">
                        <h3 class="text-xl font-semibold text-white mb-3">Controlli Stream</h3>
                        <div class="flex gap-3 flex-wrap">
                            <button class="btn btn-primary btn-sm">
                                📹 Qualità HD
                            </button>
                            <button class="btn btn-secondary btn-sm">
                                🔊 Audio On/Off
                            </button>
                            <button class="btn btn-ghost btn-sm">
                                📱 Schermo Intero
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Stream Info -->
                <div class="stream-info">
                    <!-- Weather Card -->
                    <div class="weather-card">
                        <h3 class="text-lg font-semibold text-white mb-3">
                            🌤️ Condizioni Meteo
                        </h3>
                        
                        <div class="weather-current">
                            <div class="weather-icon">🌙</div>
                            <div>
                                <div class="weather-temp">18°C</div>
                                <div class="weather-desc">Cielo sereno</div>
                            </div>
                        </div>
                        
                        <div class="weather-details">
                            <div class="weather-item">
                                <div class="weather-item-label">Umidità</div>
                                <div class="weather-item-value">65%</div>
                            </div>
                            <div class="weather-item">
                                <div class="weather-item-label">Vento</div>
                                <div class="weather-item-value">12 km/h</div>
                            </div>
                            <div class="weather-item">
                                <div class="weather-item-label">Visibilità</div>
                                <div class="weather-item-value">15 km</div>
                            </div>
                            <div class="weather-item">
                                <div class="weather-item-label">Pressione</div>
                                <div class="weather-item-value">1013 hPa</div>
                            </div>
                        </div>
                    </div>

                    <!-- Astronomical Info -->
                    <div class="weather-card">
                        <h3 class="text-lg font-semibold text-white mb-3">
                            🔭 Info Astronomiche
                        </h3>
                        
                        <div class="weather-details">
                            <div class="weather-item">
                                <div class="weather-item-label">Tramonto</div>
                                <div class="weather-item-value">19:42</div>
                            </div>
                            <div class="weather-item">
                                <div class="weather-item-label">Alba</div>
                                <div class="weather-item-value">06:28</div>
                            </div>
                            <div class="weather-item">
                                <div class="weather-item-label">Fase Lunare</div>
                                <div class="weather-item-value">🌓 Primo Quarto</div>
                            </div>
                            <div class="weather-item">
                                <div class="weather-item-label">Seeing</div>
                                <div class="weather-item-value">Buono</div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-white mb-3">
                            🚀 Azioni Rapide
                        </h3>
                        <div class="flex flex-col gap-3">
                            <a href="/?page=booking" class="btn btn-primary w-full">
                                📅 Prenota Osservazione
                            </a>
                            <a href="/?page=gallery" class="btn btn-secondary w-full">
                                📸 Vedi Gallery
                            </a>
                            <a href="/?page=contact" class="btn btn-ghost w-full">
                                💬 Contattaci
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Archive Section -->
            <div class="archive-section" id="archive">
                <div class="section-header">
                    <h2 class="text-3xl font-bold text-white mb-4">
                        📼 Archivio Stream
                    </h2>
                    <p class="text-lg text-silver">
                        Rivedi i momenti più spettacolari catturati dalla nostra webcam astronomica
                    </p>
                </div>

                <div class="archive-grid">
                    <div class="archive-item">
                        <div class="archive-thumbnail">
                            🌙
                        </div>
                        <div class="archive-content">
                            <h3 class="archive-title">Luna Piena di Gennaio</h3>
                            <div class="archive-date">15 Gennaio 2025</div>
                            <p class="archive-description">
                                Spettacolare luna piena con ottima visibilità. 
                                Registrazione di 3 ore con dettagli dei crateri.
                            </p>
                        </div>
                    </div>

                    <div class="archive-item">
                        <div class="archive-thumbnail">
                            ⭐
                        </div>
                        <div class="archive-content">
                            <h3 class="archive-title">Pioggia di Meteore</h3>
                            <div class="archive-date">12 Gennaio 2025</div>
                            <p class="archive-description">
                                Catturate oltre 50 meteore durante il picco 
                                delle Quadrantidi. Cielo eccezionalmente limpido.
                            </p>
                        </div>
                    </div>

                    <div class="archive-item">
                        <div class="archive-thumbnail">
                            🪐
                        </div>
                        <div class="archive-content">
                            <h3 class="archive-title">Congiunzione Pianeti</h3>
                            <div class="archive-date">8 Gennaio 2025</div>
                            <p class="archive-description">
                                Rara congiunzione tra Giove e Saturno visibile 
                                all'orizzonte occidentale al tramonto.
                            </p>
                        </div>
                    </div>

                    <div class="archive-item">
                        <div class="archive-thumbnail">
                            🌌
                        </div>
                        <div class="archive-content">
                            <h3 class="archive-title">Via Lattea Invernale</h3>
                            <div class="archive-date">5 Gennaio 2025</div>
                            <p class="archive-description">
                                Timelapse della Via Lattea invernale con 
                                costellazioni di Orione e Gemelli.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Technical Info -->
            <div class="archive-section">
                <div class="section-header">
                    <h2 class="text-3xl font-bold text-white mb-4">
                        🔧 Specifiche Tecniche
                    </h2>
                    <p class="text-lg text-silver">
                        Dettagli sulla nostra attrezzatura di streaming astronomico
                    </p>
                </div>

                <div class="features-grid">
                    <div class="card">
                        <div class="text-center">
                            <div class="text-4xl mb-4">📹</div>
                            <h3 class="text-xl font-semibold text-white mb-3">Camera</h3>
                            <p class="text-silver">
                                ZWO ASI294MC Pro<br>
                                Sensore Sony IMX294<br>
                                Risoluzione 4144x2822<br>
                                Raffreddamento TEC
                            </p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="text-center">
                            <div class="text-4xl mb-4">🔭</div>
                            <h3 class="text-xl font-semibold text-white mb-3">Ottica</h3>
                            <p class="text-silver">
                                Obiettivo Samyang 135mm f/2<br>
                                Campo visivo 10°x7°<br>
                                Risoluzione 4.6"/pixel<br>
                                Filtro UV/IR Cut
                            </p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="text-center">
                            <div class="text-4xl mb-4">🖥️</div>
                            <h3 class="text-xl font-semibold text-white mb-3">Streaming</h3>
                            <p class="text-silver">
                                Qualità 1080p 30fps<br>
                                Bitrate 6000 kbps<br>
                                Codec H.264<br>
                                Latenza < 5 secondi
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-content">
                <div class="footer-grid">
                    <div class="footer-section">
                        <div class="flex items-center mb-4">
                            <div class="logo-icon mr-3">
                                <img src="/assets/images/logo/astroguida-logo.jpg" alt="AstroGuida Logo">
                            </div>
                            <h3 class="text-xl font-bold">AstroGuida</h3>
                        </div>
                        <p>
                            La tua guida professionale per esplorare l'universo. 
                            Astrofotografia e turismo astronomico in Puglia.
                        </p>
                    </div>
                    
                    <div class="footer-section">
                        <h3>Servizi</h3>
                        <ul class="space-y-2">
                            <li><a href="/?page=services">Astrofotografia</a></li>
                            <li><a href="/?page=services">Turismo Astronomico</a></li>
                            <li><a href="/?page=services">Osservazione Guidata</a></li>
                            <li><a href="/?page=services">Corsi di Astronomia</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-section">
                        <h3>Info Utili</h3>
                        <ul class="space-y-2">
                            <li><a href="/?page=gallery">Gallery</a></li>
                            <li><a href="/?page=about">Chi Siamo</a></li>
                            <li><a href="/?page=contact">Contatti</a></li>
                            <li><a href="/?page=faq">FAQ</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-section">
                        <h3>Contatti</h3>
                        <p>📍 Cassano delle Murge, Puglia</p>
                        <p>📧 info@astroguida.com</p>
                        <p>📱 +39 XXX XXX XXXX</p>
                    </div>
                </div>
                
                <div class="footer-bottom">
                    <p>&copy; 2025 AstroGuida. Tutti i diritti riservati. | 
                       <a href="/?page=privacy" class="hover:text-cyan">Privacy Policy</a> | 
                       <a href="/?page=terms" class="hover:text-cyan">Termini di Servizio</a>
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <!-- JavaScript -->
    <script src="/assets/js/stellar-animations.js"></script>
    <script>
        // Aggiornamento dati meteo in tempo reale (simulato)
        function updateWeatherData() {
            // Simulazione dati meteo
            const temps = [15, 16, 17, 18, 19, 20];
            const humidity = [60, 65, 70, 75];
            const wind = [8, 10, 12, 15];
            
            const temp = temps[Math.floor(Math.random() * temps.length)];
            const hum = humidity[Math.floor(Math.random() * humidity.length)];
            const windSpeed = wind[Math.floor(Math.random() * wind.length)];
            
            document.querySelector('.weather-temp').textContent = temp + '°C';
            document.querySelector('.weather-details .weather-item:nth-child(1) .weather-item-value').textContent = hum + '%';
            document.querySelector('.weather-details .weather-item:nth-child(2) .weather-item-value').textContent = windSpeed + ' km/h';
        }
        
        // Aggiorna ogni 5 minuti
        setInterval(updateWeatherData, 300000);
        
        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html> 