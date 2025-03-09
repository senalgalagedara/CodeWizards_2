<?php
require_once 'playerdit.php';
require_once 'config.php';

if (isset($_POST['update'])) {
    $id = $_POST['player_id'];

    $player = playerdit::getById($id); 

    if ($player) {
        $player->setPlayerName($_POST['playername']);
        $player->setRole($_POST['role']);

        if ($player->update()) {
            header("location:player_details.php");
            exit();
        } else {
            echo "<script>alert('Update failed.');</script>";
        }
    } else {
        echo "<script>alert('Player not found.');</script>";
    }
} else {
    echo "<script>alert('Invalid request.');</script>";
}
?>
