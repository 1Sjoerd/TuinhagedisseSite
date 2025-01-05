<?php
session_start();
include '../../templates/dbconnection.php';

$id = $_GET['id'];
echo $id;

// Delete the news entry from the database
$conn->query("DELETE FROM users WHERE id = $id");

echo "<script>window.location.href = '../../dashboard.php';</script>";
exit();
?>