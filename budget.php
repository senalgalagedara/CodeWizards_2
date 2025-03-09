<?php
include("config.php");

$sql = "SELECT budget FROM sign_in WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

$budget = $user['budget'];

$sql = "SELECT * FROM player";
$players = mysqli_query($conn, $sql);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['player_id'])) {
    $playerId = $_POST['player_id'];

    $sql = "SELECT playername, price FROM player WHERE player_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $playerId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $player = mysqli_fetch_assoc($result);
    $playerName = $player['playername'];
    $playerPrice = $player['price'];

    if ($budget >= $playerPrice) {
        $newBudget = $budget - $playerPrice;

        $sql = "UPDATE sign_in SET budget = ? WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'di', $newBudget, $userId);
        mysqli_stmt_execute($stmt);

        $sql = "INSERT INTO purchase_history (user_id, player_name, amount_spent, remaining_budget) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'isdd', $userId, $playerName, $playerPrice, $newBudget);
        mysqli_stmt_execute($stmt);

        $budget = $newBudget;
    } else {
        echo "<script>alert('Not enough budget!');</script>";
    }
}

$sql = "SELECT * FROM purchase_history WHERE user_id = ? ORDER BY timestamp DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $userId);
mysqli_stmt_execute($stmt);
$history = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buy Players - Budget Management</title>
    
</head>
<body>

<h2>BUDGET: <span style="color:blue;">Rs. <?php echo number_format($budget, 2); ?></span></h2> 

<h3>BUDGET HISTORY</h3>
<table border="1">
    <tr>
        <th>Player</th>
        <th>Amount Spent</th>
        <th>Remaining Budget</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($history)) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row['playername']); ?></td>
        <td>Rs. <?php echo number_format($row['amount_spent'], 2); ?> ▼</td>
        <td>Rs. <?php echo number_format($row['remaining_budget'], 2); ?></td>
    </tr>
    <?php } ?>
</table>



</body>
</html>
