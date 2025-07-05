<?php
require_once __DIR__ . '/../includes/config.php';
?><!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Domande Frequenti | AstroGuida</title>
    <meta name="description" content="Trova risposte alle domande più frequenti sui nostri servizi di astrofotografia, turismo astronomico e osservazioni guidate.">
    <meta name="keywords" content="faq, domande frequenti, astrofotografia, turismo astronomico, osservazioni, prezzi, prenotazioni">
    
    <!-- Open Graph -->
    <meta property="og:title" content="FAQ - Domande Frequenti | AstroGuida">
    <meta property="og:description" content="Trova risposte alle domande più frequenti sui nostri servizi astronomici">
    <meta property="og:image" content="/assets/images/logo/astroguida-logo.jpg">
    <meta property="og:url" content="<?= SITE_URL ?>/?page=faq">
    <meta property="og:type" content="website">
    
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
                        Domande Frequenti
                    </h1>
                    <p class="hero-subtitle">
                        Trova rapidamente le risposte alle domande più comuni 
                        sui nostri servizi di astrofotografia e turismo astronomico.
                    </p>
                </div>
            </div>
        </section>

        <!-- Ricerca FAQ -->
        <section class="section">
            <div class="container">
                <div class="max-w-2xl mx-auto">
                    <div class="card">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-primary rounded-full flex items-center justify-center text-white text-xl mr-4">
                                🔍
                            </div>
                            <div class="flex-1">
                                <input type="text" 
                                       id="faq-search" 
                                       placeholder="Cerca nelle FAQ..." 
                                       class="form-input w-full">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Categorie FAQ -->
        <section class="section">
            <div class="container">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                    <button class="faq-category-btn active" data-category="generale">
                        <div class="w-12 h-12 bg-gradient-primary rounded-full flex items-center justify-center text-white text-xl mb-3">
                            ❓
                        </div>
                        <span>Generale</span>
                    </button>
                    <button class="faq-category-btn" data-category="astrofotografia">
                        <div class="w-12 h-12 bg-gradient-cosmic rounded-full flex items-center justify-center text-white text-xl mb-3">
                            📸
                        </div>
                        <span>Astrofotografia</span>
                    </button>
                    <button class="faq-category-btn" data-category="turismo">
                        <div class="w-12 h-12 bg-gradient-success rounded-full flex items-center justify-center text-white text-xl mb-3">
                            🌟
                        </div>
                        <span>Turismo</span>
                    </button>
                    <button class="faq-category-btn" data-category="prenotazioni">
                        <div class="w-12 h-12 bg-gradient-warning rounded-full flex items-center justify-center text-white text-xl mb-3">
                            📅
                        </div>
                        <span>Prenotazioni</span>
                    </button>
                </div>

                <!-- FAQ Generale -->
                <div class="faq-category active" data-category="generale">
                    <div class="section-header">
                        <h2 class="section-title">Domande Generali</h2>
                    </div>
                    <div class="space-y-4">
                        <div class="faq-item card">
                            <button class="faq-question w-full text-left flex items-center justify-between">
                                <span class="font-semibold text-white">Cos'è AstroGuida?</span>
                                <span class="faq-icon text-cyan">+</span>
                            </button>
                            <div class="faq-answer">
                                <p class="text-silver">
                                    AstroGuida è un servizio professionale di astrofotografia e turismo astronomico 
                                    con sede in Puglia. Offriamo esperienze uniche sotto il cielo stellato, 
                                    dalle osservazioni guidate ai workshops di astrofotografia.
                                </p>
                            </div>
                        </div>

                        <div class="faq-item card">
                            <button class="faq-question w-full text-left flex items-center justify-between">
                                <span class="font-semibold text-white">Dove si svolgono le attività?</span>
                                <span class="faq-icon text-cyan">+</span>
                            </button>
                            <div class="faq-answer">
                                <p class="text-silver">
                                    Le nostre attività si svolgono in diverse location della Puglia, 
                                    selezionate per il basso inquinamento luminoso e le condizioni ottimali 
                                    per l'osservazione astronomica. La sede principale è a Bari.
                                </p>
                            </div>
                        </div>

                        <div class="faq-item card">
                            <button class="faq-question w-full text-left flex items-center justify-between">
                                <span class="font-semibold text-white">Che esperienza serve?</span>
                                <span class="faq-icon text-cyan">+</span>
                            </button>
                            <div class="faq-answer">
                                <p class="text-silver">
                                    Nessuna esperienza precedente è richiesta! I nostri servizi sono pensati 
                                    per tutti i livelli, dai principianti agli esperti. Le nostre guide 
                                    vi accompagneranno passo dopo passo.
                                </p>
                            </div>
                        </div>

                        <div class="faq-item card">
                            <button class="faq-question w-full text-left flex items-center justify-between">
                                <span class="font-semibold text-white">Cosa devo portare?</span>
                                <span class="faq-icon text-cyan">+</span>
                            </button>
                            <div class="faq-answer">
                                <p class="text-silver">
                                    Vestiario caldo (anche d'estate le notti possono essere fresche), 
                                    scarpe comode, torcia con luce rossa (se disponibile), 
                                    e tanta curiosità! Noi forniamo tutta l'attrezzatura astronomica.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Astrofotografia -->
                <div class="faq-category" data-category="astrofotografia">
                    <div class="section-header">
                        <h2 class="section-title">Astrofotografia</h2>
                    </div>
                    <div class="space-y-4">
                        <div class="faq-item card">
                            <button class="faq-question w-full text-left flex items-center justify-between">
                                <span class="font-semibold text-white">Posso usare la mia fotocamera?</span>
                                <span class="faq-icon text-cyan">+</span>
                            </button>
                            <div class="faq-answer">
                                <p class="text-silver">
                                    Assolutamente sì! Accettiamo qualsiasi tipo di fotocamera, dalle reflex 
                                    alle mirrorless, dagli smartphone alle camere CCD dedicate. 
                                    Vi aiuteremo a configurarla per i migliori risultati.
                                </p>
                            </div>
                        </div>

                        <div class="faq-item card">
                            <button class="faq-question w-full text-left flex items-center justify-between">
                                <span class="font-semibold text-white">Quanto durano le sessioni?</span>
                                <span class="faq-icon text-cyan">+</span>
                            </button>
                            <div class="faq-answer">
                                <p class="text-silver">
                                    Le sessioni di astrofotografia durano tipicamente 3-4 ore, 
                                    iniziando dopo il tramonto. Per progetti speciali possiamo 
                                    organizzare sessioni più lunghe o multiple notti.
                                </p>
                            </div>
                        </div>

                        <div class="faq-item card">
                            <button class="faq-question w-full text-left flex items-center justify-between">
                                <span class="font-semibold text-white">Cosa fotograferemo?</span>
                                <span class="faq-icon text-cyan">+</span>
                            </button>
                            <div class="faq-answer">
                                <p class="text-silver">
                                    Dipende dalla stagione e dalle condizioni! Galassie, nebulose, 
                                    ammassi stellari, pianeti, la Luna, la Via Lattea e molto altro. 
                                    Pianifichiamo ogni sessione in base agli oggetti visibili.
                                </p>
                            </div>
                        </div>

                        <div class="faq-item card">
                            <button class="faq-question w-full text-left flex items-center justify-between">
                                <span class="font-semibold text-white">Riceverò le foto elaborate?</span>
                                <span class="faq-icon text-cyan">+</span>
                            </button>
                            <div class="faq-answer">
                                <p class="text-silver">
                                    Sì! Oltre alle vostre foto, riceverete anche alcune immagini 
                                    elaborate dai nostri esperti come esempio e ricordo della serata. 
                                    Includiamo anche una guida per l'elaborazione base.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Turismo -->
                <div class="faq-category" data-category="turismo">
                    <div class="section-header">
                        <h2 class="section-title">Turismo Astronomico</h2>
                    </div>
                    <div class="space-y-4">
                        <div class="faq-item card">
                            <button class="faq-question w-full text-left flex items-center justify-between">
                                <span class="font-semibold text-white">Quanto durano i tour?</span>
                                <span class="faq-icon text-cyan">+</span>
                            </button>
                            <div class="faq-answer">
                                <p class="text-silver">
                                    I tour standard durano 2-3 ore, ma offriamo anche esperienze 
                                    di mezza giornata o giornate complete che includono visite 
                                    a osservatori, musei astronomici e location speciali.
                                </p>
                            </div>
                        </div>

                        <div class="faq-item card">
                            <button class="faq-question w-full text-left flex items-center justify-between">
                                <span class="font-semibold text-white">Quante persone per gruppo?</span>
                                <span class="faq-icon text-cyan">+</span>
                            </button>
                            <div class="faq-answer">
                                <p class="text-silver">
                                    Manteniamo gruppi piccoli (massimo 8 persone) per garantire 
                                    un'esperienza personalizzata e permettere a tutti di utilizzare 
                                    l'attrezzatura. Accettiamo anche prenotazioni individuali.
                                </p>
                            </div>
                        </div>

                        <div class="faq-item card">
                            <button class="faq-question w-full text-left flex items-center justify-between">
                                <span class="font-semibold text-white">È adatto ai bambini?</span>
                                <span class="faq-icon text-cyan">+</span>
                            </button>
                            <div class="faq-answer">
                                <p class="text-silver">
                                    Assolutamente! L'astronomia affascina i bambini. Abbiamo programmi 
                                    specifici per famiglie con attività interattive e spiegazioni 
                                    adatte all'età. Consigliamo dai 6 anni in su.
                                </p>
                            </div>
                        </div>

                        <div class="faq-item card">
                            <button class="faq-question w-full text-left flex items-center justify-between">
                                <span class="font-semibold text-white">Cosa succede se piove?</span>
                                <span class="faq-icon text-cyan">+</span>
                            </button>
                            <div class="faq-answer">
                                <p class="text-silver">
                                    Monitoriamo costantemente le condizioni meteo. In caso di maltempo, 
                                    riprogrammiamo l'attività senza costi aggiuntivi o offriamo 
                                    il rimborso completo se non è possibile riprogrammare.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Prenotazioni -->
                <div class="faq-category" data-category="prenotazioni">
                    <div class="section-header">
                        <h2 class="section-title">Prenotazioni e Pagamenti</h2>
                    </div>
                    <div class="space-y-4">
                        <div class="faq-item card">
                            <button class="faq-question w-full text-left flex items-center justify-between">
                                <span class="font-semibold text-white">Come posso prenotare?</span>
                                <span class="faq-icon text-cyan">+</span>
                            </button>
                            <div class="faq-answer">
                                <p class="text-silver">
                                    Puoi prenotare direttamente dal nostro sito web, chiamarci al 
                                    +39 123 456 7890, o scriverci via email. Ti confermeremo 
                                    la disponibilità entro 24 ore.
                                </p>
                            </div>
                        </div>

                        <div class="faq-item card">
                            <button class="faq-question w-full text-left flex items-center justify-between">
                                <span class="font-semibold text-white">Quanto costa?</span>
                                <span class="faq-icon text-cyan">+</span>
                            </button>
                            <div class="faq-answer">
                                <p class="text-silver">
                                    I prezzi variano in base al servizio: Osservazione Guidata €45/persona, 
                                    Astrofotografia €89/persona, Turismo Astronomico €120/persona, 
                                    Corsi da €200. Sconti per gruppi e famiglie.
                                </p>
                            </div>
                        </div>

                        <div class="faq-item card">
                            <button class="faq-question w-full text-left flex items-center justify-between">
                                <span class="font-semibold text-white">Posso cancellare la prenotazione?</span>
                                <span class="faq-icon text-cyan">+</span>
                            </button>
                            <div class="faq-answer">
                                <p class="text-silver">
                                    Sì, puoi cancellare fino a 48 ore prima per un rimborso completo. 
                                    Cancellazioni entro 24 ore: rimborso 50%. Per maltempo o 
                                    emergenze, siamo sempre flessibili.
                                </p>
                            </div>
                        </div>

                        <div class="faq-item card">
                            <button class="faq-question w-full text-left flex items-center justify-between">
                                <span class="font-semibold text-white">Quali metodi di pagamento accettate?</span>
                                <span class="faq-icon text-cyan">+</span>
                            </button>
                            <div class="faq-answer">
                                <p class="text-silver">
                                    Accettiamo pagamenti con carta di credito, PayPal, bonifico bancario 
                                    e contanti. Per prenotazioni online richiediamo un acconto del 30%, 
                                    il resto si paga il giorno dell'attività.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contatto per Altre Domande -->
        <section class="section">
            <div class="container">
                <div class="card card-featured text-center">
                    <h2 class="text-2xl font-bold text-white mb-4">
                        Non hai trovato quello che cercavi?
                    </h2>
                    <p class="text-lg text-silver mb-8 max-w-2xl mx-auto">
                        Il nostro team è sempre disponibile per rispondere a qualsiasi domanda 
                        specifica sui nostri servizi o per aiutarti a pianificare la tua esperienza.
                    </p>
                    <div class="flex gap-4 justify-center flex-wrap">
                        <a href="/?page=contact" class="btn btn-primary btn-lg stellar-glow">
                            💬 Contattaci
                        </a>
                        <a href="tel:+393123456789" class="btn btn-secondary btn-lg">
                            📞 Chiama Ora
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
                        <h3>Seguici</h3>
                        <div class="flex space-x-4 mb-4">
                            <a href="#" class="text-silver hover:text-white">📘 Facebook</a>
                            <a href="#" class="text-silver hover:text-white">📷 Instagram</a>
                        </div>
                        <p class="text-silver text-sm">
                            📧 info@astroguida.com<br>
                            📱 +39 123 456 7890
                        </p>
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
        // Inizializza animazioni stellari
        document.addEventListener('DOMContentLoaded', function() {
            const stellarAnimations = new StellarAnimations();
            stellarAnimations.init();
            
            // Gestione FAQ
            initFAQ();
        });

        function initFAQ() {
            // Toggle FAQ items
            document.querySelectorAll('.faq-question').forEach(button => {
                button.addEventListener('click', function() {
                    const item = this.closest('.faq-item');
                    const answer = item.querySelector('.faq-answer');
                    const icon = this.querySelector('.faq-icon');
                    
                    const isOpen = answer.style.display === 'block';
                    
                    // Chiudi tutti gli altri
                    document.querySelectorAll('.faq-answer').forEach(a => a.style.display = 'none');
                    document.querySelectorAll('.faq-icon').forEach(i => i.textContent = '+');
                    
                    if (!isOpen) {
                        answer.style.display = 'block';
                        icon.textContent = '−';
                    }
                });
            });
            
            // Gestione categorie
            document.querySelectorAll('.faq-category-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const category = this.dataset.category;
                    
                    // Rimuovi classe active da tutti
                    document.querySelectorAll('.faq-category-btn').forEach(btn => btn.classList.remove('active'));
                    document.querySelectorAll('.faq-category').forEach(cat => cat.classList.remove('active'));
                    
                    // Aggiungi classe active
                    this.classList.add('active');
                    document.querySelector(`[data-category="${category}"].faq-category`).classList.add('active');
                });
            });
            
            // Ricerca FAQ
            const searchInput = document.getElementById('faq-search');
            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                const faqItems = document.querySelectorAll('.faq-item');
                
                faqItems.forEach(item => {
                    const question = item.querySelector('.faq-question span').textContent.toLowerCase();
                    const answer = item.querySelector('.faq-answer').textContent.toLowerCase();
                    
                    if (question.includes(query) || answer.includes(query)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = query === '' ? 'block' : 'none';
                    }
                });
            });
        }
    </script>
    
    <style>
        .faq-category-btn {
            background: rgba(42, 42, 42, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            color: #94a3b8;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .faq-category-btn:hover {
            background: rgba(100, 255, 218, 0.1);
            border-color: rgba(100, 255, 218, 0.3);
            color: #64ffda;
        }
        
        .faq-category-btn.active {
            background: rgba(100, 255, 218, 0.2);
            border-color: #64ffda;
            color: #64ffda;
        }
        
        .faq-category {
            display: none;
        }
        
        .faq-category.active {
            display: block;
        }
        
        .faq-item {
            cursor: pointer;
        }
        
        .faq-question {
            padding: 1rem 0;
            border: none;
            background: none;
        }
        
        .faq-answer {
            display: none;
            padding: 1rem 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .faq-icon {
            font-size: 1.5rem;
            font-weight: bold;
            transition: transform 0.3s ease;
        }
    </style>
</body>
</html> 