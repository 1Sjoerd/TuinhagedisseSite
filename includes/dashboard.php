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

<?php if ($isAdmin): ?>
<div class="block-overview">
    <div class="heading-title">
        <h2 class="block-title">Role Permissions</h2>
    </div>
    <div class="block-text">
        <form method="post" action="includes/dashboardIncludes/update_permissions.php">
            <table>
                <thead>
                    <tr>
                        <th>Role</th>
                        <?php foreach ($permissions as $permission): ?>
                            <th><?php echo htmlspecialchars($permission['name']); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($roles as $role): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($role['name']); ?></td>
                            <?php foreach ($permissions as $permission): ?>
                                <td>
                                    <input type="checkbox" name="permissions[<?php echo $role['id']; ?>][]" value="<?php echo $permission['id']; ?>"
                                        <?php echo in_array($permission['id'], $rolePermissions[$role['id']] ?? []) ? 'checked' : ''; ?>>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <input type="submit" value="Update Permissions">
        </form>
    </div>
</div>
<?php endif; ?>