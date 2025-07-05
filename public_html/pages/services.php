<?php
require_once __DIR__ . '/../includes/config.php';
?><!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servizi - AstroGuida</title>
    <meta name="description" content="Scopri tutti i servizi di AstroGuida: astrofotografia, turismo astronomico, osservazioni guidate e corsi di astronomia.">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="icon" href="/favicon.ico">
</head>
<body>
    <div class="main-container">
        <!-- Header -->
        <header class="header">
            <div class="header-content">
                <a href="/" class="logo">
                    <div class="logo-icon">
                        <img src="/assets/images/logo/astroguida-logo.jpg" alt="AstroGuida Logo">
                    </div>
                    <span>AstroGuida</span>
                </a>
                
                <nav class="nav-main">
                    <a href="/" class="nav-link">Home</a>
                    <a href="/?page=services" class="nav-link active">Servizi</a>
                    <a href="/?page=gallery" class="nav-link">Gallery</a>
                    <a href="/?page=live-sky" class="nav-link">Live Sky</a>
                    <a href="/?page=about" class="nav-link">Chi Siamo</a>
                    <a href="/?page=contact" class="nav-link">Contatti</a>
                </nav>
                
                <div class="user-menu">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="/?page=dashboard" class="btn btn-secondary btn-sm">Dashboard</a>
                        <div class="user-avatar" title="<?= htmlspecialchars($_SESSION['user_name']) ?>">
                            <?= strtoupper(substr($_SESSION['user_name'], 0, 1)) ?>
                        </div>
                    <?php else: ?>
                        <a href="/?page=login" class="btn btn-ghost btn-sm">Accedi</a>
                        <a href="/?page=register" class="btn btn-primary btn-sm">Registrati</a>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content">
                <h1 class="hero-title fade-in-up">
                    I Nostri <span class="highlight cosmic-text-bright">Servizi</span>
                </h1>
                <p class="hero-subtitle fade-in-up" style="animation-delay: 0.2s;">
                    Scopri l'universo con i nostri servizi professionali di astrofotografia, 
                    turismo astronomico e osservazioni guidate.
                </p>
            </div>
        </section>

        <!-- Servizi Dettagliati -->
        <section class="section">
            <div class="container">
                <!-- Astrofotografia -->
                <div class="card card-featured mb-12" id="astrofotografia">
                    <div class="grid md:grid-cols-2 gap-8 items-center">
                        <div>
                            <div class="flex items-center mb-4">
                                <div class="service-icon mr-4">📸</div>
                                <h2 class="text-3xl font-bold text-white">Astrofotografia Professionale</h2>
                            </div>
                            <p class="text-silver mb-6 text-lg">
                                Sessioni fotografiche dedicate per catturare la bellezza del cielo notturno. 
                                Utilizziamo attrezzature professionali per immortalare galassie, nebulose, 
                                pianeti e fenomeni astronomici.
                            </p>
                            
                            <div class="mb-6">
                                <h3 class="text-xl font-semibold text-white mb-3">Cosa Include:</h3>
                                <ul class="text-silver space-y-2">
                                    <li>✨ Sessione fotografica di 3-4 ore</li>
                                    <li>🔭 Telescopi e camere CCD professionali</li>
                                    <li>📱 Elaborazione e post-produzione</li>
                                    <li>🖼️ Consegna immagini in alta risoluzione</li>
                                    <li>📚 Spiegazione delle tecniche utilizzate</li>
                                </ul>
                            </div>
                            
                            <div class="flex items-center gap-4 mb-6">
                                <span class="text-2xl font-bold text-cyan">Da €150</span>
                                <span class="text-silver">per sessione</span>
                            </div>
                            
                            <a href="/?page=booking&service=astrofotografia" class="btn btn-primary btn-lg">
                                📸 Prenota Sessione
                            </a>
                        </div>
                        
                        <div class="gallery-grid">
                            <div class="gallery-item">
                                <img src="/fotoastronomia/m31.jpg" alt="Galassia Andromeda" class="gallery-image">
                                <div class="gallery-overlay">M31 - Andromeda</div>
                            </div>
                            <div class="gallery-item">
                                <img src="/fotoastronomia/nebulosa-cuore.jpg" alt="Nebulosa Cuore" class="gallery-image">
                                <div class="gallery-overlay">Nebulosa Cuore</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Turismo Astronomico -->
                <div class="card card-cosmic mb-12" id="turismo">
                    <div class="grid md:grid-cols-2 gap-8 items-center">
                        <div class="gallery-grid">
                            <div class="gallery-item">
                                <img src="/assets/images/services/tour-notturno.jpg" alt="Tour Notturno" class="gallery-image">
                                <div class="gallery-overlay">Tour Notturno</div>
                            </div>
                            <div class="gallery-item">
                                <img src="/assets/images/services/osservazione-gruppo.jpg" alt="Gruppo Osservazione" class="gallery-image">
                                <div class="gallery-overlay">Osservazione Gruppo</div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex items-center mb-4">
                                <div class="service-icon mr-4">🌌</div>
                                <h2 class="text-3xl font-bold text-white">Turismo Astronomico</h2>
                            </div>
                            <p class="text-silver mb-6 text-lg">
                                Escursioni notturne guidate per famiglie e gruppi. Scopri le costellazioni, 
                                i pianeti e gli oggetti del cielo profondo in compagnia di guide esperte.
                            </p>
                            
                            <div class="mb-6">
                                <h3 class="text-xl font-semibold text-white mb-3">Programma Tour:</h3>
                                <ul class="text-silver space-y-2">
                                    <li>🌅 Ritrovo al tramonto</li>
                                    <li>🔭 Osservazione con telescopi</li>
                                    <li>⭐ Riconoscimento costellazioni</li>
                                    <li>🪐 Osservazione pianeti</li>
                                    <li>☕ Pausa con bevande calde</li>
                                    <li>📱 App astronomica inclusa</li>
                                </ul>
                            </div>
                            
                            <div class="flex items-center gap-4 mb-6">
                                <span class="text-2xl font-bold text-cyan">€80</span>
                                <span class="text-silver">per persona</span>
                            </div>
                            
                            <a href="/?page=booking&service=turismo" class="btn btn-primary btn-lg">
                                🌌 Prenota Tour
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Osservazione Guidata -->
                <div class="card card-glass mb-12" id="osservazione">
                    <div class="grid md:grid-cols-2 gap-8 items-center">
                        <div>
                            <div class="flex items-center mb-4">
                                <div class="service-icon mr-4">🔭</div>
                                <h2 class="text-3xl font-bold text-white">Osservazione Guidata</h2>
                            </div>
                            <p class="text-silver mb-6 text-lg">
                                Sessioni di osservazione telescopica dedicate a oggetti specifici. 
                                Perfetto per chi vuole approfondire la conoscenza di pianeti, 
                                luna e oggetti del cielo profondo.
                            </p>
                            
                            <div class="mb-6">
                                <h3 class="text-xl font-semibold text-white mb-3">Oggetti Osservabili:</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-glass-light p-3 rounded-lg">
                                        <h4 class="font-semibold text-white">Pianeti</h4>
                                        <p class="text-sm text-silver">Giove, Saturno, Marte, Venere</p>
                                    </div>
                                    <div class="bg-glass-light p-3 rounded-lg">
                                        <h4 class="font-semibold text-white">Luna</h4>
                                        <p class="text-sm text-silver">Crateri, mari, formazioni</p>
                                    </div>
                                    <div class="bg-glass-light p-3 rounded-lg">
                                        <h4 class="font-semibold text-white">Nebulose</h4>
                                        <p class="text-sm text-silver">Orione, Anello, Aquila</p>
                                    </div>
                                    <div class="bg-glass-light p-3 rounded-lg">
                                        <h4 class="font-semibold text-white">Galassie</h4>
                                        <p class="text-sm text-silver">Andromeda, Whirlpool</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4 mb-6">
                                <span class="text-2xl font-bold text-cyan">€50</span>
                                <span class="text-silver">per persona</span>
                            </div>
                            
                            <a href="/?page=booking&service=osservazione" class="btn btn-primary btn-lg">
                                🔭 Prenota Osservazione
                            </a>
                        </div>
                        
                        <div class="text-center">
                            <div class="bg-gradient-cosmic p-8 rounded-2xl">
                                <h3 class="text-2xl font-bold text-white mb-4">Calendario Lunare</h3>
                                <div class="text-6xl mb-4">🌙</div>
                                <p class="text-silver mb-4">Prossima Luna Nuova</p>
                                <p class="text-cyan font-semibold">15 Gennaio 2025</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Corsi di Astronomia -->
                <div class="card card-featured mb-12" id="corsi">
                    <div class="grid md:grid-cols-2 gap-8 items-center">
                        <div class="text-center">
                            <div class="bg-gradient-primary p-8 rounded-2xl">
                                <h3 class="text-2xl font-bold text-white mb-4">Corso Base</h3>
                                <div class="text-6xl mb-4">🎓</div>
                                <p class="text-silver mb-4">8 Lezioni Teoriche + 4 Pratiche</p>
                                <p class="text-cyan font-semibold text-2xl">€120</p>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex items-center mb-4">
                                <div class="service-icon mr-4">🎓</div>
                                <h2 class="text-3xl font-bold text-white">Corsi di Astronomia</h2>
                            </div>
                            <p class="text-silver mb-6 text-lg">
                                Corsi completi per principianti e appassionati. Impara le basi dell'astronomia, 
                                l'uso del telescopio e le tecniche di osservazione.
                            </p>
                            
                            <div class="mb-6">
                                <h3 class="text-xl font-semibold text-white mb-3">Programma del Corso:</h3>
                                <ul class="text-silver space-y-2">
                                    <li>📚 Sistema Solare e Pianeti</li>
                                    <li>⭐ Stelle e Costellazioni</li>
                                    <li>🌌 Galassie e Cosmologia</li>
                                    <li>🔭 Uso del Telescopio</li>
                                    <li>📸 Introduzione all'Astrofotografia</li>
                                    <li>🌙 Osservazioni Pratiche</li>
                                </ul>
                            </div>
                            
                            <div class="flex items-center gap-4 mb-6">
                                <span class="text-2xl font-bold text-cyan">€120</span>
                                <span class="text-silver">corso completo</span>
                            </div>
                            
                            <a href="/?page=booking&service=corsi" class="btn btn-primary btn-lg">
                                🎓 Iscriviti al Corso
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="section">
            <div class="container">
                <div class="card card-featured text-center">
                    <h2 class="text-3xl font-bold text-white mb-4">Pronto per Esplorare l'Universo?</h2>
                    <p class="text-silver mb-8 text-lg">
                        Prenota il tuo servizio preferito e inizia il tuo viaggio tra le stelle
                    </p>
                    <div class="flex gap-4 justify-center flex-wrap">
                        <a href="/?page=booking" class="btn btn-primary btn-lg">
                            🚀 Prenota Ora
                        </a>
                        <a href="/?page=contact" class="btn btn-secondary btn-lg">
                            💬 Contattaci
                        </a>
                    </div>
                </div>
            </div>
        </section>

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
                            <li><a href="/?page=services#astrofotografia">Astrofotografia</a></li>
                            <li><a href="/?page=services#turismo">Turismo Astronomico</a></li>
                            <li><a href="/?page=services#osservazione">Osservazione Guidata</a></li>
                            <li><a href="/?page=services#corsi">Corsi di Astronomia</a></li>
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