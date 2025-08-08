<?php
require 'include/header.php';
require 'include/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// * Delete user
if (isset($_GET['delete'])) {
    $deleteId = (int)$_GET['delete'];
    if ($deleteId != $_SESSION['user_id']) { // Prevent deleting self!
        $pdo->prepare("DELETE FROM users WHERE id=?")->execute([$deleteId]);
    }
    header("Location: users.php");
    exit;
}

// * Handle user update
if (isset($_POST['update_id'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $uid = (int)$_POST['update_id'];
    if ($name && $email) {
        $pdo->prepare("UPDATE users SET user_name=?, email=? WHERE id=?")
            ->execute([$name, $email, $uid]);
    }
}

// * Show users
$users = $pdo->query("SELECT * FROM users ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<h3>Registered Users</h3>
<table class="table table-bordered table-striped">
    <tr><th>ID</th><th>Name</th><th>Email</th><th>Image</th><th>Actions</th></tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['id']) ?></td>
            <td>
                <?php if (isset($_GET['edit']) && $_GET['edit'] == $user['id']): ?>
                    <form method="post" class="form-inline">
                        <input name="name" value="<?= htmlspecialchars($user['user_name']) ?>" class="form-control form-control-sm" required>
                        <input name="email" value="<?= htmlspecialchars($user['email']) ?>" class="form-control form-control-sm" type="email" required>
                        <input type="hidden" name="update_id" value="<?= htmlspecialchars($user['id']) ?>">
                        <button class="btn btn-sm btn-primary">Save</button>
                    </form>
                <?php else: ?>
                    <?= htmlspecialchars($user['user_name']) ?>
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td>
                <?php if (!empty($user['profile_image'])): ?>
                    <img src="uploads/user_images/<?= htmlspecialchars($user['profile_image']) ?>" style="width:40px;" alt="User Image">
                <?php else: ?>
                    <span>No Image</span>
                <?php endif; ?>
            </td>
            <td>
                <a href="user.php?edit=<?= htmlspecialchars($user['id']) ?>" class="btn btn-sm btn-info">Edit</a>
                <?php if ($_SESSION['user_id'] != $user['id']): ?>
                    <a href="user.php?delete=<?= htmlspecialchars($user['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include 'include/footer.php'; ?>
