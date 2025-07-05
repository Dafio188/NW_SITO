<?php
require_once __DIR__ . '/../includes/config.php';
?><!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Termini di Servizio | AstroGuida</title>
    <meta name="description" content="Termini e condizioni d'uso dei servizi AstroGuida - Regole, responsabilità e politiche">
    <meta name="robots" content="noindex, nofollow">
    
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="icon" href="/assets/images/logo/astroguida-logo.jpg">
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
                    <a href="/?page=about" class="nav-link">Chi Siamo</a>
                    <a href="/?page=contact" class="nav-link">Contatti</a>
                </nav>

                <div class="header-actions">
                    <a href="/?page=booking" class="btn btn-primary btn-sm">
                        🚀 Prenota
                    </a>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="hero-content text-center">
                    <h1 class="hero-title">
                        Termini di Servizio
                    </h1>
                    <p class="hero-subtitle">
                        Condizioni generali di utilizzo dei servizi AstroGuida<br>
                        Ultimo aggiornamento: <?= date('d/m/Y') ?>
                    </p>
                </div>
            </div>
        </section>

        <!-- Contenuto Terms of Service -->
        <section class="section">
            <div class="container">
                <div class="max-w-4xl mx-auto">
                    <div class="card">
                        <div class="prose prose-invert max-w-none">
                            <h2 class="text-2xl font-bold text-white mb-6">1. Accettazione dei Termini</h2>
                            <p class="text-silver mb-6">
                                Utilizzando i servizi di AstroGuida, accetti integralmente i presenti Termini di Servizio. 
                                Se non accetti questi termini, non utilizzare i nostri servizi.
                            </p>

                            <h2 class="text-2xl font-bold text-white mb-6">2. Descrizione dei Servizi</h2>
                            <p class="text-silver mb-4">
                                AstroGuida offre i seguenti servizi:
                            </p>
                            <ul class="text-silver mb-6 space-y-2">
                                <li>• <strong class="text-white">Astrofotografia:</strong> sessioni guidate di fotografia astronomica</li>
                                <li>• <strong class="text-white">Turismo Astronomico:</strong> tour ed escursioni a tema astronomico</li>
                                <li>• <strong class="text-white">Osservazione Guidata:</strong> serate di osservazione del cielo</li>
                                <li>• <strong class="text-white">Corsi di Astronomia:</strong> formazione teorica e pratica</li>
                                <li>• <strong class="text-white">Consulenza:</strong> supporto per progetti astronomici</li>
                            </ul>

                            <h2 class="text-2xl font-bold text-white mb-6">3. Prenotazioni</h2>
                            <h3 class="text-xl font-semibold text-white mb-4">3.1 Processo di Prenotazione</h3>
                            <p class="text-silver mb-4">
                                Le prenotazioni possono essere effettuate tramite:
                            </p>
                            <ul class="text-silver mb-6 space-y-2">
                                <li>• Sito web ufficiale</li>
                                <li>• Telefono: +39 123 456 7890</li>
                                <li>• Email: info@astroguida.com</li>
                            </ul>

                            <h3 class="text-xl font-semibold text-white mb-4">3.2 Conferma</h3>
                            <p class="text-silver mb-6">
                                La prenotazione è confermata solo dopo il pagamento dell'acconto richiesto 
                                e la ricezione della conferma scritta da parte di AstroGuida.
                            </p>

                            <h2 class="text-2xl font-bold text-white mb-6">4. Prezzi e Pagamenti</h2>
                            <h3 class="text-xl font-semibold text-white mb-4">4.1 Prezzi</h3>
                            <p class="text-silver mb-4">
                                I prezzi sono espressi in Euro e includono IVA. I prezzi attuali sono:
                            </p>
                            <ul class="text-silver mb-6 space-y-2">
                                <li>• <strong class="text-white">Osservazione Guidata:</strong> €45 per persona</li>
                                <li>• <strong class="text-white">Astrofotografia:</strong> €89 per persona</li>
                                <li>• <strong class="text-white">Turismo Astronomico:</strong> €120 per persona</li>
                                <li>• <strong class="text-white">Corsi:</strong> da €200 per persona</li>
                            </ul>

                            <h3 class="text-xl font-semibold text-white mb-4">4.2 Modalità di Pagamento</h3>
                            <p class="text-silver mb-6">
                                Accettiamo pagamenti tramite carta di credito, PayPal, bonifico bancario e contanti. 
                                È richiesto un acconto del 30% per confermare la prenotazione.
                            </p>

                            <h2 class="text-2xl font-bold text-white mb-6">5. Cancellazioni e Rimborsi</h2>
                            <h3 class="text-xl font-semibold text-white mb-4">5.1 Cancellazione da Parte del Cliente</h3>
                            <ul class="text-silver mb-6 space-y-2">
                                <li>• <strong class="text-white">Oltre 48 ore prima:</strong> rimborso completo</li>
                                <li>• <strong class="text-white">24-48 ore prima:</strong> rimborso del 50%</li>
                                <li>• <strong class="text-white">Meno di 24 ore:</strong> nessun rimborso</li>
                            </ul>

                            <h3 class="text-xl font-semibold text-white mb-4">5.2 Cancellazione per Maltempo</h3>
                            <p class="text-silver mb-6">
                                In caso di condizioni meteorologiche avverse, AstroGuida si riserva il diritto 
                                di cancellare o riprogrammare l'attività. In tal caso, offriamo:
                            </p>
                            <ul class="text-silver mb-6 space-y-2">
                                <li>• Riprogrammazione gratuita</li>
                                <li>• Rimborso completo se la riprogrammazione non è possibile</li>
                            </ul>

                            <h2 class="text-2xl font-bold text-white mb-6">6. Responsabilità e Sicurezza</h2>
                            <h3 class="text-xl font-semibold text-white mb-4">6.1 Responsabilità del Cliente</h3>
                            <ul class="text-silver mb-6 space-y-2">
                                <li>• Seguire le istruzioni del personale AstroGuida</li>
                                <li>• Utilizzare l'attrezzatura con cura</li>
                                <li>• Informare di eventuali problemi di salute</li>
                                <li>• Vestirsi adeguatamente per le condizioni esterne</li>
                            </ul>

                            <h3 class="text-xl font-semibold text-white mb-4">6.2 Limitazione di Responsabilità</h3>
                            <p class="text-silver mb-6">
                                AstroGuida non è responsabile per danni a persone o cose causati da:
                            </p>
                            <ul class="text-silver mb-6 space-y-2">
                                <li>• Mancato rispetto delle istruzioni</li>
                                <li>• Condizioni meteorologiche avverse</li>
                                <li>• Atti di terzi</li>
                                <li>• Casi di forza maggiore</li>
                            </ul>

                            <h2 class="text-2xl font-bold text-white mb-6">7. Attrezzature</h2>
                            <h3 class="text-xl font-semibold text-white mb-4">7.1 Attrezzature Fornite</h3>
                            <p class="text-silver mb-6">
                                AstroGuida fornisce tutta l'attrezzatura astronomica necessaria. 
                                I clienti sono responsabili dell'uso corretto e di eventuali danni.
                            </p>

                            <h3 class="text-xl font-semibold text-white mb-4">7.2 Attrezzature Personali</h3>
                            <p class="text-silver mb-6">
                                I clienti possono utilizzare le proprie attrezzature fotografiche. 
                                AstroGuida non è responsabile per danni o malfunzionamenti.
                            </p>

                            <h2 class="text-2xl font-bold text-white mb-6">8. Proprietà Intellettuale</h2>
                            <h3 class="text-xl font-semibold text-white mb-4">8.1 Foto e Video</h3>
                            <p class="text-silver mb-6">
                                Le foto scattate dai clienti rimangono di loro proprietà. 
                                AstroGuida può utilizzare foto delle attività per scopi promozionali, 
                                previa autorizzazione dei partecipanti.
                            </p>

                            <h3 class="text-xl font-semibold text-white mb-4">8.2 Materiali Didattici</h3>
                            <p class="text-silver mb-6">
                                Tutti i materiali didattici forniti da AstroGuida sono protetti da copyright 
                                e non possono essere riprodotti senza autorizzazione.
                            </p>

                            <h2 class="text-2xl font-bold text-white mb-6">9. Età e Requisiti</h2>
                            <ul class="text-silver mb-6 space-y-2">
                                <li>• <strong class="text-white">Età minima:</strong> 6 anni (con accompagnatore)</li>
                                <li>• <strong class="text-white">Minori:</strong> devono essere accompagnati da un adulto</li>
                                <li>• <strong class="text-white">Condizioni fisiche:</strong> informare di eventuali limitazioni</li>
                                <li>• <strong class="text-white">Gravidanza:</strong> consultare il medico prima della partecipazione</li>
                            </ul>

                            <h2 class="text-2xl font-bold text-white mb-6">10. Modifiche ai Termini</h2>
                            <p class="text-silver mb-6">
                                AstroGuida si riserva il diritto di modificare questi termini in qualsiasi momento. 
                                Le modifiche saranno pubblicate sul sito web e comunicate ai clienti esistenti.
                            </p>

                            <h2 class="text-2xl font-bold text-white mb-6">11. Legge Applicabile</h2>
                            <p class="text-silver mb-6">
                                Questi termini sono regolati dalla legge italiana. 
                                Per qualsiasi controversia è competente il Foro di Bari.
                            </p>

                            <h2 class="text-2xl font-bold text-white mb-6">12. Contatti</h2>
                            <p class="text-silver mb-6">
                                Per domande sui termini di servizio, contattaci:
                            </p>
                            <div class="bg-gradient-primary p-4 rounded-lg">
                                <p class="text-white">
                                    <strong>AstroGuida</strong><br>
                                    Via delle Stelle, 42 - 70100 Bari (BA)<br>
                                    <strong>Email:</strong> <a href="mailto:info@astroguida.com" class="text-cyan">info@astroguida.com</a><br>
                                    <strong>Telefono:</strong> +39 123 456 7890<br>
                                    <strong>P.IVA:</strong> IT12345678901
                                </p>
                            </div>

                            <div class="mt-8 p-4 bg-gradient-warning rounded-lg">
                                <p class="text-white text-center">
                                    <strong>⚠️ Importante:</strong> Partecipando alle attività di AstroGuida, 
                                    dichiari di aver letto e accettato integralmente questi Termini di Servizio.
                                </p>
                            </div>
                        </div>
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
                        <h3>Legale</h3>
                        <ul class="space-y-2">
                            <li><a href="/?page=privacy">Privacy Policy</a></li>
                            <li><a href="/?page=terms" class="text-cyan">Termini di Servizio</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="footer-bottom">
                    <p>&copy; <?= date('Y') ?> AstroGuida. Tutti i diritti riservati.</p>
                </div>
            </div>
        </footer>
    </div>

    <script src="/assets/js/stellar-animations.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stellarAnimations = new StellarAnimations();
            stellarAnimations.init();
        });
    </script>
</body>
</html> 