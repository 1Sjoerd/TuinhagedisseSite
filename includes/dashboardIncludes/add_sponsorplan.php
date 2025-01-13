<?php
session_start();
include '../../templates/dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['sponsorplanId'];
    $sponsorplan = $_POST['sponsorplanName'];
    $min_amount = $_POST['sponsorplanMinAmount'];
    $max_amount = $_POST['sponsorplanMaxAmount'];
    $info = $_POST['sponsorplanInfo'];
    if (isset($_POST['sponsorplanWebsite'])) {
        $showlogo = 1;
    } else {
        $showlogo = 0;
    }
    
    if ($id) {
        // Update existing sponsorplan item
        $stmt = $conn->prepare("UPDATE sponsorplan SET sponsorplan = ?, min_amount = ?, max_amount = ?, info = ?, showlogo = ? WHERE id = ?");
        $stmt->bind_param("sddsii", $sponsorplan, $min_amount, $max_amount, $info, $showlogo, $id);
        if ($stmt->execute()) {
            error_log("Sponsorplan item updated successfully.");
        } else {
            error_log("Error updating sponsorplan: " . $stmt->error);
        }
    } else {
        // Insert placeholder to get new ID
        $stmt = $conn->prepare("INSERT INTO sponsorplan (sponsorplan, min_amount, max_amount, info, showlogo) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sddsi", $sponsorplan, $min_amount, $max_amount, $info, $showlogo);        
        $stmt->execute();
    }
    $stmt->close();

    header("Location: ../../dashboard.php#sponsorplan-overview");
    exit();
}
?>