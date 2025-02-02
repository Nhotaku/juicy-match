<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../models/Game.php';
$gameModel = new Game();
$leaderboard = $gameModel->getLeaderboard();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Game</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/game.css">
</head>
<body>

    <div class="container text-center mt-4">
        <h1>Memory Game</h1>

        <!-- Timer & Progress Bar -->
        <div id="timer-container">
            <div id="progress-bar"></div>
            <p id="timer">5:00</p>
        </div>

        <!-- Game Board -->
        <div id="game-board" class="d-flex flex-wrap justify-content-center"></div>

        <!-- Restart Button -->
        <button id="restart-btn" class="btn btn-primary mt-3">Restart</button>

        <!-- Leaderboard -->
        <h2 class="mt-4">Leaderboard</h2>
        <table class="table table-bordered mt-2">
            <thead>
                <tr>
                    <th>Player</th>
                    <th>Difficulty</th>
                    <th>Time</th>
                    <th>Badge</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leaderboard as $score): ?>
                <tr>
                    <td><?= htmlspecialchars($score['username']) ?></td>
                    <td><?= htmlspecialchars($score['difficulty']) ?></td>
                    <td><?= htmlspecialchars($score['time_taken']) ?>s</td>
                    <td><?= htmlspecialchars($score['badge'] ?? 'None') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Scripts -->
    <script src="scripts/timer.js"></script>
    <script src="scripts/game.js"></script>

</body>
</html>
