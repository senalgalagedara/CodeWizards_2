<?php
    include("config.php");
    
    $error = "";
    $success = "";

    if(isset($_POST['submitsignin'])){
        $uname = trim($_POST['username']);
        $pw = trim($_POST['password']);
        $cpw = trim($_POST['c_password']);

        if(empty($uname) || empty($pw) || empty($cpw)){
            $error = "All fields are required.";
        } elseif($pw !== $cpw) {
            $error = "Passwords do not match.";
        } elseif(strlen($pw) < 6) {
            $error = "Password must be at least 6 characters.";
        } else {
            $hashed_pw = password_hash($pw, PASSWORD_BCRYPT);

            $sql = "INSERT INTO sign_in(username, password , c_password) VALUES ('$uname', '$hashed_pw' , '$cpw')";

            if($conn->query($sql) === TRUE) {
                header("Location: login.php");
            } else {
                $error = "Error: " . $conn->error;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Spirit11</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/signup.js" defer></script>
</head>
<body style="background-image: url('https://i.imgur.com/5wt06s6.gif'); background-repeat:no-repeat;">
<div class="login_ui">
    <form class="form-box" style="height: 570px; padding:20px 30px;" action="" method="post" id="signupForm">
        <h2 class="headd">Create Account</h2>
        <p class="signpara">Please fill in the information below to create an account</p>

        <p class="signparaa">Username</p>
        <input class="inputbox" type="text" name="username" id="username" required>
        <p id="uerror" style="color: red;"></p>

        <p class="signparaa">Password</p>
        <input class="inputbox" type="password" name="password" id="password" onkeyup="checkPasswordStrength()" required>
        <div id="pw_strength"></div>
        <p id="perror" style="color: red;"></p>

        <p class="signparaa">Confirm Password</p>
        <input class="inputbox" type="password" name="c_password" id="c_password" required>
        <p id="cpwerror" style="color: red;"></p>

        <p class="signpara marginpara">
            <input class="checkbox" type="checkbox" name="terms" id="terms" required> By clicking this you agree to our terms & conditions.
        </p>

        <button type="submit" name="submitsignin" class="signup_submit" id="submitBtn" style="cursor: pointer;">Create An Account</button>

        <p class="para" style="text-align: center; margin-top: 20px;">
            Already have an account?
            <a href="login.php" style="color: blue;">Login here</a>
        </p>
    </form>
</div>
</body>
</html>
</body>
</html>
