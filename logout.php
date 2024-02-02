<?php 
// Start the session to manage user data
session_start();

// Unset or remove specific session variables to log out the user
unset($_SESSION['id']);
unset($_SESSION['email']);
unset($_SESSION['firstName']);
unset($_SESSION['lastName']);
unset($_SESSION['login_error']);
session_destroy();
// Redirect the user to the login page after logout
header("Location: index.php");
exit();
?>
