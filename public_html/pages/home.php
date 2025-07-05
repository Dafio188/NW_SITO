<?php /* Home AstroGuida */ ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>AstroGuida - Astrofotografia & Turismo Astronomico</title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <script defer src="/assets/js/main.js"></script>
    <meta name="description" content="Astrofotografia, turismo astronomico e streaming live dal cielo di Cassano delle Murge. Esperienze, gallery, eventi e servizi unici.">
    <meta property="og:title" content="AstroGuida - Astrofotografia & Turismo Astronomico">
    <meta property="og:description" content="Astrofotografia, turismo astronomico e streaming live dal cielo di Cassano delle Murge.">
    <meta property="og:image" content="/assets/images/logo/logo.png">
    <meta property="og:type" content="website">
    <style>
        .live-widget {background:rgba(0,0,0,0.3);border-radius:16px;padding:18px 24px;margin:32px auto 24px auto;max-width:600px;text-align:center;box-shadow:var(--shadow-medium);}
        .live-widget .live-badge {display:inline-block;background:linear-gradient(90deg,#FF453A,#FF9F0A);color:#fff;padding:4px 16px;border-radius:20px;font-weight:700;letter-spacing:1px;margin-bottom:8px;animation:blink 1s infinite alternate;}
        @keyframes blink {0%{opacity:1;}100%{opacity:0.7;}}
        .live-widget img {max-width:100%;border-radius:12px;margin:12px 0;box-shadow:var(--shadow-soft);}
        .live-widget a {display:inline-block;margin-top:8px;font-weight:600;color:var(--blue-primary);text-decoration:none;}
    </style>
</head>
<body>
    <header>
        <img src="/assets/images/logo/logo.png" alt="AstroGuida Logo" style="height:48px;">
        <nav>
            <a href="/">Home</a>
            <a href="/gallery">Gallery</a>
            <a href="/booking">Prenota</a>
            <a href="/login">Login</a>
        </nav>
    </header>
    <main>
        <section class="live-widget">
            <div class="live-badge">LIVE NOW</div>
            <h2>Streaming dal cielo di Cassano delle Murge</h2>
            <img src="https://img.youtube.com/vi/YOUR_VIDEO_ID/hqdefault.jpg" alt="Anteprima Live Sky">
            <p>Guarda il cielo in diretta! <a href="/?page=live_sky">Vai alla diretta &rarr;</a></p>
        </section>
        <section class="hero">
            <h1>Benvenuto su AstroGuida</h1>
            <p>Astrofotografia, turismo astronomico e streaming live dal cielo di Cassano delle Murge.</p>
            <a class="btn btn-primary" href="/booking">Prenota la tua esperienza</a>
        </section>
        <section class="services-preview">
            <h2>I nostri servizi</h2>
            <p>Scopri le nostre esperienze di osservazione, fotografia e consulenza astronomica.</p>
        </section>
        <section class="gallery-preview">
            <h2>Gallery Astrofotografica</h2>
            <p>Le nostre migliori foto di galassie e nebulose.</p>
        </section>
        <section class="about-preview">
            <h2>Chi siamo</h2>
            <p>Passione per il cielo, tecnologia e divulgazione scientifica.</p>
        </section>
    </main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> AstroGuida.com - Tutti i diritti riservati</p>
    </footer>
</body>
</html> 