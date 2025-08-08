<?php
session_start();
require 'include/db_connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: index.php");
        exit;
    } else {
        // failed login—show error on index or login page
        $_SESSION['login_error'] = "Invalid login.";
        header("Location: index.php");
        exit;
    }
}
// If not POST, redirect.
header("Location: index.php");
exit;
