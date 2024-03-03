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
        <button class="task_buttons" onclick="deleteTasks()">&#x2716; Delete</button>
        <button class="task_buttons"onclick="activeTasks()">&#x2605; Important</button>
        <button class="task_buttons" onclick="compTasks()" >&#x2713; Read</button>
    </div>
    <?php 
    // Pārbaudām, vai GET parametrs 'section' ir definēts un atbilstošs
    if(isset($_GET['section'])){
        $section = $_GET['section'];
        // Atkarībā no norādītās sadaļas, ielādējam attiecīgo messages sekciju
        switch($section){
            case 'sent':
                include 'messages_outbox.php';
                break;
            case 'new':
                include 'message_form.php';
                break;
            default:
                // Ja norādītā sadaļa nav atpazīta, noklusējuma kārtā ielādējam inbox
                include 'messages_inbox.php';
                break;
        }
    } else {
        // Ja sadaļa nav norādīta, noklusējuma kārtā ielādējam inbox
        include 'messages_inbox.php';
    }
    ?>
</div>
