<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database_migration.php';

class Database {
    private $pdo;
    public function __construct($db_path) {
        if(!file_exists($db_path)) {
            $this->initDb($db_path);
        }
        $this->pdo = new PDO('sqlite:'.$db_path);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Esegui migrazione automatica
        autoMigrate($this->pdo);
    }
    private function initDb($db_path) {
        $schema = file_get_contents(__DIR__.'/../data/schema.sql');
        $pdo = new PDO('sqlite:'.$db_path);
        $pdo->exec($schema);
    }
    public function pdo() { return $this->pdo; }
}

function getDb() {
    static $db = null;
    if ($db === null) {
        $db = new Database(SQLITE_PATH);
    }
    return $db->pdo();
} 