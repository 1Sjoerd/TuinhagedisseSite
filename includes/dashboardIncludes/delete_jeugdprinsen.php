<?php
session_start();
include '../../templates/dbconnection.php';

$id = $_GET['id'];

// Retrieve the image url from the database
$result = $conn->query("SELECT image_url, altimage_url FROM jeugdprinse WHERE id = $id");
$row = $result->fetch_assoc();
$image_url = "../." . $row['image_url'];
$altimage_url = "../." . $row['altimage_url'];

// Delete the image file from the server
if (file_exists($image_url)) {
    unlink($image_url);
}

// Delete the image file from the server
if (file_exists($altimage_url)) {
    unlink($altimage_url);
}

// Delete the news entry from the database
$conn->query("DELETE FROM jeugdprinse WHERE id = $id");

echo "<script>window.location.href = '../../dashboard.php';</script>";
exit();
?>