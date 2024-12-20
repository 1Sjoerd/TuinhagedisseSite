<style> <?php include './assets/css/standardblock.css'; ?> </style>
<style> <?php include './assets/css/newstemplate.css'; ?> </style>

<div class="block-overview">
    <div class="heading-title">
        <h2 class="block-title"> <?= htmlspecialchars($row["title"]) ?> </h2>
    </div>
    <div class="block-text">
        <div class="news-row">
        <?php
            if ($row['image_url'] != '') {
                echo "<div class='news-column'>";
                    echo "<img src='".htmlspecialchars($row["image_url"])."' alt='".htmlspecialchars($row["title"])."'>";
                echo "</div>";
                echo "<div class='news-column'>";
                    echo htmlspecialchars($row["text"]);
                echo "</div>";
            } else {
                echo htmlspecialchars($row["text"]);
            }
        ?>
        </div>
    </div>
</div>
