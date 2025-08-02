<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
} ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,400;0,600;1,400&family=Montserrat+Alternates:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/include/css/style.css">
    <title>Crud App</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Crud APP</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav" aria-controls="navbarNav"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">

                    <?php if(isset($_SESSION['user_id'])  && $_SESSION['user_id'] !== null):?>
                        <li class="nav-item">
                        <a class="nav-link" href="create.php">
                            Create product
                        </a>
                        </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            Logout
                            (<?=htmlspecialchars($_SESSION['username'])?>)
                        </a>
                    </li>
                    <?php else:?>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">
                            register
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">
                            Login
                        </a>
                    </li>
                    <?php endif;?>
                </ul>
    </nav>