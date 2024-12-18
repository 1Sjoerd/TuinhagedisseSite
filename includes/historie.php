<style> <?php include './assets/css/standardblock.css'; ?> </style>
<style> <?php include './assets/css/kontak.css'; ?> </style>
<style> <?php include './assets/css/historicCards.css'; ?> </style>

<head>
    <link href="./odido/CSS.css" rel="stylesheet"/>
</head>

<div class="block-overview">
    <div class="heading-title">
        <h2 class="block-title"> Historie </h2>
    </div>

    <div class="block-hp">

    <div class="historie-section">

            <div class="tablist is-inversed" role="tablist" data-tab>
                <ul class="mx-auto">
                    <li class="is-active">
                        <a href="#veurgengers" class="theme-link" role="tab" data-trigger-resize>VEURGENGERS</a>
                    </li>
                    <li class="">
                        <a href="#jeug" class="theme-link" role="tab" data-trigger-resize>JEUG</a>
                    </li>
                </ul>
            </div>

            <div id="carousel-container">
                <?php include './includes/veurgengerSlider.php'; ?>
            </div>

        </div>
    </div>
</div>

<!-- jquery Include-->
<script src="./jquery/jquery3.2.1.js"></script> 

<script>
    $(document).ready(function () {
        $('.theme-link').on('click', function (e) {

            // Get the href attribute to determine which tab was clicked
            const target = $(this).attr('href');

            // Update the active class on the tabs
            $('.theme-link').parent().removeClass('is-active');
            $(this).parent().addClass('is-active');

            // Replace content in #carousel-container based on the clicked tab
            if (target === '#veurgengers') {
                $('#carousel-container')
                    .fadeOut(500, function () {
                        $(this).load('tuinhagedissesite/includes/veurgengerSlider.php', function (response, status, xhr) {
                            if (status === "error") {
                                console.error("Error loading veurgengerSlider.php: ", xhr.status, xhr.statusText);
                            }
                            $(this).fadeIn(500); // Fade in after content loads
                        });
                    });
            } else if (target === '#jeug') {
                $('#carousel-container')
                    .fadeOut(500, function () {
                        $(this).load('tuinhagedissesite/includes/jeugSlider.php', function (response, status, xhr) {
                            if (status === "error") {
                                console.error("Error loading jeugSlider.php: ", xhr.status, xhr.statusText);
                            }
                            $(this).fadeIn(500); // Fade in after content loads
                        });
                    });
            }
        });
    });
</script>

