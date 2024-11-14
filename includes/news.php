<style> <?php include './assets/css/standardblock.css'; ?> </style>
<style> <?php include './assets/css/news.css'; ?> </style>
<style> <?php include './assets/css/modal.css'; ?> </style>

<div class="block-overview">
    <div class="heading-title">
        <h2 class="block-title"> Letste nuujts </h2>
    </div>
    <div class="news-body">
        <div id="news-slider" class="owl-carousel news-slider">
        <?php
            $sql = "SELECT * FROM `news` ORDER BY `date` DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0 ) {
                while ($row = $result->fetch_assoc()) {

                    $origDate = $row["date"];
                    $newDate = date("d-M-Y", strtotime($origDate));

                    echo "<div class='news-post'>";
                        echo "<div class='post-img'>";
                            if ($row['image_url'] == '') {
                                echo "<img src='./assets/images/TuinhagedisseLogo.png' alt=''>";
                            } else {
                                echo "<img src='".$row["image_url"]."' alt=''>";
                            }
                        echo "</div>";
                        echo "<div class='post-content'>";
                            echo "<h3 class='post-title'>";
                                echo "<a data-id='".$row['id']."news' class='show-modal'>".$row["title"]."</a>";
                            echo "</h3>";
                            echo "<p class='post-description'>".$row["text"]."</p>";
                            echo "<span class='post-date'><i class='fa fa-clock-o'></i>".$newDate."</span>";
                            echo "<a data-id='".$row['id']."news' class='read-more show-modal'>Laes meer</a>";
                        echo "</div>";
                    echo "</div>";
                }
            }
        ?>
        </div>
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
                        echo "<a class='close-button hide-modal' id='".$row['id']."news' data-id='".$row['id']."news'>&#10006;</a>";
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
    </div>
</div>



<script src="./assets/js/modal.js"></script>