<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/models/Game.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Juicy Match</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script defer src="assets/js/game.js"></script>
    <script defer src="assets/js/timer.js"></script>
</head>
<body>
    <h1>Juicy Match 🍉</h1>

    <div id="game-board"></div>
    
    <div id="timer-container">
        <progress id="progress-bar" value="100" max="100"></progress>
        <p id="timer">Temps restant : 5:00</p>
    </div>

    <button id="restart">Recommencer</button>
</body>
</html>
