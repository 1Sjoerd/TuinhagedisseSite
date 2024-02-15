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
                            <a class="nav__link" href="#">Akteweel</a>
                        </li>
                        <li class="list-item">
                            <a class="nav__link" href="#">Vereniging</a>
                        </li>
                        <li class="list-item">
                            <a class="nav__link" href="#">Historie</a>
                        </li>
                        <li class="list-item">
                            <a class="nav__link" href="#">Sjponsore</a>
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
        var banner = document.getElementById("banner");
        var images = [
            "url('https://th.martines.dev/assets/images/bannerPlaceholder.jpg')",
            "url('https://th.martines.dev/assets/images/bannerPlaceholder2.jpg')",
            "url('https://th.martines.dev/assets/images/bannerPlaceholder3.jpg')"
        ];

        setInterval(function () {
            var bg = images[Math.floor(Math.random() * images.length)];
            banner.style.backgroundImage = bg;
        }, 5000);
    </script>