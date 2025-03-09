<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In - Spirit11</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/login.js"></script>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');
    </style>
</head>
<body style="background-image: url('https://i.imgur.com/5wt06s6.gif'); background-repeat:no-repeat;">
<div class="login_ui">
    <form class="form-box" style="height: 450px; padding:20px 30px;" method="post" action="phpfiles/authenticate.php" >
        <h2 class="headd">Login to my Account</h2>
        <p class="signpara">Enter your Username and Password</p>

        <p class="signparaa">Username</p>
        <input class="inputbox" type="text" id='username' name="username" required>
    
        <p class="signparaa">Password</p>
        <input class="inputbox" type="password" name="password" id="password" required>
        <p id="perror" style="color: red;"></p>

        <script>
            function validatePassword() {
            const password = passwordInput.value;
            const hasLowercase = /[a-z]/.test(password);
            const hasUppercase = /[A-Z]/.test(password);
            const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);

            if (!hasLowercase || !hasUppercase || !hasSpecialChar) {
                passwordError.textContent = "Password must contain at least one lowercase, one uppercase, and one special character.";
                return false;
            } else {
                passwordError.textContent = "";
                return true;
            }
        }
        const toggleBtn = document.querySelector('.toggle_btn')
        const toggleBtnIcon = document.querySelector('.toggle_btn i')
        const dropDownMenu = document.querySelector('.dropdown_menu')

        toggleBtn.onclick = function (){
            dropDownMenu.classList.toggle('open')
            const isOpen = dropDownMenu.classList.contains('open')

            toggleBtnIcon.classList = isOpen
            ? 'fa-solid fa-xmark'
            : 'fa-solid fa-bars'

        }

        var loginbtn = document.getElementById("login_form");
        var regbtn = document.getElementById("reg_form");
        var btnswitch = document.getElementById("login_btns");


        function reg_switch(){
            loginbtn.style.left = "-400px";
            regbtn.style.left = "50px";
            btnswitch.style.left = "110px";
        }

        function login_switch(){
            loginbtn.style.left = "50px";
            regbtn.style.left = "450px";
            btnswitch.style.left = "0";
        }

        document.getElementById('logo-image').src = 'https://i.imgur.com/frY3DFk.png';

        </script>
 
        <button type="submit" class="login_submit" name="loginbtn">Login</button>

        <p class="para" style="text-align: center; margin-top: 20px;">
            New Customer?
            <a href="signup.php" style="color: blue;">Create your account</a>
        </p>
    </form>
</div>
</body>
</html>