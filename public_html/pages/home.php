<?php /* Home AstroGuida */ ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstroGuida - Astrofotografia e Turismo Astronomico</title>
    <meta name="description" content="Scopri l'universo con AstroGuida. Servizi professionali di astrofotografia, turismo astronomico e osservazione del cielo stellato.">
    
    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/main.css">
    
    <!-- Favicon -->
    <link rel="icon" href="/favicon.ico">
    
    <!-- Open Graph -->
    <meta property="og:title" content="AstroGuida - Astrofotografia e Turismo Astronomico">
    <meta property="og:description" content="Scopri l'universo con AstroGuida. Servizi professionali di astrofotografia e turismo astronomico.">
    <meta property="og:image" content="/assets/images/logo/astroguida-logo.jpg">
    <meta property="og:url" content="https://astroguida.com">
    
    <!-- Schema.org -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "AstroGuida",
        "description": "Servizi di astrofotografia e turismo astronomico",
        "url": "https://astroguida.com",
        "telephone": "+39-XXX-XXXXXXX",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "Cassano delle Murge",
            "addressRegion": "Puglia",
            "addressCountry": "IT"
        }
    }
    </script>
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
                    <a href="/" class="nav-link active">Home</a>
                    <a href="/?page=services" class="nav-link">Servizi</a>
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
                    Esplora l'<span class="highlight cosmic-text-bright">Universo</span> 
                    con AstroGuida
                </h1>
                <p class="hero-subtitle fade-in-up" style="animation-delay: 0.2s;">
                    Servizi professionali di astrofotografia, turismo astronomico e osservazione del cielo stellato. 
                    Scopri la bellezza del cosmo con guide esperte e attrezzature all'avanguardia.
                </p>
                <div class="hero-actions fade-in-up" style="animation-delay: 0.4s;">
                    <a href="/?page=services" class="btn btn-primary btn-lg stellar-glow">
                        🌌 Scopri i Servizi
                    </a>
                    <a href="/?page=gallery" class="btn btn-secondary btn-lg">
                        📸 Vedi Gallery
                    </a>
                </div>
            </div>
        </section>

        <!-- Servizi Principali -->
        <section class="section section-spaced">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">I Nostri Servizi</h2>
                    <p class="section-subtitle">
                        Offriamo una gamma completa di servizi per appassionati di astronomia, 
                        dalla fotografia professionale alle escursioni guidate.
                    </p>
                </div>
                
                <div class="services-grid services-grid-spaced">
                    <div class="service-card">
                        <div class="service-icon">📸</div>
                        <h3 class="service-title">Astrofotografia</h3>
                        <p class="service-description">
                            Sessioni fotografiche professionali del cielo notturno. 
                            Catturiamo galassie, nebulose e pianeti con attrezzature di alta qualità.
                        </p>
                        <div class="service-price">Da €150/sessione</div>
                        <a href="/?page=booking" class="btn btn-primary w-full">
                            Prenota Sessione
                        </a>
                    </div>
                    
                    <div class="service-card">
                        <div class="service-icon">🌌</div>
                        <h3 class="service-title">Turismo Astronomico</h3>
                        <p class="service-description">
                            Escursioni notturne guidate per osservare il cielo stellato. 
                            Perfetto per famiglie e gruppi di amici.
                        </p>
                        <div class="service-price">Da €80/persona</div>
                        <a href="/?page=booking" class="btn btn-primary w-full">
                            Prenota Tour
                        </a>
                    </div>
                    
                    <div class="service-card">
                        <div class="service-icon">🔭</div>
                        <h3 class="service-title">Osservazione Guidata</h3>
                        <p class="service-description">
                            Osservazioni telescopiche di pianeti, luna e oggetti del cielo profondo 
                            con telescopi professionali.
                        </p>
                        <div class="service-price">Da €50/persona</div>
                        <a href="/?page=booking" class="btn btn-primary w-full">
                            Prenota Osservazione
                        </a>
                    </div>
                    
                    <div class="service-card">
                        <div class="service-icon">🎓</div>
                        <h3 class="service-title">Corsi di Astronomia</h3>
                        <p class="service-description">
                            Corsi teorici e pratici per imparare l'astronomia e l'astrofotografia. 
                            Adatti a principianti e appassionati.
                        </p>
                        <div class="service-price">Da €120/corso</div>
                        <a href="/?page=booking" class="btn btn-primary w-full">
                            Iscriviti
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gallery Preview -->
        <section class="section section-spaced">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Gallery Astrofotografica</h2>
                    <p class="section-subtitle">
                        Una selezione delle nostre migliori astrofotografie. 
                        Ogni immagine racconta la storia di una notte sotto le stelle.
                    </p>
                </div>
                
                <div class="gallery-grid gallery-grid-spaced">
                    <div class="gallery-item">
                        <img src="/fotoastronomia/m31.jpg" alt="Galassia di Andromeda M31" class="gallery-image">
                        <div class="gallery-overlay">
                            <span>Galassia di Andromeda (M31)</span>
                        </div>
                    </div>
                    
                    <div class="gallery-item">
                        <img src="/fotoastronomia/nebulosa-cuore.jpg" alt="Nebulosa Cuore" class="gallery-image">
                        <div class="gallery-overlay">
                            <span>Nebulosa Cuore</span>
                        </div>
                    </div>
                    
                    <div class="gallery-item">
                        <img src="/fotoastronomia/pleadi-m45.jpg" alt="Ammasso delle Pleiadi M45" class="gallery-image">
                        <div class="gallery-overlay">
                            <span>Pleiadi (M45)</span>
                        </div>
                    </div>
                    
                    <div class="gallery-item">
                        <img src="/fotoastronomia/rosetta-red.jpg" alt="Nebulosa Rosetta" class="gallery-image">
                        <div class="gallery-overlay">
                            <span>Nebulosa Rosetta</span>
                        </div>
                    </div>
                    
                    <div class="gallery-item">
                        <img src="/fotoastronomia/ic443.jpg" alt="Nebulosa Medusa IC443" class="gallery-image">
                        <div class="gallery-overlay">
                            <span>Nebulosa Medusa (IC443)</span>
                        </div>
                    </div>
                    
                    <div class="gallery-item">
                        <img src="/fotoastronomia/ngc7635.jpg" alt="Nebulosa Bolla NGC7635" class="gallery-image">
                        <div class="gallery-overlay">
                            <span>Nebulosa Bolla (NGC7635)</span>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-8">
                    <a href="/?page=gallery" class="btn btn-secondary btn-lg">
                        🖼️ Vedi Tutta la Gallery
                    </a>
                </div>
            </div>
        </section>

        <!-- Features -->
        <section class="section section-spaced">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Perché Scegliere AstroGuida</h2>
                    <p class="section-subtitle">
                        La nostra esperienza e passione per l'astronomia garantiscono 
                        un'esperienza unica e indimenticabile.
                    </p>
                </div>
                
                <div class="features-grid features-grid-spaced">
                    <div class="card">
                        <div class="text-center mb-4">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-primary rounded-2xl text-white text-2xl mb-4">
                                🏆
                            </div>
                            <h3 class="text-xl font-semibold text-white mb-3">Esperienza Professionale</h3>
                            <p class="text-silver">
                                Oltre 10 anni di esperienza nell'astrofotografia e guide astronomiche certificate.
                            </p>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="text-center mb-4">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-cosmic rounded-2xl text-white text-2xl mb-4">
                                🔬
                            </div>
                            <h3 class="text-xl font-semibold text-white mb-3">Attrezzature Professionali</h3>
                            <p class="text-silver">
                                Telescopi di alta qualità, camere CCD raffreddate e montature computerizzate.
                            </p>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="text-center mb-4">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-success rounded-2xl text-white text-2xl mb-4">
                                🌍
                            </div>
                            <h3 class="text-xl font-semibold text-white mb-3">Cielo Incontaminato</h3>
                            <p class="text-silver">
                                Osservazioni in zone con basso inquinamento luminoso per la migliore visibilità.
                            </p>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="text-center mb-4">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-warning rounded-2xl text-white text-2xl mb-4">
                                👥
                            </div>
                            <h3 class="text-xl font-semibold text-white mb-3">Gruppi Piccoli</h3>
                            <p class="text-silver">
                                Massimo 8 persone per tour per garantire un'esperienza personalizzata.
                            </p>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="text-center mb-4">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-primary rounded-2xl text-white text-2xl mb-4">
                                📱
                            </div>
                            <h3 class="text-xl font-semibold text-white mb-3">Tecnologia Moderna</h3>
                            <p class="text-silver">
                                App mobile per identificazione stelle e pianificazione osservazioni.
                            </p>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="text-center mb-4">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-cosmic rounded-2xl text-white text-2xl mb-4">
                                💝
                            </div>
                            <h3 class="text-xl font-semibold text-white mb-3">Soddisfazione Garantita</h3>
                            <p class="text-silver">
                                Rimborso completo in caso di maltempo o condizioni non ottimali.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="section section-spaced">
            <div class="container">
                <div class="card card-featured text-center">
                    <h2 class="text-3xl font-bold text-white mb-4">
                        Pronto per la Tua Avventura Stellare?
                    </h2>
                    <p class="text-lg text-silver mb-8 max-w-2xl mx-auto">
                        Unisciti a noi per un'esperienza indimenticabile sotto il cielo stellato. 
                        Prenota ora la tua sessione di astrofotografia o tour astronomico.
                    </p>
                    <div class="flex gap-4 justify-center flex-wrap">
                        <a href="/?page=booking" class="btn btn-primary btn-lg stellar-glow">
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
                        <h3>Contatti</h3>
                        <p>📍 Cassano delle Murge, Puglia</p>
                        <p>📧 info@astroguida.com</p>
                        <p>📱 +39 XXX XXX XXXX</p>
                        <div class="mt-4">
                            <p class="text-sm">Seguici sui social:</p>
                            <div class="flex gap-3 mt-2">
                                <a href="#" class="text-silver hover:text-cyan">Facebook</a>
                                <a href="#" class="text-silver hover:text-cyan">Instagram</a>
                                <a href="#" class="text-silver hover:text-cyan">YouTube</a>
                            </div>
                        </div>
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
        // Inizializzazione effetti interattivi
        document.addEventListener('DOMContentLoaded', function() {
            // Effetto hover sui servizi
            const serviceCards = document.querySelectorAll('.service-card');
            serviceCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px) scale(1.02)';
                    this.style.boxShadow = '0 25px 50px rgba(100, 255, 218, 0.2)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                    this.style.boxShadow = '';
                });
            });
            
            // Effetto click sui bottoni
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    if (window.StellarEffects) {
                        window.StellarEffects.rippleEffect(this, e);
                    }
                });
            });
            
            // Animazione scroll per elementi
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -100px 0px'
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);
            
            // Osserva le card per animazioni
            document.querySelectorAll('.service-card, .gallery-item, .card').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                el.style.transition = 'all 0.6s ease-out';
                observer.observe(el);
            });
        });
    </script>
</body>
</html> 