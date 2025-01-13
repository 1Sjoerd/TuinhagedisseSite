<?php
// Postcode.tech API sleutel
define('POSTCODE_TECH_API_KEY', '8406e1e3-85b1-4ae5-babb-84288a601db4');

// Controleer of de juiste parameters zijn meegegeven
if (!isset($_GET['postalcode'], $_GET['housenumber'])) {
    echo json_encode(['success' => false, 'message' => 'Ongeldige invoer.']);
    exit;
}

$postalcode = htmlspecialchars($_GET['postalcode']);
$housenumber = htmlspecialchars($_GET['housenumber']);

// Valideer de invoer
if (!preg_match('/^[1-9][0-9]{3}[A-Z]{2}$/', $postalcode) || !is_numeric($housenumber)) {
    echo json_encode(['success' => false, 'message' => 'Ongeldige postcode of huisnummer.']);
    exit;
}

// Maak de API-aanroep
$apiUrl = "https://postcode.tech/api/v1/postcode?postcode=$postalcode&number=$housenumber";
$ch = curl_init($apiUrl);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . POSTCODE_TECH_API_KEY,
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    $data = json_decode($response, true);
    if (isset($data['street'])) {
        echo json_encode(['success' => true, 'street' => $data['street']]);
    }
}
?>