<?php
// LOKAAL TESTEN NIET MOGELIJK! MAIL WERKT ALLEEN BIJ ONE.COM
$to = $email;

$subject = "Reset dien wachtwoord";

include 'PasswordResetEmail.php';

// To send HTML mail, the Content-type header must be set
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';
$headers[] = 'From: VV de Tuinhagedisse <no-reply@vvdetuinhagedisse.nl>';

if (mail($to, $subject, $mailmessage, implode("\r\n", $headers))) {
    $message = "Een resetlink is verstuurd naar je e-mailadres.";
    echo "<script>setTimeout(function() { window.location.href = 'index.php'; }, 5000);</script>";
} else {
    $message = "Er is een fout opgetreden bij het versturen van de e-mail.";
}
?>
