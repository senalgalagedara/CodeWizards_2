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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Select Your Team</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      background-color: #f2f2f2;
      font-family: Arial, sans-serif;
    }

    .layout-wrapper {
      display: flex;
      height: 100vh;
      width: 100%;
    }

    /* Left Sidebar */
    .sidebar-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin: 20px;
    }

    .logo {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      margin-bottom: 10px;
    }

    .sidebar {
      width: 80px;
      background-color: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
      border-radius: 30px;
      height: 60%;
      box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
      padding-top: 20px;
    }

    .sidebar .nav-link {
      width: 100%;
      text-align: center;
      color: #000;
      font-size: 1.4rem;
      padding: 1rem 0;
    }

   /* Adjust Main Content to Move Left */
    .main-content {
      flex: 1;
      padding: 2rem;
      display: flex;
      flex-direction: column;
      align-items: flex-start; /* Move Left */
      justify-content: flex-start;
      margin-left: 50px; /* Shift Left */
    }

    /* Centered Title */
    .title {
      text-align: center;
      font-size: 2rem;
      font-weight: bold;
      margin-bottom: 20px;
      width: 100%;
    }

    /* Player Grid (Adjusted) */
    .players-container {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      margin-left: -20px; /* Move Left */
    }


    .player-card {
      position: relative;
      width: 150px;
      height: 180px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
      text-align: center;
      padding: 10px;
    }

    .player-img {
      width: 100%;
      border-radius: 8px;
    }

    .player-name {
      background-color: #3498db;
      color: #fff;
      padding: 5px;
      font-weight: bold;
      border-radius: 5px;
      margin-top: 5px;
    }

    /* Icons */
    .remove-icon, .money-icon {
      position: absolute;
      background-color: #fff;
      border-radius: 50%;
      width: 24px;
      height: 24px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      cursor: pointer;
    }

    .remove-icon {
      top: 5px;
      right: 5px;
      color: red;
    }

    .money-icon {
      bottom: 5px;
      right: 5px;
      color: black;
    }

    /* Checkout Section (Full Right Corner) */
    .checkout-container {
      width: 300px;
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      height: 100%;
      box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
      position: absolute;
      top: 0;
      right: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .checkout-section {
      width: 100%;
    }

    .checkout-item {
      display: flex;
      justify-content: space-between;
      font-size: 14px;
      margin-bottom: 5px;
    }

    .checkout-item .remove {
      color: red;
      cursor: pointer;
    }

    .total-section {
      margin-top: 10px;
      font-weight: bold;
    }

    .submit-btn {
      width: 100%;
      background-color: #28a745;
      color: white;
      border: none;
      padding: 10px;
      font-weight: bold;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 10px;
    }
  </style>
</head>
<body>

  <div class="layout-wrapper">
    <div class="sidebar-container">
      <img src="your-logo.png" alt="Logo" class="logo">

      <div class="sidebar">
        <nav class="nav flex-column w-100">
          <a class="nav-link" href="tournament.php"><i class="fas fa-home"><br><div style="font-size:8px;">Tournament</div></i></a>
          <a class="nav-link" href="leaderboard.php"><i class="fas fa-file-alt"></i><br><div style="font-size:8px;">Leaderboard</div></a>
          <a class="nav-link" href="players.php"><i class="fas fa-users"></i><br><div style="font-size:8px;">Players</div></a>
          <a class="nav-link" href="select_Team.php"><i class="fas fa-arrow-up"></i><br><div style="font-size:8px;">Team</div></a>
          <a class="nav-link" href="budget.php"><i class="fas fa-hand-holding-usd"></i><br><div style="font-size:8px;">Budget</div></a>
        </nav>
      </div>
    </div>

    <div class="main-content">
      <h1 class="title">SELECT YOUR TEAM</h1>
  <div style="width: 80%; display: grid;
  column-gap: 10px;
  row-gap: 10px;
  grid-template-columns: auto auto auto;">
      <?php
      include("config.php");

$sql = "SELECT * FROM player WHERE Role = 'Batsman'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
  echo"
        <div class='player-card'>
          <div class='player-name'>{$row['playername']}</div>
          <button type='submit' name='add_player'>Select</button>
        </div>";
}}
?></div>
      </div>
    </div>

<div class="checkout-container">
      <div class="checkout-section">
        <h5>CHECKOUT</h5>
    <?php
$sql = "SELECT * FROM team";
$result = $conn->query($sql);

if ($result->num_rows > 0) { 
  while ($row = $result->fetch_assoc()) {
    echo"   
        <div class=;checkout-item;>{$row['Playername']}<span>RS. 200 000</span></div>
        ";
      }}
        ?>
        <hr>
        <div class="total-section">TOTAL <span></span></div>
        <button class="submit-btn">SUBMIT</button>
      </div>
    </div>

  </div>

</body>
</html>
