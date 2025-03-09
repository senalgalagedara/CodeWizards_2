

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournement Summery - Spirit11</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: url('your-background-image.jpg') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        
    </style>
    <!---<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">-->
</head>
<body>
<a href="players.php">player list</a>
<?php
include("config.php");
session_start(); 

if(!isset($_SESSION)){
    echo "<div class='navbar'>
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


    <div class="container">
        <h1>TOURNAMENT SUMMARY</h1>
        <div class="stats">
    <?php
include("config.php");

$totruns = "SELECT SUM(p_runs) AS total_runs FROM player_stat";
$totwickets = "SELECT SUM(p_wickets) AS total_wickets FROM player_stat";

$sql = "SELECT p.playername, ps.p_runs 
        FROM player_stat ps
        JOIN player p ON ps.player_id = p.player_id
        ORDER BY ps.p_runs DESC
        LIMIT 1";  

$sql2 = "SELECT p.playername, ps.p_wickets 
         FROM player_stat ps
         JOIN player p ON ps.player_id = p.player_id
         ORDER BY ps.p_wickets DESC
         LIMIT 1"; 

$result = $conn->query($sql);
$result2 = $conn->query($sql2);
$result3 = $conn->query($totruns);
$result4 = $conn->query($totwickets);

if ($result3->num_rows > 0) {
    $row3 = $result3->fetch_assoc();
    echo "
            <div class='stat-box'>
                <h2>OVERALL RUN</h2>
                <p> {$row3['total_runs']} RUNS</p>
            </div>";
}

if ($result4->num_rows > 0) {
    $row4 = $result4->fetch_assoc();
    echo "
            <div class='stat-box'>
                <h2>OVERALL WICKET</h2>
                <p>{$row4['total_wickets']} WICKETS</p>
            </div>";
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "
            <div class='stat-box'>
                <h2>HIGHEST RUN Scorer</h2>
                <p> {$row['p_runs']} RUNS</p>
                <p style = 'font-size:18px'>by {$row['playername']}</p>
            </div>";
}

if ($result2->num_rows > 0) {
    $row2 = $result2->fetch_assoc();
    echo "  <div class='stat-box'>
                <h2>HIGHEST RUN Scorer</h2>
                <p> {$row2['p_wickets']} RUNS</p>
                <p style = 'font-size:18px'>by {$row2['playername']}</p>
            </div>";
} else {
    echo "No records found.";
}

$conn->close();
?>
       </div>
       </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
