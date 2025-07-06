<?php 
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';

$auth = getAuth();
$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$auth->checkCsrf($_POST['csrf_token'] ?? '')) {
        $error = 'Token CSRF non valido.';
    } else {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        if (!$name || !$email || !$password || !$confirm_password) {
            $error = 'Tutti i campi sono obbligatori.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Email non valida.';
        } elseif ($password !== $confirm_password) {
            $error = 'Le password non coincidono.';
        } elseif (strlen($password) < 6) {
            $error = 'La password deve essere di almeno 6 caratteri.';
        } elseif ($auth->register($name, $email, $password)) {
            $success = true;
        } else {
            $error = 'Email già registrata o errore durante la registrazione.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrati - AstroGuida</title>
    <meta name="description" content="Crea un account AstroGuida per prenotare servizi di astrofotografia e accedere alla gallery completa.">
    
    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/main.css">
    
    <!-- Favicon -->
    <link rel="icon" href="/favicon.jpg">
    
    <!-- Open Graph -->
    <meta property="og:title" content="Registrati - AstroGuida">
    <meta property="og:description" content="Crea un account AstroGuida">
    <meta property="og:image" content="/assets/images/logo/astroguida-logo.jpg">
    <meta property="og:url" content="<?= SITE_URL ?>/?page=register">
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
                    <a href="/?page=login" class="btn btn-ghost btn-sm">Accedi</a>
                    <a href="/?page=register" class="btn btn-primary btn-sm">Registrati</a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="auth-container">
            <!-- Hero Section -->
            <section class="hero">
                <div class="hero-content">
                    <h1 class="hero-title fade-in-up">
                        Unisciti alla <span class="highlight cosmic-text-bright">Community</span>
                    </h1>
                    <p class="hero-subtitle fade-in-up" style="animation-delay: 0.2s;">
                        Registrati per prenotare servizi di astrofotografia e accedere alla gallery completa.
                    </p>
                </div>
            </section>

            <!-- Register Form -->
            <section class="section">
                <div class="container">
                    <div class="auth-form">
                        <?php if($success): ?>
                            <div class="success-message">
                                <div class="text-6xl mb-6">🎉</div>
                                <div class="form-title">
                                    Registrazione Completata!
                                </div>
                                <div class="alert alert-success mb-6">
                                    ✅ Account creato con successo! Ora puoi accedere.
                                </div>
                                <div class="flex gap-4 justify-center">
                                    <a href="/?page=login" class="btn btn-primary">
                                        🚀 Accedi Ora
                                    </a>
                                    <a href="/" class="btn btn-secondary">
                                        🏠 Torna Home
                                    </a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="form-title">
                                🌟 Crea il tuo Account
                            </div>
                            
                            <?php if($error): ?>
                                <div class="alert alert-error mb-6">
                                    ❌ <?= htmlspecialchars($error) ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Registration Form -->
                            <form method="post" action="">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($auth->csrfToken()) ?>">
                                
                                <div class="form-group">
                                    <label for="name" class="form-label">Nome e Cognome</label>
                                    <input type="text" 
                                           id="name" 
                                           name="name" 
                                           class="form-input" 
                                           placeholder="inserisci nome e cognome"
                                           required 
                                           value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                                </div>
                                
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
                                           placeholder="minimo 6 caratteri"
                                           required>
                                    <div class="form-help">
                                        La password deve essere di almeno 6 caratteri
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="confirm_password" class="form-label">Conferma Password</label>
                                    <input type="password" 
                                           id="confirm_password" 
                                           name="confirm_password" 
                                           class="form-input" 
                                           placeholder="ripeti la password"
                                           required>
                                </div>
                                
                                <div class="form-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" required>
                                        <span class="checkmark"></span>
                                        Accetto i <a href="/?page=terms" class="text-cyan hover:text-white">Termini di Servizio</a> 
                                        e la <a href="/?page=privacy" class="text-cyan hover:text-white">Privacy Policy</a>
                                    </label>
                                </div>
                                
                                <button type="submit" class="btn btn-primary w-full">
                                    🚀 Crea Account
                                </button>
                            </form>
                            
                            <!-- Links -->
                            <div class="auth-links">
                                <p class="text-center">
                                    Hai già un account? 
                                    <a href="/?page=login" class="text-cyan hover:text-white font-semibold">
                                        Accedi qui
                                    </a>
                                </p>
                            </div>
                        <?php endif; ?>
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
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirm_password');
            
            // Real-time password matching
            function checkPasswordMatch() {
                if (passwordInput.value && confirmPasswordInput.value) {
                    if (passwordInput.value === confirmPasswordInput.value) {
                        confirmPasswordInput.style.borderColor = '#30d158';
                        passwordInput.style.borderColor = '#30d158';
                    } else {
                        confirmPasswordInput.style.borderColor = '#ff453a';
                        passwordInput.style.borderColor = '#ff453a';
                    }
                }
            }
            
            passwordInput.addEventListener('input', checkPasswordMatch);
            confirmPasswordInput.addEventListener('input', checkPasswordMatch);
            
            // Form submission validation
            form.addEventListener('submit', function(e) {
                let valid = true;
                
                // Name validation
                if (!nameInput.value || nameInput.value.length < 2) {
                    valid = false;
                    nameInput.style.borderColor = '#ff453a';
                } else {
                    nameInput.style.borderColor = '';
                }
                
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
                
                // Password confirmation
                if (passwordInput.value !== confirmPasswordInput.value) {
                    valid = false;
                    confirmPasswordInput.style.borderColor = '#ff453a';
                } else {
                    confirmPasswordInput.style.borderColor = '';
                }
                
                if (!valid) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html> 