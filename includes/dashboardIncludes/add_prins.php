<?php
session_start();
include '../../templates/dbconnection.php';

// Increase memory limit at the beginning of the script
ini_set('memory_limit', '256M');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['prinsId'];
    $firstname = $_POST['prinsfirstname'];
    $lastname = $_POST['prinslastname'];
    $number = $_POST['prinsnumber'];
    $year = $_POST['prinsyear'];
    $motto = $_POST['prinsmotto'];
    $info = $_POST['prinsinfo'] ?? null;
    $image_url = $_POST['prinsexisting_image_url'];
    $altimage_url = $_POST['prinsexisting_altimage_url'];

    if ($id) {
        // Update existing prins
        $stmt = $conn->prepare("UPDATE prinse SET firstname = ?, lastname = ?, number = ?, year = ?, motto = ?, info = ?, image_url = ?, altimage_url = ? WHERE id = ?");
        $stmt->bind_param("sssssssss", $firstname, $lastname, $number, $year, $motto, $info, $image_url, $altimage_url, $id);
        if ($stmt->execute()) {
            error_log("Prins updated successfully.");
        } else {
            error_log("Error updating prins: " . $stmt->error);
        }
    } else {
        // Insert placeholder to get new ID
        $stmt = $conn->prepare("INSERT INTO prinse (firstname, lastname, number, year, motto, info, image_url, altimage_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $firstname, $lastname, $number, $year, $motto, $info, $image_url, $altimage_url);
        $stmt->execute();
        $id = $stmt->insert_id;
    }
    
    // Handle file upload if a new file is provided
    if (!empty($_FILES['prinsimage_url']['name'])) {
        $target_dir_extention = "../.";
        $target_dir = "./assets/images/prinsen/";
        $test_dir = $target_dir_extention . $target_dir;
        $file_extension = pathinfo($_FILES["prinsimage_url"]["name"], PATHINFO_EXTENSION);
    
        // Sanitize the title to create a safe file name
        $safe_title = preg_replace('/[^a-zA-Z0-9 _-]/', '', $title); // Verwijder ongewenste tekens
        $safe_title = str_replace(' ', '_', $safe_title); // Vervang spaties door underscores
        $new_file_name = $firstname . "_" . $number . "_" . $year . ".webp";

        $target_file = $target_dir_extention . $target_dir . $new_file_name;
        $db_url = $target_dir . $new_file_name;

        // Check if the directory exists and is writable
        if (!is_dir($test_dir) || !is_writable($test_dir)) {
            die("Upload directory does not exist or is not writable.");
        }

        // Check if the uploaded file is a valid image
        $check = getimagesize($_FILES["prinsimage_url"]["tmp_name"]);
        if ($check === false) {
            die("File is not an image.");
        }

        $result = $conn->query("SELECT image_url FROM prinse WHERE id = $id");
        $row = $result->fetch_assoc();
        $current_image_url = $row['prinsimage_url'];
        if ($current_image_url) {
            $current_image_url = "../." . $current_image_url;
            // Delete the any existing image file from the server
            if (file_exists($current_image_url)) {
//
                echo "bestand wurd verwijderd";
                unlink($current_image_url);
            }
        }

        // Load the image
        switch ($file_extension) {
            case 'JPG':
            case 'jpg':
            case 'jpeg':
                $image = imagecreatefromjpeg($_FILES["prinsimage_url"]["tmp_name"]);
                break;
            case 'PNG':
            case 'png':
                $image = imagecreatefrompng($_FILES["prinsimage_url"]["tmp_name"]);
                break;
            case 'GIF':
            case 'gif':
                $image = imagecreatefromgif($_FILES["prinsimage_url"]["tmp_name"]);
                break;
            case 'WEBP':
            case 'webp':
                // If the file is already in WebP format, just move it to the target location
                if (!move_uploaded_file($_FILES["prinsimage_url"]["tmp_name"], $target_file)) {
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
        if (move_uploaded_file($_FILES["prinsimage_url"]["tmp_name"], $target_file)) {
            $image_url = $db_url;

            // Update the news item with the new image URL
            $stmt = $conn->prepare("UPDATE prinse SET image_url = ? WHERE id = ?");
            $stmt->bind_param("si", $image_url, $id);
            $stmt->execute();
        } else {
            die("There was an error uploading the file.");
        }
    }
    
    // Handle file upload if a new file is provided
    if (!empty($_FILES['prinsaltimage_url']['name'])) {
        $target_dir_extention = "../.";
        $target_dir = "./assets/images/prinsen/";
        $test_dir = $target_dir_extention . $target_dir;
        $file_extension = pathinfo($_FILES["prinsaltimage_url"]["name"], PATHINFO_EXTENSION);
    
        // Sanitize the title to create a safe file name
        $safe_title = preg_replace('/[^a-zA-Z0-9 _-]/', '', $title); // Verwijder ongewenste tekens
        $safe_title = str_replace(' ', '_', $safe_title); // Vervang spaties door underscores
        $new_file_name = $firstname . "_" . $number . "_" . $year . "_groepsfoto.webp";

        $target_file = $target_dir_extention . $target_dir . $new_file_name;
        $db_url = $target_dir . $new_file_name;

        // Check if the directory exists and is writable
        if (!is_dir($test_dir) || !is_writable($test_dir)) {
            die("Upload directory does not exist or is not writable.");
        }

        // Check if the uploaded file is a valid image
        $check = getimagesize($_FILES["prinsaltimage_url"]["tmp_name"]);
        if ($check === false) {
            die("File is not an image.");
        }

        $result = $conn->query("SELECT altimage_url FROM prinse WHERE id = $id");
        $row = $result->fetch_assoc();
        $current_image_url = $row['prinsaltimage_url'];
        if ($current_image_url) {
            $current_image_url = "../." . $current_image_url;
            // Delete the any existing image file from the server
            if (file_exists($current_image_url)) {
                unlink($current_image_url);
            }
        }

        // Load the image
        switch ($file_extension) {
            case 'JPG':
            case 'jpg':
            case 'jpeg':
                $image = imagecreatefromjpeg($_FILES["prinsaltimage_url"]["tmp_name"]);
                break;
            case 'PNG':
            case 'png':
                $image = imagecreatefrompng($_FILES["prinsaltimage_url"]["tmp_name"]);
                break;
            case 'GIF':
            case 'gif':
                $image = imagecreatefromgif($_FILES["prinsaltimage_url"]["tmp_name"]);
                break;
            case 'WEBP':
            case 'webp':
                // If the file is already in WebP format, just move it to the target location
                if (!move_uploaded_file($_FILES["prinsaltimage_url"]["tmp_name"], $target_file)) {
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
        if (move_uploaded_file($_FILES["prinsaltimage_url"]["tmp_name"], $target_file)) {
            $image_url = $db_url;

            // Update the news item with the new image URL
            $stmt = $conn->prepare("UPDATE prinse SET altimage_url = ? WHERE id = ?");
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