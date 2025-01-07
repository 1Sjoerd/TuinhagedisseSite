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
            <div class="wrapper wrapper-permissions">
                <div class="table">
                    <div class="row header">    
                        <div class="cell">Role</div>
                        <?php foreach ($permissions as $permission): ?>
                            <div class="cell"><?php echo htmlspecialchars($permission['name']); ?></div>
                        <?php endforeach; ?>
                    </div>
                    <?php foreach ($roles as $role): ?>
                        <div class="row">
                            <div class="cell" data-title="Gebroeker" data-label="Role"><?php echo htmlspecialchars($role['name']); ?></div>
                            <?php foreach ($permissions as $permission): ?>
                                <div class="cell" data-title="<?php echo htmlspecialchars($permission['name']); ?>" data-label="<?php echo htmlspecialchars($permission['name']); ?>">
                                    <input type="checkbox" class="permissioncheckbox" name="permissions[<?php echo $role['id']; ?>][]" value="<?php echo $permission['id']; ?>"
                                        <?php echo in_array($permission['id'], $rolePermissions[$role['id']] ?? []) ? 'checked' : ''; ?>>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <input type="submit" value="Opsjlaon" class="submit-button">
        </form>
    </div>
</div>
<?php endif; ?>