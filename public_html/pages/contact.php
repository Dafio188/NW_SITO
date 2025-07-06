<?php
require_once __DIR__ . '/../includes/config.php';

$success_message = '';
$error_message = '';

// Gestione invio form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Validazione
    if (empty($name) || empty($email) || empty($message)) {
        $error_message = 'Tutti i campi obbligatori devono essere compilati.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Indirizzo email non valido.';
    } else {
        // Preparazione email
        $to = 'info@astroguida.com';
        $email_subject = 'Nuovo messaggio da ' . $name . ' - ' . $subject;
        $email_body = "Nome: $name\n";
        $email_body .= "Email: $email\n";
        $email_body .= "Telefono: $phone\n";
        $email_body .= "Oggetto: $subject\n\n";
        $email_body .= "Messaggio:\n$message\n\n";
        $email_body .= "Inviato da: " . $_SERVER['HTTP_HOST'] . "\n";
        $email_body .= "Data: " . date('Y-m-d H:i:s') . "\n";
        
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        // Invio email (in produzione usare PHPMailer)
        if (mail($to, $email_subject, $email_body, $headers)) {
            $success_message = 'Messaggio inviato con successo! Ti risponderemo presto.';
        } else {
            $error_message = 'Errore nell\'invio del messaggio. Riprova più tardi.';
        }
    }
}
?><!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contatti - Scrivici | AstroGuida</title>
    <meta name="description" content="Contatta AstroGuida per informazioni sui nostri servizi di astrofotografia e turismo astronomico. Siamo qui per aiutarti a organizzare la tua esperienza stellare.">
    <meta name="keywords" content="contatti, informazioni, astrofotografia, turismo astronomico, puglia, telefono, email">
    
    <!-- Open Graph -->
    <meta property="og:title" content="Contatti - Scrivici | AstroGuida">
    <meta property="og:description" content="Contatta AstroGuida per informazioni sui nostri servizi">
    <meta property="og:image" content="/assets/images/logo/astroguida-logo.jpg">
    <meta property="og:url" content="<?= SITE_URL ?>/?page=contact">
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
        <?php include __DIR__ . '/../includes/header.php'; ?>

        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="hero-content text-center">
                    <h1 class="hero-title">
                        Contattaci
                    </h1>
                    <p class="hero-subtitle">
                        Siamo qui per rispondere alle tue domande e aiutarti 
                        a organizzare la tua esperienza astronomica perfetta.
                    </p>
                </div>
            </div>
        </section>

        <!-- Informazioni di Contatto -->
        <section class="section">
            <div class="container">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
                    <div class="card text-center">
                        <div class="w-16 h-16 bg-gradient-primary rounded-full mx-auto mb-4 flex items-center justify-center text-white text-2xl">
                            📱
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">Telefono</h3>
                        <p class="text-silver mb-3">Chiamaci per informazioni immediate</p>
                        <a href="tel:+393123456789" class="text-cyan hover:text-white font-medium">
                            +39 312 345 6789
                        </a>
                    </div>
                    
                    <div class="card text-center">
                        <div class="w-16 h-16 bg-gradient-cosmic rounded-full mx-auto mb-4 flex items-center justify-center text-white text-2xl">
                            📧
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">Email</h3>
                        <p class="text-silver mb-3">Scrivici per domande dettagliate</p>
                        <a href="mailto:info@astroguida.com" class="text-cyan hover:text-white font-medium">
                            info@astroguida.com
                        </a>
                    </div>
                    
                    <div class="card text-center">
                        <div class="w-16 h-16 bg-gradient-success rounded-full mx-auto mb-4 flex items-center justify-center text-white text-2xl">
                            📍
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">Sede</h3>
                        <p class="text-silver mb-3">Vieni a trovarci di persona</p>
                        <p class="text-cyan">
                            Via delle Stelle, 42<br>
                            70100 Bari, Puglia
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Form di Contatto -->
        <section class="section">
            <div class="container">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <div>
                        <div class="section-header">
                            <h2 class="section-title">Invia un Messaggio</h2>
                            <p class="section-subtitle">
                                Compila il form e ti risponderemo entro 24 ore
                            </p>
                        </div>
                        
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
                        
                        <form method="post" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="form-label">Nome *</label>
                                    <input type="text" id="name" name="name" class="form-input" required 
                                           value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                                </div>
                                <div>
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" id="email" name="email" class="form-input" required 
                                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="phone" class="form-label">Telefono</label>
                                    <input type="tel" id="phone" name="phone" class="form-input" 
                                           value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                                </div>
                                <div>
                                    <label for="subject" class="form-label">Oggetto</label>
                                    <select id="subject" name="subject" class="form-select">
                                        <option value="">Seleziona un argomento</option>
                                        <option value="Astrofotografia" <?= ($_POST['subject'] ?? '') === 'Astrofotografia' ? 'selected' : '' ?>>
                                            Astrofotografia
                                        </option>
                                        <option value="Turismo Astronomico" <?= ($_POST['subject'] ?? '') === 'Turismo Astronomico' ? 'selected' : '' ?>>
                                            Turismo Astronomico
                                        </option>
                                        <option value="Osservazione Guidata" <?= ($_POST['subject'] ?? '') === 'Osservazione Guidata' ? 'selected' : '' ?>>
                                            Osservazione Guidata
                                        </option>
                                        <option value="Corsi di Astronomia" <?= ($_POST['subject'] ?? '') === 'Corsi di Astronomia' ? 'selected' : '' ?>>
                                            Corsi di Astronomia
                                        </option>
                                        <option value="Altro" <?= ($_POST['subject'] ?? '') === 'Altro' ? 'selected' : '' ?>>
                                            Altro
                                        </option>
                                    </select>
                                </div>
                            </div>
                            
                            <div>
                                <label for="message" class="form-label">Messaggio *</label>
                                <textarea id="message" name="message" rows="6" class="form-textarea" required 
                                          placeholder="Descrivi la tua richiesta o le tue domande..."><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <p class="text-silver text-sm">
                                    * Campi obbligatori
                                </p>
                                <button type="submit" class="btn btn-primary btn-lg stellar-glow">
                                    📧 Invia Messaggio
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="space-y-8">
                        <!-- Orari -->
                        <div class="card">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-gradient-primary rounded-full flex items-center justify-center text-white text-xl mr-4">
                                    🕐
                                </div>
                                <h3 class="text-xl font-semibold text-white">Orari di Apertura</h3>
                            </div>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-silver">Lunedì - Venerdì</span>
                                    <span class="text-cyan">09:00 - 18:00</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-silver">Sabato</span>
                                    <span class="text-cyan">09:00 - 13:00</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-silver">Domenica</span>
                                    <span class="text-orange">Chiuso</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-silver">Serate Osservative</span>
                                    <span class="text-green">20:00 - 24:00</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tempi di Risposta -->
                        <div class="card">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-gradient-cosmic rounded-full flex items-center justify-center text-white text-xl mr-4">
                                    ⚡
                                </div>
                                <h3 class="text-xl font-semibold text-white">Tempi di Risposta</h3>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <span class="text-green mr-2">📧</span>
                                    <span class="text-silver">Email: entro 24 ore</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-cyan mr-2">📱</span>
                                    <span class="text-silver">Telefono: immediato</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-purple mr-2">💬</span>
                                    <span class="text-silver">WhatsApp: entro 2 ore</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Social Media -->
                        <div class="card">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-gradient-success rounded-full flex items-center justify-center text-white text-xl mr-4">
                                    🌐
                                </div>
                                <h3 class="text-xl font-semibold text-white">Seguici Sui Social</h3>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <a href="#" class="flex items-center text-silver hover:text-cyan transition-colors">
                                    <span class="mr-2">📘</span>
                                    Facebook
                                </a>
                                <a href="#" class="flex items-center text-silver hover:text-purple transition-colors">
                                    <span class="mr-2">📷</span>
                                    Instagram
                                </a>
                                <a href="#" class="flex items-center text-silver hover:text-blue-400 transition-colors">
                                    <span class="mr-2">🐦</span>
                                    Twitter
                                </a>
                                <a href="#" class="flex items-center text-silver hover:text-red-400 transition-colors">
                                    <span class="mr-2">📺</span>
                                    YouTube
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mappa -->
        <section class="section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Come Raggiungerci</h2>
                    <p class="section-subtitle">
                        Siamo situati nel cuore della Puglia, facilmente raggiungibili
                    </p>
                </div>
                
                <div class="card">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-xl font-semibold text-white mb-4">Indicazioni Stradali</h3>
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="w-8 h-8 bg-gradient-primary rounded-full flex items-center justify-center text-white text-sm mr-3 mt-1">
                                        🚗
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-white">In Auto</h4>
                                        <p class="text-silver text-sm">
                                            Autostrada A14, uscita Bari Nord. Seguire le indicazioni 
                                            per il centro città, poi Via delle Stelle.
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="w-8 h-8 bg-gradient-cosmic rounded-full flex items-center justify-center text-white text-sm mr-3 mt-1">
                                        🚂
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-white">In Treno</h4>
                                        <p class="text-silver text-sm">
                                            Stazione di Bari Centrale, poi autobus linea 12 
                                            fino a fermata "Osservatorio".
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="w-8 h-8 bg-gradient-success rounded-full flex items-center justify-center text-white text-sm mr-3 mt-1">
                                        ✈️
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-white">In Aereo</h4>
                                        <p class="text-silver text-sm">
                                            Aeroporto di Bari Palese, poi navetta per la stazione 
                                            centrale e autobus linea 12.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-6 p-4 bg-gradient-primary rounded-lg">
                                <h4 class="font-semibold text-white mb-2">🅿️ Parcheggio Gratuito</h4>
                                <p class="text-white text-sm">
                                    Disponibile parcheggio gratuito per i nostri clienti 
                                    direttamente presso la sede.
                                </p>
                            </div>
                        </div>
                        
                        <div>
                            <!-- Placeholder per mappa -->
                            <div class="bg-gray-800 rounded-lg h-64 lg:h-full flex items-center justify-center">
                                <div class="text-center">
                                    <div class="text-4xl mb-4">🗺️</div>
                                    <p class="text-silver">Mappa Interattiva</p>
                                    <p class="text-silver text-sm">
                                        Via delle Stelle, 42<br>
                                        70100 Bari, Puglia
                                    </p>
                                    <a href="https://maps.google.com/?q=Via+delle+Stelle+42+Bari" 
                                       target="_blank" 
                                       class="btn btn-secondary btn-sm mt-4">
                                        📍 Apri in Google Maps
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Rapide -->
        <section class="section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Domande Frequenti</h2>
                    <p class="section-subtitle">
                        Risposte rapide alle domande più comuni
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="card">
                        <h3 class="font-semibold text-white mb-2">🕐 Quanto dura un'osservazione?</h3>
                        <p class="text-silver text-sm">
                            Le nostre sessioni durano solitamente 2-3 ore, ma possiamo 
                            personalizzare la durata in base alle tue esigenze.
                        </p>
                    </div>
                    
                    <div class="card">
                        <h3 class="font-semibold text-white mb-2">🌙 Cosa succede se è nuvoloso?</h3>
                        <p class="text-silver text-sm">
                            In caso di maltempo, riprogrammiamo la sessione senza costi 
                            aggiuntivi o offriamo il rimborso completo.
                        </p>
                    </div>
                    
                    <div class="card">
                        <h3 class="font-semibold text-white mb-2">👥 Quante persone possono partecipare?</h3>
                        <p class="text-silver text-sm">
                            Accettiamo gruppi da 1 a 8 persone per garantire 
                            un'esperienza personalizzata e di qualità.
                        </p>
                    </div>
                    
                    <div class="card">
                        <h3 class="font-semibold text-white mb-2">📸 Posso portare la mia camera?</h3>
                        <p class="text-silver text-sm">
                            Assolutamente sì! Ti aiuteremo a configurare la tua 
                            attrezzatura per ottenere i migliori risultati.
                        </p>
                    </div>
                </div>
                
                <div class="text-center mt-8">
                    <a href="/?page=faq" class="btn btn-secondary btn-lg">
                        ❓ Vedi Tutte le FAQ
                    </a>
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