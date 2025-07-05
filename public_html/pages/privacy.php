<?php
require_once __DIR__ . '/../includes/config.php';
?><!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy | AstroGuida</title>
    <meta name="description" content="Informativa sulla privacy di AstroGuida - Come trattiamo i tuoi dati personali in conformità al GDPR">
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
                        Privacy Policy
                    </h1>
                    <p class="hero-subtitle">
                        Informativa sul trattamento dei dati personali<br>
                        Ultimo aggiornamento: <?= date('d/m/Y') ?>
                    </p>
                </div>
            </div>
        </section>

        <!-- Contenuto Privacy Policy -->
        <section class="section">
            <div class="container">
                <div class="max-w-4xl mx-auto">
                    <div class="card">
                        <div class="prose prose-invert max-w-none">
                            <h2 class="text-2xl font-bold text-white mb-6">1. Titolare del Trattamento</h2>
                            <p class="text-silver mb-6">
                                Il Titolare del trattamento dei dati personali è:<br>
                                <strong class="text-white">AstroGuida</strong><br>
                                Via delle Stelle, 42 - 70100 Bari (BA)<br>
                                Email: <a href="mailto:privacy@astroguida.com" class="text-cyan">privacy@astroguida.com</a><br>
                                Telefono: +39 123 456 7890
                            </p>

                            <h2 class="text-2xl font-bold text-white mb-6">2. Dati Raccolti</h2>
                            <p class="text-silver mb-4">
                                Raccogliamo i seguenti tipi di dati personali:
                            </p>
                            <ul class="text-silver mb-6 space-y-2">
                                <li>• <strong class="text-white">Dati di contatto:</strong> nome, cognome, email, telefono</li>
                                <li>• <strong class="text-white">Dati di prenotazione:</strong> servizio richiesto, data, numero partecipanti</li>
                                <li>• <strong class="text-white">Dati di navigazione:</strong> indirizzo IP, browser, pagine visitate</li>
                                <li>• <strong class="text-white">Dati di pagamento:</strong> gestiti da PayPal (non conserviamo dati di carte)</li>
                                <li>• <strong class="text-white">Foto/Video:</strong> durante le attività (solo con consenso)</li>
                            </ul>

                            <h2 class="text-2xl font-bold text-white mb-6">3. Finalità del Trattamento</h2>
                            <p class="text-silver mb-4">
                                I tuoi dati personali vengono trattati per le seguenti finalità:
                            </p>
                            <ul class="text-silver mb-6 space-y-2">
                                <li>• <strong class="text-white">Gestione prenotazioni:</strong> conferma e organizzazione delle attività</li>
                                <li>• <strong class="text-white">Comunicazioni:</strong> invio informazioni sui servizi richiesti</li>
                                <li>• <strong class="text-white">Assistenza clienti:</strong> risposta a domande e supporto</li>
                                <li>• <strong class="text-white">Marketing:</strong> invio newsletter (solo con consenso)</li>
                                <li>• <strong class="text-white">Obblighi legali:</strong> fatturazione e adempimenti fiscali</li>
                                <li>• <strong class="text-white">Sicurezza:</strong> prevenzione frodi e protezione del sito</li>
                            </ul>

                            <h2 class="text-2xl font-bold text-white mb-6">4. Base Giuridica</h2>
                            <p class="text-silver mb-4">
                                Il trattamento dei dati si basa su:
                            </p>
                            <ul class="text-silver mb-6 space-y-2">
                                <li>• <strong class="text-white">Contratto:</strong> per l'erogazione dei servizi richiesti</li>
                                <li>• <strong class="text-white">Consenso:</strong> per marketing e foto/video</li>
                                <li>• <strong class="text-white">Obbligo legale:</strong> per fatturazione e adempimenti</li>
                                <li>• <strong class="text-white">Interesse legittimo:</strong> per sicurezza e miglioramento servizi</li>
                            </ul>

                            <h2 class="text-2xl font-bold text-white mb-6">5. Conservazione dei Dati</h2>
                            <p class="text-silver mb-6">
                                I dati personali vengono conservati per il tempo necessario alle finalità per cui sono stati raccolti:
                            </p>
                            <ul class="text-silver mb-6 space-y-2">
                                <li>• <strong class="text-white">Dati di prenotazione:</strong> 10 anni (obblighi fiscali)</li>
                                <li>• <strong class="text-white">Dati di marketing:</strong> fino a revoca del consenso</li>
                                <li>• <strong class="text-white">Dati di navigazione:</strong> 24 mesi</li>
                                <li>• <strong class="text-white">Foto/Video:</strong> fino a revoca del consenso</li>
                            </ul>

                            <h2 class="text-2xl font-bold text-white mb-6">6. Condivisione dei Dati</h2>
                            <p class="text-silver mb-4">
                                I tuoi dati possono essere condivisi con:
                            </p>
                            <ul class="text-silver mb-6 space-y-2">
                                <li>• <strong class="text-white">Fornitori di servizi:</strong> PayPal per pagamenti, servizi di email</li>
                                <li>• <strong class="text-white">Autorità competenti:</strong> quando richiesto dalla legge</li>
                                <li>• <strong class="text-white">Partner commerciali:</strong> solo con consenso esplicito</li>
                            </ul>

                            <h2 class="text-2xl font-bold text-white mb-6">7. I Tuoi Diritti</h2>
                            <p class="text-silver mb-4">
                                Hai diritto a:
                            </p>
                            <ul class="text-silver mb-6 space-y-2">
                                <li>• <strong class="text-white">Accesso:</strong> conoscere quali dati abbiamo su di te</li>
                                <li>• <strong class="text-white">Rettifica:</strong> correggere dati inesatti</li>
                                <li>• <strong class="text-white">Cancellazione:</strong> richiedere la rimozione dei dati</li>
                                <li>• <strong class="text-white">Limitazione:</strong> limitare il trattamento</li>
                                <li>• <strong class="text-white">Portabilità:</strong> ricevere i dati in formato strutturato</li>
                                <li>• <strong class="text-white">Opposizione:</strong> opporti al trattamento</li>
                                <li>• <strong class="text-white">Revoca consenso:</strong> ritirare il consenso in qualsiasi momento</li>
                            </ul>

                            <h2 class="text-2xl font-bold text-white mb-6">8. Cookie</h2>
                            <p class="text-silver mb-6">
                                Il nostro sito utilizza cookie tecnici necessari per il funzionamento. 
                                Non utilizziamo cookie di profilazione senza il tuo consenso esplicito.
                            </p>

                            <h2 class="text-2xl font-bold text-white mb-6">9. Sicurezza</h2>
                            <p class="text-silver mb-6">
                                Implementiamo misure di sicurezza tecniche e organizzative appropriate 
                                per proteggere i tuoi dati personali da accessi non autorizzati, 
                                perdita, distruzione o alterazione.
                            </p>

                            <h2 class="text-2xl font-bold text-white mb-6">10. Minori</h2>
                            <p class="text-silver mb-6">
                                I nostri servizi non sono destinati a minori di 16 anni. 
                                Se veniamo a conoscenza di aver raccolto dati di minori, 
                                procederemo immediatamente alla loro cancellazione.
                            </p>

                            <h2 class="text-2xl font-bold text-white mb-6">11. Modifiche</h2>
                            <p class="text-silver mb-6">
                                Ci riserviamo il diritto di modificare questa informativa. 
                                Le modifiche saranno pubblicate su questa pagina con la data di aggiornamento.
                            </p>

                            <h2 class="text-2xl font-bold text-white mb-6">12. Contatti</h2>
                            <p class="text-silver mb-6">
                                Per esercitare i tuoi diritti o per domande sulla privacy, contattaci:
                            </p>
                            <div class="bg-gradient-primary p-4 rounded-lg">
                                <p class="text-white">
                                    <strong>Email:</strong> <a href="mailto:privacy@astroguida.com" class="text-cyan">privacy@astroguida.com</a><br>
                                    <strong>Telefono:</strong> +39 123 456 7890<br>
                                    <strong>Indirizzo:</strong> Via delle Stelle, 42 - 70100 Bari (BA)
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
                            <li><a href="/?page=privacy" class="text-cyan">Privacy Policy</a></li>
                            <li><a href="/?page=terms">Termini di Servizio</a></li>
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