 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <title>Add content</title>
</head>
<body>
    <header>
        <nav>
            <a href="first-page.php"><img src="logo.jpg" alt="image">First Page</a>
            <a href="second-page.php"> Second Page</a>
        </nav>
    </header>
    <main>
        <h1>Add Employees Details:</h1>


        <form action="second-page.php" method="post">
            <label for="title">Job Title:</label>
            <input type="text" id="title" name="title" required>

             <label for="employee-id">Your Name:</label>
            <input type="text" id="employee-id" name="employee-id" required>

             <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" required>

             <label for="department">Your Department:</label>
            <input type="text" id="department" name="department" required>

             <label for="hours">Hours Worked:</label>
            <input type="text" id="hours" name="hours" required>

            <input type="submit" value="submit">
        </form>
    </main>
    <footer>
        <p>&copy S25 2025 MySite</p>
    </footer>
</body>
</html>