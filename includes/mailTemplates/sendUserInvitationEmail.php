<?php
// LOKAAL TESTEN NIET MOGELIJK! MAIL WERKT ALLEEN BIJ ONE.COM
$to = $email;

$subject = "Welkom bie VV de Tuinhagedisse";

include 'UserInvitationEmail.php';

// To send HTML mail, the Content-type header must be set
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';
$headers[] = 'From: VV de Tuinhagedisse <no-reply@vvdetuinhagedisse.nl>';

if (mail($to, $subject, $mailmessage, implode("\r\n", $headers))) {
    $message = "De oetneudiging is verzonden.";
} else {
    $message = "Er is een fout opgetreden bij het versturen van de e-mail.";
}
?>
