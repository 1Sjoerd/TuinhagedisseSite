<?php if ($hasManageUsersPermission): ?>
<div class="block-overview block-overview-permissions">
    <div class="heading-title">
        <h2 class="block-title">Beheer gebroekers</h2>
    </div>
    <div class="block-text">
        <table class="news-table">
            <thead>
                <tr>
                    <th>E-Mail</th>
                    <th>Actief</th>
                    <?php if ($hasManagePermissionsPermission): ?>
                    <th>Rol</th>
                    <?php endif; ?>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $roles = $conn->query("SELECT * FROM roles")->fetch_all(MYSQLI_ASSOC);
                $userItems = $conn->query("SELECT users.*, roles.name AS role_name FROM users LEFT JOIN user_roles ON users.id = user_roles.user_id LEFT JOIN roles ON user_roles.role_id = roles.id ORDER BY users.created_at DESC;")->fetch_all(MYSQLI_ASSOC);

                foreach ($userItems as $userItem):
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($userItem['email']); ?></td>
                    <td><?php echo htmlspecialchars($userItem['is_active']); ?></td>
                    <?php if ($hasManagePermissionsPermission): ?>
                    <td>
                        <select class="role-dropdown styled-select" data-user-id="<?php echo $userItem['id']; ?>">
                            <?php foreach ($roles as $role): ?>
                                <option value="<?php echo $role['id']; ?>" <?php echo $role['name'] === $userItem['role_name'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($role['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <?php endif; ?>
                    <td>
                        <?php if ($userItem['is_active'] == 1): ?>
                            <a href="includes/dashboardIncludes/deactivate_user.php?id=<?php echo $userItem['id']; ?>"><i class="fa-solid fa-xmark"></i> Deactiveer</a>
                        <?php else: ?>
                            <a href="includes/dashboardIncludes/deactivate_user.php?id=<?php echo $userItem['id']; ?>"><i class="fa-solid fa-check"></i> Activeer</a>
                        <?php endif; ?>
                        </br><a href="includes/dashboardIncludes/delete_user.php?id=<?php echo $userItem['id']; ?>"><i class="fa-solid fa-trash"></i> Verwijder</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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