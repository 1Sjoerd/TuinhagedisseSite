<?php
//NEWS
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['news'])) {
    $newsId = intval($_POST['news']);

    include './templates/dbconnection.php';

    $sql = "SELECT * FROM `news` WHERE `id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $newsId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $formattedDate = date("d-m-Y", strtotime($row["date"]));
        include './news-template.php';
    } else {
        echo "<p>Nieuwsitem niet gevonden.</p>";
    }
    $stmt->close();
    $conn->close();
} else {
    header("Location: ./index.php");
}
?>