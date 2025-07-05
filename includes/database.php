<?php
require_once __DIR__ . '/config.php';

class Database {
    private $pdo;
    public function __construct() {
        $db_new = !file_exists(SQLITE_PATH) || filesize(SQLITE_PATH) < 1000;
        try {
            $dsn = 'sqlite:' . SQLITE_PATH;
            $this->pdo = new PDO($dsn);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            if ($db_new) {
                $this->initSchema();
            }
        } catch (PDOException $e) {
            die('Errore connessione database: ' . $e->getMessage());
        }
    }
    private function initSchema() {
        $schema = file_get_contents(__DIR__ . '/database_schema_sqlite.sql');
        foreach (explode(';', $schema) as $stmt) {
            $stmt = trim($stmt);
            if ($stmt) {
                $this->pdo->exec($stmt);
            }
        }
    }
    public function getPdo() {
        return $this->pdo;
    }
}

function getDb() {
    static $db = null;
    if ($db === null) {
        $db = new Database();
    }
    return $db->getPdo();
} 