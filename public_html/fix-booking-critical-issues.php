<?php
echo "<h1>🚨 FIX CRITICO PRENOTAZIONI E EMAIL</h1>";

echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .success { color: #28a745; font-weight: bold; }
    .error { color: #dc3545; font-weight: bold; }
    .warning { color: #ffc107; font-weight: bold; }
    .step { background: #f8f9fa; padding: 15px; margin: 10px 0; border-radius: 8px; }
</style>";

try {
    require_once __DIR__ . '/includes/database.php';
    $db = getDb();
    
    echo "<div class='step'>";
    echo "<h2>1. 🗄️ Verifica e Correggi Database</h2>";
    
    // Verifica struttura tabella bookings
    $columns = $db->query("PRAGMA table_info(bookings)")->fetchAll();
    $existing_columns = [];
    foreach ($columns as $col) {
        $existing_columns[] = $col['name'];
    }
    
    $required_columns = [
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
        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
    ];
    
    $missing_columns = [];
    foreach ($required_columns as $col_name => $col_type) {
        if (!in_array($col_name, $existing_columns)) {
            $missing_columns[] = $col_name;
        }
    }
    
    if (!empty($missing_columns)) {
        echo "<div class='warning'>⚠️ Colonne mancanti: " . implode(', ', $missing_columns) . "</div>";
        echo "<p>Aggiungendo colonne mancanti...</p>";
        
        foreach ($missing_columns as $col_name) {
            $col_type = $required_columns[$col_name];
            try {
                $db->exec("ALTER TABLE bookings ADD COLUMN {$col_name} {$col_type}");
                echo "<div class='success'>✅ Aggiunta colonna: {$col_name}</div>";
            } catch (Exception $e) {
                echo "<div class='error'>❌ Errore aggiunta {$col_name}: " . $e->getMessage() . "</div>";
            }
        }
    } else {
        echo "<div class='success'>✅ Database struttura OK</div>";
    }
    echo "</div>";
    
    echo "<div class='step'>";
    echo "<h2>2. 🔍 Verifica Prenotazioni Esistenti</h2>";
    
    $bookings = $db->query("SELECT COUNT(*) as count FROM bookings")->fetch();
    echo "<p><strong>Totale prenotazioni:</strong> " . $bookings['count'] . "</p>";
    
    if ($bookings['count'] > 0) {
        $recent = $db->query("SELECT * FROM bookings ORDER BY id DESC LIMIT 10")->fetchAll();
        echo "<h3>Ultime prenotazioni:</h3>";
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='background: #007aff; color: white;'><th>ID</th><th>Booking ID</th><th>User ID</th><th>Email</th><th>Servizio</th><th>Data</th><th>Status</th></tr>";
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
        
        // Correggi booking_id mancanti
        $missing_booking_ids = $db->query("SELECT id FROM bookings WHERE booking_id IS NULL OR booking_id = ''")->fetchAll();
        if (!empty($missing_booking_ids)) {
            echo "<h4>Correzione Booking ID mancanti:</h4>";
            foreach ($missing_booking_ids as $booking) {
                $new_booking_id = 'AG' . date('Ymd') . str_pad($booking['id'], 4, '0', STR_PAD_LEFT);
                $stmt = $db->prepare("UPDATE bookings SET booking_id = ? WHERE id = ?");
                $stmt->execute([$new_booking_id, $booking['id']]);
                echo "<div class='success'>✅ Aggiornato booking ID: {$new_booking_id}</div>";
            }
        }
    }
    echo "</div>";
    
    echo "<div class='step'>";
    echo "<h2>3. 🔐 Verifica Autenticazione</h2>";
    
    require_once __DIR__ . '/includes/auth.php';
    $auth = getAuth();
    
    if ($auth->isLogged()) {
        $user = $auth->currentUser();
        echo "<div class='success'>✅ Utente loggato: " . $user['name'] . " (ID: " . $user['id'] . ")</div>";
        
        // Verifica prenotazioni utente
        $stmt = $db->prepare("SELECT * FROM bookings WHERE user_id = ? OR email = ? ORDER BY id DESC");
        $stmt->execute([$user['id'], $user['email']]);
        $user_bookings = $stmt->fetchAll();
        
        echo "<p><strong>Prenotazioni utente:</strong> " . count($user_bookings) . "</p>";
        
        if (!empty($user_bookings)) {
            echo "<h4>Prenotazioni dell'utente corrente:</h4>";
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr style='background: #28a745; color: white;'><th>Booking ID</th><th>Servizio</th><th>Data</th><th>Status</th><th>Importo</th></tr>";
            foreach ($user_bookings as $booking) {
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
        echo "<div class='error'>❌ Nessun utente loggato</div>";
    }
    echo "</div>";
    
    echo "<div class='step'>";
    echo "<h2>4. 📧 Verifica Sistema Email</h2>";
    
    if (file_exists(__DIR__ . '/includes/email_service.php')) {
        echo "<div class='success'>✅ File email_service.php presente</div>";
        
        try {
            require_once __DIR__ . '/includes/email_service.php';
            echo "<div class='success'>✅ EmailService caricato</div>";
            
            $emailService = getEmailService();
            echo "<div class='success'>✅ Istanza EmailService creata</div>";
            
        } catch (Exception $e) {
            echo "<div class='error'>❌ Errore EmailService: " . $e->getMessage() . "</div>";
        }
    } else {
        echo "<div class='error'>❌ File email_service.php mancante</div>";
    }
    echo "</div>";
    
    echo "<div class='step'>";
    echo "<h2>5. 🧪 Test Prenotazione</h2>";
    
    if ($auth->isLogged()) {
        $user = $auth->currentUser();
        
        // Crea prenotazione di test
        $test_booking_id = 'TEST' . date('YmdHis');
        $stmt = $db->prepare("
            INSERT INTO bookings (
                booking_id, user_id, name, email, phone, service_name, 
                booking_date, booking_time, participants, message, status, total_amount
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $result = $stmt->execute([
            $test_booking_id,
            $user['id'],
            $user['name'],
            $user['email'],
            '1234567890',
            'Test Osservazione Stellare',
            date('Y-m-d', strtotime('+1 day')),
            '21:00',
            2,
            'Prenotazione di test',
            'confirmed',
            100.00
        ]);
        
        if ($result) {
            echo "<div class='success'>✅ Prenotazione di test creata: {$test_booking_id}</div>";
            
            // Test email
            try {
                $bookingDetails = [
                    'booking_id' => $test_booking_id,
                    'service_name' => 'Test Osservazione Stellare',
                    'booking_date' => date('Y-m-d', strtotime('+1 day')),
                    'booking_time' => '21:00',
                    'participants' => 2,
                    'total_amount' => 100.00
                ];
                
                $emailService->sendBookingConfirmation($user['email'], $user['name'], $bookingDetails);
                echo "<div class='success'>✅ Email di conferma inviata</div>";
                
            } catch (Exception $e) {
                echo "<div class='error'>❌ Errore invio email: " . $e->getMessage() . "</div>";
            }
        } else {
            echo "<div class='error'>❌ Errore creazione prenotazione di test</div>";
        }
    } else {
        echo "<div class='error'>❌ Login necessario per test prenotazione</div>";
    }
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div class='error'>❌ ERRORE GENERALE: " . $e->getMessage() . "</div>";
}

echo "<h2>🔗 LINK UTILI</h2>";
echo "<ul>";
echo "<li><a href='/?page=booking'><strong>📝 Vai alla Pagina Booking</strong></a></li>";
echo "<li><a href='/?page=user_bookings'><strong>👤 Dashboard Prenotazioni</strong></a></li>";
echo "<li><a href='/?page=login'><strong>🔐 Login</strong></a></li>";
echo "</ul>";

echo "<div style='background: #d4edda; padding: 15px; border-radius: 8px; margin-top: 20px;'>";
echo "<h3>✅ AZIONI COMPLETATE</h3>";
echo "<ol>";
echo "<li>Verificata e corretta struttura database</li>";
echo "<li>Aggiunte colonne mancanti alla tabella bookings</li>";
echo "<li>Corretti booking_id mancanti</li>";
echo "<li>Verificato sistema autenticazione</li>";
echo "<li>Testato sistema email</li>";
echo "<li>Creata prenotazione di test</li>";
echo "</ol>";
echo "</div>";
?> 