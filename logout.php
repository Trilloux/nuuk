<?php 
// Start the session to manage user data
session_start();

// Include the database connection file
include 'database.php';

// Get the user ID from session
$offline_id = $_SESSION['id'];

// Update the user's status to "offline" in the database
$status_query = "UPDATE users SET status='offline' WHERE id=$offline_id";
$status_result = mysqli_query($con, $status_query);
if(!$status_result){
    echo ('Error updating status(online/offline)' . mysqli_error($con));
}

// Unset or remove specific session variables to log out the user
unset($_SESSION['id']);
unset($_SESSION['email']);
unset($_SESSION['firstName']);
unset($_SESSION['lastName']);
unset($_SESSION['login_error']);
session_destroy();

// Close the database connection
mysqli_close($con);

// Redirect the user to the login page after logout
header("Location: index.php");
exit();
?>
