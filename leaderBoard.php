<?php
$conn = new mysqli("localhost", "root", "", "ufcg");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT playername, p_runs,p_tbf, p_innins,  
                 p_totballs, p_wickets FROM player_stat";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error executing query: " . mysqli_error($conn));
}

$players = [];

while ($row = mysqli_fetch_assoc($result)) {
    $total_runs = $row['totalp_runs_runs'];
    $total_ball_faced = $row['total_balls_faced'];
    $innings_played = $row['innings_played'];
    $total_ball_bowled = $row['total_balls_bowled'];
    $total_wickets_taken = $row['total_wickets_taken'];
    $total_runs_conceded = $row['total_runs_conceded'];

    // Prevent division by zero
    $batting_sr = ($total_ball_faced > 0) ? ($total_runs * 100) / $total_ball_faced : 0;
    $batting_avg = ($innings_played > 0) ? $total_runs / $innings_played : 0;
    $bowling_sr = ($total_wickets_taken > 0) ? $total_ball_bowled / $total_wickets_taken : 0;
    $econ_rate = ($total_ball_bowled > 0) ? ($total_runs_conceded / $total_ball_bowled) * 6 : 0;

    // Calculate batting and bowling points
    $batting_points = ($batting_sr / 5) + ($batting_avg * 0.8);
    $bowling_points = ($bowling_sr > 0 ? (500 / $bowling_sr) : 0) + ($econ_rate > 0 ? (140 / $econ_rate) : 0);
    
    $total_points = $batting_points + $bowling_points;

    // Store player info
    $players[] = [
        'playername' => $row['playername'],
        'points' => $total_points 
    ];
}

// Sort players by total points (descending order)
usort($players, function ($a, $b) {
    return $b['points'] <=> $a['points'];
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .container { background-color: rgb(141, 185, 232); width: 50%; margin: auto; border: 2px solid blue; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid black; text-align: left; }
        th { background-color: rgb(2, 6, 11); color: white; }
    </style>
</head>
<body>

<div class="container">
    <h2>Leader Board</h2>
    <table>
        <tr>
            <th>Player Name</th>
            <th>Total Points</th>
        </tr>
        <?php if (!empty($players)): ?>
            <?php foreach ($players as $player): ?>
                <tr>
                    <td><?= htmlspecialchars($player['playername']) ?></td>
                    <td><?= number_format($player['points'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="2">No players found</td></tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>
