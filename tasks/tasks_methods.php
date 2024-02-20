<?php 
date_default_timezone_set('UTC');
include 'database.php';
//Get user info from session
if (isset($_SESSION['id'])) {
    $get_id = $_SESSION['id'];
    $get_name = $_SESSION['firstName'];
    $get_lastname=$_SESSION['lastName'];
    $table_name = 'user_' . $get_id . '_tasks';
    findTable($table_name);
}
//Find Task table for user, if user doesn't have table 
//Create new table with user id and first name and last name
//Only 1 table will be created because of user specifics
function findTable($table_name){
    global $con;
    $getTab_query="SHOW TABLES LIKE '$table_name'";
    $getTab_result=mysqli_query($con, $getTab_query);
    if ($getTab_result->num_rows == 0) {
        createTable($table_name);
    }
}
//Create Task table in DB function
function createTable($table_name){
    global $con;
    $crTab_query = "CREATE TABLE IF NOT EXISTS $table_name (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT,
        created_by VARCHAR(50) NOT NULL,
        created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        title VARCHAR(50) NOT NULL,
        description TEXT,
        priority ENUM ('low', 'medium', 'high') DEFAULT 'medium',
        status ENUM('active', 'completed') DEFAULT 'active',  -- Enclose 'completed' in single quotes
        alert DATETIME DEFAULT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id)  -- Correct the foreign key declaration
    )";
    
    $crTab_result=mysqli_query($con, $crTab_query);
    if($crTab_result->num_rows>0){
        echo 'Table created';
    }else{
        echo 'Table exists';
    }
}
//Display info from task table in form(if edit)
if(isset($_GET['task_id'])) {
    $task_id = mysqli_real_escape_string($con, $_GET['task_id']);
    $selTask_query = "SELECT * FROM $table_name WHERE id = ?";
    $selTask_stmt = mysqli_prepare($con, $selTask_query);
    mysqli_stmt_bind_param($selTask_stmt, 'i', $task_id);
    mysqli_stmt_execute($selTask_stmt);
    $task_result = mysqli_stmt_get_result($selTask_stmt);
    //Show news post data in form fields
    if ($row = mysqli_fetch_array($task_result)) {
        $edit_title = $row['title'];
        $edit_descr = $row['description'];
        $edit_alert = $row['alert'];
        $edit_priority = $row['priority'];
    }
}
//Create and update variables
if(isset($_POST['submit']) || isset($_POST['submit_update'])) {
    // Create new variables from form input fields when form is submitted
    $task_title = mysqli_real_escape_string($con, $_POST['title']);
    $task_descr = mysqli_real_escape_string($con, $_POST['description']);
    //Set default to alert if not added alert time
    $task_alert = !empty($_POST['alert']) ? mysqli_real_escape_string($con, $_POST['alert']) : NULL;
    $task_priority = mysqli_real_escape_string($con, $_POST['priority']);
    $task_by = $_SESSION['firstName'];
    $user_id = $_SESSION['id'];
    // If statement if submit - create news post, if submit_update - update news post data
    if(isset($_POST['submit'])) {
        postTask($table_name, $user_id,$task_by, $task_title, $task_descr, $task_priority, $task_alert);
    } else if(isset($_POST['submit_update'])) {
        updateTask($table_name, $task_id, $task_title, $task_descr, $task_priority, $task_alert);
    }
}
//Create Task function
function postTask($table_name, $user_id, $task_by, $task_title, $task_descr, $task_priority, $task_alert) {
    global $con;
    
    $newTask_query = "INSERT INTO $table_name (user_id, created_by, title, description, priority, alert) VALUES (?,?, ?, ?, ?, ?)";
    $newTask_stmt = mysqli_prepare($con, $newTask_query);
    if ($newTask_stmt) {
        mysqli_stmt_bind_param($newTask_stmt, 'isssss', $user_id, $task_by, $task_title, $task_descr, $task_priority, $task_alert);

        if (mysqli_stmt_execute($newTask_stmt)) {
            echo 'Task created successfully!';
        } else {
            echo 'Error executing statement: ' . mysqli_stmt_error($newTask_stmt);
        }
    } else {
        echo 'Error preparing statement: ' . mysqli_error($con);
    }
}
//Update task function
function updateTask($table_name, $task_id, $task_title, $task_descr, $task_priority, $task_alert) {
    global $con;
    $updTask_query = "UPDATE $table_name SET title = ?, description = ?, priority = ?, alert = ? WHERE id = ?";
    $updTask_stmt = mysqli_prepare($con, $updTask_query);
    if ($updTask_stmt) {
        mysqli_stmt_bind_param($updTask_stmt, 'ssssi', $task_title, $task_descr, $task_priority, $task_alert, $task_id);
        if (mysqli_stmt_execute($updTask_stmt)) {
            echo 'Task updated successfully!';
        } else {
            echo 'Error executing statement: ' . mysqli_stmt_error($updTask_stmt);
        }
    } else {
        echo 'Error preparing statement: ' . mysqli_error($con);
    }
}

//Delete task function
if (isset($_GET['delete_ids'])) {
    $del_ids = explode(',', $_GET['delete_ids']); // Split the comma-separated string into an array of IDs
    deleteTasks($table_name, $del_ids);
}

function deleteTasks($table_name, $del_ids) {
    global $con;
    // Loop through each ID and delete the corresponding task
    foreach ($del_ids as $del_id) {
        $delTask_query = "DELETE FROM $table_name WHERE id = ?";
        $delTask_stmt = mysqli_prepare($con, $delTask_query);
        
        if ($delTask_stmt) {
            mysqli_stmt_bind_param($delTask_stmt, 'i', $del_id);
            mysqli_stmt_execute($delTask_stmt);
            
        } else {
            echo "Error preparing statement: " . mysqli_error($con) . "<br>";
        }
        mysqli_stmt_close($delTask_stmt);
    }
}

//Mark task as completed function
if (isset($_GET['comp_ids'])) {
    $comp_ids = explode(',', $_GET['comp_ids']); // Split the comma-separated string into an array of IDs
    tasksCompl($table_name, $comp_ids);
}

function tasksCompl($table_name, $comp_ids){
    global $con;
    $task_status='completed';
    foreach ($comp_ids as $comp_id) {
        $comp_query = "UPDATE $table_name SET status = ? WHERE  id = ?";
        $comp_stmt = mysqli_prepare($con, $comp_query);
        
        if ($comp_stmt) {
            mysqli_stmt_bind_param($comp_stmt, 'si', $task_status ,$comp_id);
            mysqli_stmt_execute($comp_stmt);
            
        } else {
            echo "Error preparing statement: " . mysqli_error($con) . "<br>";
        }
        mysqli_stmt_close($comp_stmt);
    }
}

//Mark task as active function
if (isset($_GET['active_ids'])) {
    $act_ids = explode(',', $_GET['active_ids']); // Split the comma-separated string into an array of IDs
    tasksActive($table_name, $act_ids);
}

function tasksActive($table_name, $act_ids){
    global $con;
    $task_status='active';
    foreach ($act_ids as $act_id) {
        $act_query = "UPDATE $table_name SET status = ? WHERE  id = ?";
        $act_stmt = mysqli_prepare($con, $act_query);
        
        if ($act_stmt) {
            mysqli_stmt_bind_param($act_stmt, 'si', $task_status ,$act_id);
            mysqli_stmt_execute($act_stmt);
            
        } else {
            echo "Error preparing statement: " . mysqli_error($con) . "<br>";
        }
        mysqli_stmt_close($act_stmt);
    }
}



//Function to remove alert
if(isset($_POST['submit_alert'])){
    setAlertToDefault($table_name, $task_id);
}

function setAlertToDefault($table_name, $task_id) {
    global $con; // Pārliecinieties, vai $con ir pieejams šajā failā
    $default_alert =NULL;
    $update_alert_query = "UPDATE $table_name SET alert = ? WHERE id = ?";
    $update_alert_stmt = mysqli_prepare($con, $update_alert_query);
    if ($update_alert_stmt) {
        mysqli_stmt_bind_param($update_alert_stmt, 'si', $default_alert, $task_id);
        if (mysqli_stmt_execute($update_alert_stmt)) {
            echo 'Alert removed!';
        } else {
            echo 'Error executing statement: ' . mysqli_stmt_error($update_alert_stmt);
        }
    } else {
        echo 'Error preparing statement: ' . mysqli_error($con);
    }
}
?>

