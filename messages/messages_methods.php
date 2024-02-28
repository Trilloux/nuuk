<?php
include '../database.php';
//Get user info from session
if (isset($_SESSION['id'])) {
    $get_id = $_SESSION['id'];
    $get_name = $_SESSION['firstName'];
    $get_lastname=$_SESSION['lastName'];
    $MsgTab_name = 'user_' . $get_id . '_messages';
    findMsgTab($MsgTab_name);
}
//Find Task table for user, if user doesn't have table 
//Create new table with user id and first name and last name
//Only 1 table will be created because of user specifics
function findMsgTab($MsgTab_name){
    global $con;
    $getTab_query="SHOW TABLES LIKE '$MsgTab_name'";
    $getTab_result=mysqli_query($con, $getTab_query);
    if ($getTab_result->num_rows == 0) {
        createMsgTab($MsgTab_name);
    }
}
//Create Task table in DB function
function createMsgTab($MsgTab_name){
    global $con;
    $MsgTab_query = "CREATE TABLE IF NOT EXISTS $MsgTab_name (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT,
        recipient VARCHAR(50) NOT NULL,
        title VARCHAR(100) NOT NULL,
        context TEXT,
        file_path VARCHAR(255) NOT NULL,
        sent_by VARCHAR (50) NOT NULL,
        mark ENUM ('read', 'not_read') DEFAULT 'not_read',
        important ENUM ('yes', 'no') DEFAULT 'no',
        created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $MsgTab_result=mysqli_query($con, $MsgTab_query);
    if(mysqli_num_rows($MsgTab_result) > 0){
        echo 'Table created';
    }else{
        echo 'Table exists';
    }
}

?>