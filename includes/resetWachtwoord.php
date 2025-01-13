<style> <?php include './assets/css/standardblock.css'; ?> </style>
<style> <?php include './assets/css/newstemplate.css'; ?> </style>

<?php
// Feedbackvariabele initialiseren
$message = "";

include './templates/dbconnection.php';

// Controleer of er een token is meegegeven
if (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    $message = "Ongeldige token.";
}

// Controleer of de token bestaat en niet is verlopen
$stmt = $conn->prepare("SELECT user_id FROM password_resets WHERE token = ? AND expires_at > NOW()");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    $user_id = $data['user_id'];

    // Controleer of het formulier voor wachtwoordherstel is ingediend
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if ($new_password === $confirm_password) {
            // Hash het nieuwe wachtwoord
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

            // Update het wachtwoord in de gebruikersdatabase
            $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $update_stmt->bind_param("si", $hashed_password, $user_id);
            $update_stmt->execute();

            // Verwijder de gebruikte reset-token
            $delete_stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
            $delete_stmt->bind_param("s", $token);
            $delete_stmt->execute();

            $message = "Je wachtwoord is succesvol bijgewerkt.";
        } else {
            $message = "De wachtwoorden komen niet overeen.";
        }
    }
} else {
    $message = "Ongeldige of verlopen token.";
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
                    <label for="new_password">Nieuw wachtwoord:</label>
                    <input type="password" id="new_password" name="new_password" autocomplete="new-password" required><br><br>
                    <label for="confirm_password">Bevestig wachtwoord:</label>
                    <input type="password" id="confirm_password" name="confirm_password" autocomplete="new-password" required><br><br>
                    <input type="submit" value="Reset">
                </form>
                <div class="message">
                    <?php if (!empty($message)) echo htmlspecialchars($message)."<script>setTimeout (function () {window.location.href = 'index.php';}, 5000);</script>"; ?>
                </div>
            </div>
        </div>
    </div>
</div>