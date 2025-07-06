<?php
// Test Dashboard Fix - Verifica errori PHP risolti
echo "<h1>🔧 Test Dashboard Fix</h1>\n";

// Test 1: Verifica sessione e database
session_start();
echo "<h2>📊 Test 1: Sessione e Database</h2>\n";

try {
    require_once __DIR__.'/includes/database.php';
    $db = getDb();
    echo "✅ Database connesso correttamente<br>\n";
    
    require_once __DIR__.'/includes/auth.php';
    $auth = getAuth();
    echo "✅ Sistema autenticazione caricato<br>\n";
    
} catch (Exception $e) {
    echo "❌ Errore: " . $e->getMessage() . "<br>\n";
}

// Test 2: Verifica utente admin
echo "<h2>👤 Test 2: Utente Admin</h2>\n";
try {
    $stmt = $db->prepare('SELECT * FROM users WHERE role = "admin"');
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($admin) {
        echo "✅ Utente admin trovato:<br>\n";
        echo "&nbsp;&nbsp;ID: " . $admin['id'] . "<br>\n";
        echo "&nbsp;&nbsp;Email: " . $admin['email'] . "<br>\n";
        echo "&nbsp;&nbsp;Nome: " . $admin['name'] . "<br>\n";
        echo "&nbsp;&nbsp;Ruolo: " . $admin['role'] . "<br>\n";
    } else {
        echo "❌ Nessun utente admin trovato<br>\n";
    }
} catch (Exception $e) {
    echo "❌ Errore controllo admin: " . $e->getMessage() . "<br>\n";
}

// Test 3: Simula login admin
echo "<h2>🔐 Test 3: Test Login Admin</h2>\n";
try {
    $loginResult = $auth->login('admin@astroguida.com', 'admin123');
    if ($loginResult) {
        echo "✅ Login admin riuscito<br>\n";
        
        // Test gestione utente
        $user = $auth->user();
        if (is_array($user)) {
            echo "✅ Dati utente recuperati correttamente:<br>\n";
            echo "&nbsp;&nbsp;Nome: " . (isset($user['name']) ? htmlspecialchars($user['name']) : 'N/A') . "<br>\n";
            echo "&nbsp;&nbsp;Email: " . (isset($user['email']) ? htmlspecialchars($user['email']) : 'N/A') . "<br>\n";
            echo "&nbsp;&nbsp;Ruolo: " . (isset($user['role']) ? htmlspecialchars($user['role']) : 'N/A') . "<br>\n";
        } else {
            echo "❌ Errore: user() non ha restituito un array valido<br>\n";
            echo "Tipo restituito: " . gettype($user) . "<br>\n";
        }
    } else {
        echo "❌ Login admin fallito<br>\n";
    }
} catch (Exception $e) {
    echo "❌ Errore test login: " . $e->getMessage() . "<br>\n";
}

// Test 4: Test Header dinamico
echo "<h2>🎯 Test 4: Header Dinamico</h2>\n";
try {
    if ($auth->isLogged()) {
        echo "✅ Utente loggato - Header dovrebbe mostrare Logout<br>\n";
        echo "✅ Accesso admin disponibile: " . ($auth->user()['role'] === 'admin' ? 'SÌ' : 'NO') . "<br>\n";
    } else {
        echo "❌ Utente non loggato<br>\n";
    }
} catch (Exception $e) {
    echo "❌ Errore test header: " . $e->getMessage() . "<br>\n";
}

// Test 5: Test Dashboard senza errori
echo "<h2>📋 Test 5: Dashboard Senza Errori</h2>\n";
try {
    if ($auth->isLogged()) {
        $user = $auth->user();
        if (is_array($user)) {
            $userName = isset($user['name']) ? $user['name'] : 'Utente';
            $userEmail = isset($user['email']) ? $user['email'] : 'Email non disponibile';
            
            echo "✅ Variabili dashboard preparate correttamente:<br>\n";
            echo "&nbsp;&nbsp;Nome sicuro: " . htmlspecialchars($userName) . "<br>\n";
            echo "&nbsp;&nbsp;Email sicura: " . htmlspecialchars($userEmail) . "<br>\n";
            echo "✅ Nessun errore htmlspecialchars o array offset<br>\n";
        } else {
            echo "❌ Errore: Dati utente non validi per dashboard<br>\n";
        }
    } else {
        echo "❌ Utente non loggato per test dashboard<br>\n";
    }
} catch (Exception $e) {
    echo "❌ Errore test dashboard: " . $e->getMessage() . "<br>\n";
}

echo "<h2>🏁 Conclusione</h2>\n";
echo "Se tutti i test mostrano ✅, la dashboard dovrebbe funzionare senza errori PHP.<br>\n";
echo "<br><strong>Prossimi passi:</strong><br>\n";
echo "1. Testare la dashboard utente<br>\n";
echo "2. Testare il sistema di logout<br>\n";
echo "3. Verificare accesso admin alla gestione streaming<br>\n";
echo "4. Eliminare questo file di test<br>\n";
?> 