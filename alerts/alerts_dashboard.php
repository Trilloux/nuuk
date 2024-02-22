
<?php
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
include 'alert_methods.php';

$user_id = $_SESSION['id'];
?>

<div id="alerts_wrapper">
    <p id="current_time"></p>
    <div id="Task alerts">
        <div>
            <h2 class="alerts_heading">Task alerts</h2> 
        </div>
        <div class="alert_block">
            <?php 
            // Call displayDashboard function with user ID to display tasks
            displayDashboard($user_id); 
            ?>
        </div>
    </div>
    <div id="Calendar alerts">
        <div>
            <h2 class="alerts_heading">Calendar alerts</h2>
        </div>
        <div class="alert_block">
            <?php
            displayEvents();
            ?>
        </div>
    </div>
</div>

<script>
   // Uzstāda lapas pārlādi pēc 1 minūtes
setTimeout(function() {
    location.reload();
}, 1 * 60 * 1000); // 1 minūte


        setInterval(function() {
    displayTime();
}, 1);

// Funkcija, kas parāda pašreizējo laiku HTML elementā ar ID "current_time"
function displayTime() {
    var now = new Date();
    var hours = now.getHours().toString().padStart(2, '0');
    var minutes = now.getMinutes().toString().padStart(2, '0');
    var seconds = now.getSeconds().toString().padStart(2, '0');
    var currentTimeString = hours + ":" + minutes + ":" + seconds;
    document.getElementById("current_time").innerText = "Current time:" + currentTimeString;
}
</script>
