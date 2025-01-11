<?php
session_start();
include '../../templates/dbconnection.php';

$id = $_GET['id'];

// Delete the news entry from the database
$conn->query("DELETE FROM sponsorplan WHERE id = $id");

echo "<script>window.location.href = '../../dashboard.php#sponsorplan-overview';</script>";
exit();
?>