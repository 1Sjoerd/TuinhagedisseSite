<?php
$eventid = $_POST['eventid'];
$eventName = '';

$sql = "SELECT * FROM events WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $eventid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $eventName = $row['title'];
    $eventDate = date("d-m-Y", strtotime($row['date']));
}

ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V.V. de Tuinhagedisse</title>
    <link rel="stylesheet" href="https://vvdetuinhagedisse.nl/assets/css/global.css">
    <link rel="stylesheet" href="https://vvdetuinhagedisse.nl/assets/css/standardblock.css">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&amp;display=swap" rel="stylesheet">
</head>
<body>
    <div class="container-hagedis"></div>
    <style>
    *, *::before, *::after {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --brand-clr: hsl(185, 85%, 40%);
        --bg-primary: hsl(195, 20%, 86%);
        --border-clr: hsl(195, 16%, 82%);
        --accent-blue: #ffffff;
        --text-primary: #ffffff;
        --text-accent: #ffffff;
    
        --header: 3.5rem;
        --full-width: 100%;
        --padding-space: calc(var(--full-width) - 2rem);
        --max-width: 80rem;
        --min-width: 22.5rem;
    
        --bd-radius: 0.5em;
        --space-025: 0.25rem;
        --space-05: 0.5rem;
        --space-1: 1rem;
    }

    a {
        text-decoration: none;
    }

    body {
        display: flex;
        flex-flow: column;
        min-block-size: 100vh;
        font-family: system-ui;
    }

    .container {
        flex-grow: 1;
        display: grid;
        place-self: center;
        inline-size: clamp(
            var(--min-width),
            var(--padding-space),
            var(--max-width)
        );
    }

    .site-header {
        --padding: 1rem;
        --header-margin: 5vh;
        --shadow: 0 0.1875em 0.3125em #0003, 0 0.125em 0.5em #0002;
        min-block-size: var(--header);
        background: repeating-linear-gradient(
        45deg,
        rgb(54, 161, 65),
        rgb(54, 161, 65) 210px,
        rgb(55, 165, 66) 210px,
        rgb(55, 165, 66) 420px
        );
        /* background-color: rgb(27 69 31); */
        outline: 1px solid var(--border-clr);
        padding-inline: var(--padding);
        box-shadow: var(--shadow);
        height: 60px;
    }

    .header__content--flow {
        block-size: inherit;
        display: flex;
        flex-flow: wrap;
        right: 20;
        gap: 0 clamp(3.5rem, -24.14rem + 61.43vw, 25rem);
    }

    .header__content--flow > * {
        flex-grow: 1;
        height: var(--header);
        width: calc((45rem - var(--full-width) - (var(--padding) * 2)) * 999);
    }

    .header-content--left {
        display: grid;
        grid-auto-flow: column;
        inline-size: max-content;
        place-content: center;
    }

    .logo-text {
        color: var(--text-primary);
        font-size: 20px;
        font-weight: 500;
    }

    .nav-toggle {
        aspect-ratio: 1;
        height: 2.25rem;
        display: inline-grid;
        place-content: center;
        background: none;
        border: none;
        visibility: hidden;
        cursor: pointer;
        margin-top: 4px;
        margin-right: 15px
    }

    .header-content--right {
        flex-grow: 999;
    }

    .header-nav {
        display: grid;
        align-items: center;
        block-size: 100%;
        margin-left: auto; 
        margin-right: 0;
        width: 562px;
    }

    .nav__list {
        list-style: none;
        display: grid;
        grid-auto-flow: column;
        justify-content: space-evenly;
        height: 60px;
    }

    .list-item {
        block-size: 100%;
    }

    .nav__link {
        block-size: inherit;
        display: inline-grid;
        place-items: center;
        min-width: 10ch;
        color: var(--text-primary);
        font-size: 18.3px;
        font-weight: 500;
        text-transform: uppercase;
        font-family: "Oswald", sans-serif;
        text-shadow: 2px 2px rgb(16, 90, 24);
    }

    .logo {
      height: auto;
      width: 172px;
      position: absolute;
      margin-left: 20px;
      margin-top: -20px;
      box-shadow: var(--shadow);
      z-index: 3;
    }

    .background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url("assets/images/banner/8.JPG");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        transition: background-image 1s ease;
    }

    @media (max-width: 720px) {
        .header-content--left {
            justify-content: space-between;
        }

        .header-content--right {
            height: auto;
        }

        .header-nav {
          display: grid;
          align-items: center;
          block-size: 100%;
          margin-left: auto; 
          margin-right: 0;
          width: 0px;
        }

        .nav-toggle {
            visibility: visible;
        }

        .nav__list {
            right: 0;
            margin-inline: var(--space-1);
            top: 70px;
            gap: var(--space-05) 0;
            position: fixed;
            width: 10em;
            background-color: rgb(54, 161, 65);
            border-radius: var(--bd-radius);
            border: 1px solid var(--border-clr);
            padding-block: 0.5rem;
            grid-auto-flow: row;
            box-shadow: var(--shadow);
            visibility: hidden;
            opacity: 0;
            justify-content: space-evenly;
            grid-auto-rows: 2.25rem;
            height: auto;
        }

        .nav__list[aria-expanded="true"] {
            z-index: 3;
            position: absolute;
            visibility: visible;
            transform-origin: top center;
            opacity: 1;
            transition: visibility 0ms, transform 166ms ease, opacity 166ms linear;
        }

        .logo {
          height: auto;
          width: 132px;
          position: absolute;
          margin-left: -20px;
          margin-top: -20px;
        }
    }

    @media (max-width: 479px) {
        .nav__list {
            justify-content: space-evenly;
            grid-auto-rows: 2.25rem;
            height: auto;
        }
    }    
    
    .banner-carousel .item img {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }
</style>
    <img class="logo" src="https://vvdetuinhagedisse.nl/assets/images/TuinhagedisseLogo.png">
    <header class="site-header">
        <div class="header__content--flow">
            <section class="header-content--left">
                <a href="./index.php" class="brand-logo"></a>
            </section>
            <section class="header-content--right">
                <nav class="header-nav" role="navigation">
                    <ul class="nav__list" aria-expanded="false">
                        <li class="list-item">
                            <a class="nav__link">Bevestiging</a>
                        </li>
                    </ul>
                </nav>
            </section>
        </div>
    </header>
    <div class="content">
        <div class="block-overview">
            <div class="heading-title">
                <h2 class="block-title"> Bevestiging </h2>
            </div>
            <div class="block-text">
                <p>Beste <?php echo $_POST['firstname']; ?>,</p>
                  <p>Bie deze bevestigen veer det geer ug hubt aangemeld veur de <?php echo $eventName; ?> op:</p>
                  <p><strong>Datum:</strong> <?php echo $eventDate; ?></p></br>
                  <p>Bedank!</p></br>
                  <p>Groet,</p>
                  <p>VV de Tuinhagedisse</p>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style> 
        .footer{
            background: rgb(43, 148, 53);
            padding:20px 0px;
            color: var(--text-primary);
            text-align:center;
            font-size: 20px;
            font-weight: 500;
            text-transform: uppercase;
            text-shadow: 2px 2px rgb(16, 90, 24);
            outline: 1px solid var(--border-clr);
            font-family: "Oswald", sans-serif;
        }
            
        .footer .row{
            width:100%;
            margin:1% 0%;
            padding:0.6% 0%;
            font-size:0.8em;
        }
            
        .footer .row a{
            text-decoration:none;
            color: var(--text-primary);
            transition:0.5s;
        }
            
        .footer .row a:hover{
            color:rgb(165, 165, 165);
        }
            
        .footer .row ul{
            width:100%;
        }
            
        .footer .row ul li{
            display:inline-block;
            margin:0px 30px;
        }
            
        .footer .row a i{
            font-size:2em;
            margin:0% 1%;
            text-shadow: 2px 2px rgb(16, 90, 24);
        }
    </style>
    <footer>
        <div class="footer">
            <div class="row">
                <a href="https://www.facebook.com/vvdetuinhagedisse" target="_blank"><i class="fa fa-facebook"></i></a>
                <a href="https://www.instagram.com/vvdetuinhagedisse/" target="_blank"><i class="fa fa-instagram"></i></a>
            </div>
            <div class="row">
                © 2024 V.V. de Tuinhagedisse
            </div>
        </div>
    </footer>
</body>
</html>
<?php
$message = ob_get_clean();
echo $message;
?>
