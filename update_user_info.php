<?php
//If statement so that page cannot be accessed if not logged id
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

include 'database.php';

$id = intval($_SESSION['id']);

// Get existing values from database where user id
//Display them into form value fields
$query = 'SELECT * FROM users WHERE id = ' . $id;
$result = mysqli_query($con, $query);
$row = mysqli_fetch_array($result);
$edit_fname = $row['firstName'];
$edit_lname = $row['lastName'];
$edit_email = $row['email'];
$edit_password= $row['password'];
$edit_phone = $row['phone'];
if (!$result) {
    die('Connection error' . mysqli_connect_error());
}

// Check if for is submittedf
if (isset($_POST['submit'])) {
    // Create new variables from form input fields when form is submitted
    $update_fname = mysqli_real_escape_string($con, $_POST['first_name']);
    $update_lname = mysqli_real_escape_string($con, $_POST['last_name']);
    $update_email = mysqli_real_escape_string($con, $_POST['email']);
    $update_password = mysqli_real_escape_string($con, $_POST['password']);
    $update_phone = mysqli_real_escape_string($con, $_POST['phone']);


    if ($_FILES['profile_image']['size'] > 0) {
        // Call function to handle image upload and get the new image name
        $newImageName = uploadImage($con, $id);

        // Update the 'profile_image' column in the users table with the new image name
        if ($newImageName !== false) {
            $updateImageQuery = "UPDATE users SET profile_image = ? WHERE id = ?";
            $stmtImage = mysqli_prepare($con, $updateImageQuery);
            mysqli_stmt_bind_param($stmtImage, 'si', $newImageName, $id);
            mysqli_stmt_execute($stmtImage);
            mysqli_stmt_close($stmtImage);
        }
    }

    // Call function to update DB entry for specific user id
    //false - $imgUpload , because here dont upload img
    editQuery($con, $id, $update_fname, $update_lname, $update_email, $update_password, $update_phone, false);
}
//Update database function
function editQuery($con, $id, $update_fname, $update_lname, $update_email, $update_password, $update_phone, $imgUpload)
{
   
    $query = "UPDATE users SET firstName = ?, lastName = ?, email = ?, password = ?, phone = ? WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'sssssi', $update_fname, $update_lname, $update_email, $update_password, $update_phone, $id);

    mysqli_stmt_execute($stmt);

    $affected_rows = mysqli_affected_rows($con);
    //If database is updated , display new information on session for welcome text to be updated
    //if $imgUpload true, dont show error message Error: Data was NOT updated!
    if ($affected_rows == 1 || $imgUpload) {
        header("Location: home.php?id=edit_id");
        $_SESSION['firstName']=$update_fname;
        $_SESSION['lastName']=$update_lname;
        
    } else {
        echo 'Error: Data was NOT updated!' . mysqli_error($con);
    }
    mysqli_stmt_close($stmt);
}

// Function to handle image upload
function uploadImage($con, $id)
{
    $targetDir = "uploads/user_$id/";
    $uploadOk = 1;

    $targetDir = "uploads/user_$id/";
    $uploadOk = 1;
    
    // Create the target directory if it doesn't exist
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
                            //If new image is uploaded , old one is deleted from folder to save space//
    // Get a list of all files in the directory
    $files = glob($targetDir . "*");
    // Iterate through each file and delete it
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
                        //----------------------------------------------------------------------//
    $targetFile = $targetDir . basename($_FILES["profile_image"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["profile_image"]["size"] > 10000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    $allowedExtensions = array("jpg", "jpeg", "png");
    if (!in_array($imageFileType, $allowedExtensions)) {
        echo "Sorry, only JPG, JPEG, and PNG files are allowed.";
        $uploadOk = 0;
    }
    // Create the target directory if it doesn't exist
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        return false;
    } else {
        // If file exists, delete it
        if (file_exists($targetFile)) {
            unlink($targetFile);
        }
        // If everything is ok, try to upload file
        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFile)) {
            $newImageName = basename($_FILES["profile_image"]["name"]);
            // Set $imgUpload true , if file uploaded, send it to updateQuery function as true
            editQuery($con, $id, $_SESSION['firstName'], $_SESSION['lastName'], $_SESSION['email'], $_SESSION['password'], $_SESSION['phone'] ,true);
            return $newImageName;
        } else {
            echo "Sorry, there was an error uploading your file.";
            return false;
        }
    }
}



?>
