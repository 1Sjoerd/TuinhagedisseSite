<?php
session_start();
include '../../templates/dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $date = $_POST['date'];
    $title = $_POST['title'];
    $text = $_POST['text'];
    $event_id = $_POST['event_id'] ?? null;
    $image_url = $_POST['existing_image_url'];

    if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
        $image_url = 'uploads/' . basename($_FILES['image_url']['name']);
        move_uploaded_file($_FILES['image_url']['tmp_name'], $image_url);
    }

    $stmt = $conn->prepare("UPDATE news SET date = ?, title = ?, text = ?, image_url = ?, event_id = ? WHERE id = ?");
    $stmt->bind_param("ssssii", $date, $title, $text, $image_url, $event_id, $id);
    $stmt->execute();

    echo "<script>window.location.href = 'dashboard.php';</script>";
    exit();
}

$id = $_GET['id'];
$newsItem = $conn->query("SELECT * FROM news WHERE id = $id")->fetch_assoc();
?>

<form method="post" action="edit_news.php" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $newsItem['id']; ?>">
    <label for="date">Date:</label>
    <input type="date" id="date" name="date" value="<?php echo $newsItem['date']; ?>" required>
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" value="<?php echo $newsItem['title']; ?>" required>
    <label for="text">Text:</label>
    <textarea id="text" name="text" required><?php echo $newsItem['text']; ?></textarea>
    <label for="image_url">Image:</label>
    <input type="file" id="image_url" name="image_url">
    <input type="hidden" name="existing_image_url" value="<?php echo $newsItem['image_url']; ?>">
    <label for="event_id">Event ID (optional):</label>
    <input type="number" id="event_id" name="event_id" value="<?php echo $newsItem['event_id']; ?>">
    <input type="submit" value="Update News">
</form>