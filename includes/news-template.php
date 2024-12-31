<?php
$eventid = $row['eventid'];
$image_url = htmlspecialchars($row['image_url'], ENT_QUOTES, 'UTF-8');
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
                                <form id='registrationForm' method='POST' action='submit_registration.php'>
                                    <?php
                                    $fields = explode(", ", $row['registration_fields']);
                                    $translations = [
                                        'firstname' => 'Voornaam',
                                        'lastname' => 'Achternaam',
                                        'phone' => 'Telefoonnummer',
                                        'email' => 'E-mail',
                                        'street' => 'Straatnaam',
                                        'postalcode' => 'Postcode',
                                        'housenumber' => 'Huisnummer',
                                        'addition' => 'Toevoeging',
                                        'amount_people' => 'Aantal personen',
                                    ];
                                    foreach ($fields as $field):
                                        $field = htmlspecialchars($field, ENT_QUOTES, 'UTF-8');
                                        $label = $translations[$field] ?? $field;
                                    ?>
                                        <label for="<?= $field ?>"><?= $label ?></label>
                                        <input type="text" id="<?= $field ?>" name="<?= $field ?>">
                                    <?php endforeach; ?>
                                    <input type='hidden' id='eventid' name='eventid' value='<?= $eventid ?>'>
                                    <input type='submit' value='Aanmelden'>
                                </form>
                            </div>
                        </div>
                    <?php endif;
                endif;
                $stmt->close();
            endif; ?>
        </div>
    </div>
</div>