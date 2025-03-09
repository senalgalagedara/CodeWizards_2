<?php
include ("../config.php");

if(isset($_POST['update']) )
{
    $id = $_POST['player_id'];
    $playername = $_POST['playername'];
    $role = $_POST['role'];
    $p_point = $_POST['p_point'];
    $bsr = $_POST['bat_SR'];
    $ballsr = $_POST['ball_SR'];
    $ecr = $_POST['Econ_rate'];
    $price = $_POST['Price'];

    $sql = "UPDATE player 
    SET playername = '$playername', 
        role = '$role', 
        p_point = $p_point, 
        bat_SR = $bsr, 
        ball_SR = $ballsr, 
        Econ_rate = $ecr, 
        Price = $price 
    WHERE player_id = $id";
    $result = $conn->query($sql);

    if ($result === TRUE) {
        header("Location: ../player_details.php?id=$id");
    }
    
    else{
        echo "<script>
    alert('details not complete');
          </script>
        ";
    }

}else{ echo "<script>
    alert('details not complete');
          </script>
        ";}

?>