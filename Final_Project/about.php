<?php
include 'include/header.php';
include 'include/db_connect.php';

// Show content
$stmt = $pdo->query("SELECT * FROM contents ORDER BY created_at DESC");
?>

<!-- About Page / Content -->
<h2>About this Site</h2>
<p>This demo site allows basic CRUD operations and which is fully built for the educational purpose.</p>
<hr>
<h3>All Content</h3>
<?php while ($c = $stmt->fetch()): ?>
    <div class="card my-2">
        <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($c['title']); ?></h5>
            <p class="card-text"><?php echo nl2br(htmlspecialchars($c['body'])); ?></p>
            <small class="text-muted"><?php echo $c['created_at']; ?></small>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="content_edit.php?id=<?php echo $c['id']; ?>" class="btn btn-sm btn-primary float-right ml-2">Edit</a>
                <a href="content_edit.php?delete=<?php echo $c['id']; ?>" class="btn btn-sm btn-danger float-right"
                   onclick="return confirm('Delete this item?')">Delete</a>
            <?php endif; ?>
        </div>
    </div>
<?php endwhile; ?>

<?php include 'include/footer.php'; ?>
