<?php
// Script per creare/verificare tabella bookings
echo "🛠️ CREAZIONE/VERIFICA TABELLA BOOKINGS\n\n";

try {
    require_once __DIR__ . '/includes/database.php';
    $db = getDb();
    
    // Verifica se tabella esiste
    $tables = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name='bookings'")->fetchAll();
    
    if (empty($tables)) {
        echo "❌ Tabella bookings non esiste. Creazione in corso...\n";
        
        // Crea tabella bookings
        $sql = "
        CREATE TABLE bookings (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            booking_id TEXT UNIQUE NOT NULL,
            user_id INTEGER NULL,
            name TEXT NOT NULL,
            email TEXT NOT NULL,
            phone TEXT,
            service_name TEXT NOT NULL,
            booking_date DATE NOT NULL,
            booking_time TIME,
            participants INTEGER DEFAULT 1,
            message TEXT,
            status TEXT DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
        )";
        
        $db->exec($sql);
        echo "✅ Tabella bookings creata con successo!\n";
    } else {
        echo "✅ Tabella bookings già esistente\n";
    }
    
    // Verifica struttura tabella
    $columns = $db->query("PRAGMA table_info(bookings)")->fetchAll();
    echo "\n📋 Struttura tabella bookings:\n";
    foreach ($columns as $col) {
        echo "  - " . $col['name'] . " (" . $col['type'] . ")\n";
    }
    
    // Verifica dati esistenti
    $count = $db->query("SELECT COUNT(*) as total FROM bookings")->fetch()['total'];
    echo "\n📊 Prenotazioni esistenti: $count\n";
    
    if ($count > 0) {
        echo "\n🔍 Ultime 3 prenotazioni:\n";
        $bookings = $db->query("SELECT * FROM bookings ORDER BY id DESC LIMIT 3")->fetchAll();
        foreach ($bookings as $booking) {
            echo "  - ID: {$booking['id']}, Servizio: {$booking['service_name']}, Data: {$booking['booking_date']}\n";
        }
    }
    
    echo "\n🎯 RISULTATO: Tabella bookings pronta per l'uso!\n";
    
} catch (Exception $e) {
    echo "❌ ERRORE: " . $e->getMessage() . "\n";
}
?> 