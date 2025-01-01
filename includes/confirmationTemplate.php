<style> <?php include './assets/css/standardblock.css'; ?> </style>
<style> <?php include './assets/css/newstemplate.css'; ?> </style>

<div class="block-overview">
    <div class="heading-title">
        <h2 class="block-title"> Bevestiging aanmelding </h2>
    </div>
    <div class="block-text">
        <div class="news-row">
            Ug aanmelding veur de <?php echo $eventName; ?> is geluk!</br>
            Veer zólle dit auch per mail bevestigen.</br></br>
            Binnen enkele ogenblikke keert geer automatisch teruk nao de homepagina.
        </div>
    </div>
</div>
<script>
    setTimeout (function () {
     window.location.href = "index.php";
    }, 5000);
</script>