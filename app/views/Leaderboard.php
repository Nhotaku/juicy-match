<?php
require_once __DIR__ . '/../core/Database.php';

$pdo = Database::connect();

// Récupérer les scores avec le nom du joueur et le niveau de difficulté
$query = $pdo->query("
    SELECT users.username, game_scores.time_taken, game_scores.difficulty 
    FROM game_scores
    JOIN users ON game_scores.user_id = users.id
    ORDER BY game_scores.time_taken ASC
");

$scores = $query->fetchAll(PDO::FETCH_ASSOC);

function getBadge($timeUsed, $maxTime) {
    $percentageUsed = ($timeUsed / $maxTime) * 100;
    
    if ($percentageUsed <= 50) {
        return '<span class="badge bg-warning text-dark">🥇 Or</span>';
    } elseif ($percentageUsed <= 60) {
        return '<span class="badge bg-secondary">🥈 Argent</span>';
    } elseif ($percentageUsed <= 80) {
        return '<span class="badge bg-brown">🥉 Bronze</span>';
    }
    return '<span class="badge bg-light text-dark">Aucun</span>';
}

// Définir les temps max selon la difficulté
$maxTimeByDifficulty = [
    "Easy" => 300, // 5 minutes
    "Medium" => 270, // 4 min 30
    "Hard" => 240 // 4 minutes
];

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .badge.bg-brown {
            background-color: #8B4513; /* Marron pour le Bronze */
        }
        .btn-back {
            display: block;
            width: fit-content;
            margin: 20px auto;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center my-4">🏆 Tableau des Meilleurs Scores</h2>

    <table class="table table-striped table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>👤 Joueur</th>
                <th>⏱️ Temps (secondes)</th>
                <th>🎮 Difficulté</th>
                <th>🏅 Badge</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($scores as $score): ?>
                <tr>
                    <td><?= htmlspecialchars($score['username']) ?></td>
                    <td><?= htmlspecialchars($score['time_taken']) ?>s</td>
                    <td><?= htmlspecialchars($score['difficulty']) ?></td>
                    <td><?= getBadge($score['time_taken'], $maxTimeByDifficulty[$score['difficulty']]) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="../public/index.php" class="btn btn-primary btn-back">🔙 Retour au jeu</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
