<style> <?php include './assets/css/standardblock.css'; ?> </style>
<style> <?php include './assets/css/albums.css'; ?> </style>

<div class="block-overview">
    <div class="heading-title">
        <h2 class="block-title"> Albums </h2>
    </div>
    <div class="block-text">
        <div id="album-list"></div>
        <div id="photo-album container"></div>
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
        albumList.innerHTML = ""; // Clear the album list before appending new items

        // Doorloop alle albums en haal voor elk album de coverfoto op
        for (const album of data.data) {
            // Maak een div voor elk album met de class "album-post"
            const albumItem = document.createElement('div');
            albumItem.className = 'album-post'; // Voeg de class "album-post" toe

            // Haal de coverfoto op als het album een cover_photo heeft
            let coverPhotoUrl = '';
            if (album.cover_photo) {
                const coverPhotoResponse = await fetch(`https://graph.facebook.com/v11.0/${album.cover_photo.id}?fields=source&access_token=${accessToken}`);
                const coverPhotoData = await coverPhotoResponse.json();
                coverPhotoUrl = coverPhotoData.source;
            }

            // Voeg de coverfoto en de naam van het album toe
            albumItem.innerHTML = `
                <div class="cover-img">
                    <img src="${coverPhotoUrl}" alt="${album.name}">
                </div>
                <div class="album-content">
                    <h3 class="album-title">
                        <a onclick="fetchPhotos('${album.id}')">${album.name}</a>
                    </h3>
                </div>
            `;

            albumList.appendChild(albumItem);
        }
        } catch (error) {
            console.error('Error fetching albums:', error);
        }
    }


    // Stap 2: Haal alle foto's op van een specifiek album
    async function fetchAllPhotos(albumId) {
        let allPhotos = [];
        let url = `https://graph.facebook.com/v11.0/${albumId}/photos?fields=source,name&access_token=${accessToken}`;

        while (url) {
            try {
                const response = await fetch(url);
                const data = await response.json();

                // Voeg de huidige set foto's toe aan de lijst met alle foto's
                allPhotos = allPhotos.concat(data.data);

                // Update de URL met de volgende pagineringslink, of maak het null als er geen meer is
                url = data.paging ? data.paging.next : null;
            } catch (error) {
                console.error('Error fetching photos:', error);
                break;
            }
        }
        return allPhotos;
    }

    // Stap 3: Haal en toon foto's van het geselecteerde album
    async function fetchPhotos(albumId) {
        const photoAlbum = document.getElementById('photo-album');

        try {
            // Haal alle foto's op uit het album
            const photos = await fetchAllPhotos(albumId);

            // Toon de foto's in de HTML
            photos.forEach(photo => {
                const img = document.createElement('img');
                img.src = photo.source;
                img.alt = photo.name || "Facebook Photo";
                img.style.width = '150px'; // Pas de grootte aan naar wens
                img.style.margin = '5px';
                photoAlbum.appendChild(img);
            });
        } catch (error) {
            console.error('Error fetching photos:', error);
        }
    }

    // Laad de albums zodra de pagina wordt geladen
    fetchAlbums();
</script>