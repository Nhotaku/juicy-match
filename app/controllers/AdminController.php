<?php
require_once __DIR__ . '/../models/Admin.php';

class AdminController {
    private $adminModel;

    public function __construct() {
        $this->adminModel = new Admin();
    }

    public function login() {
        session_start();
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $admin = $this->adminModel->login($_POST["username"], $_POST["password"]);
            if ($admin) {
                $_SESSION["admin_id"] = $admin["id"];
                header("Location: /admin");
                exit;
            } else {
                echo "Invalid credentials.";
            }
        }
        require __DIR__ . '/../views/admin_login.php';
    }

    public function dashboard() {
        session_start();
        if (!isset($_SESSION["admin_id"])) {
            header("Location: /admin-login");
            exit;
        }
        require __DIR__ . '/../views/admin.php';
    }

    public function deleteScore() {
        session_start();
        if (!isset($_SESSION["admin_id"])) {
            echo json_encode(["status" => "error", "message" => "Unauthorized"]);
            exit;
        }

        require_once __DIR__ . '/../models/Game.php';
        $gameModel = new Game();
        $gameModel->deleteScore($_POST["score_id"]);

        echo json_encode(["status" => "success", "message" => "Score deleted"]);
    }
}
?>
