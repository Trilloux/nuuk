<?php
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
include 'admin_methods_events.php';

//Check if isset GET
if (isset($_GET['edit_event'])) {
    $edit_id = $_GET['edit_event'];

    //Get info from db about event with specific id    
    $editEvent_query = 'SELECT * FROM events WHERE id = ?';
    $editEvent_stmt = mysqli_prepare($con, $editEvent_query);
    mysqli_stmt_bind_param($editEvent_stmt, 'i', $edit_id);
    mysqli_stmt_execute($editEvent_stmt);
    $event_result = mysqli_stmt_get_result($editEvent_stmt);
    
    //Check if event with id is found
    if ($row = mysqli_fetch_array($event_result)) {
        $event_id = $row['id'];
        $edit_name = $row['name'];
        $edit_start = $row['startDate'];
        $edit_end = $row['endDate'];
    } else {
        //If no id then empty fields
        $edit_name = '';
        $edit_start = '';
        $edit_end = '';
    }
}
?>

<div id="existing_events">
    <h2>Existing Events</h2>
</div>
<div id="event_list">
    <table id="event_table">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Start</th>
            <th>End</th>
            <th colspan="2">Action</th>
        </tr>
        <?php
        //query to Get user data in DB
        $show_query = 'SELECT * FROM events';
        $show_result = mysqli_query($con, $show_query);
        while($row=mysqli_fetch_array($show_result)){
        ?>
            <tr>
                <td><?php echo $row['id'] ?></td>
                <td id="event_title"><?php echo $row['name'] ?></td>
                <td class="event_dates"><?php echo $row['startDate'] ?></td>
                <td class="event_dates"><?php echo $row['endDate'] ?></td>
                <td><button><a id="edit_newslist" href="?id=admin_8&&edit_event=<?php echo $row['id']; ?>">Edit</a></button></td>
                <td><button onclick="deleteEvent(<?php echo $row['id']; ?>)">Delete</button></td>
            </tr>
        <?php } ?>
    </table>
</div>
<script>
    //useId is pased from <td><button onclick="deleteEvent(echo $row['id']...
    function deleteEvent(eventId) {
    var confirmation = confirm('Delete this event?');
    console.log(eventId);
    if (confirmation) {
        console.log("Confirmed");
        //Execute deleteUser function from admin_methods_events php using Ajax
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'Admin/admin_methods_events.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
                window.location.reload();
            } else {
                console.log('Request failed. Status: ' + xhr.status);
            }
        };
        //Sends data object , which contains delete ID
        var data = 'delEvent_id=' + eventId;
        xhr.send(data);
    } else {
        console.log('Deletion canceled');
    }
}
</script>

<div id="eventFormContainer">
    <form id="eventForm" method="post" action="">
        <label>Event Name:</label>
        <input type="text" name="eventName" placeholder="Event name" required value="<?php echo $edit_name; ?>">
        <label>Event Start:</label>
        <input type="text" name="eventStartDate" id="eventStartDate" required value="<?php echo $edit_start; ?>">
        <label>Event End:</label>
        <input type="text" name="eventEndDate" id="eventEndDate" required value="<?php echo $edit_end; ?>">
        <input type="hidden" name="edit_event" required value="<?php echo $event_id; ?> ">
        <div id="button_field">
            <input type="submit" name="submit_update" value="Update" class="form_button event_button">
            <input type="reset" value="Reset" role="button" name="reset" class="form_button event_button">
        </div>
    </form>
</div>
