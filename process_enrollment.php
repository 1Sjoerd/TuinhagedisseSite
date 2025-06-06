<?php
    require 'vendor/dompdf/autoload.inc.php'; // Zorg dat Composer autoload wordt ingeladen
    require 'templates/dbconnection.php';  // Jouw database connectiebestand
    
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
    $to = $email;
    if (!empty($emailparent)) {
        $to .= ', ' . $emailparent;
    }

    $subject = 'Bedank veur dien inschrieving ' . $firstname;
    $boundary = md5(uniqid());
    $filename = 'Insjriefformulier_' . $firstname . '_' . $lastname . '.pdf';
    $headers = [];
    $headers[] = 'From: "VV de Tuinhagedisse" <no-reply@vvdetuinhagedisse.nl>';
    $headers[] = 'Reply-To: no-reply@vvdetuinhagedisse.nl';
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-Type: multipart/mixed; boundary="' . $boundary . '"';
    
    $htmlMail = '<!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <meta name="viewport" content="width=device-width">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>Mail</title>
            <style type="text/css">
                html, body {
                    margin: 0 !important;
                    padding: 0 !important;
                    height: 100% !important;
                    width: 100% !important;
                }
                * {
                    -ms-text-size-adjust: 100%;
                    -webkit-text-size-adjust: 100%;
                }
                .ExternalClass {
                    width: 100%;
                }
                div[style*="margin: 16px 0"] {
                    margin: 0 !important;
                }
                table, td {
                    mso-table-lspace: 0pt !important;
                    mso-table-rspace: 0pt !important;
                }
                table {
                    border-spacing: 0 !important;
                    border-collapse: collapse !important;
                    table-layout: fixed !important;
                }
                table table table {
                    table-layout: auto;
                }
                img {
                    -ms-interpolation-mode: bicubic;
                }
                .yshortcuts a {
                    border-bottom: none !important;
                }
                a[x-apple-data-detectors] {
                    color: inherit !important;
                }
                .button-td, .button-pink {
                    transition: all 100ms ease-in;
                }
                .button-pink:hover {
                    background: #cd016a !important;
                    border-color: #cd016a !important;
                }
                .hide {
                    display:block !important;
                }
                .hide-on-client{
                    display: none !important;
                }
                .margin-0-auto{
                    margin: 0 auto !important;
                }
                .image-hover:hover>img {
                    display: none !important;
                }
    
                .image-hover:hover .hover {
                    display: block !important;
                }
                    
                #MessageViewBody .hide{
                    display: none !important;
                }
                #MessageViewBody .hide-on-client{
                    display: inline-block !important;
                }
    
                @media screen and (max-width: 650px) {
                .fluid, .fluid-centered {
                    width: 100% !important;
                    max-width:458px!important;
                    height: auto !important;
                    margin-left: auto !important;
                    margin-right: auto !important;
                }
                .fluid-centered {
                    margin-left: auto !important;
                    margin-right: auto !important;
                }
                .stack-column {
                    display: block !important;
                    width: 100% !important;
                    max-width: 100% !important;
                    direction: ltr !important;
                }
                .center-on-narrow {
                    display: block !important;
                    margin-left: auto !important;
                    margin-right: auto !important;
                    float: none !important;
                }
                table.center-on-narrow {
                    display: inline-block !important;
                }
                .text-align-left {
                    text-align: left !important;
                }
                .float-left {
                    float: left !important;
                }
                .hide {
                    display:none !important; 
                    height: 0 !important; 
                    width: 0 !important; 
                    max-height: 0 !important;
                }
                .hide-on-client {
                    display: block!important;
                    max-width: 100%!important;
                    width:100%!important;
                }
                .auto-height {
                    height: auto !important;
                }
                    
    
                /* Padding specific */
                    /* Padding top */
                    .mob-padding-top-32 {
                        padding-top:32px!important;
                    }
                    .mob-padding-top-16 {
                        padding-top:16px!important;
                    }
                    .mob-padding-top-24 {
                        padding-top:24px!important;
                    }
                    .mob-padding-top-48 {
                        padding-top:48px!important;
                    }
                    .mob-padding-top-0 {
                        padding-top:0px!important;
                    }
                    /* Padding bottom */
                    .mob-padding-bottom-32 {
                        padding-bottom:32px!important;
                    }
                    .mob-padding-bottom-16 {
                        padding-bottom:16px!important;
                    }
                    .mob-padding-bottom-24 {
                        padding-bottom:24px!important;
                    }
                    .mob-padding-bottom-48 {
                        padding-bottom:48px!important;
                    }
                    .mob-padding-bottom-0 {
                        padding-bottom:0px!important;
                    }
                    /* Padding left */
                    .mob-padding-left-32 {
                        padding-left:32px!important;
                    }
                    .mob-padding-left-16 {
                        padding-left:16px!important;
                    }
                    .mob-padding-left-24 {
                        padding-left:24px!important;
                    }
                    .mob-padding-left-48 {
                        padding-left:48px!important;
                    }
                    .mob-padding-left-0 {
                        padding-left:0px!important;
                    }
                    /* Padding right */
                    .mob-padding-right-32 {
                        padding-right:32px!important;
                    }
                    .mob-padding-right-16 {
                        padding-right:16px!important;
                    }
                    .mob-padding-right-24 {
                        padding-right:24px!important;
                    }
                    .mob-padding-right-48 {
                        padding-right:48px!important;
                    }
                    .mob-padding-right-0 {
                        padding-right:0px!important;
                    }
                    
                    /* Padding vertical/horizontal/all */
                    /* Padding horizontal */
                    .mob-padding-h-32 {
                        padding-left:32px!important;
                        padding-right:32px!important;
                    }
                    .mob-padding-h-16 {
                        padding-left:16px!important;
                        padding-right:16px!important;
                    }
                    .mob-padding-h-24 {
                        padding-left:24px!important;
                        padding-right:24px!important;
                    }
                    .mob-padding-h-48 {
                        padding-left:48px!important;
                        padding-right:48px!important;
                    }
                    .mob-padding-h-0 {
                        padding-left:0px!important;
                        padding-right:0px!important;
                    }
                    .mob-padding-h-4 {
                        padding-left: 4px !important;
                        padding-right: 4px !important;
                    }
                    /* Padding vertical */
                    .mob-padding-v-32 {
                        padding-top:32px!important;
                        padding-bottom:32px!important;
                    }
                    .mob-padding-v-16 {
                        padding-top:16px!important;
                        padding-bottom:16px!important;
                    }
                    .mob-padding-v-24 {
                        padding-top:24px!important;
                        padding-bottom:24px!important;
                    }
                    .mob-padding-v-48 {
                        padding-top:48px!important;
                        padding-bottom:48px!important;
                    }
                    .mob-padding-v-0 {
                        padding-top:0px!important;
                        padding-bottom:0px!important;
                    }
                    /* Padding all sides */
                    .mob-padding-all-32 {
                        padding-top:32px!important;
                        padding-bottom:32px!important;
                        padding-left:32px!important;
                        padding-right:32px!important;
                    }
                    .mob-padding-all-16 {
                        padding-top:16px!important;
                        padding-bottom:16px!important;
                        padding-left:16px!important;
                        padding-right:16px!important;
                    }
                    .mob-padding-all-24 {
                        padding-top:24px!important;
                        padding-bottom:24px!important;
                        padding-left:24px!important;
                        padding-right:24px!important;
                    }
                    .mob-padding-all-48 {
                        padding-top:48px!important;
                        padding-bottom:48px!important;
                        padding-left:48px!important;
                        padding-right:48px!important;
                    }
                    .mob-padding-all-0 {
                        padding-top:0px!important;
                        padding-bottom:0px!important;
                        padding-left:0px!important;
                        padding-right:0px!important;
                    }
                    
                    /* Mob font-size */
                    .mob-font-size-10 {
                        font-size: 10px !important;
                        line-height: 16px !important;
                    }
                    .mob-font-size-16 {
                        font-size: 16px !important;
                        line-height: 24px !important;
                    }
                    .mob-font-size-24 {
                        font-size: 24px !important;
                        line-height: 32px !important;
                    }
                    /* Mob Height */
                    .mob-height-32{
                        height:32px!important;
                    }
                }
    
                @media screen and (max-width: 340px) {
                .no-horizontal-padding {
                    padding-left: 0 !important;
                    padding-right: 0 !important;
                }
                }
                    
                td ul, 
                td ol{
                    text-align: left; 
                    font-family:Arial, Helvetica, sans-serif; 
                    color:#000000; 
                    font-size: 16px;
                    line-height: 22px;
                    padding-inline-start: 10px;
                    -webkit-padding-start: 20px;
                }
                td ul li,
                td ol li{
                    list-style-position: outside; 
                }
    
                td ul, 
                td ol{
                    margin:0 !important;
                    padding: 0 0 0 25px;
                    display: block;
    
                }
                td ul li,
                td ol li{
                    margin: 0;
                    padding: 3px 5px 3px 5px;
                }
            </style>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        </head>
        <body class="body" width="100%" bgcolor="#f0f0f0" style="margin: 0;font-size:16px;color:#000000;font-family: "Helvetica", "Arial", sans-serif;font-weight: 400;" yahoo="yahoo">    
            <center style="width: 100%; background-color: #F0F0F0; text-align: left;">
                <div style="max-width: 680px; margin: auto;" class="email-container">
                    <table name="header full" cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#f0f0f0">
                        <tr>
                            <td>
                                <center style="width: 100%;">
                                    <div style="max-width: 650px;">
                                        <span style="display: none; font-size: 1px; color: #ffffff; max-height: 0; max-width: 0; opacity: 0; overflow: hidden;">
                                            Beste '. htmlspecialchars($firstname) .', Bedankt veur dien insjrieving bie V.V. de Tuinhagedisse! We höbbe dien formulier good ontvangen. Dien insjrieving is nog onger veurbehoud en wurd eers beoordeild door ozze sikkertaris.
                                        </span>

                                        <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff" width="100%" style="max-width: 650px;">
                                            <tr>
                                                <td width="100%" align="center">
                                                    <a title="Subject" target="_blank" href="https://www.vvdetuinhagedisse.nl/">
                                                        <img src="https://vvdetuinhagedisse.nl/assets/images/mailheader.png" alt="VVTH" width="650" border="0" style="width: 100%; max-width: 650px; height: auto;">
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </center>
                            </td>
                        </tr>
                    </table>
                    <table name="text left aligned" cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#f0f0f0" style="border-collapse:collapse;">
                        <tbody>
                            <tr>
                                <td>
                                    <center style="width: 100%;">
                                        <div style="max-width: 650px;">
                                            <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff" width="100%" style="max-width: 650px;">
                                                <tbody>
                                                    <tr>
                                                        <td width="100%" style="max-width: 650px;padding:24px 32px; text-align: left; font-family: "Helvetica", "Arial", sans-serif; color:#000000; font-size: 16px;line-height: 1.4;" class="mob-padding-h-16">
                                                            <table class="margin-0-auto" cellpadding="0" cellspacing="0" border="0" width="458" style="width: 100%; max-width: 458px;">
                                                                <tr>
                                                                    <td align="left">
                                                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="center" valign="top" style="text-align: left;padding-top:32px;font-size:16px;color:#000000;font-family: "Helvetica", "Arial", sans-serif;font-weight: 700;line-height: 1.5;">
                                                                                        <p style="margin: 0;">Beste '. htmlspecialchars($firstname) .',</p>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td align="center" valign="top" style="text-align: left;padding:16px 0 0;font-size:16px;color:#000000;font-family: "Helvetica", "Arial", sans-serif;font-weight: 400;line-height: 1.5;mso-line-height-alt:110%">
                                                                                        <p style="margin: 0;">
                                                                                            Bedank veur dien insjrieving bie <strong>V.V. de Tuinhagedisse!</strong> We höbbe dien formulier good ontvangen. Dien insjrieving is nog <strong>onger veurbehoud</strong> en wurd eers beoordeild door ozze sikkertaris. PS: We höbbe un kopie van \'t insjriefformulier es bielage mit gestuurd.<br><br>
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </center>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table name="intro left aligned" cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#f0f0f0" style="border-collapse:collapse;">
                        <tbody>
                            <tr>
                                <td>
                                    <center style="width: 100%;">
                                        <div style="max-width: 650px;">
                                            <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff" width="100%" style="max-width: 650px;">
                                                <tbody>
                                                    <tr>
                                                        <td bgcolor="#d5f0d8" width="100%" style="max-width: 650px;padding:24px 32px; text-align: left; font-family: "Helvetica", "Arial", sans-serif; color:#000000; font-size: 16px;line-height: 1.4;" class="mob-padding-h-16">
                                                            <table class="margin-0-auto" cellpadding="0" cellspacing="0" border="0" width="458" style="width: 100%; max-width: 458px;">
                                                                <tr>
                                                                    <td align="left">
                                                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td colspan="3" align="center" valign="top" style="text-align: left;padding:0 0 16px 0;font-size: 24px; line-height: 32px;color:#000000;font-family: "Helvetica", "Arial", sans-serif;font-weight: 400;">Waat kinse verwachte?</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td colspan="3" style="font-family: sans-serif; font-size: 0.9em; line-height: 140%; color: #000000; padding: 0px 20px 5px 0;">
                                                                                        - Binne inkele dage kriegse berich of dien insjrieving is goodgekeurd.
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td colspan="3" style="font-family: sans-serif; font-size: 0.9em; line-height: 140%; color: #000000; padding: 0px 20px 5px 0;">
                                                                                        - Bie goodkeuring ontvangse un betaalverzoek veur de contribusie.
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </center>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table name="intro left aligned" cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#f0f0f0" style="border-collapse:collapse;">
                        <tbody>
                            <tr>
                                <td>
                                    <center style="width: 100%;">
                                        <div style="max-width: 650px;">
                                            <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff" width="100%" style="max-width: 650px;">
                                                <tbody>
                                                    <tr>
                                                        <td width="100%" style="max-width: 650px;padding:24px 32px; text-align: left; font-family: "Helvetica", "Arial", sans-serif; color:#000000; font-size: 16px;line-height: 1.4;" class="mob-padding-h-16">
                                                            <table class="margin-0-auto" cellpadding="0" cellspacing="0" border="0" width="458" style="width: 100%; max-width: 458px;">
                                                                <tr>
                                                                    <td align="left">
                                                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="center" valign="top" style="text-align: left;padding:8px 0;font-size:16px;color:#000000;font-family: "Helvetica", "Arial", sans-serif;font-weight: 400;line-height: 1.5;mso-line-height-alt:120%">
                                                                                        <p style="margin: 0 0 10px 0; font-size: 15px; font-weight: bold; line-height: 140%;">
                                                                                            Vraoge?
                                                                                        </p>
                                                                                        <p>
                                                                                            Höbse nog vraoge? Naem dan kóntak mit os op: <a style="color: #1063AD; text-decoration: underline;" href="https://www.vvdetuinhagedisse.nl/kontak">vvdetuinhagedisse.nl/kontak</a>. Veer helpe dich gaer verder.
                                                                                            <br>
                                                                                            <br>
                                                                                        </p>
                                                                                        <p style="margin: 0; line-height: 200%;">
                                                                                            Mit vriendelijke groeten,<br>
                                                                                            V.V. De Tuinhagedisse
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </center>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table name="footer commercial" cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#f0f0f0" style="border-collapse:collapse;">
                        <tbody>
                            <tr>
                                <td>
    			                    <center style="width: 100%;">
    			                        <div style="max-width: 650px;">
                                            <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#2b9435" width="100%" style="max-width: 650px;">
                                                <tbody>
                                                    <tr>
                                                        <td width="100%" style="padding:32px 96px;" class="mob-padding-h-16">
                                                            <table class="fluid-centered" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="left" valign="center" style="text-align: center; font-weight: 400;line-height: 16px;font-size: 10px;color:#ffffff;">
                                                                            Dit is ein automatische service mail, wao op\'se neet rechtstreeks kins reageren.
                                                                        </td>
                                                                    </tr>
    								                            </tbody>
    							                            </table>
    							                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="100%" style="max-width: 650px;padding:0 32px 0; text-align: left;" class="mob-padding-h-16">
                                                            <table class="fluid-centered margin-0-auto" cellpadding="0" cellspacing="0" border="0" width="586" style="width: 100%; max-width: 586px;">
                                                                <tr>
                                                                    <td align="left" style="border-top:1px solid #ffffff;padding: 32px 0 0;">
                                                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="center" valign="top">
                                                                                        <table class="margin-0-auto" cellpadding="0" cellspacing="0" border="0" width="160" style="width: 100%; max-width: 160px;mso-padding-right-alt:1px;">
                                                                                            <tr>
                                                                                                <td align="center" style="padding:0 4px;">
                                                                                                    <a title="Facebook" target="_blank" href="https://www.facebook.com/vvdetuinhagedisse"><i class="fa fa-facebook fa-2x" style="color: #ffffff;"></i></a>
                                                                                                </td>
                                                                                                <td align="center" style="padding:0 4px;">
                                                                                                    <a title="Instagram" target="_blank" href="https://www.instagram.com/vvdetuinhagedisse/"><i class="fa fa-instagram fa-2x" style="color: #ffffff;"></i></a>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
    						                        <tr>
    							                        <td width="100%" style="padding:32px 96px;" class="mob-padding-h-16">
    							                            <table class="fluid-centered" cellspacing="0" cellpadding="0" border="0" width="100%">
    								                            <tbody>
    									                            <tr>
                                                                        <td align="left" valign="center" style="text-align: center; font-weight: 400;line-height: 16px;font-size: 12px;color:#ffffff;">
                                                                            V.V. De Tuinhagedisse, Op het Schoor 23, 6041 AV, Roermond, KvK 13042234
                                                                        </td>
    									                            </tr>
    								                            </tbody>
    							                            </table>
                                                        </td>
    						                        </tr>
    					                        </tbody>
    				                        </table>
    			                        </div>
    			                    </center>
    			                </td>
    		                </tr>
    	                </tbody>
                    </table>
                </div>
            </center>
        </body>
    </html>';
    
    
    $pdfEncoded = chunk_split(base64_encode(file_get_contents($tempPdfPath)));

    $body = "--$boundary\r\n";
    $body .= "Content-Type: text/html; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
    $body .= $htmlMail . "\r\n";
    
    $body .= "--$boundary\r\n";
    $body .= "Content-Type: application/pdf; name=\"$filename\"\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n";
    $body .= "Content-Disposition: attachment; filename=\"$filename\"\r\n\r\n";
    $body .= $pdfEncoded . "\r\n";
    $body .= "--$boundary--\r\n";

    // Versturen
    if (mail($to, $subject, $body, implode("\r\n", $headers))) {
        $confirmationtitle = "Bevestiging insjrieving";
        $confirmationtext = "Dien insjrieving is succesvol bie os aangekomme!</br>Veer zólle dit auch per mail bevestigen.</br></br>Binnen enkele ogenblikke keerse automatisch teruk nao de homepagina.";
        include './confirmationTemplate.php';
    } else {
        
        $confirmationtitle = "ERROR!";
        $confirmationtext = "D'r is helaas get misgegaon mit dien insjrieving :(</br>Wilse estebleef kontak mit os opnaeme?</br></br>Binnen enkele ogenblikke keerse automatisch teruk nao de homepagina.";
        include './confirmationTemplate.php';
    }
    // Opruimen tijdelijk bestand
    unlink($tempPdfPath);
?>