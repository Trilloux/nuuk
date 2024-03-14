<?php
include '../database.php';

//Get user info from session

//Get users id to check if task table exists
$show_query = 'SELECT * FROM users';
$show_result = mysqli_query($con, $show_query);
while($row=mysqli_fetch_array($show_result)){
$get_id= $row['id'];
$table_name = 'user_' . $get_id . '_tasks';
findTable($table_name);
}


//Find Task table for user, if user doesn't have table 
//Create new table with user id
//Only 1 table will be created because of user specifics
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


if(isset($_POST['submit']) || isset($_POST['submit_update'])) {
    // Create new variables from form input fields when form is submitted
    $task_title =  $_POST['title'];
    $task_descr = $_POST['description'];
    $task_priority = mysqli_real_escape_string($con, $_POST['priority']);
    $task_by = $_SESSION['firstName'];
    $sel_id = $_POST['userinfo'];
    $sel_table= 'user_' . $sel_id . '_tasks';
    // If statement if submit - create new task, if submit_update - update task data
    if(isset($_POST['submit'])) {
        giveTask($sel_table, $sel_id, $task_by, $task_title, $task_descr, $task_priority);
    } else if(isset($_POST['submit_update'])) {
        //updateTask($table_name, $task_id, $task_title, $task_descr, $task_priority, $task_alert);
    }
}
//Create Task function
function giveTask($sel_table, $sel_id, $task_by, $task_title, $task_descr, $task_priority) {
    global $con;
    $giveTask_query = "INSERT INTO $sel_table (user_id, created_by,  title, description, priority) VALUES (?, ?, ?, ?, ?)";
    $giveTask_stmt = mysqli_prepare($con, $giveTask_query);
    if ($giveTask_stmt) {
        mysqli_stmt_bind_param($giveTask_stmt, 'issss', $sel_id, $task_by, $task_title, $task_descr, $task_priority);

        if (mysqli_stmt_execute($giveTask_stmt)) {
            echo 'Task created successfully!';
        } else {
            echo 'Error executing statement: ' . mysqli_stmt_error($giveTask_stmt);
        }
    } else {
        echo 'Error preparing statement: ' . mysqli_error($con);
    }
}

?>