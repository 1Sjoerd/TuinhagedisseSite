<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Kleur in de topbar van Safari -->
    <meta name="theme-color" content="#1B7A24FF" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#0b3e05" media="(prefers-color-scheme: dark)">

    <title>V.V. de Tuinhagedisse</title>

    <!-- Link naar je CSS-bestand(en) -->
    <link rel="stylesheet" href="./assets/css/global.css">
    <style> <?php include './assets/css/modal.css'; ?> </style>
    <!-- Voeg eventuele andere head-elementen toe, zoals scripts of meta-tags -->
    <link rel="shortcut icon" href="./assets/images/favicon/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="./assets/images/favicon/apple-touch-icon.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="./assets/images/favicon/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="./assets/images/favicon/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/images/favicon/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="./assets/images/favicon/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="./assets/images/favicon/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="./assets/images/favicon/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="./assets/images/favicon/apple-touch-icon-152x152.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/images/favicon/apple-touch-icon-180x180.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
</head>

<?php
    require('dbconnection.php');
?>

<div class="container-hagedis"></div>

<body>

    <!-- Inclusie van de header -->
    <?php include_once 'includes/headerNoBanner.php'; ?>

    <!-- Inhoud van de specifieke pagina wordt hier ingevoegd -->
    <div class="content">
        <?php include_once $content; ?>
    </div>

    <!-- Inclusie van de footer -->
    <?php include_once 'includes/footer.php'; ?>
    
    <!-- Voeg eventuele andere scripts toe -->
</body>
</html>
