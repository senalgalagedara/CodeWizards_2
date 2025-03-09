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
        echo "Invalid request.";
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
</head>
<body>
<h2 id="newarrivals" class="topic" style="margin-top: 40px;">Account Information</h2>
<table>
    <tr>
    <tbody>
    <?php
include("config.php");
require_once("playerdit.php");


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
        <form action='update_player.php' method='post'>
            <table>
                <tr>
                    <th colspan='2'></th>
                </tr>
                <tr>
                    <td class= 'accdetails'>User Id</td>
                    <td><input type='text' name='player_id' class='accint ' value='{$row['player_id']}' readonly></td>
                </tr>
                <tr>
                    <td class= 'accdetails'>Player Name</td>
                    <td><input type='text' name='playername' class='accint ' value='{$row['playername']}'></td>
                </tr>
                <tr>
                    <td class= 'accdetails'>Role</td>
                    <td><input type='text' name='role' class='accint ' value='{$row['role']}'></td>
                </tr>
                
                <tr>
                    <td class= 'accdetails'>Batting Strike Rate</td>
                    <td><input type='text' name='bat_SR' class='accint ' value='{$calcBat_SR}'></td>
                </tr>
                <tr>
                    <td class= 'accdetails'>Batting Avarage</td>
                    <td><input type='text' name='bat_SR' class='accint ' value='{$calcBat_avg}'></td>
                </tr>
                <tr>
                    <td class= 'accdetails'>Ball Strike Rate</td>
                    <td><input type='text' name='ball_SR' class='accint ' value='{$calcBall_SR}'></td>
                </tr>
                <tr>
                    <td class= 'accdetails'>Economy Rate</td>
                    <td><input type='text' name='Econ_rate' class='accint' id='email' value='{$calcEcon_Rate}'></td>
                </tr>
                <tr>
                    <td class= 'accdetails'>Player Point</td>
                    <td><input type='text' name='p_point' class='accint ' value='{$calcPlayerPoint}'></td>
                </tr>
                <tr>
                    <td class= 'accdetails'>Price</td>
                    <td><input type='text' name='Price' class='accint' id='email' value='{$calcValue}'></td>
                </tr>
                <tr>
                    <td>
                        <button type='submit' class='updatebtn' name='update'>Update</button>
                    </td>
                    <td>
                        <button type='submit' class='deletebtn' name='delete' formaction='deleteuser.php'>Delete</button>
                    </td>
                </tr>
            </table>
        </form>";
    }
} else {
    echo "Error fetching details.";
}
?>

</tr>
</tbody>
</table>
</body>
</html>