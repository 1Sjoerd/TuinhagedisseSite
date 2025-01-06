<?php
include '../../templates/dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = intval($_POST['user_id']);
    $roleId = intval($_POST['role_id']);

    // Controleer of de input geldig is
    if ($userId > 0 && $roleId > 0) {
        // Gebruik INSERT met ON DUPLICATE KEY UPDATE
        $query = $conn->prepare("
            INSERT INTO user_roles (user_id, role_id)
            VALUES (?, ?)
            ON DUPLICATE KEY UPDATE role_id = VALUES(role_id)
        ");

        $query->bind_param("ii", $userId, $roleId);

        if ($query->execute()) {
            echo "Rol succesvol bijgewerkt!";
        } else {
            echo "Er is een fout opgetreden: " . $conn->error;
        }
    } else {
        echo "Ongeldige invoer.";
    }
} else {
    echo "Ongeldige methode.";
}
?>