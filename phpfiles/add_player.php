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
                header("Location: ../players.php?id=$player_id");
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
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Player</title>
    <style>
        .form-container {
            background-color: #444;
            color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 70%;
            text-align: center;
            display: block;
            margin-top: -500px !important;
            margin: auto;
        }

        h2 {
            margin-bottom: 20px;
            color: white;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            padding: 20px;
        }

        label {
            text-align: left;
            font-size: 14px;
            color: white;
        }

        input, select {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 14px;
            width: 100%;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #007bff;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
        }

        .apply-btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 60%;
            margin: auto;
        }

        .cancel-btn {
            background-color: #ff4d4d;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 48%;
        }

        .apply-btn:hover, .cancel-btn:hover {
            opacity: 0.9;
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

    </style>
</head>
<body>
<div class="sidebar">
      <nav class="nav flex-column w-100">
        <a class="nav-link" href="../tournament.php"><i class="fas fa-home"><br><span style="font-size:8px;">Tournament</span></i></a>
        <a class="nav-link" href="../leaderboard.php"><i class="fas fa-file-alt"></i><br><span style="font-size:8px;">Leaderboard</span></a>
        <a class="nav-link" href="../players.php"><i class="fas fa-users"></i><br><span style="font-size:8px;">Players</span></a>
        <a class="nav-link" href="../budget.php"><i class="fas fa-hand-holding-usd"></i><br><span style="font-size:8px;">Budget</span></a>
      </nav>
    </div>
<div class="form-container">
    <h2>Add New Player</h2>
    <form action="add_player.php"  method="POST">
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
            <button type="submit" class="apply-btn">Add Player</button>
          
    </form>
</body>
</html>
