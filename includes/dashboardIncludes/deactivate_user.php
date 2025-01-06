<?php
session_start();
include '../../templates/dbconnection.php';

$id = $_GET['id'];

// Alter the is_active value of the user entry in the database
$conn->query("UPDATE users SET is_active = 0 WHERE id = $id");

echo "<script>window.location.href = '../../dashboard.php';</script>";
exit();
?>
