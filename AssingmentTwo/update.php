<?php
$pageDesc = "This page will let you update a user";
$pageTitle = "Update Products";
require_once './include/product.php';
require_once './include/header.php';


if(!isset($_SESSION['user_id'])){
    header("location: login.php");
    exit();
}
$productObj = new product();
$id = $_GET['id'] ?? null;

if (!$id) {
    die("User ID not provided");
}

$data = $productObj->getByID($id);
if (!$data) {
    die("product not found");
}

$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = trim($_POST['price'] ?? '');

    if(empty($name)){
    $error = "Name is required";
    }
    elseif(empty($description)){
        $error = "Description is required";
    }
    elseif(!is_numeric($price) || $price < 0){
        $error = "Price of product must be a positive number";
    }else{
        $image = $data['image'];
        if(isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE){
            $file = $_FILES['image'];
            $allowedTypes = array('image/jpeg', 'image/png');

            if($file['error'] === UPLOAD_ERR_OK){
                if(in_array($file['type'], $allowedTypes)){
                    $uploadDir = './uploads/';
                    if(!is_dir($uploadDir)){
                        mkdir($uploadDir, 0755, true);
                    }
                    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $filename = 'product_'.$id.'.'.time().'.'.$ext;
                    $destination = $uploadDir.$filename;


                    if(move_uploaded_file($file['tmp_name'], $destination)){
                        if(!empty($image) && file_exists($destination)){
                            unlink($image);
                        }
                        $image = $destination;
                    }
                    else{
                        $error = "Upload failed";
                    }
                }else{
                    $error = "File type not allowed";
                }
            }else{
                $error = "Upload failed";
            }
        }

        if(empty($error)){
            $updated = $productObj->update($id, $name, $description, $price, $image);
            if($updated){
                $success = "Product updated successfully";
                header("location: ../index.php?msg=".urlencode($success));
                exit();
            }
            else{
                $error = "Error updating product";
            }

        }
    }
}

?>
<section class="lesson-masthead">
    <h2>Update Product</h2>
</section>
<section class="form-row">
    <?php if (!empty($error)):?>
    <p style="color: red;"><?=htmlspecialchars($error)?></p>
    <?php endif;?>
    <?php if (!empty($success)):?>
    <p style="color: green;"><?=htmlspecialchars($success)?></p>
    <form method="post" enctype="multipart/form-data" novalidate>
        <label>Name:</label>
        <label>
            <input type="text" name="name" value="<?= htmlspecialchars($data['name']) ?>" required>
        </label><br><br>
        <label>Description:</label>
        <label>
            <textarea name="description" id = "description" required><?= htmlspecialchars($data['description']) ?>
                </textarea>
        </label><br><br>
        <label>Price:</label>
        <label>
            <input type="number" name="price" value="<?= htmlspecialchars($data['price']) ?>" min="0" step="1" required>
        </label> <br><br>
        <label>Image:</label>
        <?php
        if (empty(!$data['image']) && file_exists($data['image'])) ?>
        <img src="<?= htmlspecialchars($data['image']) ?>" alt="Current Image"
             style="max-width: 150px; display: block; margin-bottom: 10px;">
        <?php
        endif;
        ?>
        <label>
            <input type="file" name="image" id="Image" accept="image/*">
        </label><br><br>
        <input type="submit" value="Update Product">
    </form>
</section>
<?php require './include/footer.php'; ?>
