<?php if ($hasManageSponsorsPermission): ?>
<a id="sponsorplan-overview"></a>
<div class="block-overview block-overview-permissions">
    <div class="heading-title">
        <h2 class="block-title">Beheer Sjponsorplannen</h2>
    </div>
    <style>

    </style>
    <div class="block-text">
        <div class="wrapper">
            <div class="table">
                <div class="row header">
                    <div class="cell">Naam</div>
                    <div class="cell">Info</div>
                    <div class="cell">Acties</div>
                </div>
                <?php
                $sponsorplanItems = $conn->query("SELECT * FROM `sponsorplan`")->fetch_all(MYSQLI_ASSOC);
                foreach ($sponsorplanItems as $sponsorplanItem):
                ?>
                <div class="row">
                    <div class="cell" data-title="Naam"><?php echo htmlspecialchars($sponsorplanItem['sponsorplan']); ?></div>
                    <div class="cell" data-title="Info"><?php echo htmlspecialchars($sponsorplanItem['info']); ?></div>
                    <div class="cell" data-title="Acties">
                        <a href="#" class="edit-sponsorplan" data-id="<?php echo $sponsorplanItem['id']; ?>"><i class="fa-solid fa-pen-to-square"></i> Bewirk</a>
                        <a href="includes/dashboardIncludes/delete_sponsorplans.php?id=<?php echo $sponsorplanItem['id']; ?>"><i class="fa-solid fa-trash"></i> Verwijder</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <button id="addSponsorplanButton" class="submit-button">Sponsorplan toevoege</button>
        <div id="sponsorplanForm" style="display: none;">
            <form id="sponsorplanFormElement" method="post" action="includes/dashboardIncludes/add_sponsorplan.php" enctype="multipart/form-data">
                <input type="hidden" id="sponsorplanId" name="sponsorplanId">
                <label for="sponsorplanName">Naam:</label>
                <input type="text" id="sponsorplanName" name="sponsorplanName" required>
                <div class="form-row">
                    <div class="form-group">
                        <label for="sponsorplanMinAmount">Minimaal bedrag:</label>
                        <div class="currency-wrapper">
                            <span>€</span>
                            <input type="text" id="sponsorplanMinAmount" name="sponsorplanMinAmount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sponsorplanMaxAmount">Maximaal bedrag:</label>
                        <div class="currency-wrapper">
                            <span>€</span>
                            <input type="text" id="sponsorplanMaxAmount" name="sponsorplanMaxAmount">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="sponsorplanInfo">Info:</label>
                        <input type="text" id="sponsorplanInfo" name="sponsorplanInfo">
                    </div>
                    <div class="form-group">
                        <label for="sponsorplanInfo">Logo oppe sait:</label>
                        <input type="checkbox" id="sponsorplanWebsite" name="sponsorplanWebsite">
                    </div>
                </div>
                <input type="submit" value="Opsjlaon" class="submit-button">
            </form>
        </div>

        <script>
            document.getElementById('addSponsorplanButton').addEventListener('click', function() {
                var form = document.getElementById('sponsorplanForm');
                document.getElementById('sponsorplanFormElement').reset();
                document.getElementById('sponsorplanId').value = '';
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            });

            document.querySelectorAll('.edit-sponsorplan').forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    var eventId = this.getAttribute('data-id');
                    fetch('includes/dashboardIncludes/get_sponsorplans.php?id=' + eventId)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Backend response:', data);

                        // Populate form with event data
                        document.getElementById('sponsorplanId').value = data.id;
                        document.getElementById('sponsorplanName').value = data.sponsorplan;
                        document.getElementById('sponsorplanMinAmount').value = data.min_amount;
                        document.getElementById('sponsorplanMaxAmount').value = data.max_amount;
                        document.getElementById('sponsorplanInfo').value = data.info;
                        document.getElementById('sponsorplanWebsite').checked = data.showlogo == "1";

                        document.getElementById('sponsorplanForm').style.display = 'block';
                    })
                    .catch(error => console.error('Error fetching event:', error));
                });
            });

            // Validatie voor de bedragvelden
            function validateAmountInput(input) {
                input.addEventListener('input', () => {
                    input.value = input.value.replace(/[^0-9.,]/g, '').replace(/,/g, '.');
                    if (input.value.includes('.')) {
                        const parts = input.value.split('.');
                        if (parts[1] && parts[1].length > 2) {
                            input.value = parts[0] + '.' + parts[1].substring(0, 2);
                        }
                    }
                });
            }

            function validateMinMax() {
                const minAmount = document.getElementById('sponsorplanMinAmount');
                const maxAmount = document.getElementById('sponsorplanMaxAmount');

                maxAmount.addEventListener('input', () => {
                    const min = parseFloat(minAmount.value) || 0;
                    const max = parseFloat(maxAmount.value) || 0;

                    if (max < min) {
                        maxAmount.setCustomValidity('Maximaal bedrag mag niet lager zijn dan minimaal bedrag.');
                    } else {
                        maxAmount.setCustomValidity('');
                    }
                });

                minAmount.addEventListener('input', () => {
                    maxAmount.dispatchEvent(new Event('input')); // Validatie opnieuw uitvoeren
                });
            }

            document.addEventListener('DOMContentLoaded', () => {
                const minInput = document.getElementById('sponsorplanMinAmount');
                const maxInput = document.getElementById('sponsorplanMaxAmount');

                validateAmountInput(minInput);
                validateAmountInput(maxInput);
                validateMinMax();
            });
        </script>
    </div>
</div>
<?php endif; ?>