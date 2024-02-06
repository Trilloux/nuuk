<?php 
include 'database.php';

if (isset($_SESSION['id'])) {
    $get_id = $_SESSION['id'];
    $get_name = $_SESSION['firstName'];
    $get_lastname=$_SESSION['lastName'];
    $table_name= $get_id.'_'.$get_name.'_'.$get_lastname.'_tasks';
    findTable($table_name);
}
function findTable($table_name){
    global $con;
    $getTab_query="SHOW TABLES LIKE '$table_name'";
    $getTab_result=mysqli_query($con, $getTab_query);
    if ($getTab_result->num_rows == 0) {
        createTable($table_name);
    }
}

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
        alert DATETIME,
        FOREIGN KEY (user_id) REFERENCES users(id)  -- Correct the foreign key declaration
    )";
    
    $crTab_result=mysqli_query($con, $crTab_query);
    if($crTab_result->num_rows>0){
        echo 'Table created';
    }else{
        echo 'Table exists';
    }
}

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

if(isset($_POST['submit']) || isset($_POST['submit_update'])) {
    // Create new variables from form input fields when form is submitted
    $task_title = mysqli_real_escape_string($con, $_POST['title']);
    $task_descr = mysqli_real_escape_string($con, $_POST['description']);
    $task_alert = mysqli_real_escape_string($con, $_POST['alert']);
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
            
            if (mysqli_stmt_affected_rows($delTask_stmt) > 0) {
                echo "Tasksdeleted successfully!";
            } else {
                echo "Error deleting tasks!";
            }
        } else {
            echo "Error preparing statement: " . mysqli_error($con) . "<br>";
        }
        mysqli_stmt_close($delTask_stmt);
    }
}


?>