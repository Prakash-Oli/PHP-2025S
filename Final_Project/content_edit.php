<?php
require 'include/header.php';
require 'include/db_connect.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$authorId = $_SESSION['user_id'] ?? null;
if (!$authorId) {
    // Handle no logged-in user case
    die("User must be logged in to add content.");
}


if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM contents WHERE id=?")->execute([(int)$_GET['delete']]);
    header("Location: about.php");
    exit;
}

// * Insert / Update Post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $body = trim($_POST['body'] ?? '');
    $authorId = $_SESSION['user_id'];

    if (isset($_POST['id']) && $_POST['id']) {
        $pdo->prepare("UPDATE contents SET title=?, body=? WHERE id=?")->execute([$title, $body, (int)$_POST['id']]);
    } else {
        $pdo->prepare("INSERT INTO contents (title, body, author_id) VALUES (?, ?, ?)")->execute([$title, $body, $authorId]);
    }
    header("Location: about.php");
    exit;
}

// * Edit post?
$content = ['id' => '', 'title' => '', 'body' => ''];
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM contents WHERE id=?");
    $stmt->execute([(int)$_GET['id']]);
    $content = $stmt->fetch(PDO::FETCH_ASSOC) ?: $content;
}
?>

<h3><?php echo $content['id'] ? "Edit" : "Create"; ?> Content</h3>
<form method="post">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($content['id']); ?>">
    <div class="form-group">
        <label>Title</label>
        <input class="form-control" name="title" required value="<?php echo htmlspecialchars($content['title']); ?>">
    </div>
    <div class="form-group">
        <label>Body</label>
        <textarea class="form-control" name="body" required><?php echo htmlspecialchars($content['body']); ?></textarea>
    </div>
    <button class="btn btn-primary"><?php echo $content['id'] ? "Update" : "Create"; ?></button>
    <a href="about.php" class="btn btn-secondary">Back</a>
</form>

<?php include 'include/footer.php'; ?>
