<style> <?php include './assets/css/standardblock.css'; ?> </style>
<style> <?php include './assets/css/newstemplate.css'; ?> </style>

<div class="block-overview">
    <div class="heading-title">
        <h2 class="block-title"><?php echo $confirmationtitle; ?></h2>
    </div>
    <div class="block-text">
        <div class="news-row">
            <?php echo $confirmationtext; ?>
        </div>
    </div>
</div>
<script>
    setTimeout (function () {
     window.location.href = "index.php";
    }, 10000);
</script>
