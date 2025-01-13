<?php
require_once __DIR__ . '/../templates/dbconnection.php';
?>
<style> <?php include './assets/css/historicCards.css'; ?> </style>

<div class="hcard-container">
    <?php
    $sql = "SELECT * FROM `prinse` ORDER BY `year` DESC";
    $result = $conn->query($sql);
    $all_items = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $all_items[] = $row;
        }
    }
    // Convert PHP array to JSON for JavaScript
    $items_json = json_encode($all_items);
    ?>
    <div class="carousel-container">
        <div class="carousel" data-total-items="<?php echo count($all_items); ?>">
            <?php
            // Initially render only 11 items, centered around the first item
            $initial_count = min(11, count($all_items));
            $initial_items = array_slice($all_items, 0, $initial_count);
            foreach ($initial_items as $index => $row) {
                echo "<div class='carousel-item' data-index='{$index}'>";
                $image_url = !empty($row['image_url']) ? $row['image_url'] : './assets/images/prinsen/onbekend.jpg';
                echo "<img class='item-image' src='".$image_url."' alt='Prins ".$row["firstname"]." ".$row["number"]."' />";
                echo "<div class='overlay-text'>".$row["firstname"]." ".$row["number"]."</div>";
                echo "<div class='item-text'>".$row["motto"]."</div>";
                echo "</div>";
            }
            ?>
        </div>
        <button class="button-next" id="prevBtn">❮</button>
        <button class="button-next" id="nextBtn">❯</button>
    </div>
</div>

<script>
    class OptimizedCarousel {
        constructor() {
            this.carousel = document.querySelector('.carousel');
            this.totalItems = parseInt(this.carousel.dataset.totalItems);
            this.currentIndex = 0;
            this.visibleRange = 5; // Number of items on each side
            this.itemSpacing = window.innerWidth <= 500 ? 250 : 160;
            this.scaleStep = 0.10;
            this.rotationStep = -15;
            // Store all items data
            this.allItemsData = <?php echo $items_json; ?>;
            
            this.initializeCarousel();
            this.bindEvents();
        }

        initializeCarousel() {
            // Clear existing items
            this.carousel.innerHTML = '';
            
            // Load initial items (centered around currentIndex)
            for (let i = -this.visibleRange; i <= this.visibleRange; i++) {
                const index = (this.currentIndex + i + this.totalItems) % this.totalItems;
                if (index >= 0 && index < this.totalItems) {
                    this.addItem(index);
                }
            }
            
            this.updateCarousel();
        }

        bindEvents() {
            window.addEventListener('resize', () => this.updateItemSpacing());
            document.getElementById('nextBtn').addEventListener('click', () => this.moveCarousel(1));
            document.getElementById('prevBtn').addEventListener('click', () => this.moveCarousel(-1));
            this.setupTouchEvents();
        }

        updateItemSpacing() {
            this.itemSpacing = window.innerWidth <= 500 ? 250 : 160;
            this.updateCarousel();
        }

        moveCarousel(direction) {
            this.currentIndex = (this.currentIndex + direction + this.totalItems) % this.totalItems;
            this.updateVisibleItems();
            this.updateCarousel();
        }

        updateVisibleItems() {
            const items = Array.from(document.querySelectorAll('.carousel-item'));
            const currentItems = new Set(items.map(item => parseInt(item.dataset.index)));
            
            // Calculate needed indices
            const neededIndices = new Set();
            for (let i = -this.visibleRange; i <= this.visibleRange; i++) {
                const index = (this.currentIndex + i + this.totalItems) % this.totalItems;
                if (index >= 0 && index < this.totalItems) {
                    neededIndices.add(index);
                }
            }

            // Remove items that are no longer needed
            items.forEach(item => {
                const itemIndex = parseInt(item.dataset.index);
                if (!neededIndices.has(itemIndex)) {
                    item.remove();
                }
            });

            // Add new items that are needed
            neededIndices.forEach(index => {
                if (!currentItems.has(index)) {
                    this.addItem(index);
                }
            });
        }

        addItem(index) {
            const itemData = this.allItemsData[index];
            if (!itemData) return;

            const item = document.createElement('div');
            item.className = 'carousel-item';
            item.dataset.index = index;
            
            const imageUrl = itemData.image_url || './assets/images/prinsen/onbekend.jpg';
            item.innerHTML = `
                <img class='item-image' src='${imageUrl}' alt='Prins ${itemData.firstname} ${itemData.number}' />
                <div class='overlay-text'>${itemData.firstname} ${itemData.number}</div>
                <div class='item-text'>${itemData.motto}</div>
            `;
            
            this.carousel.appendChild(item);
        }

        updateCarousel() {
            const items = document.querySelectorAll('.carousel-item');
            items.forEach(item => {
                const itemIndex = parseInt(item.dataset.index);
                let distance = (itemIndex - this.currentIndex + this.totalItems) % this.totalItems;
                // Adjust distance calculation to handle wraparound correctly
                if (distance > this.totalItems / 2) {
                    distance -= this.totalItems;
                }
                
                if (Math.abs(distance) > this.visibleRange) {
                    item.style.display = 'none';
                    return;
                }
                
                item.style.display = 'block';
                let translateX, scale, rotateY, zIndex;
                let darkenValue;

                if (distance === 0) {
                    translateX = 0;
                    scale = 1;
                    rotateY = 0;
                    zIndex = this.totalItems;
                    darkenValue = 0;
                    this.showOverlay(item, true);
                } else {
                    translateX = this.itemSpacing * distance;
                    scale = 1 - this.scaleStep * Math.abs(distance);
                    rotateY = distance > 0 ? -this.rotationStep : this.rotationStep;
                    zIndex = this.totalItems - Math.abs(distance);
                    darkenValue = 0.1 * Math.abs(distance);
                    this.showOverlay(item, false);
                }

                item.style.transform = `translateX(${translateX}px) scale(${scale}) rotateY(${rotateY}deg)`;
                item.style.zIndex = zIndex;

                const image = item.querySelector('.item-image');
                if (image) {
                    image.style.filter = `brightness(${1 - darkenValue})`;
                }
            });
        }

        showOverlay(item, show) {
            const overlay = item.querySelector('.overlay-text');
            const itemText = item.querySelector('.item-text');
            
            if (overlay) {
                overlay.style.opacity = show ? '1' : '0';
                overlay.style.display = show ? 'block' : 'none';
            }
            
            if (itemText) {
                itemText.style.opacity = show ? '1' : '0';
                itemText.style.display = show ? 'block' : 'none';
            }
        }

        setupTouchEvents() {
            let startX = 0;
            let isDragging = false;

            const handleSwipe = (moveX) => {
                const diffX = moveX - startX;
                if (Math.abs(diffX) > 50) {
                    this.moveCarousel(diffX < 0 ? 1 : -1);
                    startX = moveX;
                    isDragging = false;
                }
            };

            this.carousel.addEventListener('touchstart', (event) => {
                startX = event.touches[0].clientX;
                isDragging = true;
            });

            this.carousel.addEventListener('mousedown', (event) => {
                startX = event.clientX;
                isDragging = true;
            });

            this.carousel.addEventListener('touchmove', (event) => {
                if (!isDragging) return;
                handleSwipe(event.touches[0].clientX);
            });

            this.carousel.addEventListener('mousemove', (event) => {
                if (!isDragging) return;
                handleSwipe(event.clientX);
            });

            this.carousel.addEventListener('touchend', () => isDragging = false);
            this.carousel.addEventListener('mouseup', () => isDragging = false);
            this.carousel.addEventListener('mouseleave', () => isDragging = false);
        }
    }

    // Initialize the carousel
    document.addEventListener('DOMContentLoaded', () => {
        new OptimizedCarousel();
    });
</script>