<?php
$host = "localhost";
$user = 'root';
$pass = '';
$database = 'project_db';
try {
    $dsn = "mysql:host=$host;dbname=$database";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}
?>
