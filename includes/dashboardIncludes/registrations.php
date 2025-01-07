<?php
    $eventsWithRegistrations = $conn->query("SELECT e.id AS event_id, e.title, e.date, COUNT(r.id) AS registration_count FROM events e INNER JOIN registrations r ON e.id = r.eventid WHERE e.hidden = 0 GROUP BY e.id ORDER BY e.date ASC;")->fetch_all(MYSQLI_ASSOC);
?>

<?php if ($hasManageEventsPermission): ?>
<div class="block-overview block-overview-permissions">
    <div class="heading-title">
        <h2 class="block-title">Overzicht van registraties</h2>
    </div>
    <div class="block-text">
        <table class="news-table">
            <thead>
                <tr>
                    <th>Datum</th>
                    <th>Titel</th>
                    <th>Aantal registraties</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($eventsWithRegistrations as $event): ?>
                <tr>
                    <td><?php echo htmlspecialchars((new DateTime($event['date']))->format('d-m-Y')); ?></td>
                    <td><?php echo htmlspecialchars($event['title']); ?></td>
                    <td><?php echo htmlspecialchars($event['registration_count']); ?></td>
                    <td>
                        <button class="toggle-registrations submit-button" data-event-id="<?php echo $event['event_id']; ?>">Bekijk registraties</button>
                    </td>
                </tr>
                <tr class="registration-details" id="registrations-<?php echo $event['event_id']; ?>" style="display: none;">
                    <td colspan="4">
                        <table class="registration-details-table">
                            <thead>
                                <tr>
                                    <th>Naam</th>
                                    <th>Telefoon</th>
                                    <th>Email</th>
                                    <th>Adres</th>
                                    <th>Aantal personen</th>
                                    <th>Groepsnaam</th>
                                    <th>Registratietijd</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Inhoud wordt via JavaScript ingeladen -->
                            </tbody>
                        </table>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    document.querySelectorAll('.toggle-registrations').forEach(button => {
    button.addEventListener('click', function() {
        const eventId = this.getAttribute('data-event-id');
        const detailsRow = document.getElementById('registrations-' + eventId);
        const detailsTableBody = detailsRow.querySelector('tbody');

        if (detailsRow.style.display === 'none') {
            // Rijen tonen
            fetch('includes/dashboardIncludes/get_registrations.php?eventid=' + eventId)
                .then(response => response.json())
                .then(data => {
                    detailsTableBody.innerHTML = '';
                    data.forEach(registration => {
                        // Converteer de datetime naar het juiste ISO 8601-formaat
                        const isoDatetime = registration.datetime.replace(' ', 'T');
            
                        const row = `
                            <tr>
                                <td>${registration.firstname} ${registration.lastname}</td>
                                <td>${registration.phone}</td>
                                <td>${registration.email}</td>
                                <td>${registration.street} ${registration.housenumber}${registration.addition ? ' ' + registration.addition : ''}, ${registration.postalcode}</td>
                                <td>${registration.amount_people}</td>
                                <td>${registration.groupname}</td>
                                <td>${new Date(isoDatetime).toLocaleString('nl-NL', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    second: '2-digit',
                                    hour12: false
                                })}</td>
                            </tr>
                        `;
                        detailsTableBody.innerHTML += row;
                    });
                    detailsRow.style.display = 'table-row';
                })
                .catch(error => console.error('Error fetching registrations:', error));

        } else {
            // Rijen verbergen
            detailsRow.style.display = 'none';
        }
    });
});

</script>
<?php endif; ?>
