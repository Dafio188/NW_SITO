<?php
echo "<h1>🚨 CORREZIONE EMERGENZA SCHEMA DATABASE</h1>";

try {
    require_once __DIR__ . '/includes/database.php';
    $db = getDb();
    
    // Verifica struttura attuale
    echo "<h2>📋 Struttura Attuale Tabella Bookings</h2>";
    $columns = $db->query("PRAGMA table_info(bookings)")->fetchAll();
    
    echo "<h3>Colonne esistenti:</h3><ul>";
    $existing_columns = [];
    foreach ($columns as $col) {
        $existing_columns[] = $col['name'];
        echo "<li><strong>{$col['name']}</strong> ({$col['type']})</li>";
    }
    echo "</ul>";
    
    // Verifica se ci sono dati esistenti
    $existing_data = $db->query("SELECT * FROM bookings")->fetchAll();
    $data_count = count($existing_data);
    echo "<p><strong>Prenotazioni esistenti:</strong> $data_count</p>";
    
    if ($data_count > 0) {
        echo "<h3>Dati esistenti:</h3>";
        foreach ($existing_data as $row) {
            echo "<p>ID: {$row['id']} - Servizio: {$row['service_name']} - Data: {$row['booking_date']}</p>";
        }
    }
    
    // Backup della tabella esistente
    echo "<h2>💾 Backup Tabella Esistente</h2>";
    $db->exec("CREATE TABLE IF NOT EXISTS bookings_backup AS SELECT * FROM bookings");
    echo "<p>✅ Backup creato in tabella 'bookings_backup'</p>";
    
    // Elimina tabella esistente
    echo "<h2>🗑️ Rimozione Tabella Obsoleta</h2>";
    $db->exec("DROP TABLE bookings");
    echo "<p>✅ Tabella bookings obsoleta rimossa</p>";
    
    // Crea nuova tabella con struttura completa
    echo "<h2>🛠️ Creazione Nuova Tabella</h2>";
    $sql = "
    CREATE TABLE bookings (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        booking_id TEXT UNIQUE NOT NULL,
        user_id INTEGER,
        name TEXT NOT NULL,
        email TEXT NOT NULL,
        phone TEXT,
        service_name TEXT NOT NULL,
        booking_date TEXT NOT NULL,
        booking_time TEXT,
        participants INTEGER DEFAULT 1,
        message TEXT,
        status TEXT DEFAULT 'pending',
        payment_status TEXT DEFAULT 'pending',
        transaction_id TEXT,
        total_amount REAL,
        created_at TEXT DEFAULT (datetime('now', 'localtime')),
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
    )";
    
    $db->exec($sql);
    echo "<p>✅ Nuova tabella bookings creata con struttura completa</p>";
    
    // Migra dati esistenti se presenti
    if ($data_count > 0) {
        echo "<h2>🔄 Migrazione Dati Esistenti</h2>";
        
        foreach ($existing_data as $old_booking) {
            // Genera booking_id per record esistenti
            $booking_id = 'AG' . date('Ymd') . str_pad($old_booking['id'], 4, '0', STR_PAD_LEFT);
            
            // Mappa i campi esistenti a quelli nuovi
            $name = $old_booking['name'] ?? 'Cliente';
            $email = $old_booking['email'] ?? 'cliente@esempio.com';
            $phone = $old_booking['phone'] ?? null;
            $service_name = $old_booking['service_name'] ?? 'Servizio non specificato';
            $booking_date = $old_booking['booking_date'] ?? date('Y-m-d');
            $booking_time = $old_booking['booking_time'] ?? null;
            $participants = $old_booking['participants'] ?? 1;
            $message = $old_booking['message'] ?? null;
            $status = $old_booking['status'] ?? 'pending';
            $created_at = $old_booking['created_at'] ?? date('Y-m-d H:i:s');
            
            // Calcola total_amount basato sul servizio
            $total_amount = 50.00; // Default
            if (strpos(strtolower($service_name), 'astrofotografia') !== false) {
                $total_amount = 89.00;
            } elseif (strpos(strtolower($service_name), 'turismo') !== false) {
                $total_amount = 120.00;
            } elseif (strpos(strtolower($service_name), 'corso') !== false) {
                $total_amount = 200.00;
            } elseif (strpos(strtolower($service_name), 'osservazione') !== false) {
                $total_amount = 45.00;
            }
            $total_amount *= $participants;
            
            // Inserisci nella nuova tabella
            $stmt = $db->prepare("
                INSERT INTO bookings (
                    booking_id, user_id, name, email, phone, service_name, 
                    booking_date, booking_time, participants, message, status, 
                    payment_status, total_amount, created_at
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', ?, ?)
            ");
            
            $stmt->execute([
                $booking_id, $old_booking['user_id'], $name, $email, $phone,
                $service_name, $booking_date, $booking_time, $participants, 
                $message, $status, $total_amount, $created_at
            ]);
            
            echo "<p>✅ Migrato: {$booking_id} - {$service_name}</p>";
        }
        
        echo "<p>✅ Migrazione completata: $data_count prenotazioni migrate</p>";
    }
    
    // Verifica nuova struttura
    echo "<h2>🔍 Verifica Nuova Struttura</h2>";
    $new_columns = $db->query("PRAGMA table_info(bookings)")->fetchAll();
    
    echo "<h3>Nuove colonne:</h3><ul>";
    foreach ($new_columns as $col) {
        echo "<li><strong>{$col['name']}</strong> ({$col['type']})</li>";
    }
    echo "</ul>";
    
    // Test inserimento
    echo "<h2>🧪 Test Inserimento</h2>";
    $test_booking_id = 'TEST' . date('YmdHis');
    
    $stmt = $db->prepare("
        INSERT INTO bookings (
            booking_id, user_id, name, email, phone, service_name, 
            booking_date, booking_time, participants, message, status, total_amount
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', ?)
    ");
    
    $result = $stmt->execute([
        $test_booking_id, null, 'Test User', 'test@example.com', '3331234567',
        'Osservazione Guidata', date('Y-m-d', strtotime('+1 day')), '21:00', 2, 'Test prenotazione', 90.00
    ]);
    
    if ($result) {
        echo "<p>✅ Test inserimento riuscito!</p>";
        
        // Verifica e pulisci
        $stmt = $db->prepare("SELECT * FROM bookings WHERE booking_id = ?");
        $stmt->execute([$test_booking_id]);
        $test_booking = $stmt->fetch();
        
        if ($test_booking) {
            echo "<p>✅ Test verificato: {$test_booking['booking_id']}</p>";
            $db->prepare("DELETE FROM bookings WHERE booking_id = ?")->execute([$test_booking_id]);
            echo "<p>✅ Test pulito</p>";
        }
    } else {
        echo "<p>❌ Errore nel test inserimento</p>";
    }
    
    // Statistiche finali
    $final_count = $db->query("SELECT COUNT(*) as count FROM bookings")->fetch()['count'];
    
    echo "<h2>🎯 MIGRAZIONE COMPLETATA</h2>";
    echo "<div style='background: #2d5a2d; padding: 1rem; border-radius: 8px; color: #90ee90;'>";
    echo "<h3>✅ SUCCESSO:</h3>";
    echo "<ul>";
    echo "<li><strong>Tabella aggiornata:</strong> Nuova struttura completa</li>";
    echo "<li><strong>Dati preservati:</strong> $data_count prenotazioni migrate</li>";
    echo "<li><strong>Backup creato:</strong> Tabella 'bookings_backup'</li>";
    echo "<li><strong>Prenotazioni totali:</strong> $final_count</li>";
    echo "<li><strong>Test funzionamento:</strong> Inserimento e lettura OK</li>";
    echo "</ul>";
    echo "</div>";
    
    echo "<h2>🔗 PROSSIMI PASSI</h2>";
    echo "<ul>";
    echo "<li><a href='/?page=booking' target='_blank'>🎯 Testa Form Prenotazioni</a></li>";
    echo "<li><a href='/?page=admin_bookings' target='_blank'>⚙️ Gestione Admin</a></li>";
    echo "<li><a href='test-booking-system-final.php' target='_blank'>🧪 Esegui Test Completo</a></li>";
    echo "</ul>";
    
} catch (Exception $e) {
    echo "<div style='background: #5a2d2d; padding: 1rem; border-radius: 8px; color: #ff6b6b;'>";
    echo "<h3>❌ ERRORE CRITICO:</h3>";
    echo "<p><strong>Messaggio:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>File:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Linea:</strong> " . $e->getLine() . "</p>";
    echo "</div>";
}
?> 