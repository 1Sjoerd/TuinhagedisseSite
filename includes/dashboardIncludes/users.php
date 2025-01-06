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
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $userItems = $conn->query("SELECT * FROM users ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
                foreach ($userItems as $userItem):
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($userItem['email']); ?></td>
                    <td><?php echo htmlspecialchars($userItem['is_active']); ?></td>
                    <td>
                        <a href="includes/dashboardIncludes/deactivate_user.php?id=<?php echo $userItem['id']; ?>">Deactiveer</a>
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
                <input type="submit" value="Oetneudige" class="submit-button">
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