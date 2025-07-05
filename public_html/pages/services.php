<?php
require_once __DIR__ . '/../../includes/config.php';
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
                    <div class="logo-icon">🌟</div>
                    <span>AstroGuida</span>
                </a>
                
                <nav class="nav-main">
                    <a href="/" class="nav-link">Home</a>
                    <a href="/services" class="nav-link active">Servizi</a>
                    <a href="/gallery" class="nav-link">Gallery</a>
                    <a href="/live-sky" class="nav-link">Live Sky</a>
                    <a href="/about" class="nav-link">Chi Siamo</a>
                    <a href="/contact" class="nav-link">Contatti</a>
                </nav>
                
                <div class="user-menu">
                    <a href="/booking" class="btn btn-primary btn-sm">Prenota</a>
                    <a href="/login" class="btn btn-ghost btn-sm">Accedi</a>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content">
                <h1 class="hero-title fade-in-up">
                    I Nostri <span class="highlight cosmic-text">Servizi</span>
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
                            
                            <a href="/booking?service=astrofotografia" class="btn btn-primary btn-lg">
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
                            
                            <a href="/booking?service=turismo" class="btn btn-primary btn-lg">
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
                            
                            <a href="/booking?service=osservazione" class="btn btn-primary btn-lg">
                                🔭 Prenota Osservazione
                            </a>
                        </div>
                        
                        <div class="text-center">
                            <div class="bg-gradient-cosmic p-8 rounded-2xl">
                                <h3 class="text-2xl font-bold text-white mb-4">Calendario Lunare</h3>
                                <div class="text-6xl mb-4">🌙</div>
                                <p class="text-silver mb-4">Prossima Luna Nuova</p>
                                <p class="text-xl font-semibold text-cyan">15 Febbraio 2025</p>
                                <p class="text-sm text-silver mt-2">Condizioni ottimali per cielo profondo</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Corsi di Astronomia -->
                <div class="card card-featured mb-12" id="corsi">
                    <div class="text-center mb-8">
                        <div class="service-icon mx-auto mb-4">🎓</div>
                        <h2 class="text-3xl font-bold text-white mb-4">Corsi di Astronomia</h2>
                        <p class="text-silver text-lg max-w-2xl mx-auto">
                            Corsi teorici e pratici per imparare l'astronomia e l'astrofotografia. 
                            Adatti sia a principianti che ad appassionati avanzati.
                        </p>
                    </div>
                    
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="bg-glass-medium p-6 rounded-xl">
                            <h3 class="text-xl font-semibold text-white mb-3">Corso Base</h3>
                            <ul class="text-silver text-sm space-y-1 mb-4">
                                <li>• Introduzione all'astronomia</li>
                                <li>• Uso del telescopio</li>
                                <li>• Riconoscimento costellazioni</li>
                                <li>• 4 lezioni teoriche + 2 pratiche</li>
                            </ul>
                            <div class="text-center">
                                <div class="text-xl font-bold text-cyan mb-2">€120</div>
                                <a href="/booking?service=corso-base" class="btn btn-secondary w-full">Iscriviti</a>
                            </div>
                        </div>
                        
                        <div class="bg-glass-medium p-6 rounded-xl border-2 border-cyan">
                            <div class="badge badge-primary mb-3">Più Popolare</div>
                            <h3 class="text-xl font-semibold text-white mb-3">Corso Astrofotografia</h3>
                            <ul class="text-silver text-sm space-y-1 mb-4">
                                <li>• Tecniche di ripresa</li>
                                <li>• Elaborazione immagini</li>
                                <li>• Attrezzature professionali</li>
                                <li>• 6 lezioni teoriche + 4 pratiche</li>
                            </ul>
                            <div class="text-center">
                                <div class="text-xl font-bold text-cyan mb-2">€280</div>
                                <a href="/booking?service=corso-astrofoto" class="btn btn-primary w-full">Iscriviti</a>
                            </div>
                        </div>
                        
                        <div class="bg-glass-medium p-6 rounded-xl">
                            <h3 class="text-xl font-semibold text-white mb-3">Corso Avanzato</h3>
                            <ul class="text-silver text-sm space-y-1 mb-4">
                                <li>• Spettroscopia</li>
                                <li>• Fotometria</li>
                                <li>• Ricerca scientifica</li>
                                <li>• 8 lezioni teoriche + 6 pratiche</li>
                            </ul>
                            <div class="text-center">
                                <div class="text-xl font-bold text-cyan mb-2">€450</div>
                                <a href="/booking?service=corso-avanzato" class="btn btn-secondary w-full">Iscriviti</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Servizi -->
        <section class="section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Domande Frequenti</h2>
                </div>
                
                <div class="max-w-3xl mx-auto">
                    <div class="space-y-4">
                        <div class="card">
                            <h3 class="font-semibold text-white mb-2">Cosa succede in caso di maltempo?</h3>
                            <p class="text-silver">
                                In caso di condizioni meteorologiche avverse, offriamo il rimborso completo 
                                o la possibilità di riprogrammare la sessione senza costi aggiuntivi.
                            </p>
                        </div>
                        
                        <div class="card">
                            <h3 class="font-semibold text-white mb-2">Serve esperienza precedente?</h3>
                            <p class="text-silver">
                                No, i nostri servizi sono adatti a tutti i livelli. Le guide esperte 
                                ti accompagneranno passo dopo passo nell'esperienza astronomica.
                            </p>
                        </div>
                        
                        <div class="card">
                            <h3 class="font-semibold text-white mb-2">Cosa devo portare?</h3>
                            <p class="text-silver">
                                Consigliamo abbigliamento caldo, scarpe comode e una torcia con luce rossa. 
                                Tutta l'attrezzatura astronomica è fornita da noi.
                            </p>
                        </div>
                        
                        <div class="card">
                            <h3 class="font-semibold text-white mb-2">I servizi sono adatti ai bambini?</h3>
                            <p class="text-silver">
                                Assolutamente sì! Abbiamo programmi specifici per famiglie con bambini 
                                a partire dai 6 anni. L'astronomia è un'esperienza magica per tutte le età.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="section">
            <div class="container">
                <div class="card card-cosmic text-center">
                    <h2 class="text-3xl font-bold text-white mb-4">
                        Pronto per la Tua Avventura Stellare?
                    </h2>
                    <p class="text-lg text-silver mb-8">
                        Scegli il servizio che più ti interessa e prenota la tua esperienza astronomica.
                    </p>
                    <div class="flex gap-4 justify-center flex-wrap">
                        <a href="/booking" class="btn btn-primary btn-lg stellar-glow">
                            🚀 Prenota Ora
                        </a>
                        <a href="/contact" class="btn btn-secondary btn-lg">
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
                        <h3>AstroGuida</h3>
                        <p>La tua guida professionale per esplorare l'universo.</p>
                    </div>
                    <div class="footer-section">
                        <h3>Servizi</h3>
                        <ul class="space-y-2">
                            <li><a href="#astrofotografia">Astrofotografia</a></li>
                            <li><a href="#turismo">Turismo Astronomico</a></li>
                            <li><a href="#osservazione">Osservazione Guidata</a></li>
                            <li><a href="#corsi">Corsi di Astronomia</a></li>
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
                    <p>&copy; 2025 AstroGuida. Tutti i diritti riservati.</p>
                </div>
            </div>
        </footer>
    </div>

    <script src="/assets/js/stellar-animations.js"></script>
</body>
</html> 