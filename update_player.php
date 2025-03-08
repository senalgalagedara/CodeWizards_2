<?php
include ("config.php");

if(isset($_POST['update']) )
{
    $id = $_POST['player_id'];
    $playername = $_POST['playername'];
    $role = $_POST['role'];
    $p_point = $_POST['p_point'];
    $bat_SR = $_POST['bat_SR'];
    $ball_SR = $_POST['ball_SR'];
    $econ_r = $_POST['Econ_rate'];
    $price = $_POST['Price'];


    $sql = "UPDATE player SET playername='$playername', role='$role',p_point='$p_point', bat_SR ='$bat_SR' ,ball_SR='$ball_SR',Econ_rate='$econ_r',Price = '$price' WHERE player_id = '$id'";    

    $result = $conn->query($sql);

    if($result === TRUE)    
    {
        header("location:player_details.php");
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