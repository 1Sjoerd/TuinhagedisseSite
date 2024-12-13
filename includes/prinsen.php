<link rel="stylesheet" href="./assets/css/prinsen.css">

<div class="block-overview">
    <div class="heading-title">
        <h2 class="block-title"> Veurgengers </h2>
    </div>
    <div class="prinsen-body">
        <?php
            $sql = "SELECT * FROM `prinse` ORDER BY `year` DESC LIMIT 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0 ) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='card-container'>";
                        echo "<div class='card'>";
                            echo "<div class='image-section'>";
                                echo "<img src='./assets/images/prinsen/rick.jpg' alt='Prins ".$row["firstname"]." ".$row["number"]."' loading='lazy' />";
                                echo "<div class='text-overlay'>";
                                    echo "<p class='title-text'>".$row["firstname"]." ".$row["number"]."</p>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                        echo "<div class='card-text'>\"".$row["motto"]."\"</div>";
                    echo "</div>";
                }
            }
        ?>

        <?php
            $sql = "SELECT * FROM `jeugdprinse` ORDER BY `year` DESC LIMIT 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0 ) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='card-container'>";
                        echo "<div class='card'>";
                            echo "<div class='image-section'>";
                                echo "<img src='./assets/images/prinsen/yara.jpg' alt='Prins ".$row["firstname"]." ".$row["number"]."' loading='lazy' />";
                                echo "<div class='text-overlay'>";
                                    echo "<p class='title-text'>".$row["firstname"]." ".$row["number"]."</p>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                        echo "<div class='card-text'>\"".$row["motto"]."\"</div>";
                    echo "</div>";
                }
            }
        ?>
    </div>
</div>

