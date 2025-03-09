<?php
    include("config.php");
    session_start(); 

    if(!isset($_SESSION)){
        echo "Session has not been started!";
        exit();
    }

    if(isset($_SESSION['username'])){
        $sql = "SELECT * FROM sign_in WHERE username =?;";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_assoc($result);

        $email = $_SESSION['username'];
        $id = $_SESSION['user_id'];

    } else {

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Account  - Spirit11</title>
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
<a href="tournament.php">back to home</a>
<div >
<table>
    <tr>
    <tbody>
    <?php
include("config.php");

$userId = $_SESSION['user_id'];  

$sql = "
        SELECT user_id,username FROM sign_in
        WHERE user_id = '$userId';
";

$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['user_id'];
        $username = $row['username'];
        

        echo "
        <div class='userform'>
        <form action='' method='post' >
            <table class='usertable'>
                <tr>
                    <th colspan='2'></th>
                </tr>
                <tr>
                    <td class= 'accdetails'>User Id</td>
                    <td ><input class='useraccint' type='text' name='User_Id' value='$id' class='accint none' readonly></td>
                </tr>
                <tr>
                    <td class= 'accdetails'>Username</td>
                    <td><input class='useraccint' type='text' name='username' class='accint ' value='$username'></td>
                </tr>
                
                <tr>
                    <td>
                    </td>
                </tr>
            </table>
            <button type='submit' style = 'cursor:pointer;' class='logout' name='logout' formaction='phpfiles/logout.php'>log out</button>

        </form>";
    }
} else {
    echo "Error fetching details.";
}
?>

</tr>
</tbody>
</table>
        </div>
    </div>
</div>

            </div>
        </div>
    </div>

</body>
</html>