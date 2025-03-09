<?php
    require_once 'playerdit.php';

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $player = playerdit::getById($id);
        if (!$player) {
            echo "Player not found.";
            exit;
        }
    } else {
        header("Location: player_details.php?id=$id");
        //echo "Invalid request.";
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player - Sprint11 </title>
    <link rel="stylesheet" href="css/style.css">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .accint
            {
            border: none;
            }
        body {
            background-color: #f8f9fa;
        }
        .profile-container {
            width: 90%;
            margin: 100px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .player-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
        }
        .player-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        .player-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .player-name {
            font-size: 30px;
            font-weight: bold;

        }
        .player-role {
            font-size: 12px;
            color: gray;
        }
        .player-price {
            font-size: 30px;
            font-weight: bold;
            color: green !important;
        }
        .player-stats {
            background: #e9f5ff;
            padding: 20px;
            border-radius: 5px;
        }
        .buy-button {
            background-color: green;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
            position: relative;
            right: -500px;
        
        }
        .update-button {
            background-color: green;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .delete-button {
            background-color: red;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="layout-wrapper">
    <div class="sidebar">
      <nav class="nav flex-column w-100">
        <a class="nav-link" href="tournament.php"><i class="fas fa-home"><br><div style="font-size:8px;">Tournament</div></i></a>
        <a class="nav-link" href="leaderboard.php"><i class="fas fa-file-alt"></i><br><div style="font-size:8px;">Leaderboard</div></a>
        <a class="nav-link" href="players.php"><i class="fas fa-users"></i><br><div style="font-size:8px;">Players</div></a>
        <a class="nav-link" href="select_Team.php"><i class="fas fa-arrow-up"></i><br><div style="font-size:8px;">Team</div></a>
        <a class="nav-link" href="budget.php"><i class="fas fa-hand-holding-usd"></i><br><div style="font-size:8px;">Budget</div></a>
      </nav>
    </div>
<?php
include("config.php");
require_once("playerdit.php");
session_start(); 

$sql = "
        SELECT player_id, playername, role, p_point, bat_SR, ball_SR, Econ_rate, Price
        FROM player
        WHERE player_id = '$id';
";
$sql2 =" SELECT player_id, p_runs, p_tbf, p_innins, p_totballs, p_wickets
        FROM player_stat
        WHERE player_id = '$id'
";
        $result = mysqli_query($conn, $sql);
        $result2 = mysqli_query($conn, $sql2);


if ($result AND $result2) {
    while ($row = mysqli_fetch_assoc($result) AND $row2 = mysqli_fetch_assoc($result2)) {
        $role = $row['role'];
        $name = $row['playername'];
        $bat_sr = $row['bat_SR'];
        $ball_sr = $row['ball_SR'];
        $e_rate = $row['Econ_rate'];
        $price = $row['Price'];

        $player->setPlayerName($name);
        $player->setRole($role);

        $player->setTotruns($row2['p_runs']);
        $player->setTotBF($row2['p_tbf']);
        $player->setInnins($row2['p_innins']);
        $player->setTotBallF($row2['p_totballs']);
        $player->setTotwickets($row2['p_wickets']);

        $calcBat_SR = $player->calcBat_SR();
        $calcBat_avg = $player->calcBat_avg();
        $calcBall_SR = $player->calcBall_SR();
        $calcEcon_Rate = $player->calcEcon_Rate();
        $calcPlayerPoint = $player->calcPlayerPoint();
        $calcValue = $player->calcValue();

        echo "
        <form class='playerdit' action='phpfiles/update_player.php' method='post'>
        <input type='text' name='player_id' class='accint ' value='{$row['player_id']}' readonly style ='display:none;'>
            <div class='profile-container'>
                <div class='player-header'>
                    <div class='player-info'>
                        <div>
                            <div class='player-name'>{$row['playername']}</div>
                            <div class='player-role'>{$row['role']}</div>                          

                        </div>
                    </div>
                </div>
                <table class='player-stats'>
                    <p><strong>Player Name:<input type='text' name='playername' class='accint ' value='{$row['playername']}'></strong></p>
                    <p><strong>Role:<input type='text' name='role' class='accint ' value='{$row['role']}'></strong></p>
                    <p><strong>Player Point:<input type='text' name='p_point' class='accint ' value='{$calcPlayerPoint}' readonly></strong></p>
                    <p><strong>Batting Strike Rate:<input type='text' name='bat_SR' class='accint ' value='{$calcBat_SR}' readonly></strong></p>
                    <p><strong>Balling Avarage:<input type='text' name='bat_avg' class='accint ' value='{$calcBat_avg}' readonly></strong></p>
                    <p><strong>Balling Strike Rate:<input type='text' name='ball_SR' class='accint ' value='{$calcBall_SR}' readonly></strong></p>
                    <p><strong>Economy Rate:<input type='text' name='Econ_rate' class='accint' id='email' value='{$calcEcon_Rate}' readonly></strong></p>
                    <p><strong>Price:<input type='text' name='Price' style='color:green; font-weight:700; font-size:30px;' class='accint' id='email' value='{$calcValue}' readonly></strong></p>

                    ";

                    if(!isset($_SESSION)){
                        exit();
                    }
                    
                    else if($_SESSION['username'] == 'adminteam') {
                        echo "<button type='submit' class='update-button' name='update'>Update</button>
                        <button type='submit' class='delete-button'' name='delete' formaction='phpfiles/delete_player.php'>Delete</button>";}
                     else {
                        
                    }    }
                } else {
                    echo "Error fetching details.";
                }
                ?>  
                </table>
            </div>


<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
</body>
</html>