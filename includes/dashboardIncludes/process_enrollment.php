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
                $dob = $dateObj->format('d-m-Y');
            }
        }
        $street = trim($_POST['street'] ?? '');
        $housenumber = trim($_POST['housenumber'] ?? '');
        $postalcode = trim($_POST['postalcode'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phoneparent = trim($_POST['phoneparent'] ?? '');
        $emailparent = trim($_POST['emailparent'] ?? '');
        $groep_jeug = $_POST['groep_jeug'] ?? [];
        $groep_groot = $_POST['groep_groot'] ?? [];
        $signatureData = $_POST['signatureData'] ?? '';
    }

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
                <td class="value">'. htmlspecialchars($dob) .'</td>
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
    $dompdf->render();
    
    // PDF bestand genereren
    $dompdf->render();
    
    // PDF output naar een bestand in plaats van direct naar de browser
    $pdfOutput = $dompdf->output();
    
    // Zet de juiste headers voor het downloaden
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="Injrievinge_test.pdf"');
    header('Content-Length: ' . strlen($pdfOutput));
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    // Output de PDF inhoud
    echo $pdfOutput;
    exit;
?>
