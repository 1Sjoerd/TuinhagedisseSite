<?php if ($hasCreateNewsPermission): ?>
<div class="block-overview">
    <div class="heading-title">
        <h2 class="block-title">Manage News</h2>
    </div>
    <div class="block-text">
        <h3>News Items</h3>
        <table class="permissions-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $newsItems = $conn->query("SELECT * FROM news ORDER BY date DESC")->fetch_all(MYSQLI_ASSOC);
                foreach ($newsItems as $newsItem):
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($newsItem['id']); ?></td>
                    <td><?php echo htmlspecialchars($newsItem['date']); ?></td>
                    <td><?php echo htmlspecialchars($newsItem['title']); ?></td>
                    <td>
                        <a href="includes/dashboardIncludes/edit_news.php?id=<?php echo $newsItem['id']; ?>">Edit</a>
                        <a href="includes/dashboardIncludes/delete_news.php?id=<?php echo $newsItem['id']; ?>">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h3>Add News Item</h3>
        <form method="post" action="includes/dashboardIncludes/add_news.php" enctype="multipart/form-data">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" value="<?php echo date('Y-m-d'); ?>" required>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
            <label for="text">Text:</label>
            <textarea id="text" name="text" required></textarea>
            <label for="image_url">Image:</label>
            <input type="file" id="image_url" name="image_url">
            <label for="event_id">Event ID (optional):</label>
            <select id="event_id" name="event_id">
                <option value="">Select an event</option>
                <?php foreach ($events as $event): ?>
                    <option value="<?php echo $event['id']; ?>"><?php echo htmlspecialchars($event['title']); ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Add News">
        </form>
    </div>
</div>
<?php endif; ?>