<?php
$pageTitle = "Products";
$pageDesc = "List of all the products";
require_once './include/header.php';
require_once './include/product.php';
require_once './include/database.php';

$productsObj = new Product();
$search = $_GET['search'] ?? '';
$products = $productsObj->readALL($search);

// Ensure $users is always an array to avoid foreach warnings
if (!is_array($products)) {
    $products = [];
}

// 404 redirection if no users found on search
if ($search && empty($products)) {
    header("Location: 404.php?search=" . urlencode($search));
    exit;
}
?>
<section class="lesson-masthead">
    <h1>Product List</h1>
</section>
<section class="search-form-row">
    <form method="post" id="search-form" class="search-form" autocomplete="off">
        <label>
            <input class="form-control" type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search by name">
        </label>
        <input class="btn btn-success" type="submit" value="Search">
    </form>
</section>
<section class="view-table-row">
    <a class="create-btn btn btn-primary" href="create.php">Add New Products</a>
    <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>DESCRIPTION</th>
            <th>PRICE</th>
            <th>ADDED BY</th>
        </tr>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['id']) ?></td>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= htmlspecialchars($product['description'] ?? '')?></td>
                <td><?= number_format((float)($product['price'] ?? 0 ),2) ?></td>
                <td><?= htmlspecialchars($product['username'] ?? 'N/A') ?></td>

                <td>
                    <a class="btn btn-warning" href="update.php?id=<?= $product['id'] ?>">Edit</a>
                    <a class="btn btn-danger" href="delete.php?id=<?= $product['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>
<?php
require './include/footer.php';
?>
