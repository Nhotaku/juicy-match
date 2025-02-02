<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function register() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if ($this->userModel->register($_POST["username"], $_POST["password"])) {
                header("Location: /login");
                exit;
            } else {
                echo "Error registering user.";
            }
        }
        require __DIR__ . '/../views/register.php';
    }

    public function login() {
        session_start();
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $user = $this->userModel->login($_POST["username"], $_POST["password"]);
            if ($user) {
                $_SESSION["user_id"] = $user["id"];
                header("Location: /game");
                exit;
            } else {
                echo "Invalid credentials.";
            }
        }
        require __DIR__ . '/../views/login.php';
    }
}
?>
