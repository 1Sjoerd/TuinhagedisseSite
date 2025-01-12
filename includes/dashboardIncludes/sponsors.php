<?php if ($hasManageSponsorsPermission): ?>
<?php
    // Fetch sponsorplans for the dropdown
    $sponsorplans = $conn->query("SELECT id, sponsorplan FROM sponsorplan")->fetch_all(MYSQLI_ASSOC);
?>
<a id="sponsors-overview"></a>
<div class="block-overview block-overview-permissions">
    <div class="heading-title">
        <h2 class="block-title">Beheer Sjponsore</h2>
    </div>
    <style>

    </style>
    <div class="block-text">
        <div class="wrapper">
            <div class="table">
                <div class="row header">
                    <div class="cell">Naam</div>
                    <div class="cell">Acties</div>
                </div>
                <?php
                $sponsorsItems = $conn->query("SELECT * FROM `sponsors` ORDER BY name")->fetch_all(MYSQLI_ASSOC);
                foreach ($sponsorsItems as $sponsorsItem):
                ?>
                <div class="row">
                    <div class="cell" data-title="Naam"><?php echo htmlspecialchars($sponsorsItem['name']); ?></div>
                    <div class="cell" data-title="Acties">
                        <a href="#" class="edit-sponsors" data-id="<?php echo $sponsorsItem['id']; ?>"><i class="fa-solid fa-pen-to-square"></i> Bewirk</a>
                        <a href="includes/dashboardIncludes/delete_sponsors.php?id=<?php echo $sponsorsItem['id']; ?>"><i class="fa-solid fa-trash"></i> Verwijder</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <button id="addSponsorsButton" class="submit-button">Sjponsor toevoege</button>
        <div id="sponsorsForm" style="display: none;">
            <form id="sponsorsFormElement" method="post" action="includes/dashboardIncludes/add_sponsors.php" enctype="multipart/form-data">
                <input type="hidden" id="sponsorsId" name="sponsorsId">
                <label for="sponsorsName">Naam:</label>
                <input type="text" id="sponsorsName" name="sponsorsName" required>
                <label for="sponsorsUrl">Url:</label>
                <input type="text" id="sponsorsUrl" name="sponsorsUrl">
                <div class="form-row">
                    <div class="form-group">
                        <label for="sponsorsPostalcode">Postcode:</label>
                        <input type="text" id="sponsorsPostalcode" name="sponsorsPostalcode" required>
                    </div>
                    <div class="form-group">
                        <label for="sponsorsHousenumber">Hoesnummer:</label>
                        <input type="text" id="sponsorsHousenumber" name="sponsorsHousenumber" required>
                    </div>
                    <div class="form-group">
                        <label for="sponsorsAddition">Toevoeging:</label>
                        <input type="text" id="sponsorsAddition" name="sponsorsAddition">
                    </div>
                </div>
                <label for="sponsorsStreet">Straotnaam:</label>
                <input type="text" id="sponsorsStreet" name="sponsorsStreet" required>
                <div class="form-row">
                    <div class="form-group">
                        <label for="sponsorsInfo">Info:</label>
                        <input type="text" id="sponsorsInfo" name="sponsorsInfo">
                    </div>
                    <div class="form-group">
                        <label for="sponsorsPlan">Sjponsorplan:</label>
                        <select id="sponsorsPlan" name="sponsorsPlan" class="styled-select" required>
                            <option value="">Selecteer 'n sjponsorplan</option>
                            <?php foreach ($sponsorplans as $sponsorplan): ?>
                                <option value="<?php echo $sponsorplan['id']; ?>"><?php echo htmlspecialchars($sponsorplan['sponsorplan']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="sponsorsimage_url">Poster:</label>
                        <input type="file" id="sponsorsimage_url" name="sponsorsimage_url">
                        <input type="hidden" id="sponsorsexisting_image_url" name="sponsorsexisting_image_url">
                    </div>
                    <div class="form-group">
                        <label for="sponsorsCarsponsor">Logo op de auto?</label>
                        <input type="checkbox" id="sponsorsCarsponsor" name="sponsorsCarsponsor">
                    </div>
                </div>
                <input type="submit" value="Opsjlaon" class="submit-button">
            </form>
        </div>

        <script>
            document.getElementById('addSponsorsButton').addEventListener('click', function() {
                var form = document.getElementById('sponsorsForm');
                document.getElementById('sponsorsFormElement').reset();
                document.getElementById('sponsorsId').value = '';
                document.getElementById('sponsorsexisting_image_url').value = '';
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            });

            document.querySelectorAll('.edit-sponsors').forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    var sponsorsId = this.getAttribute('data-id');
                    fetch('includes/dashboardIncludes/get_sponsors.php?id=' + sponsorsId)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Backend response:', data);

                        // Vul formulier met nieuwsgegevens
                        document.getElementById('sponsorsId').value = data.id;
                        document.getElementById('sponsorsName').value = data.name;
                        document.getElementById('sponsorsUrl').value = data.url;
                        document.getElementById('sponsorsPostalcode').value = data.postalcode;
                        document.getElementById('sponsorsHousenumber').value = data.housenumber;
                        document.getElementById('sponsorsAddition').value = data.addition;
                        document.getElementById('sponsorsStreet').value = data.street;
                        document.getElementById('sponsorsInfo').value = data.info;
                        document.getElementById('sponsorsexisting_image_url').value = data.image_url;
                        document.getElementById('sponsorsCarsponsor').checked = data.carsponsor == "1";

                        // Stel de juiste optie in voor de eventid dropdown
                        var sponsorplanidSelect = document.getElementById('sponsorsPlan');
                        var sponsorplanValue = data.sponsorplan_id ? data.sponsorplan_id.trim() : ""; // Zorg voor een opgeschoonde waarde
                        let optionFound = false;

                        Array.from(sponsorplanidSelect.options).forEach(option => {
                            if (option.value === sponsorplanValue) {
                                option.selected = true;
                                optionFound = true;
                            } else {
                                option.selected = false; // Reset andere opties
                            }
                        });

                        // Als er geen match is, reset naar standaardoptie
                        if (!optionFound) {
                            sponsorplanidSelect.value = ""; // Reset dropdown naar standaardoptie
                        }

                        document.getElementById('sponsorsForm').style.display = 'block';
                    })
                    .catch(error => console.error('Fout bij ophalen sponsorplannen:', error));
                });
            });
        </script>
    </div>
</div>
<?php endif; ?>