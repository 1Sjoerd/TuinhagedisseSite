<?php if ($hasManageUsersPermission): ?>
<a id="jeugdprinsen-overview"></a>
<div class="block-overview block-overview-permissions">
    <div class="heading-title">
        <h2 class="block-title">Beheer jeugprinse</h2>
    </div>
    <div class="block-text">
        <div class="wrapper">
            <div class="table">
                <div class="row header">
                    <div class="cell">Naam</div>
                    <div class="cell">Jaor</div>
                    <div class="cell">Acties</div>
                </div>
                <?php
                // Standaard naar pagina 1 als geen pagina is ingesteld
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $limit = 5; // Aantal items per pagina
                $offset = ($page - 1) * $limit;
                
                // Haal het totaal aantal records op
                $totalPrinsen = $conn->query("SELECT COUNT(*) as count FROM jeugdprinse")->fetch_assoc()['count'];
                $totalPages = ceil($totalPrinsen / $limit);
                
                // Haal records op voor de huidige pagina
                $jeugdprinsenItems = $conn->query("SELECT * FROM jeugdprinse ORDER BY year DESC LIMIT $limit OFFSET $offset")->fetch_all(MYSQLI_ASSOC);

                foreach ($jeugdprinsenItems as $jeugdprinsenItem):
                ?>
                    <div class="row">
                        <div class="cell" data-title="Naam"><?php echo htmlspecialchars($jeugdprinsenItem['firstname']); ?> <?php echo htmlspecialchars($jeugdprinsenItem['number']); ?> <?php echo htmlspecialchars($jeugdprinsenItem['lastname']); ?></div>
                        <div class="cell" data-title="jaor"><?php echo htmlspecialchars($jeugdprinsenItem['year']); ?></div>
                        <div class="cell" data-title="Acties">
                            <a href="#" class="edit-jeugdprins" data-id="<?php echo $jeugdprinsenItem['id']; ?>"><i class="fa-solid fa-pen-to-square"></i> Bewirk</a>
                            <a href="includes/dashboardIncludes/delete_jeugdprinsen.php?id=<?php echo $jeugdprinsenItem['id']; ?>"><i class="fa-solid fa-trash"></i> Verwijder</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>#jeugdprinsen-overview" class="pagination-link"><i class="fa-solid fa-chevron-left"></i></a>
            <?php endif; ?>
        
            <?php
            $range = 2; // Aantal pagina's aan beide kanten van de huidige pagina
            $start = max(1, $page - $range);
            $end = min($totalPages, $page + $range);
        
            if ($start > 1): ?>
                <a href="?page=1#jeugdprinsen-overview" class="pagination-link">1</a>
                <?php if ($start > 2): ?>
                    <span class="pagination-dots">...</span>
                <?php endif; ?>
            <?php endif; ?>
        
            <?php for ($i = $start; $i <= $end; $i++): ?>
                <a href="?page=<?php echo $i; ?>#jeugdprinsen-overview" class="pagination-link <?php if ($i == $page) echo 'active'; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        
            <?php if ($end < $totalPages): ?>
                <?php if ($end < $totalPages - 1): ?>
                    <span class="pagination-dots">..</span>
                <?php endif; ?>
                <a href="?page=<?php echo $totalPages; ?>#jeugdprinsen-overview" class="pagination-link"><?php echo $totalPages; ?></a>
            <?php endif; ?>
        
            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo $page + 1; ?>#jeugdprinsen-overview" class="pagination-link"><i class="fa-solid fa-chevron-right"></i></a>
            <?php endif; ?>
        </div>
        
        <button id="addJeugdPrinsButton" class="submit-button">Prins toevoege</button>
        <div id="jeugdprinsForm" style="display: none;">
            <form id="jeugdprinsFormElement" method="post" action="includes/dashboardIncludes/add_jeugdprins.php" enctype="multipart/form-data">
                <input type="hidden" id="jeugdprinsId" name="jeugdprinsId">
                <div class="form-row">
                    <div class="form-group">
                        <label for="jeugdprinsfirstname">Veurnaam:</label>
                        <input type="text" id="jeugdprinsfirstname" name="jeugdprinsfirstname" placeholder="Jan" required>
                    </div>
                    <div class="form-group">
                        <label for="jeugdprinslastname">Achternaam:</label>
                        <input type="text" id="jeugdprinslastname" name="jeugdprinslastname" placeholder="Janssen" required>
                    </div>
                    <div class="form-group">
                        <label for="jeugdprinsnumber">de:</label>
                        <input type="text" id="jeugdprinsnumber" name="jeugdprinsnumber" placeholder="III" required>
                    </div>
                    <div class="form-group">
                        <label for="jeugdprinsyear">Jaor:</label>
                        <input type="text" id="jeugdprinsyear" name="jeugdprinsyear" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="jeugdprinsmotto">Spreuk:</label>
                        <input type="text" id="jeugdprinsmotto" name="jeugdprinsmotto" required>
                    </div>
                    <div class="form-group">
                        <label for="jeugdprinsinfo">Info: (optioneel)</label>
                        <textarea type="text" id="jeugdprinsinfo" name="jeugdprinsinfo" class="styled-textarea" style="height: auto;"></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="jeugdprinsimage_url">Aafbeelding:</label>
                        <input type="file" id="jeugdprinsimage_url" name="jeugdprinsimage_url" accept="image/*">
                        <img id="jeugdprinsimagePreview" class="editprinsimg" alt="Huidige afbeelding" style="display:none;">
                        <input type="hidden" id="jeugdprinsexisting_image_url" name="jeugdprinsexisting_image_url">
                    </div>
                    <div class="form-group">
                        <label for="jeugdprinsaltimage_url">Groepsfoto: (optioneel)</label>
                        <input type="file" id="jeugdprinsaltimage_url" name="jeugdprinsaltimage_url" accept="image/*">
                        <img id="jeugdprinsaltimagePreview" class="editprinsimg" alt="Huidige groepsfoto"  style="display:none;">
                        <input type="hidden" id="jeugdprinsexisting_altimage_url" name="jeugdprinsexisting_altimage_url">
                    </div>
                </div>
                <input type="submit" value="Opsjlaon" class="submit-button">
            </form>
        </div>

        <script>
            document.getElementById('addJeugdPrinsButton').addEventListener('click', function() {
                var form = document.getElementById('jeugdprinsForm');
                document.getElementById('jeugdprinsFormElement').reset();
                document.getElementById('jeugdprinsId').value = '';
                document.getElementById('jeugdprinsexisting_image_url').value = '';
                document.getElementById('jeugdprinsexisting_altimage_url').value = '';
                

                    const prinsYearInput = document.getElementById("jeugdprinsyear");
                    const today = new Date();
                
                    // Huidig jaar en volgende jaar
                    const currentYear = today.getFullYear();
                    const nextYear = currentYear + 1;
                
                    // Bereken de eerste zondag na 11 november
                    const november11 = new Date(currentYear, 10, 11); // Maand is 0-gebaseerd (10 = november)
                    const dayOfWeek = november11.getDay(); // 0 = zondag, 1 = maandag, ..., 6 = zaterdag
                    const daysToSunday = (7 - dayOfWeek) % 7; // Aantal dagen tot de volgende zondag
                    const firstSundayAfterNovember11 = new Date(november11);
                    firstSundayAfterNovember11.setDate(november11.getDate() + daysToSunday);
                
                    // Logica om placeholder te bepalen
                    if (today >= new Date(currentYear, 0, 1) && today <= firstSundayAfterNovember11) {
                        prinsYearInput.value = currentYear; // Huidig jaar
                    } else if (today > firstSundayAfterNovember11 && today <= new Date(currentYear, 11, 31)) {
                        prinsYearInput.value = nextYear; // Volgend jaar
                    }

                
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
                var prinsImagePreview = document.getElementById('jeugdprinsimagePreview');
                prinsImagePreview.style.display = 'none';
                var prinsAltImagePreview = document.getElementById('jeugdprinsaltimagePreview');
                prinsAltImagePreview.style.display = 'none';
            });
            
            document.querySelectorAll('.edit-jeugdprins').forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    var prinsId = this.getAttribute('data-id');
                    fetch('includes/dashboardIncludes/get_jeugdprinsen.php?id=' + prinsId)
                    .then(response => response.json())
                    .then(data => {

                        // Vul formulier met nieuwsgegevens
                        document.getElementById('jeugdprinsId').value = data.id;
                        document.getElementById('jeugdprinsfirstname').value = data.firstname;
                        document.getElementById('jeugdprinslastname').value = data.lastname;
                        document.getElementById('jeugdprinsyear').value = data.year;
                        document.getElementById('jeugdprinsnumber').value = data.number;
                        document.getElementById('jeugdprinsmotto').value = data.motto;
                        document.getElementById('jeugdprinsinfo').value = data.info;
                        document.getElementById('jeugdprinsexisting_image_url').value = data.image_url;
                        document.getElementById('jeugdprinsexisting_altimage_url').value = data.altimage_url;
                        
                        // Toon de afbeeldingen
                        var prinsImagePreview = document.getElementById('jeugdprinsimagePreview');
                        if (data.image_url) {
                            prinsImagePreview.src = data.image_url;
                            prinsImagePreview.style.display = 'block';
                        } else {
                            prinsImagePreview.style.display = 'none';
                        }
            
                        var prinsAltImagePreview = document.getElementById('jeugdprinsaltimagePreview');
                        if (data.altimage_url) {
                            prinsAltImagePreview.src = data.altimage_url;
                            prinsAltImagePreview.style.display = 'block';
                        } else {
                            prinsAltImagePreview.style.display = 'none';
                        }

                        document.getElementById('jeugdprinsForm').style.display = 'block';
                    })
                    .catch(error => console.error('Fout bij ophalen nieuws:', error));
                });
            });
            
            document.getElementById('jeugdprinsfirstname').addEventListener('input', function() {
                var firstname = this.value.trim();
            
                if (firstname.length > 0) {
                    fetch('includes/dashboardIncludes/check_jeugdprins_number.php?firstname=' + encodeURIComponent(firstname))
                        .then(response => response.json())
                        .then(data => {
                            if (data.romanNumber) {
                                document.getElementById('jeugdprinsnumber').value = data.romanNumber;
                            }
                        })
                        .catch(error => console.error('Fout bij het ophalen van het prinsnummer:', error));
                } else {
                    document.getElementById('jeugdprinsnumber').value = '';
                }
            });
            
            
        </script>
    </div>
</div>
<?php endif; ?>