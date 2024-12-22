<style> <?php include './assets/css/standardblock.css'; ?> </style>
<style> <?php include './assets/css/newstemplate.css'; ?> </style>

<div class="block-overview">
    <div class="heading-title">
        <h2 class="block-title"> <?= $row["title"] ?> </h2>
    </div>
    <div class="block-text">
        <div class="news-row">
        <?php
            $eventid = $row['eventid'];
            if ($row['image_url'] != '') {
                echo "<div class='news-column'>";
                    echo "<img src='".$row["image_url"]."' alt='".$row["title"]."'>";
                echo "</div>";
                echo "<div class='news-column'>";
                    echo $row["text"];
                echo "</div>";
            } else {
                echo "<div class='news-column-noimg'>".$row["text"]."</div>";
            }
            if ($row['eventid'] != '') {
                $sql = "SELECT `registration_needed`, `registration_fields`, `registration_enddate` FROM `events` WHERE id = ".$row["eventid"]."";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                if ($row['registration_needed'] != '0' && strtotime($row['registration_enddate']) > time()) {
                    echo "</div>";
                    echo "<div class='news-row'>";
                        echo "<div class='news-column-noimg'>";
                            echo "<form id='registrationForm' method='POST' action='submit_registration.php'>";
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
                                    'groupname' => 'Groepsnaam',
                                    // Add more translations as needed
                                ];
                                
                                foreach ($fields as $field) {
                                    $dutchField = isset($translations[$field]) ? $translations[$field] : $field;
                                    if ($field == 'postalcode' || $field == 'housenumber' || $field == 'addition') {
                                        if ($field == 'postalcode') {
                                            echo "<div class='form-row'>";
                                        }
                                        echo "<div class='form-group'>";
                                        echo "<label for='".$field."'>".$dutchField.": </label>";
                                        if ($field == 'postalcode') {
                                            echo "<input type='text' id='".$field."' name='".$field."' placeholder='".($field == 'postalcode' ? '1234AB' : '')."' pattern='".($field == 'postalcode' ? '^[1-9][0-9]{3}[A-Z]{2}$' : '')."' title='".($field == 'postalcode' ? 'Voer een geldige Nederlandse postcode in (bijv. 1234AB)' : '')."' required>";
                                        }
                                        if ($field == 'housenumber') {
                                            echo "<input type='number' id='".$field."' name='".$field."' required>";
                                        }
                                        if ($field == 'addition') {
                                            echo "<input type='text' id='".$field."' name='".$field."'>";
                                        }
                                        echo "</div>";
                                        if ($field == 'addition') {
                                            echo "</div>";
                                        }
                                    } else {
                                        echo "<label for='".$field."'>".$dutchField.": </label>";
                                        if ($field == 'phone') {
                                            echo "<input type='tel' id='".$field."' name='".$field."' placeholder='06-12345678' pattern='^06[0-9]{8}$' title='Voer een geldig Nederlands mobiel nummer in (bijv. 0612345678)' required><br>";
                                        } elseif ($field == 'email') {
                                            echo "<input type='email' id='".$field."' name='".$field."' required><br>";
                                        } elseif ($field == 'amount_people') {
                                            echo "<input type='number' id='".$field."' name='".$field."' value='1' required><br>";
                                        } else {
                                            echo "<input type='text' id='".$field."' name='".$field."' required><br>";
                                        }
                                    }
                                }
                                echo "<input type='hidden' id='eventid' name='eventid' value='".$eventid."'>";
                                echo "<input type='submit' value='Aanmelden'>";
                            echo "</form>";
                        echo "</div>";
                    echo "</div>";
                }
            }
        ?>
        </div>
    </div>
</div>