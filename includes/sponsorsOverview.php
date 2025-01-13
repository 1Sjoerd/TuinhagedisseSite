<style> <?php include './assets/css/standardblock.css'; ?> </style>
<style> <?php include './assets/css/sponsors.css'; ?> </style>

<div class="block-overview">
    <div class="heading-title">
        <h2 class="block-title"> Sjponsore </h2>
    </div>
    <div class="sponsors-body">
        <div class="block-text">
            Dees sjponsore zeen de drievende krach achter os vereiniging! Dankzij häör gulle biedrage bleuje ozze aktiviteiten en greujt ozze gemeinsjap.  Veer wille ug bedanke veur de ongersjteuning.
        </div>

        <div class="logo-container">
            <ul class="logo-gallery">
                
                <?php
                    // Haal records op voor de huidige pagina
                    $sponsorcarouselItems = $conn->query("SELECT s.name, s.image_url, s.url FROM sponsors s INNER JOIN sponsorplan sp ON s.sponsorplan_id = sp.id WHERE sp.showlogo = 1 ORDER BY RAND();")->fetch_all(MYSQLI_ASSOC);
    
                    foreach ($sponsorcarouselItems as $sponsorcarouselItem):
                ?>
                <li>
                    <?php if ($sponsorcarouselItem['url'] != ""): ?>
                    <a href="<?php echo htmlspecialchars($sponsorcarouselItem['url']); ?>" target="_blank">
                    <?php endif ?>
                        <img src='<?php echo htmlspecialchars($sponsorcarouselItem['image_url']); ?>' alt="<?php echo htmlspecialchars($sponsorcarouselItem['name']); ?>">
                    <?php if ($sponsorcarouselItem['image_url'] != ""): ?>
                    </a>
                    <?php endif ?>
                </li>
                    <?php endforeach; ?>
            </ul>
        </div>
        <div class="other-sponsors">
            <div class="block-text">
                <a href="https://ok-rijmar.nl/" target="_blank">Rijmar</a><br>
                <a href="https://subnetriooltechniek.nl/" target="_blank">Subnet</a><br>
                <a href="http://gifeco.nl/" target="_blank">Gifeco Training & Advies</a><br>
                Logistic Services Personeelsdiensten bv<br>
            </div>
        </div>
    </div>
</div>