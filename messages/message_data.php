<?php 
include '../database.php';

$inbox_messages_table = 'user_'.$_SESSION['id'].'_inbox';
getMessageCount($inbox_messages_table);

function getMessageCount($inbox_messages_table){
    global $con;
    $message_count=0;
    $msg_count_query = "SELECT * FROM $inbox_messages_table WHERE mark = 'not_read' ";
    $msg_count_result = mysqli_query($con, $msg_count_query);
    
    while($row=mysqli_fetch_array($msg_count_result)){
        $msg_ID = $row['id'];
        $message_count++;
    }
   
    if($message_count>0){
    echo $message_count;
    }
}
?>




