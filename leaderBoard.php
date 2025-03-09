<?php
    $conn = new mysqli("localhost", "root", "", "profile");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

$sql = "SELECT * FROM player";
$result = $conn->query($sql);

$players = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Extract player stats
        $total_runs = $row['total_runs'];
        $total_balls_faced = $row['total_balls_faced'];
        $innings_played = $row['innings_played'];
        $total_balls_bowled = $row['total_balls_bowled'];
        $total_wickets_taken = $row['total_wickets_taken'];
        $total_runs_conceded = $row['total_runs_conceded'];

        // Calculate Batting Metrics
        $batting_sr = ($total_balls_faced > 0) ? ($total_runs / $total_balls_faced) * 100 : 0;
        $batting_avg = ($innings_played > 0) ? ($total_runs / $innings_played) : 0;

        // Calculate Bowling Metrics
        $bowling_sr = ($total_wickets_taken > 0) ? ($total_balls_bowled / $total_wickets_taken) : 0;
        $economy_rate = ($total_balls_bowled > 0) ? ($total_runs_conceded / $total_balls_bowled) * 6 : 0;

        // Calculate Player Points using the given formula
        $player_points = (($batting_sr / 5) + ($batting_avg * 0.8)) + ((500 / $bowling_sr) + (140 / $economy_rate));

        $players[] = ['playername' => $row['playername'], 'points' => $player_points];
    }
}

// Sort players in descending order of points
usort($players, function ($a, $b) {
    return $b['points'] <=> $a['points'];
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h2>Cricket Players Leaderboard</h2>
    <table>
        <tr>
            <th>Rank</th>
            <th>Player Name</th>
            <th>Points</th>
        </tr>
        <?php
        $rank = 1;
        foreach ($players as $player) {
            echo "<tr>
                    <td>{$rank}</td>
                    <td>{$player['playername']}</td>
                    <td>" . number_format($player['points'], 2) . "</td>
                  </tr>";
            $rank++;
        }
        ?>
    </table>
</body>
</html>