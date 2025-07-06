<?php
echo "<h1>🔍 DEBUG PROBLEMI PRENOTAZIONI E EMAIL</h1>";

echo "<style>
    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; margin: 20px; }
    .debug-section { background: #f5f5f5; padding: 15px; margin: 15px 0; border-radius: 8px; }
    .success { color: #28a745; font-weight: bold; }
    .warning { color: #ffc107; font-weight: bold; }
    .error { color: #dc3545; font-weight: bold; }
    .info { color: #17a2b8; font-weight: bold; }
    table { width: 100%; border-collapse: collapse; margin: 10px 0; }
    th, td { padding: 8px; border: 1px solid #ddd; text-align: left; }
    th { background: #007aff; color: white; }
    .fix-button { background: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; margin: 5px; }
</style>";

echo "<div class='debug-section'>";
echo "<h2>📋 DIAGNOSI PROBLEMI</h2>";

// Test 1: Verifica Database
echo "<h3>1. 🗄️ Verifica Struttura Database</h3>";
try {
    require_once __DIR__ . '/includes/database.php';
    $db = getDb();
    
    echo "<h4>Struttura tabella bookings:</h4>";
    $columns = $db->query("PRAGMA table_info(bookings)")->fetchAll();
    
    echo "<table>";
    echo "<tr><th>Colonna</th><th>Tipo</th><th>Presente</th></tr>";
    
    $required_columns = [
        'id' => 'INTEGER',
        'booking_id' => 'TEXT',
        'user_id' => 'INTEGER', 
        'name' => 'TEXT',
        'email' => 'TEXT',
        'phone' => 'TEXT',
        'service_name' => 'TEXT',
        'booking_date' => 'TEXT',
        'booking_time' => 'TEXT',
        'participants' => 'INTEGER',
        'message' => 'TEXT',
        'status' => 'TEXT',
        'total_amount' => 'REAL',
        'payment_status' => 'TEXT',
        'transaction_id' => 'TEXT',
        'created_at' => 'TIMESTAMP'
    ];
    
    $existing_columns = [];
    foreach ($columns as $col) {
        $existing_columns[$col['name']] = $col['type'];
    }
    
    $missing_columns = [];
    foreach ($required_columns as $col_name => $col_type) {
        $exists = isset($existing_columns[$col_name]);
        $status = $exists ? "<span class='success'>✅ Presente</span>" : "<span class='error'>❌ Mancante</span>";
        echo "<tr><td>{$col_name}</td><td>{$col_type}</td><td>{$status}</td></tr>";
        if (!$exists) {
            $missing_columns[] = $col_name;
        }
    }
    echo "</table>";
    
    if (!empty($missing_columns)) {
        echo "<div class='error'>❌ <strong>PROBLEMA:</strong> Colonne mancanti: " . implode(', ', $missing_columns) . "</div>";
        echo "<button class='fix-button' onclick='fixDatabase()'>🔧 Correggi Database</button>";
    } else {
        echo "<div class='success'>✅ <strong>Database OK:</strong> Tutte le colonne presenti</div>";
    }
    
    // Verifica prenotazioni esistenti
    echo "<h4>Prenotazioni nel database:</h4>";
    $bookings = $db->query("SELECT COUNT(*) as count FROM bookings")->fetch();
    echo "<p><strong>Totale prenotazioni:</strong> " . $bookings['count'] . "</p>";
    
    if ($bookings['count'] > 0) {
        echo "<h5>Ultime 5 prenotazioni:</h5>";
        $recent = $db->query("SELECT * FROM bookings ORDER BY id DESC LIMIT 5")->fetchAll();
        echo "<table>";
        echo "<tr><th>ID</th><th>Booking ID</th><th>User ID</th><th>Email</th><th>Servizio</th><th>Data</th><th>Status</th></tr>";
        foreach ($recent as $booking) {
            echo "<tr>";
            echo "<td>" . ($booking['id'] ?? 'N/A') . "</td>";
            echo "<td>" . ($booking['booking_id'] ?? 'N/A') . "</td>";
            echo "<td>" . ($booking['user_id'] ?? 'N/A') . "</td>";
            echo "<td>" . ($booking['email'] ?? 'N/A') . "</td>";
            echo "<td>" . ($booking['service_name'] ?? 'N/A') . "</td>";
            echo "<td>" . ($booking['booking_date'] ?? 'N/A') . "</td>";
            echo "<td>" . ($booking['status'] ?? 'N/A') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
} catch (Exception $e) {
    echo "<div class='error'>❌ <strong>ERRORE DATABASE:</strong> " . $e->getMessage() . "</div>";
}

// Test 2: Verifica Autenticazione
echo "<h3>2. 🔐 Verifica Sistema Autenticazione</h3>";
try {
    require_once __DIR__ . '/includes/auth.php';
    $auth = getAuth();
    
    if ($auth->isLogged()) {
        $user = $auth->currentUser();
        echo "<div class='success'>✅ <strong>Utente loggato:</strong> " . $user['name'] . " (ID: " . $user['id'] . ", Email: " . $user['email'] . ")</div>";
        
        // Verifica prenotazioni utente
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM bookings WHERE user_id = ? OR email = ?");
        $stmt->execute([$user['id'], $user['email']]);
        $user_bookings = $stmt->fetch();
        
        echo "<p><strong>Prenotazioni utente corrente:</strong> " . $user_bookings['count'] . "</p>";
        
        if ($user_bookings['count'] > 0) {
            $stmt = $db->prepare("SELECT * FROM bookings WHERE user_id = ? OR email = ? ORDER BY id DESC");
            $stmt->execute([$user['id'], $user['email']]);
            $bookings = $stmt->fetchAll();
            
            echo "<table>";
            echo "<tr><th>Booking ID</th><th>Servizio</th><th>Data</th><th>Status</th><th>Importo</th></tr>";
            foreach ($bookings as $booking) {
                echo "<tr>";
                echo "<td>" . ($booking['booking_id'] ?? 'N/A') . "</td>";
                echo "<td>" . ($booking['service_name'] ?? 'N/A') . "</td>";
                echo "<td>" . ($booking['booking_date'] ?? 'N/A') . "</td>";
                echo "<td>" . ($booking['status'] ?? 'N/A') . "</td>";
                echo "<td>€" . number_format($booking['total_amount'] ?? 0, 2) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        
    } else {
        echo "<div class='warning'>⚠️ <strong>Nessun utente loggato</strong> - <a href='/?page=login'>Effettua il login</a></div>";
    }
    
} catch (Exception $e) {
    echo "<div class='error'>❌ <strong>ERRORE AUTENTICAZIONE:</strong> " . $e->getMessage() . "</div>";
}

// Test 3: Verifica Sistema Email
echo "<h3>3. 📧 Verifica Sistema Email</h3>";
$email_files = [
    'includes/email_service.php' => 'Servizio Email',
    'includes/PHPMailer-master/src/PHPMailer.php' => 'PHPMailer'
];

echo "<table>";
echo "<tr><th>File</th><th>Presente</th><th>Status</th></tr>";
foreach ($email_files as $file => $description) {
    $exists = file_exists(__DIR__ . '/' . $file);
    $status = $exists ? "<span class='success'>✅ Presente</span>" : "<span class='error'>❌ Mancante</span>";
    echo "<tr><td>{$description}</td><td>{$file}</td><td>{$status}</td></tr>";
}
echo "</table>";

// Test configurazione email
if (file_exists(__DIR__ . '/includes/email_service.php')) {
    echo "<h4>Test Configurazione Email:</h4>";
    try {
        require_once __DIR__ . '/includes/email_service.php';
        echo "<div class='success'>✅ <strong>EmailService caricato correttamente</strong></div>";
        
        // Test creazione istanza
        $emailService = getEmailService();
        echo "<div class='success'>✅ <strong>Istanza EmailService creata</strong></div>";
        
    } catch (Exception $e) {
        echo "<div class='error'>❌ <strong>ERRORE EMAIL:</strong> " . $e->getMessage() . "</div>";
    }
} else {
    echo "<div class='error'>❌ <strong>File email_service.php mancante</strong></div>";
}

// Test 4: Verifica Pagine
echo "<h3>4. 📄 Verifica Pagine Critiche</h3>";
$critical_pages = [
    'pages/booking.php' => 'Pagina Prenotazioni',
    'pages/user_bookings.php' => 'Dashboard Prenotazioni Utente',
    'pages/register.php' => 'Registrazione',
    'paypal-success.php' => 'Successo PayPal'
];

echo "<table>";
echo "<tr><th>Pagina</th><th>File</th><th>Status</th></tr>";
foreach ($critical_pages as $file => $description) {
    $exists = file_exists(__DIR__ . '/' . $file);
    $status = $exists ? "<span class='success'>✅ Presente</span>" : "<span class='error'>❌ Mancante</span>";
    echo "<tr><td>{$description}</td><td>{$file}</td><td>{$status}</td></tr>";
}
echo "</table>";

// Test 5: Simulazione Prenotazione
echo "<h3>5. 🧪 Test Simulazione Prenotazione</h3>";
if ($auth->isLogged()) {
    echo "<form method='post' action='debug-booking-test.php'>";
    echo "<p><strong>Testa una prenotazione:</strong></p>";
    echo "<input type='text' name='test_service' placeholder='Nome servizio' value='Test Osservazione' style='margin: 5px; padding: 8px;'>";
    echo "<input type='date' name='test_date' value='" . date('Y-m-d', strtotime('+1 day')) . "' style='margin: 5px; padding: 8px;'>";
    echo "<button type='submit' class='fix-button'>🧪 Testa Prenotazione</button>";
    echo "</form>";
} else {
    echo "<p class='warning'>⚠️ Effettua il login per testare le prenotazioni</p>";
}

echo "</div>";

// JavaScript per fix database
echo "<script>
function fixDatabase() {
    if (confirm('Vuoi correggere la struttura del database?')) {
        window.location.href = 'fix-database-schema-emergency.php';
    }
}
</script>";

echo "<h2>🔗 LINK UTILI</h2>";
echo "<ul>";
echo "<li><a href='/?page=booking' target='_blank'><strong>📝 Pagina Booking</strong></a></li>";
echo "<li><a href='/?page=user_bookings' target='_blank'><strong>👤 Dashboard Prenotazioni</strong></a></li>";
echo "<li><a href='/?page=login' target='_blank'><strong>🔐 Login</strong></a></li>";
echo "<li><a href='fix-database-schema-emergency.php' target='_blank'><strong>🔧 Fix Database</strong></a></li>";
echo "</ul>";

echo "<div style='background: #fff3cd; padding: 15px; border-radius: 8px; margin-top: 20px;'>";
echo "<h3>🎯 POSSIBILI CAUSE PROBLEMI:</h3>";
echo "<ol>";
echo "<li><strong>Database non aggiornato:</strong> Struttura tabella bookings incompleta</li>";
echo "<li><strong>User ID mancante:</strong> Prenotazioni non collegate all'utente</li>";
echo "<li><strong>Email non configurate:</strong> SMTP non impostato correttamente</li>";
echo "<li><strong>Query dashboard:</strong> Query errata per recuperare prenotazioni utente</li>";
echo "</ol>";
echo "</div>";
?> 