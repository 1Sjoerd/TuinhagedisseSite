<?php
include './templates/dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fields = ['firstname', 'lastname', 'phone', 'email', 'street', 'postalcode', 'housenumber', 'addition', 'amount_people', 'groupname', 'eventid'];
    $data = [];
    $columns = [];
    $values = [];
    
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            $data[$field] = $conn->real_escape_string($_POST[$field]);
            $columns[] = $field;
            $values[] = "'" . $data[$field] . "'";
        }
    }

    if (!empty($columns)) {
        $sql = "INSERT INTO registrations (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $values) . ")";
        if ($conn->query($sql) === TRUE) {
            include 'conformationEmail.php';
        } else {
            echo $values."<br>";
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "No data to insert.";
    }

    $conn->close();
}
?>