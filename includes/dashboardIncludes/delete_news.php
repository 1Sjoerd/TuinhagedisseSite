<?php
session_start();
include '../../templates/dbconnection.php';

$id = $_GET['id'];
$conn->query("DELETE FROM news WHERE id = $id");

echo "<script>window.location.href = '../../dashboard.php';</script>";
exit();
?>