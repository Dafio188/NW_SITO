<?php
/**
 * Script per verificare e creare l'utente amministratore
 */
require_once __DIR__ . '/includes/config.php';

echo "=== VERIFICA UTENTE AMMINISTRATORE ===\n\n";

if (!$pdo) {
    echo "❌ ERRORE: Database non disponibile\n";
    exit(1);
}

try {
    // Verifica se esiste l'utente admin
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute(['admin@astroguida.com']);
    $admin_user = $stmt->fetch();
    
    if ($admin_user) {
        echo "✅ Utente admin trovato:\n";
        echo "   - ID: " . $admin_user['id'] . "\n";
        echo "   - Email: " . $admin_user['email'] . "\n";
        echo "   - Nome: " . $admin_user['name'] . "\n";
        echo "   - Ruolo: " . $admin_user['role'] . "\n";
        echo "   - Creato: " . $admin_user['created_at'] . "\n";
        
        // Verifica password
        if (password_verify('admin', $admin_user['password'])) {
            echo "✅ Password corretta\n";
        } else {
            echo "❌ Password non corretta, aggiorno...\n";
            $new_password = password_hash('admin', PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->execute([$new_password, $admin_user['id']]);
            echo "✅ Password aggiornata\n";
        }
        
        // Verifica ruolo admin
        if ($admin_user['role'] !== 'admin') {
            echo "❌ Ruolo non admin, aggiorno...\n";
            $stmt = $pdo->prepare("UPDATE users SET role = 'admin' WHERE id = ?");
            $stmt->execute([$admin_user['id']]);
            echo "✅ Ruolo aggiornato ad admin\n";
        }
        
    } else {
        echo "❌ Utente admin non trovato, lo creo...\n";
        
        // Crea utente admin
        $password_hash = password_hash('admin', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("
            INSERT INTO users (email, password, name, role, created_at) 
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            'admin@astroguida.com',
            $password_hash,
            'Amministratore',
            'admin',
            date('Y-m-d H:i:s')
        ]);
        
        echo "✅ Utente admin creato con successo!\n";
        echo "   - Email: admin@astroguida.com\n";
        echo "   - Password: admin\n";
        echo "   - Ruolo: admin\n";
    }
    
    echo "\n=== VERIFICA TABELLA USERS ===\n";
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
    $count = $stmt->fetch();
    echo "Totale utenti nel database: " . $count['total'] . "\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM users WHERE role = 'admin'");
    $admin_count = $stmt->fetch();
    echo "Totale amministratori: " . $admin_count['total'] . "\n";
    
    echo "\n=== LISTA UTENTI ===\n";
    $stmt = $pdo->query("SELECT id, email, name, role, created_at FROM users ORDER BY id");
    $users = $stmt->fetchAll();
    
    foreach ($users as $user) {
        echo "- ID: {$user['id']} | Email: {$user['email']} | Nome: {$user['name']} | Ruolo: {$user['role']}\n";
    }
    
    echo "\n=== CREDENZIALI ADMIN ===\n";
    echo "Email: admin@astroguida.com\n";
    echo "Password: admin\n";
    echo "URL Login: " . SITE_URL . "/?page=login\n";
    echo "Dashboard: " . SITE_URL . "/admin/\n";
    echo "Streaming: " . SITE_URL . "/admin/streaming-settings.php\n";
    
    echo "\n✅ VERIFICA COMPLETATA\n";
    
} catch (Exception $e) {
    echo "❌ ERRORE: " . $e->getMessage() . "\n";
    echo "Traccia: " . $e->getTraceAsString() . "\n";
}
?> 