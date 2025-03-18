<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Controleer of het bestand bestaat voordat het wordt geïncludeerd
$tcpdfPath = 'TCPDF-main/tcpdf.php'; // Het juiste pad naar het TCPDF-bestand

if (!file_exists($tcpdfPath)) {
    die("TCPDF bestand niet gevonden op het opgegeven pad: $tcpdfPath");
}

require_once($tcpdfPath);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $surfaces = $_POST['surface'];
    $paints = $_POST['paint'];
    $locations = $_POST['location'];
    $last_maintenances = $_POST['last_maintenance'];
    $next_maintenances = $_POST['next_maintenance'];
    $next_controls = $_POST['next_control'];

    // Create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Herschildering & Controle Tool');
    $pdf->SetTitle('Onderhoudsschema');
    $pdf->SetSubject('Onderhoudsschema PDF');
    $pdf->SetKeywords('TCPDF, PDF, onderhoud, calculator');

    // Add a page and set margins to remove the top margin
    $pdf->AddPage();
    $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);  // Adjust the top margin here

    // Set some content to print
    $html = "<h1>Onderhoudsschema</h1>";

    foreach ($surfaces as $index => $surface) {
        $html .= "
        <table border=\"0\" cellpadding=\"4\">
            <tr>
                <td colspan=\"2\"><strong>$surface</strong></td>
                <td style=\"text-align:right;\"><strong>{$locations[$index]}</strong></td>
            </tr>
            <tr>
                <td colspan=\"3\">Verfsoort: {$paints[$index]}</td>
            </tr>
            <tr>
                <td>Laatste onderhoudsdatum: {$last_maintenances[$index]}</td>
            </tr>
            <tr>
                <td colspan=\"2\"><strong>Controle & Onderhoud</strong></td>
            </tr>
            <tr>
                <td>Volgende controledatum: {$next_controls[$index]}</td>
                <td>Volgende onderhoudsdatum: {$next_maintenances[$index]}</td>
            </tr>
        </table>
        <br><hr><br>";
    }

    // Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

    // Close and output PDF document
    $pdf->Output('onderhoudsschema.pdf', 'D');
}
?>
