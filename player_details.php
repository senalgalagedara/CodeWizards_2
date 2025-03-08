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

$sql = "
        SELECT player_id, playername, role, p_point, bat_SR, ball_SR, Econ_rate, Price
        FROM player
        WHERE player_id = '$id';
";

$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['player_id'];
        $playername = $row['playername'];
        $role = $row['role'];
        $ppoint = $row['p_point'];
        $bat_sr = $row['bat_SR'];
        $ball_sr = $row['ball_SR'];
        $e_rate = $row['Econ_rate'];
        $price = $row['Price'];

        echo "
        <form action='update_player.php' method='post'>
            <table>
                <tr>
                    <th colspan='2'></th>
                </tr>
                <tr>
                    <td class= 'accdetails'>User Id</td>
                </tr>
                <tr>
                    <td class= 'accdetails'>Player Name</td>
                    <td><input type='text' name='playername' class='accint ' value='$playername'></td>
                </tr>
                <tr>
                    <td class= 'accdetails'>Role</td>
                    <td><input type='text' name='role' class='accint ' value='$role'></td>
                </tr>
                <tr>
                    <td class= 'accdetails'>Player Point</td>
                    <td><input type='text' name='p_point' class='accint ' value='$ppoint'></td>
                </tr>
                <tr>
                    <td class= 'accdetails'>Batting Strike Rate</td>
                    <td><input type='text' name='bat_SR' class='accint ' value='$bat_sr'></td>
                </tr>
                <tr>
                    <td class= 'accdetails'>Ball Strike Rate</td>
                    <td><input type='text' name='ball_SR' class='accint ' value='$ball_sr'></td>
                </tr>
                <tr>
                    <td class= 'accdetails'>Economy Rate</td>
                    <td><input type='text' name='Econ_rate' class='accint' id='email' value='$e_rate'></td>
                </tr>
                <tr>
                    <td class= 'accdetails'>Price</td>
                    <td><input type='text' name='price' class='accint' id='email' value='$price'></td>
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