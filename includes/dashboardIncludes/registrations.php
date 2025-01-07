<?php
// Data ophalen (voorbeeld logica, mogelijk al aanwezig)
$eventsWithRegistrations = $conn->query(
    "SELECT e.id AS event_id, e.title, e.date, COUNT(r.id) AS registration_count FROM events e " .
    "INNER JOIN registrations r ON e.id = r.eventid WHERE e.hidden = 0 " .
    "GROUP BY e.id ORDER BY e.date ASC;"
)->fetch_all(MYSQLI_ASSOC);
?>

<?php if ($hasManageEventsPermission): ?>
<div class="block-overview block-overview-permissions">
    <div class="heading-title">
        <h2 class="block-title">Overzicht van registraties</h2>
    </div>
    <div class="block-text">
        <div class="wrapper">
            <div class="table">
                <div class="row header">
                    <div class="cell">Datum</div>
                    <div class="cell">Titel</div>
                    <div class="cell">Aantal registraties</div>
                    <div class="cell">Acties</div>
                </div>
                <?php foreach ($eventsWithRegistrations as $event): ?>
                    <div class="row">
                        <div class="cell" data-title="Datum">
                            <?php echo htmlspecialchars((new DateTime($event['date']))->format('d-m-Y')); ?>
                        </div>
                        <div class="cell" data-title="Titel">
                            <?php echo htmlspecialchars($event['title']); ?>
                        </div>
                        <div class="cell" data-title="Aantal registraties">
                            <?php echo htmlspecialchars($event['registration_count']); ?>
                        </div>
                         <div class="cell" data-title="Acties">
                             <a href="#" data-event-id="<?php echo $event['event_id']; ?>"><i class="fa-solid fa-pen-to-square"></i> Bewirk</a>
                             <a href="#"><i class="fa-solid fa-trash"></i> Verwijder</a>
                         </div>
                    </div>
                    <div class="registration-details" id="registrations-<?php echo $event['event_id']; ?>" style="display: none;">
                        <div class="registrations-table">
                            <div class="row header">
                                <div class="cell">Naam</div>
                                <div class="cell">Telefoon</div>
                                <div class="cell">Email</div>
                                <div class="cell">Adres</div>
                                <div class="cell">Aantal personen</div>
                                <div class="cell">Groepsnaam</div>
                                <div class="cell">Registratietijd</div>                                
                            </div>
                            <div id="registration-rows-<?php echo $event['event_id']; ?>">
                                <!-- Rijen worden via JavaScript geladen -->
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.toggle-registrations').forEach(button => {
        button.addEventListener('click', function() {
            const eventId = this.getAttribute('data-event-id');
            const detailsRow = document.getElementById('registrations-' + eventId);
            const detailsTableBody = document.getElementById('registration-rows-' + eventId);

            if (detailsRow.style.display === 'none') {
                fetch('includes/dashboardIncludes/get_registrations.php?eventid=' + eventId)
                    .then(response => response.json())
                    .then(data => {
                        detailsTableBody.innerHTML = '';
                        data.forEach(registration => {
                            const row = `
                                <div class="row">
                                <div class="cell" data-title="Naam">${registration.firstname} ${registration.lastname}</div>
                                <div class="cell" data-title="Telefoon">${registration.phone}</div>
                                <div class="cell" data-title="Email">${registration.email}</div>
                                <div class="cell" data-title="Adres">${registration.street} ${registration.housenumber}${registration.addition ? ' ' + registration.addition : ''}, ${registration.postalcode}</div>
                                <div class="cell" data-title="Aantal personen">${registration.amount_people}</div>
                                <div class="cell" data-title="Groepsnaam">${registration.groupname}</div>
                                <div class="cell" data-title="Registratietijd">${new Date(registration.datetime.replace(' ', 'T')).toLocaleString('nl-NL', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    second: '2-digit',
                                    hour12: false
                                })}</div></div>
                            `;
                            detailsTableBody.innerHTML += row;
                        });
                        detailsRow.style.display = 'block';
                    })
                    .catch(error => console.error('Error fetching registrations:', error));
            } else {
                detailsRow.style.display = 'none';
            }
        });
    });
</script>
<?php endif; ?>