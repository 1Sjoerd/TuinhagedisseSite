<?php
session_start();
include '../../templates/dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['sponsorsId'];
    $name = $_POST['sponsorsName'];
    $url = $_POST['sponsorsUrl'];
    $image_url = $_POST['sponsorsexisting_image_url'];
    $sponsorplanId = $_POST['sponsorsPlan'];
    if (isset($_POST['sponsorsCarsponsor'])) {
        $carsponsor = "1";
    } else {
        $carsponsor = "0";
    }
    $street = $_POST['sponsorsStreet'];
    $postalcode = $_POST['sponsorsPostalcode'];
    $housenumber = $_POST['sponsorsHousenumber'];
    $addition = $_POST['sponsorsAddition'];
    $info = $_POST['sponsorsInfo'];
    
    if ($sponsorplanId === '') {
        $sponsorplanId = NULL;
    }

    if ($id) {
        // Update existing news item
        $stmt = $conn->prepare("UPDATE sponsors SET name = ?, url = ?, image_url = ?, sponsorplan_id = ?, carsponsor = ?, street = ?, postalcode = ?, housenumber = ?, addition = ?, info = ? WHERE id = ?");
        $stmt->bind_param("sssissssssi", $name, $url, $image_url, $sponsorplanId, $carsponsor, $street, $postalcode, $housenumber, $addition, $info, $id);
        if ($stmt->execute()) {
            error_log("Sponsor updated successfully.");
        } else {
            error_log("Error updating sponsor: " . $stmt->error);
        }
    } else {
        // Insert placeholder to get new ID
        $stmt = $conn->prepare("INSERT INTO sponsors (name, url, image_url, sponsorplan_id, carsponsor, street, postalcode, housenumber, addition, info) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssissssss", $name, $url, $image_url, $sponsorplanId, $carsponsor, $street, $postalcode, $housenumber, $addition, $info);
        $stmt->execute();
        $id = $stmt->insert_id;
    }

    // Handle file upload if a new file is provided
    if (!empty($_FILES['sponsorsimage_url']['name'])) {
        $target_dir_extention = "../.";
        $target_dir = "./assets/images/sjponsors/";
        $test_dir = $target_dir_extention . $target_dir;
        $file_extension = pathinfo($_FILES["sponsorsimage_url"]["name"], PATHINFO_EXTENSION);
    
        // Sanitize the title to create a safe file name
        $safe_title = preg_replace('/[^a-zA-Z0-9 _-]/', '', $name); // Verwijder ongewenste tekens
        $safe_title = str_replace(' ', '_', $safe_title); // Vervang spaties door underscores
        $new_file_name = $id . "_" . $safe_title . ".webp";

        $target_file = $target_dir_extention . $target_dir . $new_file_name;
        $db_url = $target_dir . $new_file_name;

        // Check if the directory exists and is writable
        if (!is_dir($test_dir) || !is_writable($test_dir)) {
            die("Upload directory does not exist or is not writable.");
        }

        // Check if the uploaded file is a valid image
        $check = getimagesize($_FILES["sponsorsimage_url"]["tmp_name"]);
        if ($check === false) {
            die("File is not an image.");
        }

        $result = $conn->query("SELECT image_url FROM sponsors WHERE id = $id");
        $row = $result->fetch_assoc();
        $current_image_url = $row['sponsorsimage_url'];
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
                $image = imagecreatefromjpeg($_FILES["sponsorsimage_url"]["tmp_name"]);
                break;
            case 'PNG':    
            case 'png':
                $image = imagecreatefrompng($_FILES["sponsorsimage_url"]["tmp_name"]);
                break;
            case 'GIF':
            case 'gif':
                $image = imagecreatefromgif($_FILES["sponsorsimage_url"]["tmp_name"]);
                break;
            case 'WEBP':
            case 'webp':
                // If the file is already in WebP format, just move it to the target location
                if (!move_uploaded_file($_FILES["sponsorsimage_url"]["tmp_name"], $target_file)) {
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
        if (move_uploaded_file($_FILES["sponsorsimage_url"]["tmp_name"], $target_file)) {
            $image_url = $db_url;

            // Update the news item with the new image URL
            $stmt = $conn->prepare("UPDATE sponsors SET sponsorsimage_url = ? WHERE id = ?");
            $stmt->bind_param("si", $image_url, $id);
            $stmt->execute();
        } else {
            die("There was an error uploading the file.");
        }
    }

    $stmt->close();

    header("Location: ../../dashboard.php#sponsors-overview");
    exit();
}
?>