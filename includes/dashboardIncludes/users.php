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
                    <th>Rol</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $userItems = $conn->query("SELECT users.*, roles.name AS role_name FROM users LEFT JOIN user_roles ON users.id = user_roles.user_id LEFT JOIN roles ON user_roles .role_id = roles.id ORDER BY users.created_at DESC;")->fetch_all(MYSQLI_ASSOC);
                foreach ($userItems as $userItem):
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($userItem['email']); ?></td>
                    <td><?php echo htmlspecialchars($userItem['is_active']); ?></td>
                    <td><?php echo htmlspecialchars($userItem['role_name']); ?></td>
                    <td>
                        <?php if ($userItem['is_active'] == 1): ?>
                            <a href="includes/dashboardIncludes/deactivate_user.php?id=<?php echo $userItem['id']; ?>">Deactiveer</a>
                        <?php else: ?>
                            <a href="includes/dashboardIncludes/deactivate_user.php?id=<?php echo $userItem['id']; ?>">Heractiveer</a>
                        <?php endif; ?>
                        <a href="includes/dashboardIncludes/delete_user.php?id=<?php echo $userItem['id']; ?>">Verwijder</a>
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
                <input type="submit" value="Toevoegen" class="submit-button">
            </form>
        </div>

        <script>
            document.getElementById('addUserButton').addEventListener('click', function() {
                var form = document.getElementById('userForm');
                document.getElementById('userFormElement').reset();
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            });
        </script>
    </div>
</div>
<?php endif; ?>
