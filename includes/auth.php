<?php
require_once __DIR__ . '/database.php';

class Auth {
    private $db;
    public function __construct() {
        $this->db = getDb();
        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public function login($email, $password) {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            return true;
        }
        return false;
    }
    public function logout() {
        session_unset();
        session_destroy();
    }
    public function isLogged() {
        return isset($_SESSION['user_id']);
    }
    public function currentUser() {
        if($this->isLogged()) {
            $stmt = $this->db->prepare('SELECT * FROM users WHERE id = ?');
            $stmt->execute([$_SESSION['user_id']]);
            return $stmt->fetch();
        }
        return null;
    }
    public function csrfToken() {
        if(empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    public function checkCsrf($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}

function getAuth() {
    static $auth = null;
    if($auth === null) {
        $auth = new Auth();
    }
    return $auth;
} 