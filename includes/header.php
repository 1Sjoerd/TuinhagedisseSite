<?php require './vendor/autoload.php'; ?>

<style> <?php include './assets/css/header.css'; ?></style>

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
                        <!--<li class="list-item">
                            <a class="nav__link" href="#">Historie</a>
                        </li>-->
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
    <div class="banner">
        <div id="banner" class="background"></div>
    </div>

    <script>
        function preloadImages() {
            var images = [
                "./assets/images/banner/1.JPG",
                "./assets/images/banner/2.JPG",
                "./assets/images/banner/3.JPG",
                "./assets/images/banner/4.JPG",
                "./assets/images/banner/5.JPG",
                "./assets/images/banner/6.JPG",
                "./assets/images/banner/7.JPG",
                "./assets/images/banner/8.JPG",
                "./assets/images/banner/9.JPG",
                "./assets/images/banner/10.JPG",
                "./assets/images/banner/11.JPG",
                "./assets/images/banner/12.JPG"
            ];

            for (var i = 0; i < images.length; i++) {
                var img = new Image();
                img.src = images[i];
            }
        }

        window.onload = preloadImages;
    </script>

    <script>
        var banner = document.getElementById("banner");
        var images = [
            "./assets/images/banner/1.JPG",
                "./assets/images/banner/2.JPG",
                "./assets/images/banner/3.JPG",
                "./assets/images/banner/4.JPG",
                "./assets/images/banner/5.JPG",
                "./assets/images/banner/6.JPG",
                "./assets/images/banner/7.JPG",
                "./assets/images/banner/8.JPG",
                "./assets/images/banner/9.JPG",
                "./assets/images/banner/10.JPG",
                "./assets/images/banner/11.JPG",
                "./assets/images/banner/12.JPG"
        ];

        setInterval(function () {
            var bg = "url(" + images[Math.floor(Math.random() * images.length)] + ")";
            banner.style.backgroundImage = bg;
        }, 5000);
    </script>