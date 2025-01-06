<?php
session_start();
include '../../templates/dbconnection.php';

$id = $_GET['id'];

// Delete the user entry from the database
$conn->query("DELETE FROM users WHERE id = $id");
// Delete the user roles from the database
$conn->query("DELETE FROM user_roles WHERE user_id = $id");

echo "<script>window.location.href = '../../dashboard.php';</script>";
exit();
?>
