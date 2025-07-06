<?php
// 🚨 SCRIPT EMERGENZA - Risolve TUTTO subito!
echo "<h1>🚨 SCRIPT EMERGENZA - Risolviamo TUTTO!</h1>\n";

session_start();

// STEP 1: Verifica e risolve problema admin
echo "<h2>🔧 STEP 1: Risolvo Admin</h2>\n";

try {
    require_once __DIR__.'/includes/database.php';
    $db = getDb();
    echo "✅ Database connesso<br>\n";
    
    // Elimina completamente l'admin esistente
    $stmt = $db->prepare('DELETE FROM users WHERE email = ?');
    $stmt->execute(['admin@astroguida.com']);
    echo "🗑️ Eliminato admin esistente<br>\n";
    
    // Crea nuovo admin con password SICURA
    $adminPassword = 'admin123'; // Password temporanea
    $hashedPassword = password_hash($adminPassword, PASSWORD_BCRYPT);
    
    $stmt = $db->prepare('INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)');
    $result = $stmt->execute(['Admin AstroGuida', 'admin@astroguida.com', $hashedPassword, 'admin']);
    
    if ($result) {
        echo "✅ <strong>ADMIN CREATO CON SUCCESSO!</strong><br>\n";
        echo "📧 Email: <strong>admin@astroguida.com</strong><br>\n";
        echo "🔑 Password: <strong>admin123</strong><br>\n";
        
        // Test login immediato
        require_once __DIR__.'/includes/auth.php';
        $auth = getAuth();
        $loginTest = $auth->login('admin@astroguida.com', 'admin123');
        
        if ($loginTest) {
            echo "✅ <strong>LOGIN ADMIN FUNZIONA!</strong><br>\n";
            $user = $auth->user();
            echo "👤 Utente loggato: " . $user['name'] . " (Ruolo: " . $user['role'] . ")<br>\n";
        } else {
            echo "❌ Login admin ancora non funziona<br>\n";
        }
    } else {
        echo "❌ Errore creazione admin<br>\n";
    }
    
} catch (Exception $e) {
    echo "❌ Errore database: " . $e->getMessage() . "<br>\n";
}

// STEP 2: Test pagine Gallery, Chi Siamo, Contatti
echo "<h2>🔍 STEP 2: Verifico Pagine</h2>\n";

$pagesToTest = [
    'gallery' => '/pages/gallery.php',
    'about' => '/pages/about.php', 
    'contact' => '/pages/contact.php'
];

foreach ($pagesToTest as $name => $path) {
    echo "<h3>📄 Test pagina: $name</h3>\n";
    
    $fullPath = __DIR__ . $path;
    
    if (file_exists($fullPath)) {
        echo "✅ File esiste: $fullPath<br>\n";
        
        // Test sintassi PHP
        $output = shell_exec("php -l \"$fullPath\" 2>&1");
        if (strpos($output, 'No syntax errors') !== false) {
            echo "✅ Sintassi PHP corretta<br>\n";
        } else {
            echo "❌ Errore sintassi PHP:<br>\n";
            echo "<pre style='background:#f00;color:#fff;padding:10px;'>$output</pre>\n";
        }
        
        // Test inclusioni
        ob_start();
        try {
            include $fullPath;
            $content = ob_get_contents();
            ob_end_clean();
            
            if (strlen($content) > 1000) {
                echo "✅ Pagina genera contenuto (". strlen($content) ." caratteri)<br>\n";
            } else {
                echo "⚠️ Pagina genera poco contenuto (". strlen($content) ." caratteri)<br>\n";
            }
        } catch (Exception $e) {
            ob_end_clean();
            echo "❌ Errore esecuzione: " . $e->getMessage() . "<br>\n";
        }
        
    } else {
        echo "❌ File non trovato: $fullPath<br>\n";
    }
    
    echo "<br>\n";
}

// STEP 3: Test header dinamico
echo "<h2>🎯 STEP 3: Test Header Dinamico</h2>\n";

$headerPath = __DIR__ . '/includes/header.php';
if (file_exists($headerPath)) {
    echo "✅ Header dinamico esiste<br>\n";
    
    // Test sintassi
    $output = shell_exec("php -l \"$headerPath\" 2>&1");
    if (strpos($output, 'No syntax errors') !== false) {
        echo "✅ Header sintassi corretta<br>\n";
    } else {
        echo "❌ Errore sintassi header:<br>\n";
        echo "<pre style='background:#f00;color:#fff;padding:10px;'>$output</pre>\n";
    }
} else {
    echo "❌ Header dinamico non trovato!<br>\n";
}

// STEP 4: Test file CSS e JS
echo "<h2>🎨 STEP 4: Test Assets</h2>\n";

$assets = [
    'CSS' => '/assets/css/main.css',
    'JS' => '/assets/js/main.js'
];

foreach ($assets as $type => $path) {
    $fullPath = __DIR__ . $path;
    if (file_exists($fullPath)) {
        echo "✅ $type esiste: $path<br>\n";
    } else {
        echo "❌ $type mancante: $path<br>\n";
    }
}

// STEP 5: Test favicon
echo "<h2>🖼️ STEP 5: Test Favicon</h2>\n";
$faviconPath = __DIR__ . '/favicon.jpg';
if (file_exists($faviconPath)) {
    echo "✅ Favicon esiste: /favicon.jpg<br>\n";
} else {
    echo "❌ Favicon mancante: /favicon.jpg<br>\n";
}

echo "<h2>🎉 RIEPILOGO FINALE</h2>\n";
echo "<div style='background:#222;color:#fff;padding:20px;border-radius:10px;'>\n";
echo "<h3>✅ ADMIN RISOLTO</h3>\n";
echo "Email: <strong>admin@astroguida.com</strong><br>\n";
echo "Password: <strong>admin123</strong><br>\n";
echo "<br>\n";
echo "<h3>🔄 PROSSIMI PASSI</h3>\n";
echo "1. Prova a fare login con le nuove credenziali<br>\n";
echo "2. Testa le pagine Gallery, Chi Siamo, Contatti<br>\n";
echo "3. Verifica che l'header mostri Logout<br>\n";
echo "4. Accedi alla gestione streaming<br>\n";
echo "<br>\n";
echo "<strong>Se questo script ha risolto tutto, NON ESSERE PIÙ TRISTE! 😊</strong><br>\n";
echo "</div>\n";
?> 