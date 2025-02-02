<?php
require_once __DIR__ . '/../core/Database.php';

class Admin {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::connect();
    }

    public function login($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();
        if ($admin && password_verify($password, $admin["password"])) {
            return $admin;
        }
        return false;
    }
}
?>
