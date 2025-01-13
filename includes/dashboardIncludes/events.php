<?php if ($hasManageEventsPermission): ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


<div class="block-overview block-overview-permissions">
    <div class="heading-title">
        <h2 class="block-title">Beheer ivvenementen</h2>
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
                $eventItems = $conn->query("SELECT * FROM `events` WHERE `date` >= CURDATE() ORDER BY `date` ASC")->fetch_all(MYSQLI_ASSOC);
                foreach ($eventItems as $eventItem):
                ?>
                <div class="row">
                    <div class="cell" data-title="Datum">
                        <?php 
                        $date = new DateTime($eventItem['date']);
                        echo htmlspecialchars($date->format('d-m-Y'));
                        ?>
                    </div>
                    <div class="cell" data-title="Titel"><?php echo htmlspecialchars($eventItem['title']); ?></div>
                    <div class="cell" data-title="Acties">
                        <a href="#" class="edit-event" data-id="<?php echo $eventItem['id']; ?>"><i class="fa-solid fa-pen-to-square"></i> Bewirk</a>
                        <a href="includes/dashboardIncludes/delete_events.php?id=<?php echo $eventItem['id']; ?>"><i class="fa-solid fa-trash"></i> Verwijder</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
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
                    <select class="registrationFieldSelect" name="eventRegistration_fields[]" style="width: 100%;" multiple="multiple">
                        <option value="firstname" >Veurnaam</option>
                        <option value="lastname" >Achternaam</option>
                        <option value="phone" >Tillefoonnómmer</option>
                        <option value="email" >E-Mail</option>
                        <option value="adres" >Adres</option>
                        <option value="amount_people" >Aantal persone</option>
                        <option value="groupname" >Groepsnaam</option>
                    </select>
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

                // Reset de select-velden
                var selectElement = document.querySelector('select[name="eventRegistration_fields[]"]');
                if (selectElement) {
                    Array.from(selectElement.options).forEach(option => {
                        option.selected = false; // Deselecteer alle opties
                    });

                    // Reset Select2 als het gebruikt wordt
                    if ($(selectElement).hasClass('js-select2')) {
                        $(selectElement).trigger('change'); // Werk de weergave van Select2 bij
                    }
                }

                // Zorg ervoor dat de registratie-opties verborgen zijn
                document.getElementById('registrationOptions').style.display = 'none';

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

                        // Set the registration fields for the select element
                        var registrationFields = data.registration_fields ? data.registration_fields.split(', ') : [];
                        var selectElement = document.querySelector('select[name="eventRegistration_fields[]"]');

                        if (selectElement) {
                            Array.from(selectElement.options).forEach(option => {
                                option.selected = false;
                            });

                            registrationFields.forEach(field => {
                                for (let i = 0; i < selectElement.options.length; i++) {
                                    if (selectElement.options[i].value === field) {
                                        selectElement.options[i].selected = true;
                                        break;
                                    }
                                }
                            });

                            if ($(selectElement).hasClass('registrationFieldSelect')) {
                                $(selectElement).trigger('change');
                            }
                        }

                        document.getElementById('eventForm').style.display = 'block';
                    })
                    .catch(error => console.error('Error fetching event:', error));
                });
            });


        </script>
    </div>
</div>

<?php endif; ?>
