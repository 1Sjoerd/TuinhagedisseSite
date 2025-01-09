<?php
include '../../templates/dbconnection.php';

$id = $_GET['id'];
$prinsenItem = $conn->query("SELECT * FROM prinse WHERE id = $id")->fetch_assoc();

header('Content-Type: application/json');
echo json_encode($prinsenItem);
?>