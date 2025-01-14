<?php
// LOKAAL TESTEN NIET MOGELIJK! MAIL WERKT ALLEEN BIJ ONE.COM
$to = $_POST['email'];

$subject = 'Bevestiging aanmelding';

include 'confirmationEmail.php';

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

mail($to, $subject, $message, implode("\r\n", $headers));
?>