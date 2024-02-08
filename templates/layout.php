<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V.V. de Tuinhagedisse</title>

    <!-- Link naar je CSS-bestand(en) -->
    <link rel="stylesheet" href="./assets/css/global.css">

    <!-- Voeg eventuele andere head-elementen toe, zoals scripts of meta-tags -->
    <link rel="shortcut icon" href=".assets/images/favicon/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href=".assets/images/favicon/apple-touch-icon.png" />
    <link rel="apple-touch-icon" sizes="57x57" href=".assets/images/favicon/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href=".assets/images/favicon/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="76x76" href=".assets/images/favicon/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon" sizes="114x114" href=".assets/images/favicon/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="120x120" href=".assets/images/favicon/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon" sizes="144x144" href=".assets/images/favicon/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="152x152" href=".assets/images/favicon/apple-touch-icon-152x152.png" />
    <link rel="apple-touch-icon" sizes="180x180" href=".assets/images/favicon/apple-touch-icon-180x180.png" />
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
    <script src="./assets/js/header.js"></script>

    <!-- Voeg eventuele andere scripts toe -->
</body>
</html>
