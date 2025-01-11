<?php
    include '../../templates/dbconnection.php';

    $id = $_GET['id'];
    $sponsorplanItem = $conn->query("SELECT * FROM sponsorplan WHERE id = $id")->fetch_assoc();

    header('Content-Type: application/json');
    echo json_encode($sponsorplanItem);
?>