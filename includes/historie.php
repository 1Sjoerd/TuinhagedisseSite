<style> <?php include './assets/css/standardblock.css'; ?> </style>
<style> <?php include './assets/css/kontak.css'; ?> </style>
<style> <?php include './assets/css/historicCards.css'; ?> </style>

<div class="block-overview">
    <div class="heading-title">
        <h2 class="block-title"> Historie </h2>
    </div>

    <div class="block-hp">
        <div class="hcard-container">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide swiper-slide-active">
                        <div class="card">
                            <img src="./assets/images/prinsen/rick.jpg" alt="">
                            <div class="info">
                                <h4 class="name">Rick</h4>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide swiper-slide-active">
                        <div class="card">
                            <img src="./assets/images/prinsen/rick.jpg" alt="">
                            <div class="info">
                                <h4 class="name">Rick</h4>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide swiper-slide-active">
                        <div class="card">
                            <img src="./assets/images/prinsen/rick.jpg" alt="">
                            <div class="info">
                                <h4 class="name">Rick</h4>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide swiper-slide-active">
                        <div class="card">
                            <img src="./assets/images/prinsen/rick.jpg" alt="">
                            <div class="info">
                                <h4 class="name">Rick</h4>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide swiper-slide-active">
                        <div class="card">
                            <img src="./assets/images/prinsen/rick.jpg" alt="">
                            <div class="info">
                                <h4 class="name">Rick</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".swiper", {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        loop: true,
        autoplay: {
            delay: 3000,
        },
        coverflowEffect: {
            rotate: 0,             // No rotation for slides
            stretch: -50,          // Controls spacing between slides
            depth: 150,            // Adjust depth for a more noticeable 3D effect
            modifier: 2,           // Increases the scale of the center slide
            slideShadows: true,    // Add shadows for better visual effect
        },
        spaceBetween: -40,          // Avoid additional space between slides
        preloadImages: false, // Do not preload all images
        lazy: true,           // Enable lazy loading
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            1024: {
                coverflowEffect: {
                    stretch: -80,   // Slightly adjust stretch for larger screens
                    depth: 300,     // Add more depth for larger screens
                    modifier: 2.5,  // Make the center slide more prominent
                },
            },
        },
    });
</script>

