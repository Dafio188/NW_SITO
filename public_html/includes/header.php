<?php
/**
 * Header Dinamico Universale AstroGuida
 * Gestisce automaticamente Login/Logout e logo
 * VERSIONE SICURA - Gestisce correttamente valori null
 */

// Assicurati che la sessione sia avviata
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Determina la pagina corrente
$current_page = $_GET['page'] ?? 'home';

// Verifica se l'utente è loggato con controlli sicuri
$is_logged = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
$user_name = isset($_SESSION['user_name']) && !empty($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Utente';
$user_role = isset($_SESSION['user_role']) && !empty($_SESSION['user_role']) ? $_SESSION['user_role'] : 'user';

// Funzione per determinare se una pagina è attiva
function isActivePage($page, $current) {
    return $page === $current ? 'active' : '';
}

// Funzione sicura per htmlspecialchars
function safeHtml($value, $default = '') {
    return htmlspecialchars($value ?? $default, ENT_QUOTES, 'UTF-8');
}
?>

<header class="header">
    <div class="header-content">
        <div class="logo">
            <img src="/favicon.jpg" alt="AstroGuida Logo" class="logo-image">
            <span class="logo-text">AstroGuida</span>
        </div>
        
        <nav class="nav">
            <a href="/" class="nav-link <?= isActivePage('home', $current_page) ?>">Home</a>
            <a href="/?page=services" class="nav-link <?= isActivePage('services', $current_page) ?>">Servizi</a>
            <a href="/?page=gallery" class="nav-link <?= isActivePage('gallery', $current_page) ?>">Gallery</a>
            <a href="/?page=about" class="nav-link <?= isActivePage('about', $current_page) ?>">Chi Siamo</a>
            <a href="/?page=contact" class="nav-link <?= isActivePage('contact', $current_page) ?>">Contatti</a>
            <a href="/?page=live-sky" class="nav-link <?= isActivePage('live-sky', $current_page) ?>">🔴 Live</a>
        </nav>
        
        <div class="user-menu">
            <?php if ($is_logged): ?>
                <a href="/?page=dashboard" class="btn btn-secondary">Dashboard</a>
                <?php if ($user_role === 'admin'): ?>
                    <a href="/?page=admin_dashboard" class="btn btn-admin">Admin</a>
                <?php endif; ?>
                <div class="user-info">
                    <div class="user-avatar" title="<?= safeHtml($user_name) ?>">
                        <?= safeHtml(strtoupper(substr($user_name, 0, 1))) ?>
                    </div>
                    <div class="user-dropdown">
                        <a href="/?page=dashboard">📊 Dashboard</a>
                        <?php if ($user_role === 'admin'): ?>
                            <a href="/?page=admin_dashboard">🎛️ Dashboard Admin</a>
                            <a href="/admin/streaming-settings.php">🎥 Gestione Streaming</a>
                        <?php endif; ?>
                        <a href="/?page=logout">🚪 Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="/?page=login" class="btn btn-primary">Login</a>
                <a href="/?page=register" class="btn btn-secondary">Registrati</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<style>
/* Stili Header Sicuro */
.header {
    background: rgba(0, 0, 0, 0.9);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    padding: 1rem 0;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    transition: all 0.3s ease;
}

.header-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.logo {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: white;
    font-size: 1.5rem;
    font-weight: bold;
}

.logo-image {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    margin-right: 1rem;
    object-fit: cover;
}

.logo-text {
    background: linear-gradient(135deg, #64ffda, #007aff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.nav {
    display: flex;
    align-items: center;
    gap: 2rem;
}

.nav-link {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.nav-link:hover {
    color: #64ffda;
    background: rgba(100, 255, 218, 0.1);
}

.nav-link.active {
    color: #64ffda;
    background: rgba(100, 255, 218, 0.2);
}

.user-menu {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-primary {
    background: linear-gradient(135deg, #007aff, #64ffda);
    color: white;
}

.btn-secondary {
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.btn-admin {
    background: linear-gradient(135deg, #ff6b6b, #ffa726);
    color: white;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}

/* User dropdown styles */
.user-info {
    position: relative;
    cursor: pointer;
}

.user-avatar {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: linear-gradient(135deg, #64ffda, #007aff);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1rem;
    color: white;
    transition: all 0.3s ease;
}

.user-avatar:hover {
    transform: scale(1.1);
    box-shadow: 0 5px 15px rgba(100, 255, 218, 0.3);
}

.user-dropdown {
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    background: rgba(0, 0, 0, 0.95);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    padding: 0.75rem 0;
    min-width: 220px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    z-index: 1000;
}

.user-info:hover .user-dropdown {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.user-dropdown:hover {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.user-dropdown a {
    display: flex;
    align-items: center;
    padding: 0.75rem 1.25rem;
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: all 0.3s ease;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    font-size: 0.9rem;
}

.user-dropdown a:last-child {
    border-bottom: none;
}

.user-dropdown a:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #64ffda;
    padding-left: 1.5rem;
}

.user-dropdown::before {
    content: '';
    position: absolute;
    top: -6px;
    right: 20px;
    width: 12px;
    height: 12px;
    background: rgba(0, 0, 0, 0.95);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-bottom: none;
    border-right: none;
    transform: rotate(45deg);
}

/* Responsive */
@media (max-width: 768px) {
    .header-content {
        padding: 0 1rem;
    }
    
    .nav {
        display: none;
    }
    
    .user-menu {
        gap: 0.5rem;
    }
    
    .btn {
        padding: 0.4rem 0.8rem;
        font-size: 0.9rem;
    }
}
</style> 