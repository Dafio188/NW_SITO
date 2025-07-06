<?php
require_once __DIR__ . '/../includes/config.php';
?><!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Siamo - La Nostra Storia | AstroGuida</title>
    <meta name="description" content="Scopri la storia di AstroGuida, il nostro team di esperti astronomi e le attrezzature professionali che utilizziamo per offrirti un'esperienza stellare unica.">
    <meta name="keywords" content="chi siamo, team, astronomi, astrofotografi, esperienza, attrezzature, telescopi, puglia">
    
    <!-- Open Graph -->
    <meta property="og:title" content="Chi Siamo - La Nostra Storia | AstroGuida">
    <meta property="og:description" content="Scopri la storia di AstroGuida e il nostro team di esperti astronomi">
    <meta property="og:image" content="/assets/images/logo/astroguida-logo.jpg">
    <meta property="og:url" content="<?= SITE_URL ?>/?page=about">
    <meta property="og:type" content="website">
    
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="icon" href="/favicon.jpg">
</head>
<body>
    <div class="stellar-background">
        <div class="stars"></div>
        <div class="nebula"></div>
        <div class="cosmic-particles"></div>
    </div>

    <div class="main-container">
        <!-- Header -->
        <header class="header">
            <div class="header-content">
                <div class="logo">
                    <img src="/assets/images/logo/astroguida-logo.jpg" alt="AstroGuida Logo" class="logo-image">
                    <span class="logo-text">AstroGuida</span>
                </div>
                
                <nav class="nav">
                    <a href="/" class="nav-link">Home</a>
                    <a href="/?page=services" class="nav-link">Servizi</a>
                    <a href="/?page=gallery" class="nav-link">Gallery</a>
                    <a href="/?page=about" class="nav-link active">Chi Siamo</a>
                    <a href="/?page=contact" class="nav-link">Contatti</a>
                    <a href="/?page=live-sky" class="nav-link">🔴 Live</a>
                </nav>

                <div class="header-actions">
                    <a href="/?page=booking" class="btn btn-primary btn-sm">
                        🚀 Prenota
                    </a>
                    <a href="/?page=login" class="btn btn-ghost btn-sm">
                        👤 Login
                    </a>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="hero-content text-center">
                    <h1 class="hero-title">
                        Chi Siamo
                    </h1>
                    <p class="hero-subtitle">
                        La passione per l'astronomia che diventa professione. 
                        Scopri la nostra storia e il team che rende possibile 
                        ogni avventura stellare.
                    </p>
                </div>
            </div>
        </section>

        <!-- La Nostra Storia -->
        <section class="section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">La Nostra Storia</h2>
                    <p class="section-subtitle">
                        Un viaggio iniziato guardando le stelle
                    </p>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-6">
                        <div class="card">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-gradient-primary rounded-full flex items-center justify-center text-white text-xl mr-4">
                                    🌟
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-white">2010 - Gli Inizi</h3>
                                    <p class="text-silver">Prima passione per l'astronomia</p>
                                </div>
                            </div>
                            <p class="text-silver">
                                Tutto è iniziato con un piccolo telescopio e la curiosità di un bambino 
                                che guardava la Luna. Da quella prima osservazione è nata una passione 
                                che non si è mai spenta.
                            </p>
                        </div>
                        
                        <div class="card">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-gradient-cosmic rounded-full flex items-center justify-center text-white text-xl mr-4">
                                    📸
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-white">2015 - Prima Foto</h3>
                                    <p class="text-silver">Scoperta dell'astrofotografia</p>
                                </div>
                            </div>
                            <p class="text-silver">
                                La prima fotografia astronomica di M31, la Galassia di Andromeda, 
                                ha segnato l'inizio del nostro percorso nell'astrofotografia professionale.
                            </p>
                        </div>
                        
                        <div class="card">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-gradient-success rounded-full flex items-center justify-center text-white text-xl mr-4">
                                    🏆
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-white">2020 - AstroGuida</h3>
                                    <p class="text-silver">Nascita del progetto</p>
                                </div>
                            </div>
                            <p class="text-silver">
                                Dopo anni di esperienza e centinaia di notti sotto le stelle, 
                                nasce AstroGuida per condividere questa passione con tutti.
                            </p>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="card card-glass">
                            <div class="text-center">
                                <div class="text-6xl mb-4">🌌</div>
                                <h3 class="text-2xl font-bold text-white mb-4">La Nostra Missione</h3>
                                <p class="text-silver mb-6">
                                    Rendere l'astronomia accessibile a tutti, offrendo esperienze 
                                    indimenticabili sotto il cielo stellato della Puglia.
                                </p>
                                <div class="grid grid-cols-2 gap-4 text-center">
                                    <div>
                                        <div class="text-2xl font-bold text-cyan">500+</div>
                                        <div class="text-silver text-sm">Clienti Soddisfatti</div>
                                    </div>
                                    <div>
                                        <div class="text-2xl font-bold text-purple">1000+</div>
                                        <div class="text-silver text-sm">Foto Scattate</div>
                                    </div>
                                    <div>
                                        <div class="text-2xl font-bold text-green">200+</div>
                                        <div class="text-silver text-sm">Notti di Osservazione</div>
                                    </div>
                                    <div>
                                        <div class="text-2xl font-bold text-orange">50+</div>
                                        <div class="text-silver text-sm">Oggetti Fotografati</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Il Nostro Team -->
        <section class="section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Il Nostro Team</h2>
                    <p class="section-subtitle">
                        Esperti astronomi e astrofotografi al tuo servizio
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="card text-center">
                        <div class="w-24 h-24 bg-gradient-primary rounded-full mx-auto mb-4 flex items-center justify-center text-white text-3xl">
                            👨‍🚀
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">Marco Stellari</h3>
                        <p class="text-cyan mb-3">Fondatore & Astrofotografo</p>
                        <p class="text-silver text-sm">
                            15 anni di esperienza nell'astrofotografia. Specializzato in 
                            oggetti del cielo profondo e divulgazione scientifica.
                        </p>
                    </div>
                    
                    <div class="card text-center">
                        <div class="w-24 h-24 bg-gradient-cosmic rounded-full mx-auto mb-4 flex items-center justify-center text-white text-3xl">
                            👩‍🔬
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">Elena Cosmos</h3>
                        <p class="text-purple mb-3">Astronoma & Guida</p>
                        <p class="text-silver text-sm">
                            Laurea in Astronomia e Astrofisica. Esperta in osservazione 
                            planetaria e fenomeni celesti.
                        </p>
                    </div>
                    
                    <div class="card text-center">
                        <div class="w-24 h-24 bg-gradient-success rounded-full mx-auto mb-4 flex items-center justify-center text-white text-3xl">
                            🔭
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">Luca Nebula</h3>
                        <p class="text-green mb-3">Tecnico Strumentale</p>
                        <p class="text-silver text-sm">
                            Specialista in telescopi e montature. Si occupa della 
                            manutenzione e calibrazione delle attrezzature.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Le Nostre Attrezzature -->
        <section class="section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Le Nostre Attrezzature</h2>
                    <p class="section-subtitle">
                        Tecnologia all'avanguardia per risultati professionali
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="card">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gradient-primary rounded-full flex items-center justify-center text-white text-xl mr-4">
                                🔭
                            </div>
                            <h3 class="text-xl font-semibold text-white">Telescopi</h3>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-silver">Celestron EdgeHD 11"</span>
                                <span class="text-cyan">Principale</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-silver">Takahashi FSQ-106EDX</span>
                                <span class="text-purple">Astrofotografia</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-silver">William Optics GT81</span>
                                <span class="text-green">Portatile</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gradient-cosmic rounded-full flex items-center justify-center text-white text-xl mr-4">
                                📷
                            </div>
                            <h3 class="text-xl font-semibold text-white">Camere</h3>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-silver">ZWO ASI2600MC-Pro</span>
                                <span class="text-cyan">Raffreddata</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-silver">Canon EOS Ra</span>
                                <span class="text-purple">Astronomica</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-silver">ZWO ASI290MM Mini</span>
                                <span class="text-green">Guida</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gradient-success rounded-full flex items-center justify-center text-white text-xl mr-4">
                                ⚙️
                            </div>
                            <h3 class="text-xl font-semibold text-white">Montature</h3>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-silver">Celestron CGX-L</span>
                                <span class="text-cyan">Equatoriale</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-silver">Sky-Watcher EQ6-R Pro</span>
                                <span class="text-purple">Computerizzata</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-silver">iOptron SkyGuider Pro</span>
                                <span class="text-green">Tracking</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gradient-warning rounded-full flex items-center justify-center text-white text-xl mr-4">
                                🛠️
                            </div>
                            <h3 class="text-xl font-semibold text-white">Accessori</h3>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-silver">Filtri Narrowband</span>
                                <span class="text-cyan">Ha, OIII, SII</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-silver">Ruota Portafiltri</span>
                                <span class="text-purple">Automatica</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-silver">Focuser Elettronico</span>
                                <span class="text-green">Precisione</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Certificazioni -->
        <section class="section">
            <div class="container">
                <div class="card card-featured text-center">
                    <h2 class="text-2xl font-bold text-white mb-6">Certificazioni e Riconoscimenti</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-gradient-primary rounded-full flex items-center justify-center text-white text-2xl mb-3">
                                🏆
                            </div>
                            <h3 class="font-semibold text-white mb-2">Guida Astronomica Certificata</h3>
                            <p class="text-silver text-sm">Associazione Astrofili Italiani</p>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-gradient-cosmic rounded-full flex items-center justify-center text-white text-2xl mb-3">
                                📜
                            </div>
                            <h3 class="font-semibold text-white mb-2">Abilitazione Turismo</h3>
                            <p class="text-silver text-sm">Regione Puglia</p>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-gradient-success rounded-full flex items-center justify-center text-white text-2xl mb-3">
                                🌟
                            </div>
                            <h3 class="font-semibold text-white mb-2">5 Stelle TripAdvisor</h3>
                            <p class="text-silver text-sm">Eccellenza nel Turismo</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="section">
            <div class="container">
                <div class="card card-glass text-center">
                    <h2 class="text-3xl font-bold text-white mb-4">
                        Pronto a Conoscerci Meglio?
                    </h2>
                    <p class="text-lg text-silver mb-8 max-w-2xl mx-auto">
                        Vieni a trovarci durante una delle nostre serate osservative 
                        o contattaci per organizzare la tua esperienza personalizzata.
                    </p>
                    <div class="flex gap-4 justify-center flex-wrap">
                        <a href="/?page=contact" class="btn btn-primary btn-lg stellar-glow">
                            💬 Contattaci
                        </a>
                        <a href="/?page=booking" class="btn btn-secondary btn-lg">
                            🚀 Prenota Ora
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
                        <div class="mt-4">
                            <a href="/?page=live-sky" class="text-cyan hover:text-white">
                                🔴 Live Sky Cam
                            </a>
                        </div>
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
                        <h3>Seguici</h3>
                        <div class="flex space-x-4 mb-4">
                            <a href="#" class="text-silver hover:text-white">📘 Facebook</a>
                            <a href="#" class="text-silver hover:text-white">📷 Instagram</a>
                            <a href="#" class="text-silver hover:text-white">🐦 Twitter</a>
                        </div>
                        <p class="text-silver text-sm">
                            📧 info@astroguida.com<br>
                            📱 +39 123 456 7890
                        </p>
                    </div>
                </div>
                
                <div class="footer-bottom">
                    <p>&copy; <?= date('Y') ?> AstroGuida. Tutti i diritti riservati.</p>
                    <div class="footer-links">
                        <a href="/?page=privacy">Privacy Policy</a>
                        <a href="/?page=terms">Termini di Servizio</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="/assets/js/stellar-animations.js"></script>
    <script>
        // Inizializza animazioni stellari
        document.addEventListener('DOMContentLoaded', function() {
            const stellarAnimations = new StellarAnimations();
            stellarAnimations.init();
        });
    </script>
</body>
</html> 