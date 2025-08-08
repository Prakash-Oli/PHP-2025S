<?php
include 'include/header.php';
include 'include/db_connect.php';
?>

<!-- Main Content: Home Page -->
<h1>Welcome To My Mini Blog!</h1>
<p>This Is My public home page.</p>
<hr>
<h3>Recent Content</h3>
<ul class="list-group">
    <?php
    $stmt = $pdo->query("SELECT * FROM contents ORDER BY created_at DESC LIMIT 5");
    while ($content = $stmt->fetch()):
        ?>
        <li class="list-group-item">
            <strong><?php echo htmlspecialchars($content['title']); ?></strong><br>
            <?php echo htmlspecialchars(substr($content['body'], 0, 100)); ?>...
            <small class="text-muted"><?php echo $content['created_at']; ?></small>
        </li>
    <?php endwhile; ?>
</ul>

<?php include 'include/footer.php'; ?>
