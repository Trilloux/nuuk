<?php
// Start the session to manage user data
session_start();

// Check if the user is not logged in (id is not set in the session)
if (!isset($_SESSION["id"])) {
    // Redirect to the login page if not logged in
    header("Location: index.php");
    exit();
}

// Proceed to the rest of the content on the home.php page
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
    <div class="signup-form">
    <form action="home.php" method="post" enctype="multipart/form-data">
		<h2>Welcome</h2>
        <br>

            <?php
				session_start();
				include 'database.php';
				$id= $_SESSION["id"];
				$sql=mysqli_query($con,"SELECT * FROM register where id='$id' ");
				$row  = mysqli_fetch_array($sql);
            ?>
            
        <img src="upload/<?php echo $row['File'] ?>" height="150" width="150" style="border-radius:50%;display:block;margin-left:auto;margin-right:auto;" />
		<p class="hint-text"><br><b>Welcome </b><?php echo $_SESSION["firstName"] ?> <?php echo $_SESSION["lastName"] ?></p>
        <div class="text-center">Want to Leave the Page? <br><a href="logout.php">Logout</a></div>
    </form>
        <body>
            </html>