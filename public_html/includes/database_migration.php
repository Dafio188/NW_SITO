<?php
// Sistema di migrazione automatica database
function migrateDatabase($db) {
    try {
        // Controlla se le colonne reset_token e reset_expires esistono
        $stmt = $db->query("PRAGMA table_info(users)");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $hasResetToken = false;
        $hasResetExpires = false;
        
        foreach ($columns as $column) {
            if ($column['name'] === 'reset_token') {
                $hasResetToken = true;
            }
            if ($column['name'] === 'reset_expires') {
                $hasResetExpires = true;
            }
        }
        
        // Aggiungi colonne se mancanti
        if (!$hasResetToken) {
            $db->exec("ALTER TABLE users ADD COLUMN reset_token TEXT");
            error_log("AstroGuida: Colonna reset_token aggiunta al database");
        }
        
        if (!$hasResetExpires) {
            $db->exec("ALTER TABLE users ADD COLUMN reset_expires DATETIME");
            error_log("AstroGuida: Colonna reset_expires aggiunta al database");
        }
        
        return true;
        
    } catch (Exception $e) {
        error_log("AstroGuida Migration Error: " . $e->getMessage());
        return false;
    }
}

// Esegui migrazione automatica
function autoMigrate($db) {
    static $migrated = false;
    
    if (!$migrated) {
        migrateDatabase($db);
        $migrated = true;
    }
}
?> 