<style> <?php include './assets/css/standardblock.css'; ?> </style>
<style> <?php include './assets/css/newstemplate.css'; ?> </style>

<div class="block-overview">
    <div class="heading-title">
        <h2 class="block-title"> Bevestiging insjrieving </h2>
    </div>
    <div class="block-text">
        <div class="news-row">
            <?php if ($_POST['amount_people'] > 1) { echo "Uch"; } else { echo "Dien"; } ?> aanmelding veur de <?php echo $eventName; ?> is gelök!</br>
            Veer zólle dit auch per mail bevestigen.</br></br>
            Binnen enkele ogenblikke keerse automatisch teruk nao de homepagina.
        </div>
    </div>
</div>
<script>
    setTimeout (function () {
     window.location.href = "index.php";
    }, 10000);
</script>