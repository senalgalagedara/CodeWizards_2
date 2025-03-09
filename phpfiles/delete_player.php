<?php
include ("../config.php");

if(isset($_POST['delete'])){
    $id = $_POST['player_id'];

    $sql = "DELETE FROM player WHERE player_id = '$id'";

    $result = $conn->query($sql);

    if($result === TRUE){
        session_start();
        session_destroy();
        header("location:../players.php");
        exit();
    }
    else{
        echo "<script>
            alert('User id not deleted');
              </script>
            ";    
}
};
?>
