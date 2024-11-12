<style> <?php include './assets/css/standardblock.css'; ?> </style>
<style> <?php include './assets/css/albums.css'; ?> </style>

<div class="block-overview">
    <div class="heading-title">
        <h2 class="block-title"> Albums </h2>
    </div>
    <div class="block-text">
        <div id="album-list"></div>
    </div>
    <div class="block-text">
        <div id="photo-album"></div>
    </div>
</div>

<script>
    const pageId = '848282781947419';
    const accessToken = 'EAAMuxlWpSN8BO4Jq8LwWbE5nd2SDQelAvc2Gd3gX8Qkf4cPUKmFVnw0wGHtDmZBhO8EuJR5N7G84BeZCCIaDnLZAyv3lvuGQ36tZAU8G2UrGkR0caZCc8OYvEkuvOqOX3WjqPh3wj7O4l0VJf8YQxOGQlZCZADSGcAcpqsPa7dV82pfnUOOwSsLHlj2NUboGcZAW';

// Stap 1: Haal de lijst met albums op
async function fetchAlbums() {
    try {
        const response = await fetch(`https://graph.facebook.com/v11.0/${pageId}/albums?fields=id,name,cover_photo&access_token=${accessToken}`);
        const data = await response.json();

        const albumList = document.getElementById('album-list');
        albumList.innerHTML = "";

        for (const album of data.data) {
            const albumItem = document.createElement('div');
            albumItem.className = 'album-post';

            let coverPhotoUrl = '';
            if (album.cover_photo) {
                const coverPhotoResponse = await fetch(`https://graph.facebook.com/v11.0/${album.cover_photo.id}?fields=source&access_token=${accessToken}`);
                const coverPhotoData = await coverPhotoResponse.json();
                coverPhotoUrl = coverPhotoData.source;
            }

            albumItem.innerHTML = `
                <div class="cover-img">
                    <img href="#photo-album" src="${coverPhotoUrl}" alt="${album.name}">
                </div>
                <div class="album-content">
                    <h3 class="album-title">
                        <a href="#photo-album" onclick="fetchPhotos('${album.id}')">${album.name}</a>
                    </h3>
                </div>
            `;

            albumList.appendChild(albumItem);
        }
    } catch (error) {
        console.error('Error fetching albums:', error);
        albumList.innerHTML = `<p>Fout bij het laden van albums. Probeer het later opnieuw.</p>`;
    }
}

// Stap 2: Haal alle foto's op van een specifiek album en start de slideshow
async function fetchAllPhotos(albumId) {
    let allPhotos = [];
    let url = `https://graph.facebook.com/v11.0/${albumId}/photos?fields=source,name&access_token=${accessToken}`;

    while (url) {
        try {
            const response = await fetch(url);
            const data = await response.json();
            allPhotos = allPhotos.concat(data.data);
            url = data.paging ? data.paging.next : null;
        } catch (error) {
            console.error('Error fetching photos:', error);
            break;
        }
    }
    return allPhotos;
}

// Stap 3: Haal en toon foto's van het geselecteerde album in een slideshow
async function fetchPhotos(albumId) {
    const photoAlbum = document.getElementById('photo-album');
    photoAlbum.innerHTML = ""; // Leeg de container

    try {
        const photos = await fetchAllPhotos(albumId);

        // Voor elke foto maken we een slide aan
        photos.forEach((photo, index) => {
            const slide = document.createElement('div');
            slide.className = 'mySlides';
            slide.style.display = index === 0 ? 'block' : 'none'; // Alleen de eerste foto is zichtbaar

            const img = document.createElement('img');
            img.src = photo.source;
            img.alt = photo.name || "Facebook Photo";
            img.style.width = '100%';

            slide.appendChild(img);
            photoAlbum.appendChild(slide);
        });

        // Voeg navigatieknoppen toe voor de slideshow
        photoAlbum.innerHTML += `
            <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
            <a class="next" onclick="changeSlide(1)">&#10095;</a>
        `;

        currentSlideIndex = 0;
    } catch (error) {
        console.error('Error fetching photos:', error);
    }
}

// Slideshow-functionaliteit
let currentSlideIndex = 0;

function changeSlide(n) {
    const slides = document.getElementsByClassName("mySlides");
    slides[currentSlideIndex].style.display = "none"; // Verberg huidige slide
    currentSlideIndex = (currentSlideIndex + n + slides.length) % slides.length; // Update index
    slides[currentSlideIndex].style.display = "block"; // Toon volgende slide
}

// Laad de albums zodra de pagina wordt geladen
fetchAlbums();

</script>