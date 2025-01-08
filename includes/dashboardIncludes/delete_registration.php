<?php
session_start();
include '../../templates/dbconnection.php';

$eventId = $_GET['id'];

// Delete the news entry from the database
$conn->query("DELETE FROM registrations WHERE eventid = $eventId");

echo "<script>window.location.href = '../../dashboard.php';</script>";
exit();
?>