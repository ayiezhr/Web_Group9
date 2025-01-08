<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Header</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script>
        function showRegister(){
            var x = document.getElementById("registerDiv");
            x.style.display = 'block';

            var x = document.getElementById("newsDiv");
            x.style.display = 'none';

            var firstField = document.getElementById('matricNo');
            firstField.focus();
        }

        //JS to cancel registration by hiding div (display=none)
        function cancelRegister(){
            var x = document.getElementById("registerDiv");
            x.style.display = 'none';

            var x = document.getElementById("newsDiv");
            x.style.display = 'block';
        }
    </script>
</head>

<body>
    <div class="header">
        <h1>Welcome to FKI leave management system</h1>
    </div>

    <?php 
    if(isset($_SESSION["student_id"])){
        include 'lecturer_logged_menu.php';
    }
    else {
        include 'lecturer_menu.php';
    }
    ?>


    <div class="row">
        <div class="col-login">
            <?php 
                if(isset($_SESSION["lecturer_id"])){
                    // Fetch user's profile picture
                    $profile = isset($_SESSION["img_path"]) ? $_SESSION["img_path"] : "";

                    echo '<div class="imgcontainer">';
                        echo '<img class="avatar" src="lectprofile/' . $profile . '">';
                    echo '</div>';

                    echo '<p align="center">Welcome: ' . $_SESSION["userName"] . "<p>";
            }
            else {
                ?>
                <form action="lecturer_login_action.php" method="post" id="login">
                    <div class="imgcontainer">
                        <img src="img/.png" alt="" class="avatar">
                    </div>

					<div class="container login-container">
                        <div class="input-container">
                            <label for="uname"><b>Username</b></label>
                            <input type="text" placeholder="Username" name="userName" required>
                        </div>
                        <div class="input-container">
                            <label for="psw"><b>Password</b></label>
                            <input type="password" placeholder="Enter Password" name="userPwd" required>
                        </div>
                        <div class="button-container">
                            <button type="submit">Login</button>
                        </div>
                        <label>
                            <input type="checkbox" checked="checked" name="remember"> Remember me
                        </label>
                    </div>

                    <div class="container" style="background-color:#f1f1f1">
                        <span class="psw">
                            <a onClick="showRegister()" style="cursor: pointer;"> Register</a> | 
                            <a style="cursor: pointer;">Forgot password?</a>
                        </span>
                    </div>
                </form>
            <?php 
            }   
            ?>
        </div>

            <div id="registerDiv" class="registration-container">
                <h2>| Lecturer Registration </h2>
                <form action="lecturer_register_action.php" method="post">
                    <label for="usernameL">Username</label>
                    <input type="text" name="lecturerNo" id="lecturerNo" required>

                    <label for="lectEmail">Lecturer Email:</label>
                    <input type="email" id="lectEmail" name="lectEmail" required><br><br>

                    <label for="userPwd">Password:</label>
                    <input type="password" id="userPwd" name="userPwd" required maxlength="8"><br><br>

                    <label for="userPwd">Confirm Password:</label>
                    <input type="password" id="confirmPwd" name="confirmPwd" required><br><br>

                    <input type="submit" value="Register">
                    <input type="reset" value="Reset">
                    <input type="reset" value="Cancel" onClick="cancelRegister()">
                </form>
            </div>
        </div>
    </div>

    <footer>
        <p>Copyright (c) 2024 - FKI Leave Management System (GROUP 9)</p>
    </footer>
</body>
</html>
