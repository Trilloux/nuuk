<?php
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
include 'messages_methods.php';

?>

<div id="messages_wrapper">
    <div id="messages_cpanel">
        <button class="task_buttons"><a href="?id=4">&#8595; Inbox</button>
        <button class="task_buttons"> <a href="?id=4&section=sent">&#8593; Sent</button>
        <button class="task_buttons"><a href="?id=4&section=new">&#x2295; New</a></button>
        <button class="task_buttons" onclick="deleteMessage()">&#x2716; Delete</button>
        <button class="task_buttons"onclick="markImportant()">&#x2605; Important</button>
        <button class="task_buttons" onclick="markRead()" >&#x2713; Read</button>
    </div>
    <?php 
   
    //Check if get parameter is defined for section to use
    if(isset($_GET['section'])){
        $section = $_GET['section'];
        //deppending on get case will display section
        switch($section){
            case 'sent':
                include 'messages_outbox.php';
                break;
            case 'new':
                include 'message_form.php';
                break;
            case 'reply':
                include 'reply_form.php';
                break;
            default:
                // Default is inbox
                include 'messages_inbox.php';
                break;
        }
    } else {
        // If section is not chosen, then display inbox
        include 'messages_inbox.php';
    }
    ?>
</div>


