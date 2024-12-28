<?php
$message = "";

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    echo "<script>window.location.href = 'index.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include './templates/dbconnection.php';

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $stmt = $conn->prepare("
        SELECT users.id, users.password, user_roles.role_id 
        FROM users 
        JOIN user_roles ON users.id = user_roles.user_id 
        WHERE users.email = ? AND users.is_active = 1
    ");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Set user ID and role
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role_id'];
            echo "<script>window.location.href = 'dashboard.php';</script>";
            exit();
        } else {
            // Destroy session on failed login
            session_destroy();
            $message = "Ongeldige inloggegevens.";
        }
    } else {
        // Destroy session on failed login
        session_destroy();
        $message = "Ongeldige inloggegevens.";
    }

    $stmt->close();
    $conn->close();
}
?>

<style> <?php include './assets/css/standardblock.css'; ?> </style>
<style> <?php include './assets/css/newstemplate.css'; ?> </style>

<div class="block-overview">
    <div class="heading-title">
        <h2 class="block-title">Inloggen</h2>
    </div>
    <div class="block-text">
        <div class="news-row">
            <div class="news-column-noimg">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="email">E-Mail</label>
                        <input type="email" id="email" name="email" placeholder="Vul je e-mail in" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Wachtwoord</label>
                        <input type="password" id="password" name="password" placeholder="Vul je wachtwoord in" required>
                    </div>
                    <input type="submit" value="Inloggen">
                </form>
                <div class="message">
                    <?php if (!empty($message)) echo htmlspecialchars($message); ?>
                </div>
            </div>
        </div>
    </div>
</div>