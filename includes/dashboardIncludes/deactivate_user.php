<?php
session_start();
include '../../templates/dbconnection.php';

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT is_active FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
                    
if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    $is_active = $data['is_active'];
    if ($is_active == 1) {
        // Alter the is_active value of the user entry in the database
        $conn->query("UPDATE users SET is_active = 0 WHERE id = $id");
    } elseif ($is_active == 0) {
        // Alter the is_active value of the user entry in the database
        $conn->query("UPDATE users SET is_active = 1 WHERE id = $id");
    }
}



echo "<script>window.location.href = '../../dashboard.php';</script>";
exit();
?>
