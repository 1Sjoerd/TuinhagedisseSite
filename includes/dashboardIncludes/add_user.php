<?php
session_start();
include '../../templates/dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $token = bin2hex(random_bytes(32));
    $expires_at = date('Y-m-d H:i:s', strtotime('+7 days'));
    $user_id = $_SESSION['user_id'];

    if ($email) {
        $stmt = $conn->prepare("INSERT INTO invitations (email, token, expires_at, created_by) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $email, $token, $expires_at, $user_id);

        if ($stmt->execute()) {
            $invite_link = "https://vvdetuinhagedisse.nl/register.php?token=$token";

            include '../../includes/mailTemplates/sendUserInvitationEmail.php';
        } else {
            echo "Kon de uitnodiging niet toevoegen.";
        }
    } else {
        echo "Ongeldig e-mailadres.";
    }
}

$stmt->close();

header("Location: ../../dashboard.php");
exit();
?>