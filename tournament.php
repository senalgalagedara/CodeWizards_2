<?php
require_once 'playerdit.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournement Summery</title>
    <!---<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">-->
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center">Tournement Summery</h2>
<?php
include("config.php");

    $totruns = "SUM(p_runs) FROM player_stat";
    $totwickets = "SUM(p_wickets) FROM player_stat";

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

    if($result3 == TRUE){
        $row3 = $result3->fetch_assoc();
        echo
        "<div>
            <p></p>
            <h3>Overall Runs</h3>
        </div> ";
    }
    if($result4 == TRUE){
        $row4 = $result4->fetch_assoc();
            echo"
            <div>
            <p></p>
            <h3>Overall Wickets</h3>
            </div> ";
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo"
            <div>
            <p>{$row['playername']}</p>
            <p>{$row['p_runs']}</p>
            <h3>Highest run Scorer</h3>
            </div> 
            ";
    }
    if ($result2->num_rows > 0) {
        $row2 = $result2->fetch_assoc();
        echo"
            <div>
                <p>{$row2['playername']}</p>
                <p>{$row2['p_wickets']}</p>   
                <h3>Highest Wicket taker</h3>
            </div> ";
    } else {
        echo "No records found.";
    }
    
    $conn->close();
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
