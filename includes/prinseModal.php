<?php
$sql = "SELECT * FROM `prinse`";
$result = $conn->query($sql);

if ($result->num_rows > 0 ) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='modal' id='".$row["id"]."prinse'>";
            echo "<div class='modal-content'>";
                echo "<div class='block-overview'>";
                    echo "<div class='heading-title'>";
                        echo "<h2 class='block-title'>".$row["firstname"]." ".$row["number"]."</h2>";
                        echo "<a class='close-button hide-modal' style='color:white;' id='".$row['id']."prinse' data-id='".$row['id']."prinse'><i class='fas fa-times'></i></a>";
                    echo "</div>";
                    echo "<div class='block-text'>";
                        echo "<img src='./assets/images/prinsen/rick-groepsfoto.jpg' alt='Prins ".$row["firstname"]." ".$row["number"]."' loading='lazy' />";
                        echo $row["info"];
                    echo "</div>";
                echo "</div>";
            echo "</div>";
        echo "</div>";
    }
}
?>