<?php
include '../../templates/dbconnection.php';

$id = $_GET['id'];
$newsItem = $conn->query("SELECT * FROM news WHERE id = $id")->fetch_assoc();

header('Content-Type: application/json');
echo json_encode($newsItem);
?>