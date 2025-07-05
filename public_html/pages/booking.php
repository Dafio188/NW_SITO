<?php /* Prenotazione AstroGuida */ ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Prenota - AstroGuida</title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <script defer src="/assets/js/main.js"></script>
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
<section class="hero">
    <h1>Prenota la tua esperienza</h1>
    <p>Compila il modulo per prenotare un servizio astronomico.</p>
</section>
<section>
    <form class="card" method="post" action="">
        <label>Nome e Cognome<br><input class="form-input" type="text" name="name" required></label><br>
        <label>Email<br><input class="form-input" type="email" name="email" required></label><br>
        <label>Servizio<br><select class="form-input" name="service" required><option value="Tour">Tour astronomico</option><option value="Workshop">Workshop astrofotografia</option></select></label><br>
        <label>Data<br><input class="form-input" type="date" name="date" required></label><br>
        <button class="btn btn-primary" type="submit">Prenota ora</button>
    </form>
</section>
<footer>
    &copy; <?php echo date('Y'); ?> AstroGuida.com - Tutti i diritti riservati
</footer>
</body>
</html> 