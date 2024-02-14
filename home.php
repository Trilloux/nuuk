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
		<title>Workspace Dashboard</title>
		<meta name="author" content="Trilloux" >
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		 <meta name="description" content="Nuuk Media OU workspace page">
		   <meta name="keywords" content="Nuuk Media OU">
		   <link rel="stylesheet" href="CSS/home.css">
		   <link rel="stylesheet" href="CSS/edit_profile_style.css">
		   <link rel="stylesheet" href="CSS/news.css">
		   <link rel="stylesheet" href="CSS/admin_dashboard.css">
		   <link rel="stylesheet" href="CSS/create_edit_user.css">
		   <link rel="stylesheet" href="CSS/tasks.css">
		   <link rel="stylesheet" href="CSS/alerts.css">
		   <script src="JS/onload_home.js"></script>
		   <script src="JS/user_alerts.js"></script>
		   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	</head>
	<body>
		<div id="wrapper">
			<div id="header">
				<div id="logo">
					<img src="PIC/nuuk_logo.png" alt="Media logo">
				</div>
				<div id="welcome">
            		<?php
					session_start();
					include 'database.php';
					$id= $_SESSION["id"];
					$sql=mysqli_query($con,"SELECT * FROM register where id='$id' ");
					$row  = mysqli_fetch_array($sql);
            		?>
					<p><br>Welcome <?php echo $_SESSION["firstName"] ?> <?php echo $_SESSION["lastName"] ?>!</p>
				</div>
				<div id="clouds">
					<img src="PIC/cloud_test.png" alt="cloud" id="cloud_1">
            		<img src="PIC/cloud_test1.png" alt="cloud" id="cloud_2">
				</div>
			</div>

    		<div id="container">
    			<div id="control_panel">
					<button class="cp_button"><a href="?id=1"><img src="PIC/main.png" alt=""></a></button>
					<button class="cp_button"><a href="?id=2"><img src="PIC/tasks.png" alt=""></a></button>
					<button class="cp_button"><a href=""><img src="PIC/calendar.png" alt=""></a></button>
					<button class="cp_button"><a href=""><img src="PIC/messages.png" alt=""></a></button>
					<button class="cp_button" id="alerts_button"><a href="?id=5" id="alerts_image"><img src="PIC/alerts.png" alt=""><span id="alert_count">0</span></a></button>
					<button class="cp_button"><a href=""><img src="PIC/files.png" alt=""></a></button>
					<button id="logout_button"><a href="logout.php" class="link"><span id="std_icon">&#9212;</span> Logout</a></button>
				</div>
				<div id="main">
					<?php
					if(isset($_GET['id']) && isset($_SESSION['role']) && $_GET['id'] == 'admin' && $_SESSION['role'] == 'admin'){
						include 'Admin/admin_dashboard.php';
					}
					if(isset($_GET['id']) && isset($_SESSION['role']) && $_GET['id'] == 'admin_1' && $_SESSION['role'] == 'admin'){
						include 'Admin/create_user.php';
					}
					if(isset($_GET['id']) && isset($_SESSION['role']) && $_GET['id'] == 'admin_2' && $_SESSION['role'] == 'admin'){
						include 'Admin/edit_user.php';
					}
					if(isset($_GET['id']) && isset($_SESSION['role']) && $_GET['id'] == 'admin_3' && $_SESSION['role'] == 'admin'){
						include 'main/news_form.php';
					}
					if(isset($_GET['id']) && isset($_SESSION['role']) && $_GET['id'] == 'admin_4' && $_SESSION['role'] == 'admin'){
						include 'main/edit_news.php';
					}
					if($_GET['id']=='edit_id'){
						include 'edit_profile.php';
					}
					if($_GET['id']==1){
						include 'main/news.php';
					}
					if($_GET['id']==2){
						include 'tasks/tasks_dashboard.php';
					}
					if($_GET['id']==21){
						include 'tasks/tasks_form.php';
					}
					if($_GET['id']==5){
						include 'alerts/alerts_dashboard.php';
					}
					?>
				</div>
				<div id="side_bar">
				<?php
					// Get profile pic name form DB
					$profileImageQuery = "SELECT profile_image FROM users WHERE id = $id";
					$profileImageResult = mysqli_query($con, $profileImageQuery);
					if ($profileImageResult && $row = mysqli_fetch_assoc($profileImageResult)) {
						$targetDir = "uploads/user_$id/";
						$profileImage = $row['profile_image'];
						// If profile_image field in DB empty then use default picuture in uploads folder
						if (empty($profileImage)) {
							$targetDir = "uploads/";
							$profileImage = "default.png"; 
						}
					} 
					?>
					<img src="<?= $targetDir . $profileImage ?>" id="prof_pic" alt="Profile picture">
					<button id="settings_button"><a href="?id=edit_id" id="settings_link">Settings</a></button>
					<?php if ($_SESSION['role'] == 'admin') { ?>
    				<button id="settings_button"><a href="?id=admin" id="settings_link">Admin</a></button>
					<?php } ?>
				</div>
			</div>
			<div id="sub_content">
				<div id="footer">
					<p>Copyright © 2024 NUUK Media. All rights reserved.</p>
				</div>
				<div id="image_section">
					<img src="PIC/rocket.png" alt="Rocket">
				</div>
			</div>
		</div>
	</body>
</html>