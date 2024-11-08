<?php
// Database credentials
//$servername = "vvdetuinhagedisse.nl.mysql";
//$username = "vvdetuinhagedisse_nl";
//$password = "TH2024!";
//$dbname = "vvdetuinhagedisse_nl";

// Create connection
//$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
//if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
//}

// Query to get the string
//$sql = "SELECT `string` FROM `test-table`";
//$result = $conn->query($sql);

//$string_output = "";

//if ($result->num_rows > 0) {
    // Assuming you want to display only the first result
//    $row = $result->fetch_assoc();
//    $string_output = $row["string"];
//} else {
//    $string_output = "No information available";
//}

// Close connection
//$conn->close();
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style> <?php include './assets/css/footer.css'; ?> </style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

<!-- Owl Stylesheets -->
<link rel="stylesheet" href="./assets/js/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css" />


<!-- javascript -->
<script src="./assets/js/OwlCarousel2-2.3.4/dist/owl.carousel.min.js"></script>

<div class="owl-carousel">
<div class="sponsoren-carousel">
        <a href='' target='blank'>
            <img src='./assets/images/logos-sjponsoren/aad_20leeuwe.jpg' alt="">
        </a>
    </div>
    <div class="sponsoren-carousel">
        <a href='' target='blank'>
            <img src='./assets/images/logos-sjponsoren/Baker%20Bart%20kazerneplein.jpg' alt="">
        </a>
    </div>
    <div class="sponsoren-carousel">
        <a href='' target='blank'>
            <img src='./assets/images/logos-sjponsoren/bartjanssenassurantien.png' alt="">
        </a>
    </div>
    <div class="sponsoren-carousel">
        <a href='' target='blank'>
            <img src='./assets/images/logos-sjponsoren/botex%20wasserij%20logo.jpg' alt="">
        </a>
    </div>
    <div class="sponsoren-carousel">
        <a href='' target='blank'>
            <img src='./assets/images/logos-sjponsoren/Dierx%20Groep.jpg' alt="">
        </a>
    </div>
    <div class="sponsoren-carousel">
        <a href='' target='blank'>
            <img src='./assets/images/logos-sjponsoren/domiveranda.png' alt="">
        </a>
    </div>
    <div class="sponsoren-carousel">
        <a href='' target='blank'>
            <img src='./assets/images/logos-sjponsoren/hetfinancieeladvieshuis.png' alt="">
        </a>
    </div>
    <div class="sponsoren-carousel">
        <a href='' target='blank'>
            <img src='./assets/images/logos-sjponsoren/Hotel-en-Grand-Cafe-De-Pauw.png' alt="">
        </a>
    </div>
    <div class="sponsoren-carousel">
        <a href='' target='blank'>
            <img src='./assets/images/logos-sjponsoren/janwuts.jpeg' alt="">
        </a>
    </div>
    <div class="sponsoren-carousel">
        <a href='' target='blank'>
            <img src='./assets/images/logos-sjponsoren/meneerkes.jpg' alt="">
        </a>
    </div>
    <div class="sponsoren-carousel">
        <a href='' target='blank'>
            <img src='./assets/images/logos-sjponsoren/mts.gif' alt="">
        </a>
    </div>
    <div class="sponsoren-carousel">
        <a href='' target='blank'>
            <img src='./assets/images/logos-sjponsoren/sif.jpeg' alt="">
        </a>
    </div>
    <div class="sponsoren-carousel">
        <a href='' target='blank'>
            <img src='./assets/images/logos-sjponsoren/van%20Tuyl%20beheer.jpg' alt="">
        </a>
    </div>
    <!-- Carousel content remains unchanged -->
</div>

<footer>
    <div class="footer">
        <div class="row">
            <a href="https://www.facebook.com/vvdetuinhagedisse" target="_blank"><i class="fa fa-facebook"></i></a>
            <a href="https://www.instagram.com/vvdetuinhagedisse/" target="_blank"><i class="fa fa-instagram"></i></a>
        </div>

        <div class="row">
            &copy; <?php echo date("Y"); ?> V.V. de Tuinhagedisse
        </div>
    </div>
</footer>

<script>
    $(document).ready(function(){
        $("#news-slider").owlCarousel({
            autoplay:false,
            center: false,
            loop:false,
            dots:true,
            nav:true,
            navText: ["<a class='buttonprev'>","<a class='buttonnext'></a>"],
            responsiveClass:true,
            responsive:{
                0:{
                    items:1
                },
                980:{
                    items:2
                },
                1200:{
                    items:3
                }
            }
        });

        $('.owl-carousel').owlCarousel({
            autoplay:true,
            autoplayHoverPause:true,
            center: false,
            loop:true,
            margin:50,
            dots:false,
            responsiveClass:true,
            responsive:{
                0:{
                    items:1,
                    autoplayTimeout:4000,
                },
                600:{
                    items:4,
                    autoplayTimeout:2500,
                },
                1000:{
                    items:6,
                    autoplayTimeout:2500,
                }
            }
        })
    });
</script>
