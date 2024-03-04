<?php
include '../database.php';
//Get user info from session
if (isset($_SESSION['id'])) {
    $get_id = $_SESSION['id'];
    $get_name = $_SESSION['firstName'];
    $get_lastname=$_SESSION['lastName'];
    $MsgTab_name = 'user_' . $get_id . '_inbox';
    $SendTab_name = 'user_' . $get_id . '_outbox';
    findMsgTab($MsgTab_name);
    findSendTab($SendTab_name);
}
//Find INBOX messages table for user, if user doesn't have table 
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
//Find OUTBOX messages table for user, if user doesn't have table 
//Create new table with user id and first name and last name
//Only 1 table will be created because of user specifics
function findSendTab($SendTab_name){
    global $con;
    $getTab_query="SHOW TABLES LIKE '$SendTab_name'";
    $getTab_result=mysqli_query($con, $getTab_query);
    if ($getTab_result->num_rows == 0) {
        createSendTab($SendTab_name);
    }
}
//Create INBOX table in DB function
function createMsgTab($MsgTab_name){
    global $con;
    $MsgTab_query = "CREATE TABLE IF NOT EXISTS $MsgTab_name (
        id INT PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(100) NOT NULL,
        context TEXT,
        file_path VARCHAR(255),
        sent_by VARCHAR (50) NOT NULL,
        mark ENUM ('read', 'not_read') DEFAULT 'not_read',
        important ENUM ('yes', 'no') DEFAULT 'no',
        created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $MsgTab_result=mysqli_query($con, $MsgTab_query);
    if(mysqli_num_rows($MsgTab_result) > 0){
        echo 'Table created';
    }else{
        echo 'Inbox table exists';
    }
}
//Create OUTBOX table in DB function
function createSendTab($SendTab_name){
    global $con;
    $SendTab_query = "CREATE TABLE IF NOT EXISTS $SendTab_name (
        id INT PRIMARY KEY AUTO_INCREMENT,
        sent_to VARCHAR(50),
        title VARCHAR(100) NOT NULL,
        context TEXT,
        file_path VARCHAR(255),
        sent_by VARCHAR (50) NOT NULL,
        created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $SendTab_result=mysqli_query($con, $SendTab_query);
    if(mysqli_num_rows($SendTab_result) > 0){
        echo 'Table created';
    }else{
        echo 'Outbox table exists';
    }
}

if(isset($_POST['submit'])){
    $msg_title = mysqli_real_escape_string($con, $_POST['title']);
    $msg_text = mysqli_real_escape_string($con, $_POST['description']);
    $sent_by = $_SESSION['firstName'].' '.$_SESSION['lastName'];
    

    // check if file uploaded
    if(isset($_FILES['file_upload']) && is_array($_FILES['file_upload']['name'])) {
        $upload_dir = 'msg_files/';

        // Save all files
        $uploaded_files = array();

        // Loop through each uploaded file
        for($i = 0; $i < count($_FILES['file_upload']['name']); $i++) {
            $file_name = $_FILES['file_upload']['name'][$i];
            $file_tmp = $_FILES['file_upload']['tmp_name'][$i];

            // save files if uploaded
            if(move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
                $uploaded_files[] = $upload_dir . $file_name;
                echo 'File uploaded successfully: ' . $file_name . '<br>';
            } 
        }

        
        //create variable to store file paths to be inserted in DB
        if (!empty($uploaded_files)) {
            $msg_file = implode(',', $uploaded_files);
        }
    } else {
        // If no files uploaded , then empty field to be stored in DB
        $msg_file = '';
    }

    // Send message to all added recipients
    $recipients = isset($_POST['recipients']) ? $_POST['recipients'] : array();
foreach ($recipients as $recipient_id) {
    sendMsg($recipient_id, $msg_title, $msg_text, $msg_file, $sent_by);
}

}


function sendMsg($recipient_id, $msg_title, $msg_text, $msg_file, $sent_by){
    global $con;
    $message_table = 'user_' . $recipient_id . '_inbox';
    $send_query="INSERT INTO $message_table (title, context, file_path, sent_by) VALUES (?,?,?,?)";
    $send_stmt = mysqli_prepare($con, $send_query);
    if($send_stmt){
        mysqli_stmt_bind_param($send_stmt, 'ssss', $msg_title, $msg_text, $msg_file, $sent_by);
        if(mysqli_stmt_execute($send_stmt)){
            echo 'Message sent succesfully';
            //Add message to outbox table
            sentMail($recipient_id, $msg_title, $msg_text, $msg_file, $sent_by);
        }else{
            echo 'Error sending message: ' . mysqli_stmt_error($send_stmt);
        }
    }else{
        echo 'Error '.mysqli_error($con);
    }
}

function sentMail($recipient_id, $msg_title, $msg_text, $msg_file, $sent_by){
    global $con;
    $sent_table = 'user_'.$_SESSION['id'].'_outbox';
    //query to get recipient first name and last name from recipient id 
    $getInfo_query = "SELECT firstName, lastName FROM users where id = $recipient_id";
    $getInfo_result = mysqli_query($con, $getInfo_query);
    while($row=mysqli_fetch_array($getInfo_result)){
        $sent_to = $row['firstName'].' '.$row['lastName'];
    }

    $sentMail_query="INSERT INTO $sent_table (sent_to, title, context, file_path, sent_by) VALUES (?,?,?,?,?) ";
    $sentMail_stmt=mysqli_prepare($con, $sentMail_query);
    if($sentMail_stmt){
        mysqli_stmt_bind_param($sentMail_stmt, 'sssss', $sent_to, $msg_title, $msg_text, $msg_file, $sent_by);
    }
    if(mysqli_stmt_execute($sentMail_stmt)){
        //Add message to outbox table
    }else{
        echo 'Error adding message to sent mail: ' . mysqli_stmt_error($sentMail_stmt);
    }
}

if(isset($_POST['submit_reply'])){    
    $reply_title = mysqli_real_escape_string($con, $_POST['title']);
    $reply_text = mysqli_real_escape_string($con, $_POST['description']);
    $sent_by = $_SESSION['firstName'] . ' ' . $_SESSION['lastName'];

    // Izvilkiet saņēmēja ID no datu bāzes, izmantojot viņa vārdu un uzvārdu
    $recipient_name = $_POST['recipient'];
    $recipient_query = "SELECT id FROM users WHERE CONCAT(firstName, ' ', lastName) = '$recipient_name'";
    $recipient_result = mysqli_query($con, $recipient_query);
    if($recipient_row = mysqli_fetch_assoc($recipient_result)) {
        $recipient_id = $recipient_row['id'];
    } else {
        echo "Recipient not found!";
        return; // Pārtraucam funkcijas izpildi, ja saņēmējs nav atrasts
    }

    if(isset($_FILES['file_upload']) && is_array($_FILES['file_upload']['name'])) {
        $upload_dir = 'msg_files/';

        // Save all files
        $uploaded_files = array();

        // Loop through each uploaded file
        for($i = 0; $i < count($_FILES['file_upload']['name']); $i++) {
            $file_name = $_FILES['file_upload']['name'][$i];
            $file_tmp = $_FILES['file_upload']['tmp_name'][$i];

            // save files if uploaded
            if(move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
                $uploaded_files[] = $upload_dir . $file_name;
                echo 'File uploaded successfully: ' . $file_name . '<br>';
            } 
        }

        
        //create variable to store file paths to be inserted in DB
        if (!empty($uploaded_files)) {
            $msg_file = implode(',', $uploaded_files);
        }
    } else {
        // If no files uploaded , then empty field to be stored in DB
        $msg_file = '';
    }

    replyMessage($con, $recipient_id, $reply_title, $reply_text, $msg_file, $sent_by);
}

function replyMessage($con, $recipient_id, $reply_title, $reply_text, $msg_file, $sent_by){
    $message_table = 'user_' . $recipient_id . '_inbox';
    $reply_query="INSERT INTO $message_table (title, context, file_path, sent_by) VALUES (?,?,?,?)";
    $reply_stmt = mysqli_prepare($con, $reply_query);
    if($reply_stmt){
        mysqli_stmt_bind_param($reply_stmt, 'ssss', $reply_title, $reply_text, $msg_file, $sent_by);
        if(mysqli_stmt_execute($reply_stmt)){
            echo 'Reply sent succesfully';
            //Add message to outbox table
            sentMail($recipient_id, $reply_title, $reply_text, $msg_file, $sent_by);
        }else{
            echo 'Error sending reply: ' . mysqli_stmt_error($reply_stmt);
        }
    }else{
        echo 'Error '.mysqli_error($con);
    }
}
?>
