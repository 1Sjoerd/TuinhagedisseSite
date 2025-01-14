<style> <?php include './assets/css/standardblock.css'; ?> </style>
<link rel="stylesheet" href="./assets/css/verenigingPrinsen.css">

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
                                if ($row["altimage_url"] == "") {
                                    echo "<img src='".$row["image_url"]."' alt='Prins ".$row["firstname"]." ".$row["number"]."' loading='lazy' />";
                                } else {
                                    echo "<img src='".$row["altimage_url"]."' alt='Prins ".$row["firstname"]." ".$row["number"]."' loading='lazy' />";
                                }
                                echo "<div class='text-overlay'>";
                                    echo "<p class='title-text'>".$row["firstname"]." ".$row["number"]."</p>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                        if ($row["info"] == "") {
                            echo "<div class='card-text'>".$row["motto"]."</div>";
                        } else {
                            echo "<div class='card-text'>".$row["info"]."</div>";
                        }
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
                            if ($row["altimage_url"] == "") {
                                echo "<img src='".$row["image_url"]."' alt='Prins ".$row["firstname"]." ".$row["number"]."' loading='lazy' />";
                            } else {
                                echo "<img src='".$row["altimage_url"]."' alt='Prins ".$row["firstname"]." ".$row["number"]."' loading='lazy' />";
                            }
                            echo "<div class='text-overlay'>";
                                echo "<p class='title-text'>".$row["firstname"]." ".$row["number"]."</p>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                    if ($row["info"] == "") {
                        echo "<div class='card-text'>".$row["motto"]."</div>";
                    } else {
                        echo "<div class='card-text'>".$row["info"]."</div>";
                    }
                echo "</div>";
            }
        }
    ?>
    </div>
</div>