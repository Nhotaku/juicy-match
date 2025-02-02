<?php
require_once __DIR__ . '/../core/Database.php';

class Game {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::connect();
    }

    public function saveScore($userId, $timeTaken, $difficulty, $badge) {
        $stmt = $this->pdo->prepare("INSERT INTO game_scores (user_id, difficulty, time_taken, badge) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$userId, $difficulty, $timeTaken, $badge]);
    }

    public function getLeaderboard() {
        $stmt = $this->pdo->query("SELECT users.username, game_scores.difficulty, game_scores.time_taken, game_scores.badge
                                   FROM game_scores
                                   JOIN users ON game_scores.user_id = users.id
                                   ORDER BY game_scores.time_taken ASC
                                   LIMIT 10");
        return $stmt->fetchAll();
    }
}
?>
