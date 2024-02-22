
<?php
include '../database.php';

if(isset($_COOKIE['current_time'])) {
    $current_time = $_COOKIE['current_time'];
}

function getTaskAlerts($user_id) {
    global $con, $current_time;
    $alert_query = "SELECT title, description, created_by, alert FROM user_" . $user_id . "_tasks WHERE (alert <= ? OR (alert IS NULL AND created_by IN (SELECT firstName FROM users WHERE role = 'admin'))) AND status = 'active'";
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
        if ($intTime> $intAlert || $row['alert'] == NULL) {
            $description = strlen($row['description']) > 250 ? substr($row['description'], 0, 250) . '...' : $row['description'];
            $tasks[] ='<span class="alert-title">'.$row['title'].'</span><br>'.$description . '<br>' .'<span class="alert-author">'.$row['created_by'].'</span><br><hr class="alert-line">';
        }
    }
    return $tasks;
}
function displayDashboard($user_id) {
    // Call getTaskAlerts function to retrieve tasks with alerts
    $tasks_with_alerts = getTaskAlerts($user_id);
    
    // Display tasks in dashboard
    // You can loop through tasks and display them, marking the ones with alerts as red
    foreach ($tasks_with_alerts as $task) {
        // Display tasks in dashboard, marking ones with alerts as red
        echo "<div style=width:100%;>$task</div><br>";
    }

    //If user has no active alerts
    if(empty($tasks_with_alerts)){ 
        echo "You currently have no alerts!";
    }
}

function displayEvents() {
    // Call getTaskAlerts function to retrieve events
    $getEvents = getCalendarAlerts();
    
    // If there are events, display them
    if (!empty($getEvents)) {
        // Loop through events and display them
        foreach ($getEvents as $event) {
            // Display each event
            echo "<div style='width:100%;'>$event</div><br>";
        }
    } else {
        // If there are no events, display a message
        echo "You currently have no events!";
    }
}


function getCalendarAlerts(){
    global $con; 
    $dateNow = date('Y-m-d');
    $cal_query = "SELECT * FROM events WHERE startDate <= ? AND endDate >= ?";
    $cal_stmt = mysqli_prepare($con, $cal_query);
    mysqli_stmt_bind_param($cal_stmt, 'ss', $dateNow, $dateNow); // Bind both parameters
    mysqli_stmt_execute($cal_stmt);
    $result = mysqli_stmt_get_result($cal_stmt);
    
    // Pārbauda, vai ir kļūdas
    if(!$result){
        die('Query error: '.mysqli_error($con));
    }

    $events=[];
    while($row=mysqli_fetch_array($result)){
        $events[] = '<span class="alert-title">'.$row['name'].'</span><br>'.'<span class="alert-author">'.$row['startDate'].' -- '.$row['endDate'].'</span><br><hr class="alert-line">';
        
    }
    return $events;
}
?>

