<style> <?php include './assets/css/standardblock.css'; ?> </style>

<div class="block-overview">
    <div class="heading-title">
        <h2 class="block-title"> <?= htmlspecialchars($row["title"]) ?> </h2>
    </div>
    <div class="block-text">
        <?= htmlspecialchars($row["text"]) ?>
    </div>
</div>