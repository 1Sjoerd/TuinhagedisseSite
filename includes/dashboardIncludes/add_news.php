<?php
session_start();
include '../../templates/dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $title = $_POST['title'];
    $text = $_POST['text'];
    $event_id = $_POST['event_id'] ?? null;
    $image_url = '';

    if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
        $image_url = 'uploads/' . basename($_FILES['image_url']['name']);
        move_uploaded_file($_FILES['image_url']['tmp_name'], $image_url);
    }

    $stmt = $conn->prepare("INSERT INTO news (date, title, text, image_url, eventid) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $date, $title, $text, $image_url, $event_id);
    $stmt->execute();

    echo "<script>window.location.href = '../../dashboard.php';</script>";
    exit();
}
?>