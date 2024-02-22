<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style> <?php include './assets/css/footer.css'; ?> </style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

<!-- Owl Stylesheets -->
<link rel="stylesheet" href="./assets/js/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css" />
<link rel="stylesheet" href="./assets/js/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css">


<!-- javascript -->
<script src="./assets/js/OwlCarousel2-2.3.4/dist/owl.carousel.min.js"></script>

<div class="owl-carousel">
    <div class="sponsoren-carousel">
        <a href='' target='blank'>
            <img src='./assets/images/logos-sjponsoren/aad_20leeuwe.jpg'>
        </a>
    </div>
    <div class="sponsoren-carousel">
        <a href='' target='blank'>
            <img src='./assets/images/logos-sjponsoren/Baker%20Bart%20kazerneplein.jpg'>
        </a>
    </div>
    <div class="sponsoren-carousel">
        <a href='' target='blank'>
            <img src='./assets/images/logos-sjponsoren/bartjanssenassurantien.png'>
        </a>
    </div>
    <div class="sponsoren-carousel">
        <a href='' target='blank'>
            <img src='./assets/images/logos-sjponsoren/botex%20wasserij%20logo.jpg'>
        </a>
    </div>
    <div class="sponsoren-carousel">
        <a href='' target='blank'>
            <img src='./assets/images/logos-sjponsoren/Dierx%20Groep.jpg'>
        </a>
    </div>
    <div class="sponsoren-carousel">
        <a href='' target='blank'>
            <img src='./assets/images/logos-sjponsoren/domiveranda.png'>
        </a>
    </div>
    <div class="sponsoren-carousel">
        <a href='' target='blank'>
            <img src='./assets/images/logos-sjponsoren/hetfinancieeladvieshuis.png'>
        </a>
    </div>
    <div class="sponsoren-carousel">
        <a href='' target='blank'>
            <img src='./assets/images/logos-sjponsoren/Hotel-en-Grand-Cafe-De-Pauw.png'>
        </a>
    </div>
    <div class="sponsoren-carousel">
        <a href='' target='blank'>
            <img src='./assets/images/logos-sjponsoren/janwuts.jpeg'>
        </a>
    </div>
    <div class="sponsoren-carousel">
        <a href='' target='blank'>
            <img src='./assets/images/logos-sjponsoren/meneerkes.jpg'>
        </a>
    </div>
    <div class="sponsoren-carousel">
        <a href='' target='blank'>
            <img src='./assets/images/logos-sjponsoren/mts.gif'>
        </a>
    </div>
    <div class="sponsoren-carousel">
        <a href='' target='blank'>
            <img src='./assets/images/logos-sjponsoren/sif.jpeg'>
        </a>
    </div>
    <div class="sponsoren-carousel">
        <a href='' target='blank'>
            <img src='./assets/images/logos-sjponsoren/van%20Tuyl%20beheer.jpg'>
        </a>
    </div>
</div>

<footer>
    <div class="footer">
        <div class="row">
            <a href="https://www.facebook.com/vvdetuinhagedisse" target=”_blank”><i class="fa fa-facebook"></i></a>
            <a href="https://www.instagram.com/vvdetuinhagedisse/" target=”_blank”><i class="fa fa-instagram"></i></a>
        </div>

        <div class="row">
            &copy; <?php echo date("Y"); ?> V.V. de Tuinhagedisse
        </div>
    </div>
</footer>

<script>
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
</script>