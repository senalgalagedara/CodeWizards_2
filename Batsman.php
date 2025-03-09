<?php
require 'config.php';

$sql_create_table = "CREATE TABLE IF NOT EXISTS team (
    player_id INT PRIMARY KEY,
    playername VARCHAR(100),
    university VARCHAR(50),
    budget FLOAT
)";
$conn->query($sql_create_table);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_player'])) {
    $player_id = $_POST['player_id'];
    $player_name = $_POST['player_name'];
    $uni = $_POST['uni'];
    $budget = $_POST['budget'];

    $sql = "INSERT IGNORE INTO team (Player_Id, Playername, University, Budget) 
            VALUES ('$player_id', '$player_name', '$uni', '$budget')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Player added successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_player'])) {
    $player_id = $_POST['player_id'];

    $sql = "DELETE FROM team WHERE player_id = '$player_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: red;'>Player removed successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batsmen Selection</title>
</head>
<body>

<h2>Available Batsmen</h2>

<?php
$sql = "SELECT * FROM player WHERE Role = 'Batsman'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Player ID</th>
                <th>Player Name</th>
                <th>Role</th>
                <th>Points</th>
                <th>Batting SR</th>
                <th>Bowling SR</th>
                <th>Economy Rate</th>
                <th>Price</th>
                <th>Action</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row['player_id']."</td>
                <td>".$row['playername']."</td>
                <td>".$row['role']."</td>
                <td>".$row['p_point']."</td>
                <td>".$row['bat_SR']."</td>
                <td>".$row['ball_SR']."</td>
                <td>".$row['Econ_rate']."</td>
                <td>".$row['Price']."</td>
                <td>
                    <form method='POST'>
                        <input type='hidden' name='player_id' value='".$row['player_id']."'>
                        <input type='hidden' name='player_name' value='".$row['playername']."'>
                        <input type='hidden' name='role' value='".$row['role']."'>
                        <input type='hidden' name='points' value='".$row['p_point']."'>
                        <input type='hidden' name='batting_sr' value='".$row['bat_SR']."'>
                        <input type='hidden' name='bowling_sr' value='".$row['ball_SR']."'>
                        <input type='hidden' name='econ_rate' value='".$row['Econ_rate']."'>
                        <input type='hidden' name='price' value='".$row['Price']."'>
                        <button type='submit' name='add_player'>Select</button>
                    </form>
                </td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No batsmen available.</p>";
}
?>

<h2>Selected Players</h2>

<?php
// Fetch selected players from the 'team' table
$sql = "SELECT * FROM team";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Player ID</th>
                <th>Player Name</th>
                <th> University </th>
                <th>Budget</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row['Player_Id']."</td>
                <td>".$row['Playername']."</td>
                <td>".$row['University']."</td>
                <td>".$row['Budget']."</td>
                <td>
                    <form method='POST'>
                        <input type='hidden' name='player_id' value='".$row['Player_Id']."'>
                        <button type='submit' name='remove_player'>Remove</button>
                    </form>
                </td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No players selected.</p>";
}

$conn->close();
?>

</body>
</html>
