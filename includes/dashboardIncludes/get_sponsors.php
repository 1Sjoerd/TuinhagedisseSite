<?php
    include '../../templates/dbconnection.php';

    $id = $_GET['id'];
    $sponsorsItem = $conn->query("SELECT * FROM sponsors WHERE id = $id")->fetch_assoc();

    header('Content-Type: application/json');
    echo json_encode($sponsorsItem);
?>