<?php if ($hasManageNewsPermission): ?>
<?php
    // Fetch events for the dropdown
    $events = $conn->query("SELECT id, title FROM events ORDER BY date DESC LIMIT 10")->fetch_all(MYSQLI_ASSOC);
?>
<div class="block-overview">
    <div class="heading-title">
        <h2 class="block-title">Beheer nuujts</h2>
    </div>
    <div class="block-text">
        <div class="wrapper">
            <div class="table">
                <div class="row header">
                    <div class="cell">Datum</div>
                    <div class="cell">Titel</div>
                    <div class="cell">Acties</div>
                </div>
                <?php
                $newsItems = $conn->query("SELECT * FROM news ORDER BY date DESC LIMIT 10")->fetch_all(MYSQLI_ASSOC);
                foreach ($newsItems as $newsItem):
                ?>
                    <div class="row">
                        <div class="cell" data-title="Datum">
                            <?php 
                            $date = new DateTime($newsItem['date']);
                            echo htmlspecialchars($date->format('d-m-Y')); 
                            ?>
                        </div>
                        <div class="cell" data-title="Titel"><?php echo htmlspecialchars($newsItem['title']); ?></div>
                        <div class="cell" data-title="Acties">
                            <a href="#" class="edit-news" data-id="<?php echo $newsItem['id']; ?>"><i class="fa-solid fa-pen-to-square"></i> Bewirk</a>
                            <a href="includes/dashboardIncludes/delete_news.php?id=<?php echo $newsItem['id']; ?>"><i class="fa-solid fa-trash"></i> Verwijder</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <button id="addNewsButton" class="submit-button">Nuujts toevoege</button>
        <div id="newsForm" style="display: none;">
            <form id="newsFormElement" method="post" action="includes/dashboardIncludes/add_news.php" enctype="multipart/form-data">
                <input type="hidden" id="newsId" name="id">
                <label for="title">Titel:</label>
                <input type="text" id="title" name="title" required>
                <label for="text">Inhoud:</label>
                <textarea id="text" name="text" class="styled-textarea" required></textarea>
                <div class="form-row">
                    <div class="form-group">
                        <label for="image_url">Poster:</label>
                        <input type="file" id="image_url" name="image_url" accept="image/*">
                        <input type="hidden" id="existing_image_url" name="existing_image_url">
                    </div>
                    <div class="form-group">
                        <label for="date">Datum:</label>
                        <input type="date" id="date" name="date" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="eventid">Event ID (optioneel):</label>
                        <select id="eventid" name="eventid" class="styled-select">
                            <option value="">Selecteer 'n ivvenement</option>
                            <?php foreach ($events as $event): ?>
                                <option value="<?php echo $event['id']; ?>"><?php echo htmlspecialchars($event['title']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <label for="post_on_facebook" id="facebookPostLabel" style="display: none;">
                    <input type="checkbox" id="post_on_facebook" name="post_on_facebook" value="1">
                    Mot dit bericht auch op Facebook?
                </label>

                <input type="submit" value="Opsjlaon" class="submit-button">
            </form>
        </div>

        <script>
            document.getElementById('addNewsButton').addEventListener('click', function() {
                var form = document.getElementById('newsForm');
                document.getElementById('newsFormElement').reset();
                document.getElementById('newsId').value = '';
                document.getElementById('existing_image_url').value = '';
                document.getElementById('facebookPostLabel').style.display = 'block';
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            });

            document.querySelectorAll('.edit-news').forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    var newsId = this.getAttribute('data-id');
                    fetch('includes/dashboardIncludes/get_news.php?id=' + newsId)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Backend response:', data);

                        // Vul formulier met nieuwsgegevens
                        document.getElementById('newsId').value = data.id;
                        document.getElementById('title').value = data.title;
                        document.getElementById('text').value = data.text;
                        document.getElementById('date').value = data.date;
                        document.getElementById('existing_image_url').value = data.image_url;
                        document.getElementById('facebookPostLabel').style.display = 'none';

                        // Stel de juiste optie in voor de eventid dropdown
                        var eventidSelect = document.getElementById('eventid');
                        var eventIdValue = data.eventid ? data.eventid.trim() : ""; // Zorg voor een opgeschoonde waarde
                        let optionFound = false;

                        Array.from(eventidSelect.options).forEach(option => {
                            if (option.value === eventIdValue) {
                                option.selected = true;
                                optionFound = true;
                            } else {
                                option.selected = false; // Reset andere opties
                            }
                        });

                        // Als er geen match is, reset naar standaardoptie
                        if (!optionFound) {
                            eventidSelect.value = ""; // Reset dropdown naar standaardoptie
                        }

                        document.getElementById('newsForm').style.display = 'block';
                    })
                    .catch(error => console.error('Fout bij ophalen nieuws:', error));
                });
            });
        </script>
    </div>
</div>
<?php endif; ?>
