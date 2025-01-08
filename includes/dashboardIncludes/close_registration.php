<?php
session_start();
include '../../templates/dbconnection.php';

$eventId = $_GET['id'];
$stmt = $conn->prepare("UPDATE events SET registration_enddate = NOW() WHERE id = ?");
$stmt->bind_param("i", $eventId); // 'i' staat voor een integer
$stmt->execute();

echo "<script>window.location.href = '../../dashboard.php';</script>";
exit();
?>
