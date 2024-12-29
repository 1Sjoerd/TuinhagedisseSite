<?php
session_start();
// Check if user is logged in and has the admin role
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    echo "<script>window.location.href = '../../index.php';</script>";
    exit();
}

// Correct the path to dbconnection.php
include '../../templates/dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $permissions = $_POST['permissions'] ?? [];

    // Clear existing permissions
    $conn->query("DELETE FROM role_permissions");

    // Insert new permissions
    $stmt = $conn->prepare("INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)");
    foreach ($permissions as $roleId => $permissionIds) {
        foreach ($permissionIds as $permissionId) {
            $stmt->bind_param("ii", $roleId, $permissionId);
            $stmt->execute();
        }
    }

    echo "<script>window.location.href = '../../dashboard.php';</script>";
    exit();
}
?>