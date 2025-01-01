<?php
session_start();
include '../../templates/dbconnection.php';

// Increase memory limit at the beginning of the script
ini_set('memory_limit', '256M');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $date = $_POST['date'];
    $title = $_POST['title'];
    $text = $_POST['text'];
    $eventid = $_POST['eventid'] ?? null;
    $image_url = $_POST['existing_image_url'];

    if ($eventid === '') {
        $eventid = NULL;
    }

    if ($id) {
        // Update existing news item
        $stmt = $conn->prepare("UPDATE news SET eventid = ?, title = ?, text = ?, date = ?, image_url = ? WHERE id = ?");
        $stmt->bind_param("issssi", $eventid, $title, $text, $date, $image_url, $id);
        if ($stmt->execute()) {
            error_log("News item updated successfully.");
        } else {
            error_log("Error updating news item: " . $stmt->error);
        }
    } else {
        // Insert placeholder to get new ID
        $stmt = $conn->prepare("INSERT INTO news (date, title, text, image_url, eventid) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $date, $title, $text, $image_url, $eventid);
        $stmt->execute();
        $id = $stmt->insert_id;
    }

    // Handle file upload if a new file is provided
    if (!empty($_FILES['image_url']['name'])) {
        $target_dir_extention = "../.";
        $target_dir = "./assets/images/news/";
        $test_dir = $target_dir_extention . $target_dir;
        $file_extension = pathinfo($_FILES["image_url"]["name"], PATHINFO_EXTENSION);
        $new_file_name = $id . "_" . $title . ".webp";
        $target_file = $target_dir_extention . $target_dir . $new_file_name;
        $db_url = $target_dir . $new_file_name;

        // Check if the directory exists and is writable
        if (!is_dir($test_dir) || !is_writable($test_dir)) {
            die("Upload directory does not exist or is not writable.");
        }

        // Check if the uploaded file is a valid image
        $check = getimagesize($_FILES["image_url"]["tmp_name"]);
        if ($check === false) {
            die("File is not an image.");
        }

        $result = $conn->query("SELECT image_url FROM news WHERE id = $id");
        $row = $result->fetch_assoc();
        $current_image_url = $row['image_url'];
        if ($current_image_url) {
            $current_image_url = "../." . $current_image_url;
            // Delete the any existing image file from the server
            if (file_exists($current_image_url)) {
                unlink($current_image_url);
            }
        }

        // Load the image
        switch ($file_extension) {
            case 'jpg':
            case 'jpeg':
                $image = imagecreatefromjpeg($_FILES["image_url"]["tmp_name"]);
                break;
            case 'png':
                $image = imagecreatefrompng($_FILES["image_url"]["tmp_name"]);
                break;
            case 'gif':
                $image = imagecreatefromgif($_FILES["image_url"]["tmp_name"]);
                break;
            case 'webp':
                // If the file is already in WebP format, just move it to the target location
                if (!move_uploaded_file($_FILES["image_url"]["tmp_name"], $target_file)) {
                    die("Failed to move WebP file.");
                }
                $stmt->close();
                header("Location: ../../dashboard.php");
                // Exit the script as no further processing is needed
                exit;
            default:
                die("Unsupported image format.");
        }

        // Convert the image to WebP format
        if (!imagewebp($image, $target_file)) {
            die("Failed to convert image to WebP format.");
        }

        // Free up memory
        imagedestroy($image);

        // Move the uploaded file
        if (move_uploaded_file($_FILES["image_url"]["tmp_name"], $target_file)) {
            $image_url = $db_url;

            // Update the news item with the new image URL
            $stmt = $conn->prepare("UPDATE news SET image_url = ? WHERE id = ?");
            $stmt->bind_param("si", $image_url, $id);
            $stmt->execute();
        } else {
            die("There was an error uploading the file.");
        }
    }

    $stmt->close();

    header("Location: ../../dashboard.php");
    exit();
}
?>