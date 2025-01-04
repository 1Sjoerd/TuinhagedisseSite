<?php
session_start();
include '../../templates/dbconnection.php';

// Increase memory limit at the beginning of the script
ini_set('memory_limit', '256M');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['eventId'];
    $title = $_POST['eventTitle'];
    $location = $_POST['eventLocation'];
    $date = $_POST['eventDate'];
    $registration_enddate = !empty($_POST['eventRegistration_enddate']) ? $_POST['eventRegistration_enddate'] : null;


    if (isset($_POST['eventRegistration_needed'])) {
        $registration_needed = "1";
        
        if (isset($_POST['eventRegistration_fields']) && is_array($_POST['eventRegistration_fields'])) {
            // Haal de waarden van de geselecteerde checkboxes op
            $registration_fields = $_POST['eventRegistration_fields'];
    
            // Controleer of "adres" is geselecteerd en voeg de extra velden toe
            if (in_array('adres', $registration_fields)) {
                $registration_fields = array_merge(
                    $registration_fields, 
                    ['postalcode', 'housenumber', 'addition', 'street']
                );
                // Verwijder "adres" als je alleen de subvelden wilt tonen
                $registration_fields = array_diff($registration_fields, ['adres']);
            }
    
            // Combineer de waarden in een komma-gescheiden string
            $registration_fields_string = implode(', ', $registration_fields);
        } else {
            $registration_fields = NULL;
        }
        
    } else {
        $registration_needed = "0";
        $registration_enddate = NULL;
        $registration_fields_string = NULL;
    }
    
    
    if ($id) {
        // Update existing news item
        $stmt = $conn->prepare("UPDATE events SET title = ?, location = ?, date = ?, registration_needed = ?, registration_fields = ?, registration_enddate = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $title, $location, $date, $registration_needed, $registration_fields_string, $registration_enddate, $id);
        if ($stmt->execute()) {
            error_log("Event item updated successfully.");
        } else {
            error_log("Error updating event item: " . $stmt->error);
        }
    } else {
        // Insert placeholder to get new ID
        $stmt = $conn->prepare("INSERT INTO events (title, location, date, registration_needed, registration_fields, registration_enddate) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $title, $location, $date, $registration_needed, $registration_fields_string, $registration_enddate);        
        $stmt->execute();
        $id = $stmt->insert_id;
    }
    $stmt->close();

    header("Location: ../../dashboard.php");
    exit();
}
?>