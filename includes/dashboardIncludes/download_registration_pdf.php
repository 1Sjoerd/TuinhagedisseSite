<?php
    require '../../vendor/dompdf/autoload.inc.php'; // Zorg dat Composer autoload wordt ingeladen
    require '../../templates/dbconnection.php';  // Jouw database connectiebestand
    
    use Dompdf\Dompdf;
    use Dompdf\Options;
    
    // Event-ID ophalen
    if (!isset($_GET['event_id'])) {
        die('Geen evenement ID opgegeven.');
    }
    
    $eventId = intval($_GET['event_id']);
    
    // Ophalen van de titel van het evenement
    $titleQuery = $conn->prepare("
        SELECT title 
        FROM events 
        WHERE id = ?
    ");
    $titleQuery->bind_param('i', $eventId);
    $titleQuery->execute();
    $titleResult = $titleQuery->get_result();
    $titleRow = $titleResult->fetch_assoc();
    
    if (!$titleRow) {
        die('Evenement niet gevonden.');
    }
    
    $eventname = $titleRow['title'];
    
    // Ophalen van de registratievelden
    $eventQuery = $conn->prepare("
        SELECT registration_fields 
        FROM events 
        WHERE id = ?
    ");
    $eventQuery->bind_param('i', $eventId);
    $eventQuery->execute();
    $eventResult = $eventQuery->get_result();
    $event = $eventResult->fetch_assoc();
    
    if (!$event) {
        die('Evenement niet gevonden.');
    }
    
    // Registration fields verwerken
    $registrationFields = array_map('trim', explode(',', $event['registration_fields']));
    
    // Voeg datetime toe aan de lijst van velden als deze niet expliciet aanwezig is
    if (!in_array('datetime', $registrationFields)) {
        $registrationFields[] = 'datetime';
    }

    // Controleer of de velden voor het adres aanwezig zijn
    $hasAddressFields = in_array('street', $registrationFields) && 
                        in_array('postalcode', $registrationFields) && 
                        in_array('housenumber', $registrationFields);

    // Als adresvelden aanwezig zijn, voeg een nieuwe kolom "Adres" toe
    if ($hasAddressFields) {
        $registrationFields = array_diff($registrationFields, ['street', 'postalcode', 'housenumber', 'addition']);
        
        // Plaats "adres" op de gewenste positie
        $adresPosition = -1;
        if (in_array('email', $registrationFields)) {
            $adresPosition = array_search('email', $registrationFields) + 1;
        } elseif (in_array('phone', $registrationFields)) {
            $adresPosition = array_search('phone', $registrationFields) + 1;
        } elseif (in_array('lastname', $registrationFields)) {
            $adresPosition = array_search('lastname', $registrationFields) + 1;
        }
        
        if ($adresPosition !== -1) {
            array_splice($registrationFields, $adresPosition, 0, 'adres');
        } else {
            $registrationFields[] = 'adres';
        }
    }
    
    // Voeg "fullname" toe aan de registratievelden en verwijder de afzonderlijke "firstname" en "lastname"
    $firstnameLastNamePosition = -1;
    if (in_array('firstname', $registrationFields) && in_array('lastname', $registrationFields)) {
        $registrationFields = array_diff($registrationFields, ['firstname', 'lastname']);
        $firstnameLastNamePosition = 0;  // Plaats fullname als eerste kolom
    }
    
    // Voeg de "fullname" kolom toe
    if ($firstnameLastNamePosition === 0) {
        array_splice($registrationFields, $firstnameLastNamePosition, 0, 'Naam');
    }

    // Registraties ophalen
    $query = $conn->prepare("
        SELECT r.firstname, r.lastname, r.phone, r.email, r.street, r.postalcode, 
               r.housenumber, r.addition, r.amount_people, r.groupname, r.datetime
        FROM registrations r
        WHERE r.eventid = ?
    ");
    $query->bind_param('i', $eventId);
    $query->execute();
    $result = $query->get_result();
    $registrations = $result->fetch_all(MYSQLI_ASSOC);
    
    // Vertalingen van registratievelden
    $translations = [
        'firstname' => 'Veurrnaam',
        'lastname'  => 'Achternaam',
        'phone'     => 'Tillefoonnummer',
        'email'     => 'E-Mail',
        'amount_people' => 'Aantal Personen',
        'groupname' => 'Groepsnaam',
        'datetime'  => 'Registratiedatum'
    ];

    // Controleren of er registraties zijn
    if (empty($registrations)) {
        die('Geen registraties gevonden voor dit evenement.');
    }

    // HTML genereren
    $html = '<!DOCTYPE html>
    <html lang="nl">
        <head>
            <meta charset="UTF-8">
            <title>Injrievinge ' . htmlspecialchars($eventname) . '</title>
            <style>
                body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 0; }
                .logo {top: 10px; left: 10px; max-width: 75px; }
                h1 {text-align: center; position: absolute; margin-top: 8px;}
                table { width: 100%; border-collapse: collapse; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2); }
                th { background-color: rgb(43, 148, 53); color: #fff; text-shadow: 2px 2px rgb(16, 90, 24); }
                td { padding: 6px 12px; }
                tr { background: #f6f6f6; }
                tr:nth-of-type(odd) { background: #e9e9e9; }
            </style>
        </head>
        <body>
            <img src="https://vvdetuinhagedisse.nl/assets/images/TuinhagedisseLogo.png" class="logo" />
            <h1>Insjrievinge ' . htmlspecialchars($eventname) . '</h1>
            <table>
                <thead>
                    <tr>';
                    // Dynamisch de kop van de tabel genereren
                    foreach ($registrationFields as $field) {
                        $translatedField = isset($translations[$field]) ? $translations[$field] : ucfirst($field);
                        $html .= '<th>' . htmlspecialchars($translatedField) . '</th>';
                    }
                $html .= '</tr>
                </thead>
                <tbody>';
    
                // Dynamisch de rijen genereren
                foreach ($registrations as $row) {
                    $html .= '<tr>';

                    // Voeg de Naam kolom toe
                    if (in_array('Naam', $registrationFields)) {
                        $fullname = htmlspecialchars(trim($row['firstname'] . ' ' . $row['lastname']));
                        $html .= '<td>' . $fullname . '</td>';
                    }

                    // Voeg de overige velden toe
                    foreach ($registrationFields as $field) {
                        if ($field === 'adres' && $hasAddressFields) {
                            // Combineer de adresvelden
                            $adres = htmlspecialchars(trim(
                                $row['postalcode'] . ', ' . 
                                $row['street'] . ' ' . 
                                $row['housenumber'] . ' ' . 
                                ($row['addition'] ?? '')
                            ));
                            $html .= '<td>' . $adres . '</td>';
                        } elseif ($field !== 'Naam') {  // Vermijd dubbele kolom voor Naam
                            // Gebruik het veld zoals het is
                            $value = isset($row[$field]) ? htmlspecialchars($row[$field]) : '-';
                            $html .= '<td>' . $value . '</td>';
                        }
                    }
                    $html .= '</tr>';
                }
            $html .= '</tbody>
            </table>
        </body>
    </html>';

    // PDF opties instellen
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);
    
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    
    $eventname = str_replace(' ', '_', $eventname);
    
    // PDF downloaden
    $dompdf->stream('Injrievinge_' . $eventname . '.pdf', ['Attachment' => true]);
?>
