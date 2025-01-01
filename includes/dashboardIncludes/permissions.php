<?php if ($hasManagePermissionsPermission): ?>
<?php
// Fetch roles and permissions
$roles = $conn->query("SELECT * FROM roles")->fetch_all(MYSQLI_ASSOC);
$permissions = $conn->query("SELECT * FROM permissions")->fetch_all(MYSQLI_ASSOC);
?>
<div class="block-overview block-overview-permissions">
    <div class="heading-title">
        <h2 class="block-title">Groeps rechten</h2>
    </div>
    <div class="block-text">
        <form method="post" action="includes/dashboardIncludes/update_permissions.php" class="permissions-form">
            <table class="permissions-table">
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
                            <td data-label="Role"><?php echo htmlspecialchars($role['name']); ?></td>
                            <?php foreach ($permissions as $permission): ?>
                                <td data-label="<?php echo htmlspecialchars($permission['name']); ?>">
                                    <input type="checkbox" class="permissioncheckbox" name="permissions[<?php echo $role['id']; ?>][]" value="<?php echo $permission['id']; ?>"
                                        <?php echo in_array($permission['id'], $rolePermissions[$role['id']] ?? []) ? 'checked' : ''; ?>>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <input type="submit" value="Opsjlaon" class="submit-button">
        </form>
    </div>
</div>
<?php endif; ?>