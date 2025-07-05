<?php
// Sistema autenticazione base AstroGuida
session_start();

class Auth {
    private $db;
    public function __construct($pdo) {
        $this->db = $pdo;
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }
    public function csrfToken() {
        return $_SESSION['csrf_token'];
    }
    public function checkCsrf($token) {
        return hash_equals($_SESSION['csrf_token'], $token ?? '');
    }
    public function login($email, $password) {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            return true;
        }
        return false;
    }
    public function register($name, $email, $password) {
        $stmt = $this->db->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) return false;
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare('INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)');
        return $stmt->execute([$name, $email, $hash, 'user']);
    }
    public function logout() {
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');
    }
    public function isLogged() {
        return isset($_SESSION['user_id']);
    }
    public function user() {
        if ($this->isLogged()) {
            $stmt = $this->db->prepare('SELECT * FROM users WHERE id = ?');
            $stmt->execute([$_SESSION['user_id']]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return null;
    }
    public function requireLogin() {
        if (!$this->isLogged()) {
            header('Location: /login');
            exit;
        }
    }
    // Rate limiting base (max 5 tentativi in 10 min)
    public function checkRateLimit($email) {
        if (!isset($_SESSION['login_attempts'])) $_SESSION['login_attempts'] = [];
        $_SESSION['login_attempts'] = array_filter($_SESSION['login_attempts'], function($t) {
            return $t > time() - 600;
        });
        if (count($_SESSION['login_attempts']) >= 5) return false;
        $_SESSION['login_attempts'][] = time();
        return true;
    }
}

function getAuth() {
    static $auth = null;
    if ($auth === null) {
        require_once __DIR__.'/database.php';
        $db = (new Database(DB_PATH))->pdo();
        $auth = new Auth($db);
    }
    return $auth;
} 