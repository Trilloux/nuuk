<?php
// Start the session to manage user data
session_start();
include 'loginAttempts.php';

// Initialize error message variable
$errorMessage = null;

// Check if the form is submitted
if (isset($_POST['save'])) {
    // Extract form data
    extract($_POST);

    // Include the database connection file
    include 'database.php';

    // Prepared statements to avoid SQL injections
    $stmt = $con->prepare("SELECT * FROM users WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    // Get the result of the query
    $result = $stmt->get_result();

    // Check for SQL errors
    if (!$result) {
        die('SQL error: ' . mysqli_error($con));
    }

    // If a matching user is found
    if ($result->num_rows > 0) {
        reset_logins();
        // Fetch user data
        $row = $result->fetch_assoc();

        // Set session variables for the logged-in user
        $_SESSION["id"] = $row['id'];
        $_SESSION["email"] = $row['email'];
        $_SESSION["firstName"] = $row['firstName'];
        $_SESSION["lastName"] = $row['lastName'];

        // Redirect to the home page
        header("Location: home.php");
    } else {
        // If no matching user is found, set an error message and redirect to the login page
        $_SESSION['login_error'] = "Invalid Username/Password!";
        header("Location: index.php");
        invalid_logins();
        displayTooManyAttemptsMessage();
        isLoginBlocked();
        
        exit();
    }

    // Close the prepared statement and the database connection
    $stmt->close();
    $con->close();
}
?>

