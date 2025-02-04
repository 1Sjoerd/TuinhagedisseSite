<?php
$eventid = $row['eventid'];
if ($row['image_url']) {
    $image_url = htmlspecialchars($row['image_url'], ENT_QUOTES, 'UTF-8');
} else {
    $image_url = null;
}
$title = htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8');
$text = htmlspecialchars($row['text'], ENT_QUOTES, 'UTF-8');
?>

<link rel="stylesheet" href="./assets/css/standardblock.css">
<link rel="stylesheet" href="./assets/css/newstemplate.css">

<div class="block-overview">
    <div class="heading-title">
        <h2 class="block-title"><?= $title ?></h2>
    </div>
    <div class="block-text">
        <div class="news-row">
            <?php if ($image_url): ?>
                <div class='news-column'>
                    <img src='<?= $image_url ?>' alt='<?= $title ?>'>
                </div>
                <div class='news-column'>
                    <?= $text ?>
                </div>
                <?php else: ?>
                    <div class='news-column-noimg'><?= $text ?></div>
                <?php endif; ?>

                <?php if ($eventid): 
                    $stmt = $conn->prepare("SELECT `registration_needed`, `registration_fields`, `registration_enddate` FROM `events` WHERE id = ?");
                    $stmt->bind_param("i", $eventid);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result && $row = $result->fetch_assoc()):
                        if ($row['registration_needed'] != '0' && strtotime($row['registration_enddate']) > time()): ?>
                            </div>
                            <div class='news-row'>
                                <div class='news-column-noimg'>
                                    <form id="registrationForm" method="POST" action="submit_registration.php">
                                    <?php
                                        $fields = explode(", ", $row['registration_fields']);
                                        $translations = [
                                            'firstname' => ['Veurnaam', 'Jan', true, 'given-name'],
                                            'lastname' => ['Achternaam', 'Janssen', true, 'family-name'],
                                            'phone' => ['Tillefoonnómmer', '', true, 'tel-local'],
                                            'email' => ['E-mail', 'info@vvdetuinhagedisse.nl', true, 'email'],
                                            'street' => ['Sjtraotnaam', '', true, 'off'],
                                            'postalcode' => ['Postcode', '1234AB', true, 'postal-code'],
                                            'housenumber' => ['Hoesnómmer', '', true, 'off'],
                                            'addition' => ['Toevoeging', '', false, ''], // Niet verplicht
                                            'amount_people' => ['Aantal personen', '1', true, ''],
                                            'groupname' => ['Groepsnaam', 'VV de Tuinhagedisse', true, ''],
                                        ];
                                        foreach ($fields as $field):
                                            $field = htmlspecialchars($field, ENT_QUOTES, 'UTF-8');
                                            $label = $translations[$field][0] ?? $field;
                                            $placeholder = $translations[$field][1] ?? '';
                                            $isRequired = $translations[$field][2] ?? false;
                                            $autocomplete = $translations[$field][3] ?? '';
                                            if (in_array($field, ['postalcode', 'housenumber', 'addition'])):
                                                if ($field == 'postalcode'): ?>
                                                    <div class="address-row">
                                                <?php endif; ?>
                                                <div class="address-field">
                                                    <label for="<?= $field ?>"><?= $label ?></label>
                                                    <input type="text" id="<?= $field ?>" name="<?= $field ?>" 
                                                    placeholder="<?= $placeholder ?>" 
                                                    <?= $isRequired ? 'required' : '' ?> 
                                                    <?= $autocomplete ? "autocomplete=\"$autocomplete\"" : '' ?>>
                                                </div>
                                                <?php if ($field == 'addition'): ?>
                                                    </div>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <label for="<?= $field ?>"><?= $label ?></label>
                                                <input type="<?php 
                                                    if ($field == 'amount_people') {
                                                        echo 'number';
                                                    } elseif ($field == 'email') {
                                                        echo 'email';
                                                    } elseif ($field == 'phone') {
                                                        echo 'tel';
                                                    } else {
                                                        echo 'text';
                                                    }
                                                ?>" id="<?= $field ?>" name="<?= $field ?>" 
                                                placeholder="<?= $placeholder ?>" 
                                                <?= $isRequired ? 'required' : '' ?> 
                                                <?= $autocomplete ? "autocomplete=\"$autocomplete\"" : '' ?>>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <input type="hidden" id="eventid" name="eventid" value="<?= htmlspecialchars($eventid, ENT_QUOTES, 'UTF-8') ?>">
                                        <input type="submit" value="Aanmelden" class="submit-button">
                                    </form>
                            </div>
                        </div>
                    <?php endif;
                endif;
            endif; ?>
        </div>
    </div>
</div>
<script>
    document.getElementById('postalcode').addEventListener('blur', function() {
        const postalcodeInput = document.getElementById('postalcode');
        // Verwijder spaties en zet om naar hoofdletters
        postalcodeInput.value = postalcodeInput.value.replace(/\s+/g, '').toUpperCase();
        fetchStreetNameIfValid(); // Roep de API-aanroep functie aan
    });
    
    document.getElementById('housenumber').addEventListener('blur', fetchStreetNameIfValid);
    
    function fetchStreetNameIfValid() {
        const postalcodeInput = document.getElementById('postalcode');
        const housenumberInput = document.getElementById('housenumber');
        const streetInput = document.getElementById('street');
    
        const postalcode = postalcodeInput.value.trim();
        const housenumber = housenumberInput.value.trim();
    
        // Controleer of beide velden volledig en geldig zijn
        const postalcodeRegex = /^[1-9][0-9]{3}[A-Z]{2}$/;
        if (postalcodeRegex.test(postalcode) && housenumber !== '') {
            // API-aanroep
            fetch(`includes/dashboardIncludes/get_street.php?postalcode=${encodeURIComponent(postalcode)}&housenumber=${encodeURIComponent(housenumber)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        streetInput.value = data.street;
                    } else {
                        alert(data.message || 'Straatnaam niet gevonden. Controleer de invoer.');
                        streetInput.value = '';
                    }
                })
        }
    }
</script>