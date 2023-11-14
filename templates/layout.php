<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website Title</title>

    <!-- Link naar je CSS-bestand(en) -->
    <link rel="stylesheet" href="/assets/css/style.css">

    <!-- Voeg eventuele andere head-elementen toe, zoals scripts of meta-tags -->
</head>
<body>

    <!-- Inclusie van de header -->
    <?php include_once 'includes/header.php'; ?>

    <!-- Inhoud van de specifieke pagina wordt hier ingevoegd -->
    <div class="content">
        <?php include_once $content; ?>
    </div>

    <!-- Inclusie van de footer -->
    <?php include_once 'includes/footer.php'; ?>

    <!-- Link naar je JavaScript-bestand(en) -->
    <script src="/assets/js/script.js"></script>

    <!-- Voeg eventuele andere scripts toe -->
</body>
</html>
