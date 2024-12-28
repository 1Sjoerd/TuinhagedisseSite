<style> <?php include './assets/css/standardblock.css'; ?> </style>
<style> <?php include './assets/css/newstemplate.css'; ?> </style>

<?php
// Feedbackvariabele initialiseren
$message = "";

include './templates/dbconnection.php';

// Controleer of het formulier is ingediend
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Controleer of het e-mailadres bestaat in de database
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Gebruiker gevonden, genereer een reset token
        $user = $result->fetch_assoc();
        $user_id = $user['id'];
        $token = bin2hex(random_bytes(32));
        $expires_at = date('Y-m-d H:i:s', strtotime('+2 hours'));

        // Sla het token op in de database
        $stmt = $conn->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $token, $expires_at);
        $stmt->execute();

// AANPASSINGEN NODIG! DIENT NOG HETZELFDE FORMAT TE KRIJGEN ALS DE BEVESTIGINGSMAIL
// Verstuur een e-mail naar de gebruiker
        $reset_link = "TuinhagedisseSite/resetWachtwoord.php?token=$token";

        include './includes/mailTemplates/sendPasswordResetEmail.php';

    } else {
        $message = "Geen account gevonden met dit e-mailadres.";
    }

    $stmt->close();
}

$conn->close();
?>

<div class="block-overview">
    <div class="heading-title">
        <h2 class="block-title">Reset dien wachtwoord</h2>
    </div>
    <div class="block-text">
        <div class="news-row">
            <div class="news-column-noimg">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="email">E-Mail</label>
                        <input type="email" id="email" name="email" placeholder="Vul je e-mail in" required>
                    </div>
                    <input type="submit" value="Reset">
                </form>
                <div class="message">
                    <?php if (!empty($message)) echo htmlspecialchars($message); ?>
                </div>
            </div>
        </div>
    </div>
</div>