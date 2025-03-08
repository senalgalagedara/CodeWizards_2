<?php
include("config.php");
require_once 'playerdit.php';

$result = $conn->query("SELECT * FROM player ORDER BY player_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Management</title>
    <!---<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">-->
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center">Player Management</h2>
    
    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                
                <th>Player Name</th>
                <th>Role</th>
                <th>Price ($)</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td>
                        <a href="player_details.php?id=<?php echo $row["player_id"]; ?>">
                            <?php echo $row["playername"]; ?>
                        </a>
                    </td>
                    <td><?php echo $row["role"]; ?></td>
                    <td><?php echo $row["Price"]; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <a href="add_player.php"><button type="submit" class="btn btn-success">Add Player</button></a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
