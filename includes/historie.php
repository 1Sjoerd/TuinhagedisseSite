<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historie</title>
    <link rel="stylesheet" href="./assets/css/standardblock.css">
    <link rel="stylesheet" href="./assets/css/kontak.css">
    <link rel="stylesheet" href="./assets/css/historicCards.css">
    <link rel="stylesheet" href="./assets/css/historieBtn.css">
    <script>
        window.addEventListener('beforeunload', () => {
            localStorage.setItem('scrollPosition', window.scrollY);
        });

        window.addEventListener('load', () => {
            const scrollPosition = localStorage.getItem('scrollPosition');
            if (scrollPosition) {
                window.scrollTo(0, parseInt(scrollPosition, 10));
                localStorage.removeItem('scrollPosition');
            }
        });
    </script>
</head>
<body>
    <div class="block-overview">
        <div class="heading-title">
            <h2 class="block-title">Historie</h2>
        </div>

        <div class="block-hp">
            <div class="historie-section">
                <form id="sliderForm" method="get" action="">
                    <div id="inputContainer">
                        <div class="segmentedControl">
                            <span class="segmentedControl--group">
                                <input 
                                    type="radio" 
                                    name="album" 
                                    id="album--16x9" 
                                    value="veurgengers" 
                                    <?php echo (!isset($_GET['album']) || $_GET['album'] === 'veurgengers') ? 'checked' : ''; ?> 
                                    onchange="document.getElementById('sliderForm').submit();" 
                                />
                                <label class="label-input" for="album--16x9">VEURGENGERS</label>
                            </span>
                            <span class="segmentedControl--group">
                                <input 
                                    type="radio" 
                                    name="album" 
                                    id="album--1x1" 
                                    value="jeug" 
                                    <?php echo (isset($_GET['album']) && $_GET['album'] === 'jeug') ? 'checked' : ''; ?> 
                                    onchange="document.getElementById('sliderForm').submit();" 
                                />
                                <label class="label-input" for="album--1x1">JEUG</label>
                            </span>
                        </div>
                    </div>
                </form>

                <div id="carousel-container">
                    <?php
                    if (isset($_GET['album']) && $_GET['album'] === 'jeug') {
                        include './includes/jeugSlider.php';
                    } else {
                        include './includes/veurgengerSlider.php';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
