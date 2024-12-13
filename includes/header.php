<?php require './vendor/autoload.php'; ?>

<style>
    <?php include './assets/css/header.css'; ?>
    .banner-carousel .item img {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }
</style>

<a href="./index.php">
    <img class="logo" src="./assets/images/TuinhagedisseLogo.png"/>
</a>
<header class="site-header">
    <div class="header__content--flow">
        <section class="header-content--left">
            <a href="./index.php" class="brand-logo"></a>
            <button class="nav-toggle">
                <span class="toggle--icon"></span>
            </button>
        </section>
        <section class="header-content--right">
            <nav class="header-nav" role="navigation">
                <ul class="nav__list" aria-expanded="false">
                    <li class="list-item">
                        <a class="nav__link" href="./index.php">Akteweel</a>
                    </li>
                    <li class="list-item">
                        <a class="nav__link" href="./vereniging.php">Vereniging</a>
                    </li>
                    <li class="list-item">
                        <a class="nav__link" href="#">Historie</a>
                    </li>
                    <li class="list-item">
                        <a class="nav__link" href="./sjponsore.php">Sjponsore</a>
                    </li>
                    <li class="list-item">
                        <a class="nav__link" href="./kontak.php">Kóntak</a>
                    </li>
                </ul>
            </nav>
        </section>
    </div>
</header>

<div id="banner-carousel" class="banner-carousel owl-carousel">
    <div class="item"><img src="./assets/images/banner/1.JPG" alt="Banner 1"></div>
    <div class="item"><img src="./assets/images/banner/2.JPG" alt="Banner 2"></div>
    <div class="item"><img src="./assets/images/banner/3.JPG" alt="Banner 3"></div>
    <div class="item"><img src="./assets/images/banner/4.JPG" alt="Banner 4"></div>
    <div class="item"><img src="./assets/images/banner/5.JPG" alt="Banner 5"></div>
    <div class="item"><img src="./assets/images/banner/6.JPG" alt="Banner 6"></div>
    <div class="item"><img src="./assets/images/banner/7.JPG" alt="Banner 7"></div>
    <div class="item"><img src="./assets/images/banner/8.JPG" alt="Banner 8"></div>
    <div class="item"><img src="./assets/images/banner/9.JPG" alt="Banner 9"></div>
    <div class="item"><img src="./assets/images/banner/10.JPG" alt="Banner 10"></div>
    <div class="item"><img src="./assets/images/banner/11.JPG" alt="Banner 11"></div>
    <div class="item"><img src="./assets/images/banner/12.JPG" alt="Banner 12"></div>
</div>