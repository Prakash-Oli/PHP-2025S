 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add content</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <a href="first-page.php"><img src="logo.jpg" alt="image">first page</a>
            <a href="second-page.php">second page</a>
        </nav>
    </header>
    <main>
        <h1>Employees Details:</h1>
        <?php
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $title = htmlspecialchars($_POST['title']);
            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $department = htmlspecialchars($_POST['department']);
            $hours = htmlspecialchars($_POST['hours']);

            echo "<p> title: $title </p>";
            echo "<p> name: $name </p>";
            echo "<p> email: $email </p>";
            echo "<p> department: $department </p>";
            echo "<p> hours: $hours </p>";
        } else {
            echo "<p> no data has been added </p>";
        }
        ?>
    </main>
    <footer>
        <p>&copy S25 2025 MySite</p>
    </footer>
</body>
</html>