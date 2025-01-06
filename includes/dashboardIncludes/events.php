<?php if ($hasManageEventsPermission): ?>
<div class="block-overview block-overview-permissions">
    <div class="heading-title">
        <h2 class="block-title">Beheer ivvenementen</h2>
    </div>
    <div class="block-text">
        <table class="news-table">
            <thead>
                <tr>
                    <th>Datum</th>
                    <th>Titel</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $eventItems = $conn->query("SELECT * FROM `events` WHERE `date` >= CURDATE() ORDER BY `date` ASC LIMIT 10")->fetch_all(MYSQLI_ASSOC);
                foreach ($eventItems as $eventItem):
                ?>
                <tr>
                    <td>
                        <?php 
                        $date = new DateTime($eventItem['date']);
                        echo htmlspecialchars($date->format('d-m-Y'));
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($eventItem['title']); ?></td>
                    <td>
                        <i class="fa-solid fa-pen-to-square"></i> <a href="#" class="edit-event" data-id="<?php echo $eventItem['id']; ?>">Bewerk</a>
                        </br><i class="fa-solid fa-trash"></i> <a href="includes/dashboardIncludes/delete_events.php?id=<?php echo $eventItem['id']; ?>">Verwijder</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button id="addEventButton" class="submit-button">Ivvenement toevoege</button>
        <div id="eventForm" style="display: none;">
            <form id="eventFormElement" method="post" action="includes/dashboardIncludes/add_event.php" enctype="multipart/form-data">
                <input type="hidden" id="eventId" name="eventId">
                <label for="eventTitle">Titel:</label>
                <input type="text" id="eventTitle" name="eventTitle" required>
                <label for="eventLocation">Locatie:</label>
                <input type="text" id="eventLocation" name="eventLocation" required>
                <label for="eventDate">Datum:</label>
                <input type="datetime-local" id="eventDate" name="eventDate" required>
                <label for="eventRegistration_needed">Registratie neudig?</label>
                <input type="checkbox" id="eventRegistration_needed" name="eventRegistration_needed">
                        
                <div id="registrationOptions" style="display: none; margin-top: 10px;">
                    Welke gegaeves hubse dao veur neudig:
                    <label for="firstname">Veurnaam:</label>
                    <input type="checkbox" id="firstname" name="eventRegistration_fields[]" value="firstname">
                    <label for="lastname">Achternaam:</label>
                    <input type="checkbox" id="lastname" name="eventRegistration_fields[]" value="lastname">
                    <label for="phone">Tillefoonnómmer:</label>
                    <input type="checkbox" id="phone" name="eventRegistration_fields[]" value="phone"> 
                    <label for="email">E-Mail:</label>
                    <input type="checkbox" id="email" name="eventRegistration_fields[]" value="email">
                    <label for="adres">Adres:</label>
                    <input type="checkbox" id= "adres" name="eventRegistration_fields[]" value="adres">
                    <label for="amount_people">Aantal persone:</label>
                    <input type="checkbox" id="amount_people" name="eventRegistration_fields[]" value="amount_people">
                    <label for="groupname">Groepsnaam:</label>
                    <input type="checkbox" id="groupname" name="eventRegistration_fields[]" value="groupname">
                    <label for="eventRegistration_enddate">Tot wanneer kinse dich opgaeve:</label>
                    <input type="datetime-local" id="eventRegistration_enddate" name="eventRegistration_enddate" value="eventRegistration_enddate">
                </div>
                <input type="submit" value="Opsjlaon" class="submit-button">
            </form>
        </div>

        <script>
            document.getElementById('addEventButton').addEventListener('click', function() {
                var form = document.getElementById('eventForm');
                document.getElementById('eventFormElement').reset();
                document.getElementById('eventId').value = '';
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            });

            document.getElementById('eventRegistration_needed').addEventListener('change', function() {
                var options = document.getElementById('registrationOptions');
                options.style.display = this.checked ? 'block' : 'none';
            });

            document.querySelectorAll('.edit-event').forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    var eventId = this.getAttribute('data-id');
                    fetch('includes/dashboardIncludes/get_events.php?id=' + eventId)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Backend response:', data);

                        // Populate form with event data
                        document.getElementById('eventId').value = data.id;
                        document.getElementById('eventTitle').value = data.title;
                        document.getElementById('eventLocation').value = data.location;
                        document.getElementById('eventDate').value = data.date;
                        document.getElementById('eventRegistration_needed').checked = data.registration_needed == "1";

                        // Zorg ervoor dat registratieopties worden weergegeven of verborgen
                        document.getElementById('registrationOptions').style.display = data.registration_needed == "1" ? 'block' : 'none';

                        document.getElementById('eventRegistration_enddate').value = data.registration_enddate;

                        // Set the registration fields checkboxes
                        var registrationFields = data.registration_fields ? data.registration_fields.split(', ') : [];
                        document.querySelectorAll('input[name="eventRegistration_fields[]"]').forEach(function(checkbox) {
                            checkbox.checked = registrationFields.includes(checkbox.value);
                        });

                        document.getElementById('eventForm').style.display = 'block';
                    })
                    .catch(error => console.error('Error fetching event:', error));
                });
            });
        </script>
    </div>
</div>
<?php endif; ?>
