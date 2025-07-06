<?php 
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';

$auth = getAuth();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$auth->checkCsrf($_POST['csrf_token'] ?? '')) {
        $error = 'Token CSRF non valido.';
    } elseif (!$auth->checkRateLimit($_POST['email'] ?? '')) {
        $error = 'Troppi tentativi, riprova tra qualche minuto.';
    } else {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        if ($auth->login($email, $password)) {
            header('Location: /?page=dashboard');
            exit;
        } else {
            $error = 'Email o password errati.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accedi - AstroGuida</title>
    <meta name="description" content="Accedi al tuo account AstroGuida per gestire le prenotazioni e accedere alla gallery completa.">
    
    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/main.css">
    
    <!-- Favicon -->
    <link rel="icon" href="/favicon.jpg">
    
    <!-- Open Graph -->
    <meta property="og:title" content="Accedi - AstroGuida">
    <meta property="og:description" content="Accedi al tuo account AstroGuida">
    <meta property="og:image" content="/assets/images/logo/astroguida-logo.jpg">
    <meta property="og:url" content="<?= SITE_URL ?>/?page=login">
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
                    <a href="/?page=services" class="nav-link">Servizi</a>
                    <a href="/?page=gallery" class="nav-link">Gallery</a>
                    <a href="/?page=live-sky" class="nav-link">Live Sky</a>
                    <a href="/?page=about" class="nav-link">Chi Siamo</a>
                    <a href="/?page=contact" class="nav-link">Contatti</a>
                </nav>
                
                <div class="user-menu">
                    <a href="/?page=login" class="btn btn-primary btn-sm">Accedi</a>
                    <a href="/?page=register" class="btn btn-ghost btn-sm">Registrati</a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="auth-container">
            <!-- Hero Section -->
            <section class="hero">
                <div class="hero-content">
                    <h1 class="hero-title fade-in-up">
                        Accedi al tuo <span class="highlight cosmic-text-bright">Account</span>
                    </h1>
                    <p class="hero-subtitle fade-in-up" style="animation-delay: 0.2s;">
                        Effettua il login per gestire le tue prenotazioni e accedere alla gallery completa.
                    </p>
                </div>
            </section>

            <!-- Login Form -->
            <section class="section">
                <div class="container">
                    <div class="auth-form">
                        <div class="form-title">
                            🌟 Benvenuto su AstroGuida
                        </div>
                        
                        <?php if($error): ?>
                            <div class="alert alert-error mb-6">
                                ❌ <?= htmlspecialchars($error) ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Google Login -->
                        <a href="/api/google_login.php" class="google-login-btn">
                            <svg width="20" height="20" viewBox="0 0 24 24">
                                <path fill="#4285f4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34a853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#fbbc05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#ea4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            Accedi con Google
                        </a>
                        
                        <div class="divider">
                            <span>oppure</span>
                        </div>
                        
                        <!-- Email Login Form -->
                        <form method="post" action="">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($auth->csrfToken()) ?>">
                            
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       class="form-input" 
                                       placeholder="inserisci la tua email"
                                       required 
                                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       class="form-input" 
                                       placeholder="inserisci la tua password"
                                       required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-full">
                                🚀 Accedi
                            </button>
                        </form>
                        
                        <!-- Links -->
                        <div class="auth-links">
                            <p class="text-center">
                                <a href="/?page=reset_password" class="text-cyan hover:text-white">
                                    Password dimenticata?
                                </a>
                            </p>
                            <p class="text-center">
                                Non hai un account? 
                                <a href="/?page=register" class="text-cyan hover:text-white font-semibold">
                                    Registrati qui
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </div>

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
                            <li><a href="/?page=services">Astrofotografia</a></li>
                            <li><a href="/?page=services">Turismo Astronomico</a></li>
                            <li><a href="/?page=services">Osservazione Guidata</a></li>
                            <li><a href="/?page=services">Corsi di Astronomia</a></li>
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

        // Form validation
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            
            form.addEventListener('submit', function(e) {
                let valid = true;
                
                // Email validation
                if (!emailInput.value || !emailInput.validity.valid) {
                    valid = false;
                    emailInput.style.borderColor = '#ff453a';
                } else {
                    emailInput.style.borderColor = '';
                }
                
                // Password validation
                if (!passwordInput.value || passwordInput.value.length < 6) {
                    valid = false;
                    passwordInput.style.borderColor = '#ff453a';
                } else {
                    passwordInput.style.borderColor = '';
                }
                
                if (!valid) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html> 