<?php
$sql = "SELECT * FROM `news` ORDER BY `date` DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0 ) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='modal' id='".$row["id"]."news'>";
            echo "<div class='modal-content'>";
                echo "<div class='block-overview'>";
                    echo "<div class='heading-title'>";
                        echo "<h2 class='block-title'>".$row["title"]."</h2>";
                        echo "<a class='close-button hide-modal' style='color:white;' id='".$row['id']."news' data-id='".$row['id']."news'><i class='fas fa-times'></i></a>";
                    echo "</div>";
                    echo "<div class='block-text'>";
                        echo $row["text"];
                    echo "</div>";
                echo "</div>";
            echo "</div>";
        echo "</div>";
    }
}
?>