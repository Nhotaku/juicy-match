<?php
require_once __DIR__ . '/../models/Game.php';

class GameController {
    private $gameModel;

    public function __construct() {
        $this->gameModel = new Game();
    }

    public function saveScore() {
        session_start();
        if (!isset($_SESSION["user_id"])) {
            echo json_encode(["status" => "error", "message" => "Not logged in"]);
            exit;
        }
        $this->gameModel->saveScore($_SESSION["user_id"], $_POST["time_taken"], $_POST["difficulty"]);
        echo json_encode(["status" => "success"]);
    }

    public function leaderboard() {
        $leaderboard = $this->gameModel->getLeaderboard();
        require __DIR__ . '/../views/leaderboard.php';
    }
}
?>
