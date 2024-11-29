<style> <?php include './assets/css/standardblock.css'; ?> </style>
<style> <?php include './assets/css/news.css'; ?> </style>

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
                        $newDate = explode('-', $newDate);

                        $day = $newDate[0];
                        $month = $newDate[1];
                        $year = $newDate[2];

                        if ($month == "Mar") {
                            $month = "Mrt";
                        } elseif ($month == "May") {
                            $month = "Mei";
                        } elseif ($month == "Oct") {
                            $month = "Okt";
                        }

                        $formattedDate = $day . '-' . $month . '-' . $year;

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
                                echo "<span class='post-date'><i class='fa fa-clock-o'></i>".$formattedDate."</span>";
                                echo "<a data-id='".$row['id']."news' class='read-more show-modal'>Laes meer</a>";
                            echo "</div>";
                        echo "</div>";
                    }
                }
            ?>
        </div>
    </div>
</div>



