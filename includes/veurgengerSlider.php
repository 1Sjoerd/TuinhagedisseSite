
<style> <?php include './assets/css/historicCards.css'; ?> </style>

<div class="hcard-container">
    <div class="carousel-container">
        <div class="carousel">
            <div class="carousel-item">
                <img class="item-image lazy-image" src="./assets/images/prinsen/rick.jpg" alt="Prins Rick I" loading="lazy" />
                <div class="overlay-text">Rick I</div>
                <div class="item-text">"Vastelaovend raak biej os de gooje toon!"</div>
            </div>
            <div class="carousel-item">
                <img class="item-image lazy-image" src="./assets/images/prinsen/rick.jpg" alt="Prins Rick I" loading="lazy" />
                <div class="overlay-text">Rick I</div>
                <div class="item-text">"Vastelaovend raak biej os de gooje toon!"</div>
            </div>
            <div class="carousel-item">
                <img class="item-image lazy-image" src="./assets/images/prinsen/rick.jpg" alt="Prins Rick I" loading="lazy" />
                <div class="overlay-text">Rick I</div>
                <div class="item-text">"Vastelaovend raak biej os de gooje toon!"</div>
            </div>
            <div class="carousel-item">
                <img class="item-image lazy-image" src="./assets/images/prinsen/rick.jpg" alt="Prins Rick I" loading="lazy" />
                <div class="overlay-text">Rick I</div>
                <div class="item-text">"Vastelaovend raak biej os de gooje toon!"</div>
            </div>
            <div class="carousel-item">
                <img class="item-image lazy-image" src="./assets/images/prinsen/rick.jpg" alt="Prins Rick I" loading="lazy" />
                <div class="overlay-text">Rick I</div>
                <div class="item-text">"Vastelaovend raak biej os de gooje toon!"</div>
            </div>
            <div class="carousel-item">
                <img class="item-image lazy-image" src="./assets/images/prinsen/rick.jpg" alt="Prins Rick I" loading="lazy" />
                <div class="overlay-text">Rick I</div>
                <div class="item-text">"Vastelaovend raak biej os de gooje toon!"</div>
            </div>
            <div class="carousel-item">
                <img class="item-image lazy-image" src="./assets/images/prinsen/rick.jpg" alt="Prins Rick I" loading="lazy" />
                <div class="overlay-text">Rick I</div>
                <div class="item-text">"Vastelaovend raak biej os de gooje toon!"</div>
            </div>
        </div>
        <button class="button-next" id="prevBtn"> ❮ </button>
        <button class="button-next" id="nextBtn"> ❯ </button>
    </div>
</div>

<!-- Prinsen Cover Flow Script -->
<script>
    const carousel = document.querySelector('.carousel');
    const items = document.querySelectorAll('.carousel-item');
    const totalItems = items.length;
    let currentIndex = 0;
    let itemSpacing = 120;
    const scaleStep = 0.10;
    const rotationStep = -15;
    const opacityStep = 0.1;
    const preloadRange = 5;

    function preloadImages(index) {
        for (let i = -preloadRange; i <= preloadRange; i++) {
            const itemIndex = (index + i + totalItems) % totalItems;
            const img = items[itemIndex].querySelector('.lazy-image');
            if (img && img.dataset.src) {
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
            }
        }
    }

    function updateItemSpacing() {
        const isMobile = window.innerWidth <= 500;
        itemSpacing = isMobile ? 250 : 160;
        updateCarousel();
    }

    window.addEventListener('resize', updateItemSpacing);
    updateItemSpacing();

    function updateCarousel() {
        items.forEach((item, index) => {
            const distance = (index - currentIndex + totalItems) % totalItems;
            let translateX, scale, rotateY, zIndex;
            let darkenValue;

            if (distance === 0) {
                translateX = 0;
                scale = 1;
                rotateY = 0;
                zIndex = totalItems;
                darkenValue = 0;

                const overlayText = item.querySelector('.overlay-text');
                if (overlayText) {
                    overlayText.style.display = 'block';
                    overlayText.style.opacity = 0;
                    overlayText.style.transition = 'opacity 0.3s ease-in';
                    requestAnimationFrame(() => {
                        overlayText.style.opacity = 1;
                    });
                }
            } else if (distance <= totalItems / 2) {
                translateX = itemSpacing * distance;
                scale = 1 - scaleStep * distance;
                rotateY = -rotationStep;
                zIndex = totalItems - distance;
                darkenValue = 0.1 * distance;
            } else {
                translateX = -itemSpacing * (totalItems - distance);
                scale = 1 - scaleStep * (totalItems - distance);
                rotateY = rotationStep;
                zIndex = distance;
                darkenValue = 0.1 * (totalItems - distance);
            }

            item.style.transform = `translateX(${translateX}px) scale(${scale}) rotateY(${rotateY}deg)`;
            item.style.zIndex = zIndex;

            const image = item.querySelector('.item-image');
            if (image) {
                image.style.filter = `brightness(${1 - darkenValue})`;
            }

            const overlayText = item.querySelector('.overlay-text');
            if (overlayText) {
                if (distance === 0) {
                    overlayText.style.display = 'block';
                    overlayText.style.opacity = 0;
                    overlayText.style.transition = 'opacity 0.3s ease-in';
                    requestAnimationFrame(() => {
                        overlayText.style.opacity = 1;
                    });
                } else {
                    overlayText.style.opacity = 0;
                    overlayText.style.transition = 'opacity 0.3s ease-out';
                    setTimeout(() => {
                        overlayText.style.display = 'none';
                    }, 300);
                }
            }

            const itemText = item.querySelector('.item-text');
            if (itemText) {
                if (distance === 0) {
                    itemText.style.display = 'block';
                    itemText.style.opacity = 0;
                    itemText.style.transition = 'opacity 0.3s ease-in';
                    requestAnimationFrame(() => {
                        itemText.style.opacity = 1;
                    });
                } else {
                    itemText.style.opacity = 0;
                    itemText.style.transition = 'opacity 0.3s ease-out';
                    setTimeout(() => {
                        itemText.style.display = 'none';
                    }, 300);
                }
            }
        });

    preloadImages(currentIndex);
}

    document.getElementById('nextBtn').addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % totalItems;
        updateCarousel();
    });

    document.getElementById('prevBtn').addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + totalItems) % totalItems;
        updateCarousel();
    });

    updateCarousel();

    let startX = 0;
    let isDragging = false;

    function handleSwipe(moveX) {
        const diffX = moveX - startX;

        if (Math.abs(diffX) > 50) {
            if (diffX < 0) {
                currentIndex = (currentIndex + 1) % totalItems;
            } else {
                currentIndex = (currentIndex - 1 + totalItems) % totalItems;
            }
            updateCarousel();
            startX = moveX;
            isDragging = false;
        }
    }

    let startX = 0;
    let startY = 0;
    let isDragging = false;
    let isVerticalScroll = false;

    carousel.addEventListener('touchstart', (event) => {
        startX = event.touches[0].clientX;
        startY = event.touches[0].clientY;
        isDragging = true;
        isVerticalScroll = false;
    });

    carousel.addEventListener('mousedown', (event) => {
        startX = event.clientX;
        isDragging = true;
    });

    carousel.addEventListener('touchmove', (event) => {
        if (!isDragging) return;

        const moveX = event.touches[0].clientX;
        const moveY = event.touches[0].clientY;

        const diffX = Math.abs(moveX - startX);
        const diffY = Math.abs(moveY - startY);

        if (diffY > diffX) {
            // User is scrolling vertically
            isVerticalScroll = true;
            return; // Allow the default vertical scrolling behavior
        }

        // User is swiping horizontally
        event.preventDefault(); // Prevent vertical scrolling during horizontal swipe
        handleSwipe(moveX);
    });

    carousel.addEventListener('mousemove', (event) => {
        if (!isDragging) return;
        const moveX = event.clientX;
        handleSwipe(moveX);
    });

    carousel.addEventListener('touchend', () => {
        isDragging = false;
        isVerticalScroll = false;
    });

    carousel.addEventListener('mouseup', () => {
        isDragging = false;
    });

    carousel.addEventListener('mouseleave', () => {
        isDragging = false;
        isVerticalScroll = false;
    });
</script>