<?php
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
include 'messages_methods.php';

?>

<div id="messages_wrapper">
    <div id="messages_cpanel">
        <button class="task_buttons"onclick="activeTasks()">&#8595; Inbox</button>
        <button class="task_buttons"onclick="activeTasks()">&#8593; Sent</button>
        <button class="task_buttons"><a href="?id=43">&#x2295; New</a></button>
        <button class="task_buttons" onclick="deleteTasks()">&#x2716; Delete</button>
        <button class="task_buttons"onclick="activeTasks()">&#x2605; Important</button>
        <button class="task_buttons" onclick="compTasks()" >&#x2713; Read</button>
    </div>
</div>