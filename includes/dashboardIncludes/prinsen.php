<?php if ($hasManageUsersPermission): ?>
<a id="prinsen-overview"></a>
<div class="block-overview block-overview-permissions">
    <div class="heading-title">
        <h2 class="block-title">Beheer prinsen</h2>
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
                $limit = 10; // Aantal items per pagina
                $offset = ($page - 1) * $limit;
                
                // Haal het totaal aantal records op
                $totalPrinsen = $conn->query("SELECT COUNT(*) as count FROM prinse")->fetch_assoc()['count'];
                $totalPages = ceil($totalPrinsen / $limit);
                
                // Haal records op voor de huidige pagina
                $prinsenItems = $conn->query("SELECT * FROM prinse ORDER BY year DESC LIMIT $limit OFFSET $offset")->fetch_all(MYSQLI_ASSOC);

                foreach ($prinsenItems as $prinsenItem):
                ?>
                    <div class="row">
                        <div class="cell" data-title="Naam"><?php echo htmlspecialchars($prinsenItem['firstname']); ?> <?php echo htmlspecialchars($prinsenItem['number']); ?> <?php echo htmlspecialchars($prinsenItem['lastname']); ?></div>
                        <div class="cell" data-title="jaor"><?php echo htmlspecialchars($prinsenItem['year']); ?></div>
                        <div class="cell" data-title="Acties">
                            <a href="#" class="edit-prins" data-id="<?php echo $prinsenItem['id']; ?>"><i class="fa-solid fa-pen-to-square"></i> Bewirk</a>
                            <a href="#"><i class="fa-solid fa-trash"></i> Verwijder</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>#prinsen-overview" class="pagination-link">Vorige</a>
            <?php endif; ?>
        
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?php echo $i; ?>#prinsen-overview" class="pagination-link <?php if ($i == $page) echo 'active'; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        
            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo $page + 1; ?>#prinsen-overview" class="pagination-link">Volgende</a>
            <?php endif; ?>
        </div>


        <button id="addPrinsButton" class="submit-button">Prins toevoege</button>
        <div id="prinsForm" style="display: none;">
            <form id="prinsFormElement" method="post" action="includes/dashboardIncludes/add_prins.php" enctype="multipart/form-data">
                <input type="hidden" id="prinsId" name="id">
                <div class="form-row">
                    <div class="form-group">
                        <label for="prinsfirstname">Veurnaam:</label>
                        <input type="text" id="prinsfirstname" name="prinsfirstname" placeholder="Jan" required>
                    </div>
                    <div class="form-group">
                        <label for="prinslastname">Achternaam:</label>
                        <input type="text" id="prinslastname" name="prinslastname" placeholder="Janssen" required>
                    </div>
                    <div class="form-group">
                        <label for="prinsnumber">de:</label>
                        <input type="text" id="prinsnumber" name="prinsnumber" placeholder="III" required>
                    </div>
                    <div class="form-group">
                        <label for="prinsyear">Jaor:</label>
                        <input type="text" id="prinsyear" name="prinsyear" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="prinsmotto">Spreuk:</label>
                        <input type="text" id="prinsmotto" name="prinsmotto" required>
                    </div>
                    <div class="form-group">
                        <label for="prinsinfo">Info: (optioneel)</label>

                        <textarea type="text" id="prinsinfo" name="prinsinfo" class="styled-textarea" style="height: auto;"></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="prinsimage_url">Aafbeelding:</label>
                        <input type="file" id="prinsimage_url" name="prinsimage_url">
                        <img id="prinsimagePreview" class="editprinsimg" alt="Huidige afbeelding" style="display:none;">
                        <input type="hidden" id="prinsexisting_image_url" name="prinsexisting_image_url">
                    </div>
                    <div class="form-group">
                        <label for="prinsaltimage_url">Groepsfoto: (optioneel)</label>
                        <input type="file" id="prinsaltimage_url" name="prinsaltimage_url">
                        <img id="prinsaltimagePreview" class="editprinsimg" alt="Huidige groepsfoto"  style="display:none;">
                        <input type="hidden" id="prinsexisting_altimage_url" name="prinsexisting_altimage_url">
                    </div>
                </div>
                <input type="submit" value="Opsjlaon" class="submit-button">
            </form>
        </div>

        <script>
            document.getElementById('addPrinsButton').addEventListener('click', function() {
                var form = document.getElementById('prinsForm');
                document.getElementById('prinsFormElement').reset();
                document.getElementById('prinsId').value = '';
                document.getElementById('prinsexisting_image_url').value = '';
                

                    const prinsYearInput = document.getElementById("prinsyear");
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
                var prinsImagePreview = document.getElementById('prinsimagePreview');
                prinsImagePreview.style.display = 'none';
                
                
            });
            
            document.querySelectorAll('.edit-prins').forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    var prinsId = this.getAttribute('data-id');
                    fetch('includes/dashboardIncludes/get_prinsen.php?id=' + prinsId)
                    .then(response => response.json())
                    .then(data => {

                        // Vul formulier met nieuwsgegevens
                        document.getElementById('prinsId').value = data.id;
                        document.getElementById('prinsfirstname').value = data.firstname;
                        document.getElementById('prinslastname').value = data.lastname;
                        document.getElementById('prinsyear').value = data.year;
                        document.getElementById('prinsnumber').value = data.number;
                        document.getElementById('prinsmotto').value = data.motto;
                        document.getElementById('prinsinfo').value = data.info;
                        document.getElementById('prinsexisting_image_url').value = data.image_url;
                        document.getElementById('prinsexisting_altimage_url').value = data.altimage_url;
                        
                        // Toon de afbeeldingen
                        var prinsImagePreview = document.getElementById('prinsimagePreview');
                        if (data.image_url) {
                            prinsImagePreview.src = data.image_url;
                            prinsImagePreview.style.display = 'block';
                        } else {
                            prinsImagePreview.style.display = 'none';
                        }
            
                        var prinsAltImagePreview = document.getElementById('prinsaltimagePreview');
                        if (data.altimage_url) {
                            prinsAltImagePreview.src = data.altimage_url;
                            prinsAltImagePreview.style.display = 'block';
                        } else {
                            prinsAltImagePreview.style.display = 'none';
                        }

                        document.getElementById('prinsForm').style.display = 'block';
                    })
                    .catch(error => console.error('Fout bij ophalen nieuws:', error));
                });
            });
            
            document.getElementById('prinsfirstname').addEventListener('input', function() {
                var firstname = this.value.trim();
            
                if (firstname.length > 0) {
                    fetch('includes/dashboardIncludes/check_prins_number.php?firstname=' + encodeURIComponent(firstname))
                        .then(response => response.json())
                        .then(data => {
                            if (data.romanNumber) {
                                document.getElementById('prinsnumber').value = data.romanNumber;
                            }
                        })
                        .catch(error => console.error('Fout bij het ophalen van het prinsnummer:', error));
                } else {
                    document.getElementById('prinsnumber').value = '';
                }
            });
            
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            });
        </script>
    </div>
</div>
<?php endif; ?>