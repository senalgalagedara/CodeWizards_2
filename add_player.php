<?php
include("config.php");
require_once 'playerdit.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["playername"];
    $role = $_POST["role"];

    $player = new playerdit($name, $role);

    $stmt = $conn->prepare("INSERT INTO player (player_id, playername, role, p_point, bat_SR, ball_SR, Econ_rate, Price) VALUES (NULL, ?, ?, 0, 0, 0, 0, 0)");
    $stmt->bind_param("ss", $name, $role);
    if ($stmt->execute()) {
        header("Location: players.php"); 
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">-->
    <title>Document</title>
</head>
<body>
<h4 class="mt-4">Add New Player</h4>
    <form action="add_player.php" method="POST">
        <div class="mb-3">
            <label class="form-label">Player Name</label>
            <input type="text" name="playername" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-control" required>
                <option value="Batsman">Batsman</option>
                <option value="Bowler">Bowler</option>
                <option value="All-Rounder">All-Rounder</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Add Player</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
