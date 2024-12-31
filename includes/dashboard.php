<?php
// Check if user is already logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href = 'index.php';</script>";
    exit();
}

// Check if user has the admin role
$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1;

include './templates/dbconnection.php';

// Fetch roles and permissions
$roles = $conn->query("SELECT * FROM roles")->fetch_all(MYSQLI_ASSOC);
$permissions = $conn->query("SELECT * FROM permissions")->fetch_all(MYSQLI_ASSOC);

// Fetch role permissions
$rolePermissions = [];
$result = $conn->query("SELECT * FROM role_permissions");
while ($row = $result->fetch_assoc()) {
    $rolePermissions[$row['role_id']][] = $row['permission_id'];
}
?>

<style> <?php include './assets/css/standardblock.css'; ?> </style>
<style> <?php include './assets/css/newstemplate.css'; ?> </style>
<style> <?php include './assets/css/dashboard.css'; ?> </style>

<?php include 'dashboardIncludes/permissions.php'; ?>