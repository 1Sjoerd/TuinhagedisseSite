<?php
include '../../templates/dbconnection.php';

if (isset($_GET['firstname'])) {
    $firstname = $conn->real_escape_string($_GET['firstname']);

    // Zoek naar bestaande prinsen met dezelfde of soortgelijke naam
    $query = "SELECT COUNT(*) as count FROM jeugdprinse WHERE firstname LIKE ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $firstname);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $count = $row['count'];
    $number = $count + 1; // Romeins cijfer berekenen op basis van aantal bestaande prinsen

    // Converteer naar Romeins cijfer
    function toRoman($num) {
        $map = [
            'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
            'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
            'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1,
        ];
        $roman = '';
        foreach ($map as $romanNum => $value) {
            while ($num >= $value) {
                $roman .= $romanNum;
                $num -= $value;
            }
        }
        return $roman;
    }

    echo json_encode(['romanNumber' => toRoman($number)]);
}