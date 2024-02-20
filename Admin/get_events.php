<?php
// Iekļaujam savienojumu ar datubāzi
include '../database.php';

// Izgūstam notikumu datus no datubāzes
$events_query = "SELECT * FROM events";
$events_result = mysqli_query($con, $events_query);

// Pārbaudam, vai ir notikumu datus
if (mysqli_num_rows($events_result) > 0) {
    // Saglabājam notikumu datus masīvā
    $events = array();
    while ($row = mysqli_fetch_assoc($events_result)) {
        $events[] = array(
            'id' => $row['id'],
            'title' => $row['name'],
            'start' => $row['startDate'],
            'end' => $row['endDate']
        );
    }
    $data = array(
        'status' => true,
        'msg' => 'successfully!',
        'data' => $events
    );
} else {
    $data = array(
        'status' => false,
        'msg' => 'No events found!'
    );
}

// Atgriežam notikumu datus JSON formātā
header('Content-Type: application/json');
echo json_encode($data);
?>
