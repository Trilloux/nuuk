<?php
// Start the session to manage user data
session_start();
include 'loginAttempts.php';
// Retrieve login error message from session
$errorMessage = $_SESSION['login_error'];
// Check if the user is already logged in (id is set in the session)
if (isset($_SESSION['id'])) {
    // Redirect to the home page if the user is already logged in
    header("Location: home.php");
    exit();
}
?>


<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8" />
		<title>Login</title>
		<meta name="author" content="Trilloux" >
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		 <meta name="description" content="Nuuk Media OU login page">
		   <meta name="keywords" content="Nuuk Media OU">
		   <link rel="stylesheet" href="CSS/login.css">
           <script src="JS/login.js"></script>
	</head>
	<body>
        <div id="wrapper">
            <img src="PIC/cloud_test.png" alt="cloud" id="cloud_1">
            <img src="PIC/cloud_test1.png" alt="cloud" id="cloud_2">
            <div id="container">
                <div id="header">
                    <img src="PIC/nuuk_logo.png" alt="Nuuk logo" >
                </div>
                <div>
                <?php if($errorMessage != "" && $_SESSION['login_attempts'] <5){ ?>
                        <p id="login_error"><?php echo $errorMessage; //display PHP error message ?></p>
                     <?php }else{ ?>
                        <p id="login_error"><?php displayTooManyAttemptsMessage(); ?></p>
                    <?php } ?>
                </div>
                 <div id="form_field">
                    <div id="form">
                        <form method="post" id="login_form" action="loginProcess.php" >
                        <label>Username<span class="req-field">*</span></label>
                        <span id="username_error_1" class="error-message">Enter username</span>
                        <span id="username_error_2" class="error-message">Username contains atleast 6 characters!</span>
                        <input type="text" name="username" id="username">
                        <br>
                        <label>Password<span class="req-field">*</span></label>
                        <span id="password_error_1" class="error-message">Enter password</span>
                        <span id="password_error_2" class="error-message">Password containts atleast 8 characters !</span>
                        <input type="password" name="password" id="password">
                        <br> 
                 </div>
                </div>
                <input type="submit" value="Login" class="button" id="sub_button" name="save" <?php if (shouldBlockSubmitButton()) { echo 'disabled'; } ?>>
                <br>
                <a class="button" id="reset_button"  href="reset_password.php">Forgot password?</a>
            </form>
            </div>
            <footer id="footer">
                <a href="https://nuukmedia.com" target="_blank">
                    <img src="PIC/nuuk_media_logo.png" alt="Nuuk logo">
                </a>
                <a href="https://www.linkedin.com/company/nuuk-media/about/" target="_blank">
                    <img src="PIC/linkedin.png" alt="Linkedin logo">
                </a>
                    <p>Copyright © 2024 NUUK Media. All rights reserved.</p>
            </footer>
        </div>
		</body>
	</html>