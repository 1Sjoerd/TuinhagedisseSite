<?php require './vendor/autoload.php'; ?>

<style> <?php include './assets/css/header.css'; ?></style>

    <a href="#">
        <img class="logo" src="./assets/images/TuinhagedisseLogo.png"/>
    </a>
    <header class="site-header">
        <div class="header__content--flow">
            <section class="header-content--left">
                <a href="#" class="brand-logo"></a>
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
                            <a class="nav__link" href="#">Vereniging</a>
                        </li>
                        <li class="list-item">
                            <a class="nav__link" href="#">Historie</a>
                        </li>
                        <li class="list-item">
                            <a class="nav__link" href="./sjponsore.php">Sjponsore</a>
                        </li>
                        <li class="list-item">
                            <a class="nav__link" href="#">Ketak</a>
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
                "https://th.martines.dev/assets/images/bannerPlaceholder.jpg",
                "https://th.martines.dev/assets/images/bannerPlaceholder2.jpg",
                "https://th.martines.dev/assets/images/bannerPlaceholder3.jpg"
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
            "https://th.martines.dev/assets/images/bannerPlaceholder.jpg",
            "https://th.martines.dev/assets/images/bannerPlaceholder2.jpg",
            "https://th.martines.dev/assets/images/bannerPlaceholder3.jpg"
        ];

        setInterval(function () {
            var bg = "url(" + images[Math.floor(Math.random() * images.length)] + ")";
            banner.style.backgroundImage = bg;
        }, 5000);
    </script>