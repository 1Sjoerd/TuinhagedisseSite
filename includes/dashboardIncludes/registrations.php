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
                             <a href="#" data-event-id="<?php echo $event['event_id']; ?>"><i class="fa-solid fa-download"></i> Download</a>
                             <a href="#"><i class="fa-solid fa-trash"></i> Sjloet registraties</a>
                             <a href="#"><i class="fa-solid fa-trash"></i> Verwijder registraties</a>
                         </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>