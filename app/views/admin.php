<?php
require_once __DIR__ . '/../models/Game.php';
$gameModel = new Game();
$scores = $gameModel->getLeaderboard();
?>

<h2>Admin Dashboard - Manage Scores</h2>
<table>
    <tr>
        <th>Player</th>
        <th>Difficulty</th>
        <th>Time (s)</th>
        <th>Action</th>
    </tr>
    <?php foreach ($scores as $score): ?>
    <tr>
        <td><?= htmlspecialchars($score["username"]); ?></td>
        <td><?= htmlspecialchars($score["difficulty"]); ?></td>
        <td><?= htmlspecialchars($score["time_taken"]); ?></td>
        <td>
            <form method="POST" action="/delete-score">
                <input type="hidden" name="score_id" value="<?= $score["id"]; ?>">
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
