<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$pageTitle = "Adding New Product";
$pageDesc = "This page lets the user to add a new product.";

require './include/header.php';
require_once './include/product.php';

$product = new product();
$error = '';
$success = '';

$name = '';
$description = '';
$price = '';
$image = null;
$created_by = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $image = null;
    $created_by = trim($_POST['created_by'] ?? '');


    if (empty($name)) {
        $error = "Please enter the product name.";
    } elseif (empty($price) || !is_numeric($price) || floatval($price) <= 0) {
        $error = "Please enter a valid price.";
    }


    if (empty($error) && isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $allowedTypes = ['image/jpeg', 'image/png'];
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileType = mime_content_type($fileTmpPath);
        $fileSize = $_FILES['image']['size'];

        if (!in_array($fileType, $allowedTypes)) {
            $error = "Only JPG and PNG image formats are allowed.";
        } elseif ($fileSize > 2 * 1024 * 1024) { // 2MB max
            $error = "Image size must be less than 2MB.";
        } else {
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $imageName = uniqid('prod_', true) . '.' . $ext;
            $uploadDir = __DIR__ . '/images';
            $destination = $uploadDir . $imageName;

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            if (!move_uploaded_file($fileTmpPath, $destination)) {
                $error = "Failed to upload image.";
            } else {
                $image = $imageName;
            }
        }
    }


    if (empty($error)) {
        $created_by = $_SESSION['user_id'];
        $created = $product->create($name, $description, $price, $image, $created_by);

        if ($created) {
            $success = "Product created successfully!";
            // Clear form data
            $name = $description = $price = '';
            $image = null;
        } else {
            $error = "Failed to create the product. Please try again.";
        }
    }
}

?>

<section class="products container mt-4">
    <h1>Add New Product</h1>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php elseif (!empty($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form action="create.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input
                    type="text"
                    class="form-control"
                    name="name"
                    id="name"
                    value="<?= htmlspecialchars($name) ?>"
                    required
            >
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea
                    class="form-control"
                    name="description"
                    id="description"
                    rows="3"
                    required><?= htmlspecialchars($description) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price:</label>
            <input
                    type="number"
                    class="form-control"
                    name="price"
                    id="price"
                    step="0.01"
                    min="0.01"
                    value="<?= htmlspecialchars($price) ?>"
                    required
            >
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image:</label>
            <input
                    type="file"
                    class="form-control"
                    name="image"
                    id="image"
                    accept="image/png, image/jpeg"
            >
        </div>

        <button type="submit" class="btn btn-success">Add New Product</button>
    </form>
</section>

<?php require './include/footer.php'; ?>
