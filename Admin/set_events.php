<?php
include '../database.php'; 

// Pārbauda, vai POST pieprasījumā ir saņemti dati
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pārbauda, vai ir saņemti notikuma nosaukums un datumi
    if (isset($_POST["eventName"]) && isset($_POST["eventStartDate"]) && isset($_POST["eventEndDate"])) {
        // Iegūst notikuma nosaukumu un datumus no POST pieprasījuma
        $eventName = $_POST["eventName"];
        $eventStart = date('Y-m-d', strtotime($_POST["eventStartDate"])); // Pielāgojiet formātu atbilstoši savam datubāzes formātam
        $eventEnd = date('Y-m-d', strtotime($_POST["eventEndDate"])); // Pielāgojiet formātu atbilstoši savam datubāzes formātam

        // Sagatavo un izpilda SQL vaicājumu, lai pievienotu notikumu datubāzē
        $insert_query = "INSERT INTO events (name, startDate, endDate) VALUES (?, ?, ?)";
        $insert_statement = mysqli_prepare($con, $insert_query);
        mysqli_stmt_bind_param($insert_statement, "sss", $eventName, $eventStart, $eventEnd);

        if(mysqli_stmt_execute($insert_statement)){
            $events = array(
                'success' => true,
                'msg' => 'Event added successfully!'
            );
        }else{
            $events = array(
                'success' => false,
                'msg' => 'Sorry, Event not added.'				
            );
        }
        
        // Aizver savienojumu ar datubāzi
        mysqli_close($con);
    } else {
        // Ja trūkst nepieciešamie dati, atgriežam kļūdas paziņojumu
        $events = array(
            'success' => false,
            'msg' => 'Event name and dates are mandatory'
        );
    }
} else {
    // Ja pieprasījums nav POST, atgriežam kļūdas paziņojumu
    $events = array(
        'success' => false,
        'msg' => 'Invalid request'
    );
}

// Atgriežam atbildi JSON formātā
header('Content-Type: application/json');
echo json_encode($events);
?>
