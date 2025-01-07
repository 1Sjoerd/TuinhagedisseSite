<?php if ($hasManageUsersPermission): ?>
<div class="block-overview block-overview-permissions">
    <div class="heading-title">
        <h2 class="block-title">Beheer gebroekers</h2>
    </div>
    <div class="block-text">
        <div class="wrapper">
            <div class="table">
                <div class="row header">
                    <div class="cell">E-Mail</div>
                    <div class="cell">Actief</div>
                    <?php if ($hasManagePermissionsPermission): ?>
                    <div class="cell">Rol</div>
                    <?php endif; ?>
                    <div class="cell">Acties</div>
                </div>
                <?php
                $roles = $conn->query("SELECT * FROM roles")->fetch_all(MYSQLI_ASSOC);
                $userItems = $conn->query("SELECT users.*, roles.name AS role_name FROM users LEFT JOIN user_roles ON users.id = user_roles.user_id LEFT JOIN roles ON user_roles.role_id = roles.id ORDER BY users.created_at DESC;")->fetch_all(MYSQLI_ASSOC);

                foreach ($userItems as $userItem):
                ?>
                <div class="row">
                    <div class="cell" data-title="E-Mail"><?php echo htmlspecialchars($userItem['email']); ?></div>
                    <div class="cell" data-title="Actief"><?php echo htmlspecialchars($userItem['is_active']); ?></div>
                    <?php if ($hasManagePermissionsPermission): ?>
                    <div class="cell" data-title="Rol">
                        <select class="role-dropdown styled-select" data-user-id="<?php echo $userItem['id']; ?>">
                            <?php foreach ($roles as $role): ?>
                                <option value="<?php echo $role['id']; ?>" <?php echo $role['name'] === $userItem['role_name'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($role['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>
                    <div class="cell" data-title="Acties">
                        <?php if ($userItem['is_active'] == 1): ?>
                            <a href="includes/dashboardIncludes/deactivate_user.php?id=<?php echo $userItem['id']; ?>"><i class="fa-solid fa-xmark"></i> Deactiveer</a>
                        <?php else: ?>
                            <a href="includes/dashboardIncludes/deactivate_user.php?id=<?php echo $userItem['id']; ?>"><i class="fa-solid fa-check"></i> Activeer</a>
                        <?php endif; ?>
                        <a href="includes/dashboardIncludes/delete_user.php?id=<?php echo $userItem['id']; ?>"><i class="fa-solid fa-trash"></i> Verwijder</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <button id="addUserButton" class="submit-button">Gebroeker toevoege</button>
        <div id="userForm" style="display: none;">
            <form id="userFormElement" method="post" action="includes/dashboardIncludes/add_user.php" enctype="multipart/form-data">
                <label for="email">E-Mail:</label>
                <input type="email" id="email" name="email" required>
                <input type="submit" value="Neudig oet" class="submit-button">
            </form>
        </div>

        <script>
            document.getElementById('addUserButton').addEventListener('click', function() {
                var form = document.getElementById('userForm');
                document.getElementById('userFormElement').reset();
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            });

            document.querySelectorAll('.role-dropdown').forEach(function(dropdown) {
                dropdown.addEventListener('change', function() {
                    const userId = this.getAttribute('data-user-id');
                    const roleId = this.value;

                    // AJAX request
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'includes/dashboardIncludes/update_user_role.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            alert(xhr.responseText); // Voor debuggen, later vervangen door een betere notificatie.
                        }
                    };
                    xhr.send('user_id=' + userId + '&role_id=' + roleId);
                });
            });
        </script>
    </div>
</div>
<?php endif; ?>