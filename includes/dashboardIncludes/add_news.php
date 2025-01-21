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
        $new = "1";
        
        // Post to Facebook
        if (isset($_POST['post_on_facebook']) && $_POST['post_on_facebook'] == '1' && isset($new) && empty($_FILES['image_url']['name'])) {
            $accessToken = 'EAAMuxlWpSN8BO4Jq8LwWbE5nd2SDQelAvc2Gd3gX8Qkf4cPUKmFVnw0wGHtDmZBhO8EuJR5N7G84BeZCCIaDnLZAyv3lvuGQ36tZAU8G2UrGkR0caZCc8OYvEkuvOqOX3WjqPh3wj7O4l0VJf8YQxOGQlZCZADSGcAcpqsPa7dV82pfnUOOwSsLHlj2NUboGcZAW';
            $pageId = '848282781947419';
            $message = $title . "\n\n" . $text;
            $currentTimestamp = time();
            
            $defaultTime = '09:00:00';
            $selectedTimestamp = strtotime("$date $defaultTime");

            $isScheduled = $selectedTimestamp > $currentTimestamp;
            
            $url = "https://graph.facebook.com/v17.0/$pageId/feed";
            $postData = [
                'message' => $message,
                'access_token' => $accessToken,
            ];
            
            if ($isScheduled) {
                $postData['scheduled_publish_time'] = $selectedTimestamp;
                $postData['published'] = false; // Markeer als gepland
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
            $postResponse = curl_exec($ch);
            $postHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
        }
        
    }

    // Handle file upload if a new file is provided
    if (!empty($_FILES['image_url']['name'])) {
        $target_dir_extention = "../.";
        $target_dir = "./assets/images/news/";
        $test_dir = $target_dir_extention . $target_dir;
        $file_extension = pathinfo($_FILES["image_url"]["name"], PATHINFO_EXTENSION);
    
        // Sanitize the title to create a safe file name
        $safe_title = preg_replace('/[^a-zA-Z0-9 _-]/', '', $title); // Verwijder ongewenste tekens
        $safe_title = str_replace(' ', '_', $safe_title); // Vervang spaties door underscores
        $new_file_name = $id . "_" . $safe_title . ".webp";

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
            case 'JPG':
            case 'jpg':
            case 'jpeg':
                $image = imagecreatefromjpeg($_FILES["image_url"]["tmp_name"]);
                break;
            case 'PNG':    
            case 'png':
                $image = imagecreatefrompng($_FILES["image_url"]["tmp_name"]);
                break;
            case 'GIF':
            case 'gif':
                $image = imagecreatefromgif($_FILES["image_url"]["tmp_name"]);
                break;
            case 'WEBP':
            case 'webp':
                // If the file is already in WebP format, just move it to the target location
                if (!move_uploaded_file($_FILES["image_url"]["tmp_name"], $target_file)) {
                    die("Failed to move WebP file.");
                }
                $stmt->close();
                $image_url = $db_url;
                // Update the news item with the new image URL
                $stmt = $conn->prepare("UPDATE news SET image_url = ? WHERE id = ?");
                $stmt->bind_param("si", $image_url, $id);
                $stmt->execute();
                
                
                // Post to Facebook
                if (isset($_POST['post_on_facebook']) && $_POST['post_on_facebook'] == '1' && isset($new)) {
                    $message = $title . "\n\n" . $text;
                    $currentTimestamp = time();
                    $defaultTime = '09:00:00';
                    $selectedTimestamp = strtotime("$date $defaultTime");
                
                    $isScheduled = $selectedTimestamp > $currentTimestamp;
                    
                    $absoluteImagePath = "../." . $image_url;
                    
                    // Check if the image file exists before posting to Facebook
                    if (!file_exists($absoluteImagePath)) {
                        die("Afbeeldingsbestand bestaat niet: $absoluteImagePath");
                    }
                    
                    $url = "https://graph.facebook.com/v17.0/$pageId/photos";
                    $postData = [
                        'source' => new CURLFile($absoluteImagePath),
                        'caption' => $message,
                        'access_token' => $accessToken,
                    ];
                    
                    if ($isScheduled) {
                        $postData['scheduled_publish_time'] = $selectedTimestamp;
                        $postData['published'] = false; // Markeer als gepland
                    }


                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
                    $postResponse = curl_exec($ch);
                    $postHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);
                }
                
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
            
            // Post to Facebook
            if (isset($_POST['post_on_facebook']) && $_POST['post_on_facebook'] == '1' && isset($new)) {
                $message = $title . "\n\n" . $text;
                $currentTimestamp = time();
                $defaultTime = '09:00:00';
                $selectedTimestamp = strtotime("$date $defaultTime");
    
                $isScheduled = $selectedTimestamp > $currentTimestamp;
                
                $absoluteImagePath = "../." . $image_url;
                
                // Check if the image file exists before posting to Facebook
                if (!file_exists($absoluteImagePath)) {
                    die("Afbeeldingsbestand bestaat niet: $absoluteImagePath");
                }
                
                $url = "https://graph.facebook.com/v17.0/$pageId/photos";
                $postData = [
                    'source' => new CURLFile($absoluteImagePath),
                    'caption' => $message,
                    'access_token' => $accessToken,
                ];
                
                if ($isScheduled) {
                    $postData['scheduled_publish_time'] = $selectedTimestamp;
                    $postData['published'] = false; // Markeer als gepland
                }


                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
                $postResponse = curl_exec($ch);
                $postHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
            }
            
        } else {
            die("There was an error uploading the file.");
        }
    }
    $stmt->close();

    header("Location: ../../dashboard.php");
    exit();
}
?>
