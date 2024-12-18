<style>
    <?php include './assets/css/standardblock.css'; ?>
</style>
<style>
    <?php include './assets/css/kontak.css'; ?>
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
        // Listen for radio button changes
        $('input[name="aspectRatio"]').on('change', function () {
            let selectedId = $(this).attr('id');
            let contentUrl = '';

            // Determine the URL to load based on the selected radio button
            if (selectedId === 'aspectRatio--16x9') {
                contentUrl = 'includes/veurgengerSlider.php';
            } else if (selectedId === 'aspectRatio--1x1') {
                contentUrl = 'includes/jeugSlider.php';
            }

            // Debugging: Log selected URL
            console.log(`Loading content from: ${contentUrl}`);

            // Load the selected content dynamically
            $('#carousel-container').load(contentUrl, function (response, status, xhr) {
                if (status === "error") {
                    console.error(`Error loading content: ${xhr.status} ${xhr.statusText}`);
                } else {
                    console.log(`Content loaded successfully from: ${contentUrl}`);
                }
            });
        });
    });
</script>
