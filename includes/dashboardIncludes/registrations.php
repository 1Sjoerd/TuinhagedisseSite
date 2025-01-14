<?php if ($hasManageEventsPermission): ?>
<?php
    // Data ophalen
    $eventsWithRegistrations = $conn->query(
        "SELECT e.id AS event_id, e.title, e.date, e.registration_enddate, COUNT(r.id) AS registration_count FROM events e " .
        "INNER JOIN registrations r ON e.id = r.eventid WHERE e.hidden = 0 " .
        "GROUP BY e.id ORDER BY e.date ASC;"
    )->fetch_all(MYSQLI_ASSOC);
?>
<div class="block-overview block-overview-permissions">
    <div class="heading-title">
        <h2 class="block-title">Euverzich van insjrievinge</h2>
    </div>
    <div class="block-text">
        <?php if ($eventsWithRegistrations): ?>
        <div class="wrapper">
            <div class="table">
                <div class="row header">
                    <div class="cell">Einddatum</div>
                    <div class="cell">Titel</div>
                    <div class="cell">Aantal registraties</div>
                    <div class="cell">Acties</div>
                </div>
                <?php foreach ($eventsWithRegistrations as $event): ?>
                    <div class="row">
                        <div class="cell" data-title="Datum">
                            <?php echo htmlspecialchars((new DateTime($event['registration_enddate']))->format('d-m-Y H:i')); ?>
                        </div>
                        <div class="cell" data-title="Titel">
                            <?php echo htmlspecialchars($event['title']); ?>
                        </div>
                        <div class="cell" data-title="Aantal registraties">
                            <?php echo htmlspecialchars($event['registration_count']); ?>
                        </div>
                         <div class="cell" data-title="Acties">
                             <a href="includes/dashboardIncludes/download_registration_pdf.php?event_id=<?php echo $event['event_id']; ?>"><i class="fa-solid fa-download"></i> Download</a>
                             <a href="includes/dashboardIncludes/close_registration.php?id=<?php echo $event['event_id']; ?>"><i class="fa-solid fa-lock"></i> Sjloet insjrievinge</a>
                             <a href="includes/dashboardIncludes/delete_registration.php?id=<?php echo $event['event_id']; ?>"><i class="fa-solid fa-trash"></i> Verwijder insjrievinge</a>
                         </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php else: ?>
        D'r zeen gein insjrievinge
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
