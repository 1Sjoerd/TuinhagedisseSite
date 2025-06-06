<?php
    require '../../vendor/dompdf/autoload.inc.php'; // Zorg dat Composer autoload wordt ingeladen
    require '../../templates/dbconnection.php';  // Jouw database connectiebestand
    
    use Dompdf\Dompdf;
    use Dompdf\Options;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $firstname = trim($_POST['firstname'] ?? '');
        $lastname = trim($_POST['lastname'] ?? '');
        $initials = trim($_POST['initials'] ?? '');
        $dob = trim($_POST['dob'] ?? '');
        if ($dob) {
            $dateObj = DateTime::createFromFormat('Y-m-d', $dob);
            if ($dateObj) {
                $dob_for_display = $dateObj->format('d-m-Y'); // Voor PDF
                $dob = $dateObj->format('Y-m-d'); // Voor database
            }
        }
        $street = trim($_POST['street'] ?? '');
        $housenumber = trim($_POST['housenumber'] ?? '');
        $postalcode = trim($_POST['postalcode'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $phoneparent = trim($_POST['phoneparent'] ?? '');
        $emailparent = filter_var($_POST['emailparent'], FILTER_VALIDATE_EMAIL);
        $groep_jeug = $_POST['groep_jeug'] ?? [];
        $groep_groot = $_POST['groep_groot'] ?? [];
        $signatureData = $_POST['signatureData'] ?? '';
    }

    if (!$conn) {
        die('Fout bij verbinden met database: ' . mysqli_connect_error());
    }

    $token = bin2hex(random_bytes(32));
    $stmt = $conn->prepare("INSERT INTO member_enrollments (
        token, firstname, initials, lastname, dob, street, housenumber, postalcode, city, 
        phone, email, phoneparent, emailparent, groupjeug, groupgroot, signature
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die('Fout bij voorbereiden van statement: ' . $conn->error);
    }

   $stmt->bind_param(
        "ssssssssssssssss",
        $token,
        $firstname,
        $initials,
        $lastname,
        $dob,
        $street,
        $housenumber,
        $postalcode,
        $city,
        $phone,
        $email,
        $phoneparent,
        $emailparent,
        json_encode($groep_jeug),
        json_encode($groep_groot),
        $signatureData
    );

    if (!$stmt->execute()) {
        die('Fout bij uitvoeren van statement: ' . $stmt->error);
    }

    $stmt->close();

    $html = '<!DOCTYPE html>
    <html lang="nl">
    <head>
        <meta charset="UTF-8">
        <title>Inschrijfformulier v.v. de Tuinhagedisse</title>
        <style>
            body {
                font-family: DejaVu Sans, sans-serif;
                font-size: 12px;
                padding: 20px;
            }
            h1 {
                text-align: center;
                color: rgb(43, 148, 53);
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }
            td {
                padding: 6px 8px;
                vertical-align: top;
            }
            .label {
                font-weight: bold;
                width: 25%;
                white-space: nowrap;
            }
            .value {
                border-bottom: 1px solid #000;
                width: 25%;
                height: 20px;
                min-height: 20px;
            }
        </style>
    </head>
    <body>
        <img src="https://vvdetuinhagedisse.nl/assets/images/TuinhagedisseLogo.png" alt="Logo" style="height: 60px; float: left; margin-right: 15px;">
        <h1>Inschrijfformulier v.v. de Tuinhagedisse</h1>
        <table>
            <tr>
                <td class="label">Achternaam:</td>
                <td class="value">'. htmlspecialchars($lastname) .'</td>
                <td class="label">Voorletters:</td>
                <td class="value">'. htmlspecialchars($initials) .'</td>
            </tr>
            <tr>
                <td class="label">Voornaam:</td>
                <td class="value">'. htmlspecialchars($firstname) .'</td>
                <td class="label">Geboortedatum:</td>
                <td class="value">'. htmlspecialchars($dob_for_display) .'</td>
            </tr>
            <tr>
                <td class="label">Adres:</td>
                <td class="value">'. htmlspecialchars($street) .' '. htmlspecialchars($housenumber) .'</td>
                <td class="label">Postcode:</td>
                <td class="value">'. htmlspecialchars($postalcode) .'</td>
            </tr>
            <tr>
                <td class="label">Woonplaats:</td>
                <td class="value">'. htmlspecialchars($city) .'</td>
                <td class="label">Telefoonnummer:</td>
                <td class="value">'. htmlspecialchars($phone) .'</td>
            </tr>
            <tr>
                <td class="label">Telefoon ouder/verzorger*:</td>
                <td class="value">'. htmlspecialchars($phoneparent) .'</td>
                <td class="label">E-mailadres:</td>
                <td class="value">'. htmlspecialchars($email) .'</td>
            </tr>
            <tr>
                <td class="label">E-mailadres ouder/verzorger*:</td>
                <td class="value" colspan="3" style="border-bottom: 1px solid #000;">'. htmlspecialchars($emailparent) .'</td>
            </tr>
        </table>
        *Allein van toepassing veur minder jeurige leeje
        <hr>
        <table>
            <tr>
                <td class="label"><strong>Jeugdgroep</strong></td>
                <td class="value">
                    '. (in_array("Jeugraod", $groep_jeug) ? "☑" : "☐") .' Jeugraod<br>
                    '. (in_array("Jeuggarde", $groep_jeug) ? "☑" : "☐") .' Jeuggarde<br>
                    '. (in_array("Crew", $groep_jeug) ? "☑" : "☐") .' Crew
                </td>
            </tr>
            <tr>
                <td class="label"><strong>Grootgroep</strong></td>
                <td class="value">
                    '. (in_array("Begl. jeug", $groep_groot) ? "☑" : "☐") .' Begl. jeug<br>
                    '. (in_array("Raodslid", $groep_groot) ? "☑" : "☐") .' Raodslid<br>
                    '. (in_array("Dansgarde", $groep_groot) ? "☑" : "☐") .' Dansgarde<br>
                    '. (in_array("Aektesse", $groep_groot) ? "☑" : "☐") .' Aektesse<br>
                    '. (in_array("Createam", $groep_groot) ? "☑" : "☐") .' Createam<br>
                    '. (in_array("Overig", $groep_groot) ? "☑" : "☐") .' Overig
                </td>
            </tr>
        </table>
        <hr>
        <p>
            Contribusie seizoen 2022/2023*:</br>
            Jeugd: €….., inclusief circa 8 consumpties</br>
            Volwassenen: €….., geen consumpties</br>
            <i style="font-size: 0.8rem;">*Indeen lid van de jeuggarde én de grote garde, wurd de contribusie voor de jeug aangehaaje.</i>
        </p>

        <p>De statuten en huishoudelijk regelement zeen van toepassing op alle leeje.</p>
        <p>
            <strong>Betaling contribusie:</strong></br>
            Betaling van de jaorlijkse contribusie zól in eine keer plaatsvinje middels ein betaalverzeuk.
            Dit wurd gestuurd nao \'t op dit formulier ingevuld mobiel tillefoonnómmer (veur minderjeurige nao \'t ingevulde tillefoonnómmer van de aojer).</br>
            Indeen dit neet meugelijk is wurd ein passende oplossing gezoch in euverlegk mit de centefoekser.
        </p>
        <table style="margin-top: 30px;">
            <tr>
                <td class="value" style="text-align: bottom; vertical-align: bottom">'. date('d-m-Y') .'</td>      
                <td class="value">
                    '. ($signatureData ? '<img src="' . $signatureData . '" alt="Handtekening" style="height: 150px; width: 300px">' : 'Geen handtekening ontvangen') .'
                </td>
            </tr>
            <tr>
                <td class="label">Datum:</td>
                <td class="label">Handtekening:</td>
            </tr>
        </table>
    </body>
    </html>';

    // PDF opties instellen
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);
    
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait'); // Zet papierformaat en oriëntatie
    
    // PDF bestand genereren
    $dompdf->render();
    
    // PDF output naar een bestand in plaats van direct naar de browser
    $pdfOutput = $dompdf->output();
    
    // Tijdelijk pad om PDF op te slaan
    $tempPdfPath = sys_get_temp_dir() . '/enrollmentform' . uniqid() . '.pdf';
    file_put_contents($tempPdfPath, $pdfOutput);
    
    // E-mailgegevens
    $to = ' . $email . ';
    $subject = 'Nieuwe inschrijving van ' . $firstname . ' ' . $lastname;
    $boundary = md5(uniqid());
    $filename = 'Inschrijving_' . $lastname . '.pdf';
    $headers = [];
    $headers[] = 'From: VV de Tuinhagedisse <no-reply@vvdetuinhagedisse.nl>';
    $headers[] = 'Reply-To: no-reply@vvdetuinhagedisse.nl';
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-Type: multipart/mixed; boundary="' . $boundary . '"';
    
    // Basis HTML boodschap
    $body = "--$boundary\r\n";
    $body .= "Content-Type: text/html; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
    $body .= "<p>Er is een nieuwe inschrijving ontvangen van <strong>$firstname $lastname</strong>.</p>";
    $body .= "<p>De PDF is als bijlage toegevoegd.</p>\r\n";

    $body .= "";
    
    // PDF toevoegen
    $pdfEncoded = chunk_split(base64_encode(file_get_contents($tempPdfPath)));
    $body .= "--$boundary\r\n";
    $body .= "Content-Type: application/pdf; name=\"$filename\"\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n";
    $body .= "Content-Disposition: attachment; filename=\"$filename\"\r\n\r\n";
    $body .= $pdfEncoded . "\r\n";
    $body .= "--$boundary--";
    
    // Versturen
    if (mail($to, $subject, $body, implode("\r\n", $headers))) {
        echo "E-mail met inschrijving succesvol verzonden.";
    } else {
        echo "Fout bij verzenden van e-mail.";
    }
    
    // Opruimen tijdelijk bestand
    unlink($tempPdfPath);
    exit;
?>