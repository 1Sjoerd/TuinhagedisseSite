<style> <?php include './assets/css/standardblock.css'; ?> </style>
<style> <?php include './assets/css/albums.css'; ?> </style>

<div class="block-overview">
    <div class="heading-title">
        <h2 class="block-title"> Albums </h2>
    </div>
    <div class="block-text">
        <div id="album-list"></div>
        <div id="loading-spinner" class="hidden">
            <div class="spinner">
        </div>
    </div>
    </div>
</div>

<script>
    const pageId = '848282781947419';
    const accessToken = 'EAAMuxlWpSN8BO4Jq8LwWbE5nd2SDQelAvc2Gd3gX8Qkf4cPUKmFVnw0wGHtDmZBhO8EuJR5N7G84BeZCCIaDnLZAyv3lvuGQ36tZAU8G2UrGkR0caZCc8OYvEkuvOqOX3WjqPh3wj7O4l0VJf8YQxOGQlZCZADSGcAcpqsPa7dV82pfnUOOwSsLHlj2NUboGcZAW';

    let endDate = new Date();
    const stepInYears = 2;
    const spinner = document.getElementById('loading-spinner');
    const albumList = document.getElementById('album-list');
    let moreButton; // Declare the "Bekiek meer" button globally

    // Toon de spinner, verberg de knop, en voeg padding toe
    function showSpinner() {
        spinner.style.display = 'block';
        if (moreButton) {
            moreButton.style.display = 'none'; // Hide the "Bekiek meer" button
        }
        albumList.style.setProperty('padding-bottom', '80px', 'important');
    }

    // Verberg de spinner, toon de knop, en verwijder padding
    function hideSpinner() {
        spinner.style.display = 'none';
        if (moreButton) {
            moreButton.style.display = 'inline-block'; // Show the "Bekiek meer" button
        }
        albumList.style.setProperty('padding-bottom', '0px', 'important'); // Remove the padding instantly
    }

    // Functie om albums te laden voor een specifiek tijdsbereik
    async function fetchAlbumsForPeriod(startDate, endDate) {
        let allAlbums = [];
        let url = `https://graph.facebook.com/v11.0/${pageId}/albums?fields=id,name,cover_photo,created_time,link&access_token=${accessToken}`;

        try {
            // Toon de spinner voor we beginnen met laden
            showSpinner();

            let nextPageUrl = url;

            while (nextPageUrl) {
                const response = await fetch(nextPageUrl);
                const data = await response.json();

                // Filter albums op basis van het opgegeven tijdsbereik
                const periodAlbums = data.data.filter(album => {
                    const createdTime = new Date(album.created_time);
                    return createdTime >= startDate && createdTime < endDate;
                });

                allAlbums = allAlbums.concat(periodAlbums);

                // Update de URL voor de volgende pagina (of stop als er geen volgende pagina is)
                nextPageUrl = data.paging ? data.paging.next : null;
            }

            // Sorteer albums aflopend op basis van `created_time`
            allAlbums.sort((a, b) => new Date(b.created_time) - new Date(a.created_time));

            // Haal de coverfoto's van alle albums tegelijk op
            const coverPhotoIds = allAlbums.map(album => album.cover_photo && album.cover_photo.id);
            const coverPhotos = await fetchCoverPhotosInBulk(coverPhotoIds);

            // Voeg albums toe aan de UI
            allAlbums.forEach((album, index) => {
                const albumItem = document.createElement('div');
                albumItem.className = 'album-post';

                const coverPhotoUrl = coverPhotos[album.cover_photo.id] || '';

                let albumLink = album.link || '#';

                const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

                const albumIdMatch = album.link.match(/album\.php\?fbid=(\d+)/);
                const albumId = albumIdMatch ? albumIdMatch[1] : null;

                if (isMobile && albumId) {
                    albumLink = `fb://profile?id=${albumId}`;
                }

                albumItem.innerHTML = `
                    <div class="cover-img">
                        <img href="#photo-album" src="${coverPhotoUrl}" alt="${album.name}">
                    </div>
                    <div class="album-content">
                        <h3 class="album-title">
                            <a href="${albumLink}" target="_blank">${album.name}</a>
                        </h3>
                    </div>
                `;

                albumList.appendChild(albumItem);
            });

            hideSpinner(); // Verberg de spinner nadat de albums zijn geladen
        } catch (error) {
            console.error('Error fetching albums:', error);
            hideSpinner();
        }
    }

    // Haal alle coverfoto's op in bulk
    async function fetchCoverPhotosInBulk(coverPhotoIds) {
        const coverPhotoUrls = {};

        // Als er geen coverfoto's zijn, retourneer een leeg object
        if (coverPhotoIds.length === 0) return coverPhotoUrls;

        const url = `https://graph.facebook.com/v11.0?ids=${coverPhotoIds.join(',')}&fields=source&access_token=${accessToken}`;
        const response = await fetch(url);
        const data = await response.json();

        // Sla de URLs van coverfoto's op
        for (let id in data) {
            if (data[id].source) {
                coverPhotoUrls[id] = data[id].source;
            }
        }

        return coverPhotoUrls;
    }

    // Functie om albums te laden voor oudere periodes
    async function loadMoreAlbums() {
        showSpinner(); // Toon de spinner wanneer de "Bekiek meer" knop wordt ingedrukt

        const startDate = new Date(endDate); // Begin bij de huidige `endDate`
        startDate.setFullYear(endDate.getFullYear() - stepInYears); // Bereken de nieuwe startdatum
        await fetchAlbumsForPeriod(startDate, endDate); // Haal albums op voor deze periode
        endDate = startDate; // Update de globale `endDate` naar het begin van deze periode
    }

    // Initialiseer de pagina en laad de eerste albums
    document.addEventListener('DOMContentLoaded', async () => {
        // Bereken de beginperiode (laatste 2 jaar)
        const startDate = new Date();
        startDate.setFullYear(endDate.getFullYear() - stepInYears);

        // Laad albums van de eerste periode
        await fetchAlbumsForPeriod(startDate, endDate);

        // Update de globale `endDate` naar de huidige `startDate`
        endDate = startDate;

        // Voeg de "Meer Laden"-knop toe
        moreButton = document.createElement('a'); // Gebruik een <a>-element
        moreButton.className = 'read-more'; // Voeg de gewenste class toe
        moreButton.textContent = 'Bekiek meer'; // Gebruik dezelfde tekst
        moreButton.onclick = (event) => {
            event.preventDefault(); // Zorg dat de knop niet standaard linkgedrag vertoont
            loadMoreAlbums(); // Roep de functie aan om meer albums te laden
        };
        albumList.parentNode.appendChild(moreButton); // Plaats de knop direct na album-list
    });
</script>

