<?php
session_start();
include 'include/header.php';
include 'include/db_connect.php';

$errors = [];
$success = '';

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validate inputs
    if (!$name) {
        $errors[] = 'Name is required.';
    }
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email is required.';
    }
    if (!$password || strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }

    // Check if email already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $errors[] = 'Email already registered.';
    }

    // Handle the image upload if file provided
    $imagePath = null;
    if (!empty($_FILES['image']['name'])) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $fileType = mime_content_type($_FILES['image']['tmp_name']);
        $fileSize = $_FILES['image']['size'];

        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = 'Only JPG and PNG images are allowed.';
        } elseif ($fileSize > 2 * 1024 * 1024) { // 2MB limit
            $errors[] = 'Image size should be less than 2MB.';
        } else {
            // Prepare unique filename and target directory
            $imgName = uniqid() . '_' . basename($_FILES['image']['name']);
            $targetDir = 'uploads/user_images/';
            $target = $targetDir . $imgName;

            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $errors[] = 'Failed to upload the image.';
            } else {
                $imagePath = $imgName;
            }
        }
    }

    // If no errors, insert user into database
    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (user_name, email, password, profile_image) VALUES (?, ?, ?, ?)");
        $success = $stmt->execute([$name, $email, $hash, $imagePath]);

        if ($success) {
            // Registration successful - redirect or message
            $_SESSION['success'] = 'Registration successful! You can now login.';
            header('Location: login.php');
            exit;
        } else {
            $errors[] = 'Registration failed. Please try again.';
        }
    }
}
?>

<div class="container mt-4" style="max-width: 500px;">
    <h2>Register</h2>

    <!-- Success Message -->
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- Error Messages -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" novalidate>
        <div class="form-group">
            <label for="name">Full Name *</label>
            <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-control"
                    value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                    required
                    maxlength="100"
            >
        </div>
        <div class="form-group">
            <label for="email">Email address *</label>
            <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-control"
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                    required
                    maxlength="255"
            >
        </div>
        <div class="form-group">
            <label for="password">Password * (min 6 characters)</label>
            <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control"
                    required
                    minlength="6"
            >
        </div>
        <div class="form-group">
            <label for="image">Profile Image (optional)</label>
            <input
                    type="file"
                    name="image"
                    id="image"
                    class="form-control-file"
                    accept="image/jpeg,image/png,image/jpg"
            >
            <small class="form-text text-muted">Allowed file types: JPG, PNG. Max size 2MB.</small>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Register</button>
    </form>

    <p class="mt-3">Already have an account? <a href="login.php">Login here</a>.</p>
</div>

<?php include 'include/footer.php'; ?>
