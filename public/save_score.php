<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    echo json_encode(["status" => "error", "message" => "Not logged in"]);
    exit;
}

require_once __DIR__ . '/../models/Game.php';
$gameModel = new Game();

$userId = $_SESSION["user_id"];
$timeTaken = $_POST["time_taken"];
$difficulty = $_POST["difficulty"];

// Déterminer le badge en fonction du temps
$maxTime = ["Easy" => 300, "Medium" => 270, "Hard" => 240];
$threshold = $maxTime[$difficulty] ?? 300;

$badge = "None";
if ($timeTaken <= $threshold * 0.5) {
    $badge = "Gold";
} elseif ($timeTaken <= $threshold * 0.6) {
    $badge = "Silver";
} elseif ($timeTaken <= $threshold * 0.8) {
    $badge = "Bronze";
}

// Sauvegarde du score avec le badge
$gameModel->saveScore($userId, $timeTaken, $difficulty, $badge);

echo json_encode(["status" => "success"]);
?>
