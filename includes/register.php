<style> <?php include './assets/css/standardblock.css'; ?> </style>
<style> <?php include './assets/css/newstemplate.css'; ?> </style>

<?php
$message = "";

include './templates/dbconnection.php';

// Controleer de token in de URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Zoek de uitnodiging in de database
    $stmt = $conn->prepare("SELECT email FROM invitations WHERE token = ? AND expires_at > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $email = $data['email'];

        // Controleer of het formulier is ingediend
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $is_active = 1;
            // Voeg de gebruiker toe aan de database
            $insert_user = $conn->prepare("INSERT INTO users (email, password, is_active) VALUES (?, ?, ?)");
            $insert_user->bind_param("ssi", $email, $password, $is_active);
            if ($insert_user->execute()) {
                // Verwijder de uitnodiging
                $delete_invite = $conn->prepare("DELETE FROM invitations WHERE token = ?");
                $delete_invite->bind_param("s", $token);
                $delete_invite->execute();
                
                if ($delete_invite->execute()) {
                    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if ($result->num_rows > 0) {
                        $data = $result->fetch_assoc();
                        $id = $data['id'];
                        $role = "3";
                        
                        $stmt = $conn->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)");
                        $stmt->bind_param("si", $id, $role);
                        if ($stmt->execute()) {
                            $message = "Account is aangemaakt en rol is gekoppeld";
                        } else {
                            $message = "Kon geen role koppelen voor je account. Neem contact op met de beheerder";
                        }
                    }
                }
            } else {
                $message = "Er is een fout opgetreden bij het registreren.";
            }
        }
    } else {
        $message = "Ongeldige of verlopen uitnodiging.";
    }
}
$conn->close();
?>
?>

<div class="block-overview">
    <div class="heading-title">
        <h2 class="block-title">Maak dien wachwoord aan</h2>
    </div>
    <div class="block-text">
        <div class="news-row">
            <div class="news-column-noimg">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="password">Wachwoord:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <input type="submit" value="Aanmake" class="submit-button">
                </form>
                <div class="message">
                    <?php if (!empty($message)) echo htmlspecialchars($message); ?>
                </div>
            </div>
        </div>
    </div>
</div>
