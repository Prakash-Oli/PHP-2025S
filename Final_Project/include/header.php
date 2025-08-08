<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mini Blog Project</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">MiniBlog</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item"><a href="user.php" class="nav-link">Users</a></li>
                <li class="nav-item"><a href="content_edit.php" class="nav-link">Edit Content</a></li>
            <?php endif; ?>
        </ul>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <form class="form-inline" action="login.php" method="post">
                <fieldset class="form-group">
                    <input class="form-control mr-sm-2" type="email" name="email" placeholder="Enter your email." required>
                    <input class="form-control mr-sm-2" type="password" name="password" placeholder="Enter your password." required>
                    <button class="btn btn-success" type="submit">Login</button>
                </fieldset>
            </form>
            <a href="register.php" class="btn btn-primary ml-2">Register</a>
        <?php else: ?>
            <span class="navbar-text text-white mr-3">
            Logged in as <?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?>
        </span>
            <a href="logout.php" class="btn btn-warning">Logout</a>
        <?php endif; ?>
    </div>
</nav>
<div class="container mt-4">
