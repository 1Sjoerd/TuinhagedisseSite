<?php
// LOKAAL TESTEN NIET MOGELIJK! MAIL WERKT ALLEEN BIJ ONE.COM
// Multiple recipients
$to = $_POST['email']; // note the comma

// Subject
$subject = 'Bevestiging aanmelding';

include 'confirmationEmail.php';

// To send HTML mail, the Content-type header must be set
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';
$headers[] = 'From: VV de Tuinhagedisse <no-reply@vvdetuinhagedisse.nl>';

// Mail it
mail($to, $subject, $message, implode("\r\n", $headers));
?>
