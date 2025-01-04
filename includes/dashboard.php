<?php
// Check if user is already logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href = 'index.php';</script>";
    exit();
}

include './templates/dbconnection.php';

// Fetch role permissions
$rolePermissions = [];
$result = $conn->query("SELECT * FROM role_permissions");
while ($row = $result->fetch_assoc()) {
    $rolePermissions[$row['role_id']][] = $row['permission_id'];
}

function userHasPermission($conn, $userId, $permissionId, $rolePermissions) {
    $userRoles = $conn->query("SELECT role_id FROM user_roles WHERE user_id = {$userId}")->fetch_all(MYSQLI_ASSOC);
    foreach ($userRoles as $userRole) {
        if (in_array($permissionId, $rolePermissions[$userRole['role_id']] ?? [])) {
            return true;
        }
    }
    return false;
}

// Check if user has create_news permission
$hasManageNewsPermission = userHasPermission($conn, $_SESSION['user_id'], 1, $rolePermissions);

// Check if user has manage_users permission
$hasManageUsersPermission = userHasPermission($conn, $_SESSION['user_id'], 2, $rolePermissions);

// Check if user has manage_events permission
$hasManageEventsPermission = userHasPermission($conn, $_SESSION['user_id'], 3, $rolePermissions);

// Check if user has manage_permissions permission
$hasManagePermissionsPermission = userHasPermission($conn, $_SESSION['user_id'], 4, $rolePermissions);
?>

<style> <?php include './assets/css/standardblock.css'; ?> </style>
<style> <?php include './assets/css/newstemplate.css'; ?> </style>
<style> <?php include './assets/css/dashboard.css'; ?> </style>

<?php include 'dashboardIncludes/news.php'; ?>
<?php include 'dashboardIncludes/events.php'; ?>
<?php include 'dashboardIncludes/permissions.php'; ?>