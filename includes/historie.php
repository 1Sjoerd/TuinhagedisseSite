<style>
    <?php include './assets/css/standardblock.css'; ?>
</style>
<style>
    <?php include './assets/css/kontak.css'; ?>
</style>
<style>
    <?php include './assets/css/historicCards.css'; ?>
</style>

<head>
    <link rel="stylesheet" href="./assets/css/historieBtn.css">
</head>

<div class="block-overview">
    <div class="heading-title">
        <h2 class="block-title"> Historie </h2>
    </div>

    <div class="block-hp">

        <div class="historie-section">

            <div id="inputContainer">
                <div class="segmentedControl">
                    <span class="segmentedControl--group">
                        <input type="radio" name="aspectRatio" id="aspectRatio--16x9" checked />
                        <label class="label-input" for="aspectRatio--16x9">VEURGENGERS</label>
                    </span>
                    <span class="segmentedControl--group">
                        <input type="radio" name="aspectRatio" id="aspectRatio--1x1" />
                        <label class="label-input" for="aspectRatio--1x1">JEUG</label>
                    </span>
                </div>
            </div>

            <div id="carousel-container">
                <!-- Initially load veurgengerSlider.php -->
                <?php include './includes/veurgengerSlider.php'; ?>
            </div>

        </div>
    </div>
</div>

<!-- jQuery Include -->
<script src="./jquery/jquery3.2.1.js"></script>

<script>
    $(document).ready(function () {
        $('input[name="aspectRatio"]').on('change', function () {
            let selectedId = $(this).attr('id');
            let contentUrl = '';

            if (selectedId === 'aspectRatio--16x9') {
                contentUrl = 'includes/veurgengerSlider.php';
            } else if (selectedId === 'aspectRatio--1x1') {
                contentUrl = 'includes/jeugSlider.php';
            }

            // Add loading state
            $('#carousel-container').addClass('loading');

            // Load the selected content dynamically
            $('#carousel-container').load(contentUrl, function (response, status, xhr) {
                if (status === "error") {
                    console.error(`Error loading content: ${xhr.status} ${xhr.statusText}`);
                    $('#carousel-container').html('<div class="error">Error loading content. Please try again.</div>');
                } else {
                    console.log(`Content loaded successfully from: ${contentUrl}`);
                    // Initialize the carousel after content is loaded
                    new OptimizedCarousel();
                }
                // Remove loading state
                $('#carousel-container').removeClass('loading');
            });
        });
    });
</script>
