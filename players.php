<?php
include("config.php");
require_once 'playerdit.php';

$result = $conn->query("SELECT * FROM player ORDER BY player_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Management</title>
    <!---<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">-->
<style>
    html, body {
      margin: 0;
      padding: 0;
      width: 100%;
      height: 100%;
      background-color: #f2f2f2;
      font-family: Arial, sans-serif;
    }

    .layout-wrapper {
      display: flex;
      width: 100%;
      height: 100%;
    }

    .sidebar {
      width: 70px;
      background-color: #fff;
      border-right: 1px solid #ccc;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      border-radius: 30px;
      margin: 100px 8px;
      height: 60%;
      box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
    }

    .sidebar .nav-link {
      width: 100%;
      text-align: center;
      color: #000;
      font-size: 1.4rem;
      padding: 1rem 0;
      display: block;

    }

    .main-content {
      flex: 1;
      overflow-y: auto;
      padding: 1rem;
    }
    
    .navbar button {
    padding: 8px 15px;
    border: none;
    background: #007bff;
    color: white;
    cursor: pointer;
    border-radius: 5px;
    font-size: 14px;
    float: right !important;
    }

    .navbar button:hover {
        background: #0056b3;
    }
    .players-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 16px;
      padding-bottom: 60px;
      width: 80%;
      margin-top: -70vh;
      margin-left: 100px;
      margin-bottom: 100vh;
    }
    .navbars {
        background-color: red;
        width: 20%;
        padding: 10px 20px;
        position: absolute;
        top: 0;
        right: 0;
        display: flex;
        justify-content: flex-end;
        gap: 10px !important;
    }

    .player-card {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      position: relative;
    }

    .player-photo {
      width: 100%;
      height: 150px;
      object-fit: cover;
    }

    .card-bottom {
      background-color: #86c0ff;
      padding: 0.75rem;
      min-height: 80px;
      text-align: center;
      font-weight: bold;
    }

    .player-price {
      position: absolute;
      top: 0.5rem;
      right: 0.5rem;
      background-color: #fff;
      color: #000;
      padding: 0.5rem 0.8rem;
      font-size: 1.2rem; 
      font-weight: bold;
      border-radius: 4px;
    }

    .floating-plus {
      position: fixed;
      bottom: 50px;
      right: 20px;
      background-color: #007bff;
      color: #fff;
      width: 100px;
      height: 50px;
      border-radius: 10%;
      font-size: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      z-index: 999;
    }
  </style>
</head>
<body><?php
include("config.php");
session_start(); 

if(!isset($_SESSION)){
    echo "<div class='navbars'>
                    <a href='signup.php'>
                        <button>Signup</button>
                    </a>
                    <a href='login.php'>
                        <button>Login</button>
                    </a>
               </div>";
    exit();
}

else if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $id = $_SESSION['user_id'];
        echo "<div class='navbar'>
                    <a href='useraccount.php'>
                        <button>Welcome $username</button>
                    </a>
               </div>";
} else {
    echo "<div class='navbar'>
                    <a href='signup.php'>
                        <button>Signup</button>
                    </a>
                    <a href='login.php'>
                        <button>Login</button>
                    </a>
               </div>"; 
}
?>

<div class="main-content" style="top: 0px ; position:relative;">
    <div class="sidebar">
      <nav class="nav flex-column w-100">
        <a class="nav-link" href="tournament.php"><i class="fas fa-home"><br><span style="font-size:8px;">Tournament</span></i></a>
        <a class="nav-link" href="leaderboard.php"><i class="fas fa-file-alt"></i><br><span style="font-size:8px;">Leaderboard</span></a>
        <a class="nav-link" href="players.php"><i class="fas fa-users"></i><br><span style="font-size:8px;">Players</span></a>
        <a class="nav-link" href="budget.php"><i class="fas fa-hand-holding-usd"></i><br><span style="font-size:8px;">Budget</span></a>
      </nav>
    </div>
      <div class="players-grid" >
            <?php while ($row = $result->fetch_assoc()) { ?>
                <a href="player_details.php?id=<?php echo $row["player_id"]; ?>">
                    <div class="player-card">
                        <div class="player-price"><?php echo $row["Price"]; ?></div>
                        <?php if($row["role"]=="Batsman"){
                          echo "<img src='src/bat.jpeg'  class='player-photo'>";
                           }
                           else if($row["role"]=="Bowler"){ 
                            echo "<img src='src/ball.jpeg'  class='player-photo'>";}?>
                        <div class="card-bottom">
                            <?php echo $row["playername"]; ?>
                            <?php echo $row["role"]; ?>
                        </div>
                    </div>
            </a>
              <?php } ?>
      </div>
    </div>
<?php
    include("config.php");
    if(!isset($_SESSION)){
        exit();
    }
    else if($_SESSION['username'] == 'adminteam') {
        echo "<a href='phpfiles/add_player.php'><button type='submit' class='floating-plus btn btn-success'>Add Player</button></a>";}
    else {
        
    }    
        
?> 
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
