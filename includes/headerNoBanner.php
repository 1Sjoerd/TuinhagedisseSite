<style>
    <?php include './assets/css/header.css'; 
    session_start();
    ?>
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
                        <a class="nav__link" href="./historie.php">Historie</a>
                    </li>
                    <li class="list-item">
                        <a class="nav__link" href="./sjponsore.php">Sjponsore</a>
                    </li>
                    <li class="list-item">
                        <a class="nav__link" href="./kontak.php">Kóntak</a>
                    </li>
                    <?php
                        if (isset($_SESSION['user_id'])) {
                            echo "<li class='list-item'><a class='nav__link' href='./includes/logout.php'>Logoet</a></li>";
                        }
                    ?>
                </ul>
            </nav>
        </section>
    </div>
</header>