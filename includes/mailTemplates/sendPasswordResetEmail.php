<?php
// LOKAAL TESTEN NIET MOGELIJK! MAIL WERKT ALLEEN BIJ ONE.COM
$to = $email;

$subject = "Reset dien wachtwoord";

include 'PasswordResetEmail.php';

$headers[] = 'MIME-Version: 1.0';
$headers[] = "Content-Type: text/html; charset=UTF-8";
$headers[] = "Content-Transfer-Encoding: 8bit";
$headers[] = 'From: VV de Tuinhagedisse <no-reply@vvdetuinhagedisse.nl>';
$headers[] = "Reply-To: no-reply@vvdetuinhagedisse.nl";
$headers[] = "X-Mailer: PHP/" . phpversion();
$headers[] = "X-Priority: 3";
$headers[] = "Date: " . date("r");

// Genereer een unieke Message-ID
$message_id = '<' . uniqid('msgid-', true) . '@vvdetuinhagedisse.nl>';
$headers[] = 'Message-ID: ' . $message_id;

if (mail($to, $subject, $mailmessage, implode("\r\n", $headers))) {
    $message = "Een resetlink is verstuurd naar je e-mailadres.";
    echo "<script>setTimeout(function() { window.location.href = 'index.php'; }, 5000);</script>";
} else {
    $message = "Er is een fout opgetreden bij het versturen van de e-mail.";
}
?>
