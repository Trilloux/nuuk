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
            <div id="container">
                <div id="header">
                    <img src="PIC/nuuk_logo.png" alt="Nuuk logo" >
                </div>
                 <div id="form_field">
                    <div id="form">
                        <form method="post" id="login_form" action="">
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
                <input type="submit" value="Login" class="button" id="sub_button" >
                <br>
                <a class="button" id="reset_button"  href="reset_password.php">Forgot password?</a>


                    </form>
            </div>
            <footer id="footer">
                    <p>Copyright © 2024 NUUK Media. All rights reserved.</p>
            </footer>
        </div>
		</body>
	</html>