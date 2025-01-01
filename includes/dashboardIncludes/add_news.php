<?php
session_start();
include '../../templates/dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $date = $_POST['date'];
    $title = $_POST['title'];
    $text = $_POST['text'];
    $eventid = $_POST['eventid'] ?? null;
    $image_url = $_POST['existing_image_url'];

    // Handle file upload if a new file is provided
    if (!empty($_FILES['image_url']['name'])) {
        $target_dir = "../../uploads/";
        $target_file = $target_dir . basename($_FILES["image_url"]["name"]);
        move_uploaded_file($_FILES["image_url"]["tmp_name"], $target_file);
        $image_url = $target_file;
    } else {
        $image_url = empty($image_url) ? NULL : $image_url;
    }

    $eventid = $_POST['eventid'];
    if ($eventid === '') {
        $eventid = NULL;
    }

    if ($id) {
        // Update existing news item
        $stmt = $conn->prepare("UPDATE news SET eventid = ?, title = ?, text = ?, date = ?, image_url = ? WHERE id = ?");
        $stmt->bind_param("issssi", $eventid, $title, $text, $date, $image_url, $id);
    } else {
        // Insert new news item
        if ($eventid) {
            $sql = "INSERT INTO news (date, title, text, image_url, eventid) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $date, $title, $text, $image_url, $eventid);
        } else {
            $sql = "INSERT INTO news (date, title, text, image_url) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $date, $title, $text, $image_url);
        }
    }

    $stmt->execute();
    $stmt->close();

    header("Location: ../../dashboard.php");
    exit();
}
?>