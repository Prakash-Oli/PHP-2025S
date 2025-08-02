<?php
require_once './include/product.php';
require_once './include/user.php';
session_start();
if (!isset($_SESSION["user_id"])) {
   header("location: login.php");
    exit();
}

$product = new Product();
$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
if ($id <= 0) {
    header("location: index.php");
    exit();
}


$item = $product->getByID($id);
if($item){
    if (!empty($data['image']) && file_exists($data['image'])) {
        unlink($data['image']);
    }
    $product->delete($id);
}
header("location: index.php");
exit();

?>