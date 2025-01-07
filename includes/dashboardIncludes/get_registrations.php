<?php
    include '../../templates/dbconnection.php';
    
$eventId = isset($_GET['eventid']) ? intval($_GET['eventid']) : 0;

if ($eventId > 0) {
    $stmt = $conn->prepare("SELECT firstname, lastname, phone, email, street, housenumber, addition, postalcode, amount_people, groupname, datetime FROM registrations WHERE eventid = ?");
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $result = $stmt->get_result();
    $registrations = $result->fetch_all(MYSQLI_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($registrations);
} else {
    echo json_encode([]);
}
?>