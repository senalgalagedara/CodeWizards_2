<?php
include("../config.php");
require_once '../playerdit.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["playername"]);
    $role = trim($_POST["role"]);
    $university = trim($_POST["university"]);

    $player_runs = isset($_POST["player_runs"]) && $_POST["player_runs"] !== "" ? (int)$_POST["player_runs"] : 0;
    $p_TBF = isset($_POST["p_TBF"]) && $_POST["p_TBF"] !== "" ? (int)$_POST["p_TBF"] : 0;  
    $p_innins = isset($_POST["p_innins"]) && $_POST["p_innins"] !== "" ? (int)$_POST["p_innins"] : 0;
    $p_totball = isset($_POST["p_totball"]) && $_POST["p_totball"] !== "" ? (int)$_POST["p_totball"] : 0; 
    $p_wickets = isset($_POST["p_wickets"]) && $_POST["p_wickets"] !== "" ? (int)$_POST["p_wickets"] : 0;

    $player = new playerdit($name, $role, $player_runs, $p_TBF, $p_innins, $p_totball, $p_wickets);

 

    echo "<pre>";
    print_r($player);
    echo "</pre>";

    $stmt = $conn->prepare("INSERT INTO player (playername, role, p_point, bat_SR, ball_SR, Econ_rate, Price , university) VALUES (?, ?, 0, 0, 0, 0, 0,?)");
    $stmt->bind_param("sss", $name, $role,$university);

    if ($stmt->execute()) {
        $player_id = $conn->insert_id; 

        $stmt1 = $conn->prepare("INSERT INTO player_stat (player_id, p_runs, p_tbf, p_innins, p_totballs, p_wickets) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt1->bind_param("iiiiii", $player_id, $player_runs, $p_TBF, $p_innins, $p_totball, $p_wickets);

        if ($stmt1->execute()) {
            header("Location: ../players.php");
            exit();
        } else {
            echo "Error inserting into player_stat: " . $stmt1->error;
        }
    } else {
        echo "Error inserting into player: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Player</title>
</head>
<body>
    <h4>Add New Player</h4>
    <form action="add_player.php" method="POST">
        <div>
            <label>Player Name</label>
            <input type="text" name="playername" required>
        </div>
        <div>
            <label>Role</label>
            <select name="role" required>
                <option value="Batsman">Batsman</option>
                <option value="Bowler">Bowler</option>
                <option value="All-Rounder">All-Rounder</option>
            </select>
        </div>
        <div>
            <label>Playe's University'</label>
            <input type="text" name="university" required min="0">
        </div>
        <div>
            <label>Player Runs</label>
            <input type="number" name="player_runs" required min="0">
        </div>
        <div>
            <label>Player Total Balls Faced</label>
            <input type="number" name="p_TBF" required min="0">
        </div>
        <div>
            <label>Player Innings</label>
            <input type="number" name="p_innins" required min="0">
        </div>
        <div>
            <label>Player Total Balls</label>
            <input type="number" name="p_totball" required min="0">
        </div>
        <div>
            <label>Player Wickets</label>
            <input type="number" name="p_wickets" required min="0">
        </div>
        <button type="submit">Add Player</button>
    </form>
</body>
</html>
