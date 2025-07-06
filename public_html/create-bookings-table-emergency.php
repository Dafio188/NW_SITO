<?php
// Script emergenza per creare tabella bookings compatibile SQLite
echo "<h1>🚨 CREAZIONE EMERGENZA TABELLA BOOKINGS</h1>";

try {
    require_once __DIR__ . '/includes/database.php';
    $db = getDb();
    
    // Elimina tabella se esiste (per ricrearla correttamente)
    echo "<p>🗑️ Eliminazione tabella esistente...</p>";
    $db->exec("DROP TABLE IF EXISTS bookings");
    
    // Crea tabella bookings corretta per SQLite
    echo "<p>🛠️ Creazione tabella bookings...</p>";
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
        created_at TEXT DEFAULT (datetime('now', 'localtime')),
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
    )";
    
    $db->exec($sql);
    echo "<p>✅ Tabella bookings creata con successo!</p>";
    
    // Verifica struttura
    echo "<h2>📋 Verifica struttura:</h2>";
    $columns = $db->query("PRAGMA table_info(bookings)")->fetchAll();
    echo "<ul>";
    foreach ($columns as $col) {
        echo "<li>{$col['name']} ({$col['type']})</li>";
    }
    echo "</ul>";
    
    // Test inserimento
    echo "<h2>🧪 Test inserimento...</h2>";
    $test_booking_id = 'TEST' . date('YmdHis');
    
    $stmt = $db->prepare("
        INSERT INTO bookings (
            booking_id, user_id, name, email, phone, service_name, 
            booking_date, booking_time, participants, message, status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')
    ");
    
    $stmt->execute([
        $test_booking_id, null, 'Test User', 'test@example.com', '123456789',
        'Osservazione Guidata', date('Y-m-d', strtotime('+1 day')), '21:00', 2, 'Test booking'
    ]);
    
    echo "<p>✅ Inserimento test riuscito!</p>";
    
    // Verifica inserimento
    $stmt = $db->prepare("SELECT * FROM bookings WHERE booking_id = ?");
    $stmt->execute([$test_booking_id]);
    $result = $stmt->fetch();
    
    if ($result) {
        echo "<p>✅ Prenotazione test verificata: ID {$result['id']}</p>";
        
        // Pulizia
        $db->prepare("DELETE FROM bookings WHERE booking_id = ?")->execute([$test_booking_id]);
        echo "<p>✅ Test pulito</p>";
    }
    
    echo "<h2>🎯 TABELLA BOOKINGS PRONTA!</h2>";
    echo "<ul>";
    echo "<li>Struttura corretta per SQLite</li>";
    echo "<li>Inserimenti funzionanti</li>";
    echo "<li>Compatibile con il form booking</li>";
    echo "</ul>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ ERRORE: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . "</p>";
    echo "<p>Linea: " . $e->getLine() . "</p>";
}
?> 