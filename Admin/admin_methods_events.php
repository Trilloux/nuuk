<?php
include '../database.php';

if(isset($_POST['submit_update'])) {
    //get data from form
    $event_name = mysqli_real_escape_string($con, $_POST['eventName']);
    $event_start = mysqli_real_escape_string($con, $_POST['eventStartDate']);
    $event_end = mysqli_real_escape_string($con, $_POST['eventEndDate']);
    $upd_id = mysqli_real_escape_string($con, $_POST['edit_event']);
    
    //call update function, pass arguments
    updateEvent($upd_id, $event_name, $event_start, $event_end);
}

function updateEvent($upd_id, $event_name, $event_start, $event_end) {
    global $con;
    $updateEvent_query = 'UPDATE events SET name = ?, startDate = ?, endDate = ? WHERE id = ?';
    $updateEvent_stmt = mysqli_prepare($con, $updateEvent_query);
    mysqli_stmt_bind_param($updateEvent_stmt, 'sssi', $event_name, $event_start, $event_end, $upd_id);
    mysqli_stmt_execute($updateEvent_stmt);

    if (mysqli_stmt_affected_rows($updateEvent_stmt) > 0) {
        echo "Event updated!";
    } else {
        echo "Error updating event!";
    }
}
function deleteEvent($eventId) {
    global $con;
    $delEvent_query = 'DELETE FROM events WHERE id = ?';
    $delEvent_stmt = mysqli_prepare($con, $delEvent_query);
    mysqli_stmt_bind_param($delEvent_stmt, 'i', $eventId);
    mysqli_stmt_execute($delEvent_stmt);

    if (mysqli_stmt_affected_rows($delEvent_stmt) > 0) {
        echo "Event deleted!";
    } else {
        echo "Error deleting event!";
    }
}

//Check if delete request
if (isset($_POST['delEvent_id'])) {
    $eventId = $_POST['delEvent_id'];
    //Call delete fucntion , pass arguments (event id)
    deleteEvent($eventId);
}
?>



