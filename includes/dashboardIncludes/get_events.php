<?php
    include '../../templates/dbconnection.php';

    $id = $_GET['id'];
    $eventItem = $conn->query("SELECT * FROM events WHERE id = $id")->fetch_assoc();

    header('Content-Type: application/json');
    echo json_encode($eventItem);
?>