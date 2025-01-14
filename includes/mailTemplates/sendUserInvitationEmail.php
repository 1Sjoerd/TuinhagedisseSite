<?php
// LOKAAL TESTEN NIET MOGELIJK! MAIL WERKT ALLEEN BIJ ONE.COM
$to = $email;

$subject = "Welkom bie VV de Tuinhagedisse";

include 'UserInvitationEmail.php';

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
    $message = "De oetneudiging is verzonden.";
} else {
    $message = "Er is een fout opgetreden bij het versturen van de e-mail.";
}
?>
