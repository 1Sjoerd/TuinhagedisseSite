<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style> <?php include './assets/css/footer.css'; ?> </style>



<!-- Owl Stylesheets -->
<link rel="stylesheet" href="./assets/js/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css" />


<!-- javascript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="./assets/js/OwlCarousel2-2.3.4/dist/owl.carousel.min.js"></script>

<div id="sponsoren-carousel" class="owl-carousel sponsoren-carousel">
    <?php
        // Haal records op voor de huidige pagina
        $sponsorcarouselItems = $conn->query("SELECT s.name, s.image_url, s.url FROM sponsors s INNER JOIN sponsorplan sp ON s.sponsorplan_id = sp.id WHERE sp.showlogo = 1 ORDER BY RAND();")->fetch_all(MYSQLI_ASSOC);

        foreach ($sponsorcarouselItems as $sponsorcarouselItem):
    ?>
        <div class="item">
            <?php if ($sponsorcarouselItem['url'] != ""): ?><a href="<?php echo htmlspecialchars($sponsorcarouselItem['url']); ?>" target="_blank"><?php endif ?>
                <img src='<?php echo htmlspecialchars($sponsorcarouselItem['image_url']); ?>' alt="<?php echo htmlspecialchars($sponsorcarouselItem['name']); ?>">
            <?php if ($sponsorcarouselItem['image_url'] != ""): ?></a><?php endif ?></div>
    <?php endforeach; ?>
</div>


<footer>
    <div class="footer">
        <div class="footerrow">
            <a href="https://www.facebook.com/vvdetuinhagedisse" target="_blank"><i class="fa fa-facebook"></i></a>
            <a href="https://www.instagram.com/vvdetuinhagedisse/" target="_blank"><i class="fa fa-instagram"></i></a>
        </div>

        <div class="footerrow">
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
            dots:false,
            nav:false,
            navText: ["<a class='buttonprev'>","<a class='buttonnext'></a>"],
            responsiveClass:true,
            responsive:{
                0:{
                    items:1
                },
                620:{
                    items:2
                },
                1200:{
                    items:3
                }
            }
        });

        $("#banner-carousel .item").sort(function () {
            return Math.random() - 0.5;
        }).appendTo("#banner-carousel");

        $("#banner-carousel").owlCarousel({
            autoplay: true,
            center: false,
            loop: true,
            dots: false,
            nav: false,
            navText: [
                "<a class='buttonprev'>&lt;</a>",
                "<a class='buttonnext'>&gt;</a>"
            ],
            responsiveClass: true,
            items: 1,
            animateOut: 'fadeOut',
            autoplayTimeout: 5000,
        });

        $("#sponsoren-carousel .item").sort(function () {
            return Math.random() - 0.5;
        }).appendTo("#sponsoren-carousel");

        $("#sponsoren-carousel").owlCarousel({
            autoplay: true,
            autoplayHoverPause: true,
            loop: true,
            margin: 50,
            dots: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    autoplayTimeout: 4000
                },
                600: {
                    items: 3,
                    autoplayTimeout: 2500
                },
                1000: {
                    items: 4,
                    autoplayTimeout: 2500
                },
                1350: {
                    items: 5,
                    autoplayTimeout: 2500
                },
                1550: {
                    items: 6,
                    autoplayTimeout: 2500
                }
            }
        });
    });
</script>
