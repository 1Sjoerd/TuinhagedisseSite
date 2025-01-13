<style> <?php include './assets/css/standardblock.css'; ?> </style>
<style> <?php include './assets/css/newstemplate.css'; ?> </style>

<?php
$message = "";

include './templates/dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_id = $user['id'];
        $token = bin2hex(random_bytes(32));
        $expires_at = date('Y-m-d H:i:s', strtotime('+2 hours'));

        $stmt = $conn->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $token, $expires_at);
        $stmt->execute();

        $reset_link = "https://vvdetuinhagedisse.nl/resetWachtwoord.php?token=$token";

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
        <h2 class="block-title">Reset dien wachwoord</h2>
    </div>
    <div class="block-text">
        <div class="news-row">
            <div class="news-column-noimg">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="email">E-Mail</label>
                        <input type="email" id="email" name="email" placeholder="Vul dien e-mail in" autocomplete="email" required>
                    </div>
                    <input type="submit" value="Reset" class="submit-button">
                </form>
                <div class="message">
                    <?php if (!empty($message)) echo htmlspecialchars($message); ?>
                </div>
            </div>
        </div>
    </div>
</div>