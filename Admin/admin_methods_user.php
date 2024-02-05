<?php
include '../database.php';

//Get userinfo , show them in form fields
if (isset($_GET['edit_id'])) {
    $edit_id = mysqli_real_escape_string($con, $_GET['edit_id']);
    $select_query = 'SELECT * FROM users WHERE id = ?';
    $select_stmt = mysqli_prepare($con, $select_query);
    mysqli_stmt_bind_param($select_stmt, 'i', $edit_id);
    mysqli_stmt_execute($select_stmt);
    $result = mysqli_stmt_get_result($select_stmt);

    if ($row = mysqli_fetch_array($result)) {
        $edit_username = $row['username'];
        $edit_password = $row['password'];
        $edit_fname = $row['firstName'];
        $edit_lname = $row['lastName'];
        $edit_email = $row['email'];
        $edit_phone = $row['phone'];
        $edit_role = $row['role'];
    }
}

if (isset($_POST['submit']) || isset($_POST['submit_update'])) {
    // Create new variables from form input fields when form is submitted
    $user_name = mysqli_real_escape_string($con, $_POST['user_name']);
    $user_password = mysqli_real_escape_string($con, $_POST['user_password']);
    $user_fname = mysqli_real_escape_string($con, $_POST['user_fname']);
    $user_lname = mysqli_real_escape_string($con, $_POST['user_lname']);
    $user_email = mysqli_real_escape_string($con, $_POST['user_email']);
    $user_phone = mysqli_real_escape_string($con, $_POST['user_phone']);
    $user_role = mysqli_real_escape_string($con, $_POST['user_role']);

    //If statement if submit - create user , if submit_update - update user data
    if(isset($_POST['submit'])){
    createUser($user_name, $user_password, $user_fname, $user_lname, $user_email, $user_phone, $user_role);
    }else if(isset($_POST['submit_update'])){
    $updateId=$_GET['edit_id'];
    updateUser($updateId, $user_name, $user_password, $user_fname, $user_lname, $user_email, $user_phone, $user_role);
 }
}
//Create new user function
function createUser($user_name, $user_password, $user_fname, $user_lname, $user_email, $user_phone, $user_role){
    global $con;
    $errorMessage = 'Error: Data was NOT updated!' . mysqli_error($con);
    $successMessage = "User created successfully";
    $create_query = "INSERT INTO users (username, password, firstname, lastName, email, phone, role) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $create_stmt = mysqli_prepare($con, $create_query);

    if ($create_stmt) {
        mysqli_stmt_bind_param($create_stmt, 'sssssss', $user_name, $user_password, $user_fname, $user_lname, $user_email, $user_phone, $user_role);

        if (mysqli_stmt_execute($create_stmt)) {
            echo $successMessage;
            //echo $displayCreated;
        } else {
            echo $errorMessage;
        }
    } else {
        echo $errorMessage;
    }
}
//Update existing user data
function updateUser($updateId, $user_name, $user_password, $user_fname, $user_lname, $user_email, $user_phone, $user_role){
global $con;
$upd_query = "UPDATE users SET username = ?, password = ?, firstName = ?, lastName = ?, email = ?, phone = ?, role = ? WHERE id = ?";
    $upd_stmt = mysqli_prepare($con, $upd_query);
    mysqli_stmt_bind_param($upd_stmt, 'sssssssi', $user_name, $user_password, $user_fname, $user_lname, $user_email, $user_phone, $user_role, $updateId);
    if (mysqli_stmt_execute($upd_stmt)) {
        if (mysqli_stmt_affected_rows($upd_stmt) > 0) {
            echo 'User updated successfully';
        } else {
            echo 'No changes were made to the user data';
        }
    } else {
        echo 'Error: Data was NOT updated!' . mysqli_error($con);
    }    
}

//Delete user function
function deleteUser($deleteId) {
    global $con;
    $del_query = 'DELETE FROM users WHERE id = ?';
    $del_stmt = mysqli_prepare($con, $del_query);
    mysqli_stmt_bind_param($del_stmt, 'i', $deleteId);
    mysqli_stmt_execute($del_stmt);

    if (mysqli_stmt_affected_rows($del_stmt) > 0) {
        echo "User deleted!";
    } else {
        echo "Error deleting user.";
        echo $deleteId;
    }
}
//get id of user to delete, pass the id to deleteUser function
if (isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];
    // Izsaukt deleteUser funkciju, nododot tai dzēšanas ID
    deleteUser($deleteId);
}

?>