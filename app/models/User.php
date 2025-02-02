<?php
require_once __DIR__ . '/../core/Database.php';

class User {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::connect();
    }

    public function register($username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        return $stmt->execute([$username, $hashedPassword]);
    }

    public function login($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user["password"])) {
            return $user;
        }
        return false;
    }
}
?>
