<?php
/**
 * Header Dinamico Universale AstroGuida
 * Gestisce automaticamente Login/Logout e logo
 */

// Assicurati che la sessione sia avviata
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Determina la pagina corrente
$current_page = $_GET['page'] ?? 'home';

// Verifica se l'utente è loggato
$is_logged = isset($_SESSION['user_id']);
$user_name = $_SESSION['user_name'] ?? '';
$user_role = $_SESSION['user_role'] ?? 'user';

// Funzione per determinare se una pagina è attiva
function isActivePage($page, $current) {
    return $page === $current ? 'active' : '';
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

        <div class="header-actions">
            <?php if ($is_logged): ?>
                <!-- Utente loggato -->
                <?php if ($user_role === 'admin'): ?>
                    <a href="/admin/" class="btn btn-secondary btn-sm">
                        🎛️ Admin
                    </a>
                <?php else: ?>
                    <a href="/?page=booking" class="btn btn-primary btn-sm">
                        🚀 Prenota
                    </a>
                <?php endif; ?>
                
                <a href="/?page=dashboard" class="btn btn-ghost btn-sm">
                    📊 Dashboard
                </a>
                
                <div class="user-menu">
                    <div class="user-avatar" title="<?= htmlspecialchars($user_name) ?>">
                        <?= strtoupper(substr($user_name, 0, 1)) ?>
                    </div>
                    <div class="user-dropdown">
                        <a href="/?page=dashboard">👤 Profilo</a>
                        <?php if ($user_role === 'admin'): ?>
                            <a href="/admin/">🎛️ Admin Panel</a>
                            <a href="/admin/streaming-settings.php">🎥 Streaming</a>
                        <?php endif; ?>
                        <a href="/?page=logout">🚪 Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <!-- Utente non loggato -->
                <a href="/?page=booking" class="btn btn-primary btn-sm">
                    🚀 Prenota
                </a>
                <a href="/?page=login" class="btn btn-ghost btn-sm">
                    👤 Login
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>

<style>
.user-menu {
    position: relative;
    display: inline-block;
}

.user-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, #007aff, #64ffda);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    margin-left: 10px;
}

.user-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    background: rgba(26, 26, 46, 0.95);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    padding: 8px 0;
    min-width: 160px;
    display: none;
    z-index: 1000;
    backdrop-filter: blur(20px);
}

.user-menu:hover .user-dropdown {
    display: block;
}

.user-dropdown a {
    display: block;
    padding: 8px 16px;
    color: #f5f5f7;
    text-decoration: none;
    font-size: 14px;
    transition: background 0.2s ease;
}

.user-dropdown a:hover {
    background: rgba(255, 255, 255, 0.1);
}
</style> 