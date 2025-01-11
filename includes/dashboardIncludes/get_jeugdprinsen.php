<?php
include '../../templates/dbconnection.php';

$id = $_GET['id'];
$jeugdprinsenItem = $conn->query("SELECT * FROM jeugdprinse WHERE id = $id")->fetch_assoc();

header('Content-Type: application/json');
echo json_encode($jeugdprinsenItem);
?>