<?php
include '../database.php';

if(isset($_COOKIE['current_time'])) {
    $current_time = $_COOKIE['current_time'];
}
$user_id= $_SESSION['id'];
getTaskAlerts($user_id);

function getTaskAlerts($user_id) {
    global $con, $current_time;
    $task_count = 0;
    $alert_query = "SELECT title, description, created_by, alert FROM user_" . $user_id . "_tasks WHERE alert <= ? AND status = 'active'";
    $alert_stmt = mysqli_prepare($con, $alert_query);
    mysqli_stmt_bind_param($alert_stmt, 's', $current_time);
    mysqli_stmt_execute($alert_stmt);
    $result = mysqli_stmt_get_result($alert_stmt);
    if (!$result) {
        die('Query error: ' . mysqli_error($con));
    }
    $tasks = [];
    while($row = mysqli_fetch_array($result)) {
        // Pārbaudiet, vai pašreizējais laiks ir lielāks par alerta laiku
        $alert_time = $row['alert']; 
        $numericAlert = preg_replace('/[^0-9]/', '', $alert_time);
        $intAlert = (int) $numericAlert;
        $numericTime = preg_replace('/[^0-9]/', '', $current_time);
        $intTime = (int) $numericTime;
        if ($intTime> $intAlert) {
            $tasks[] = $row['title'] . '<br>' . $row['description'] . '<br>' . $row['created_by'];
            $task_count++;
        }
    }
    if($task_count != 0){
        echo $task_count;
    }
}