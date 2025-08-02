<?php
require './include/header.php';
$pageDesc = "This is our 404 pages";
$pageTitle = "result Not Found";
// Get the 'search' parameter from the URL if it exists; otherwise, set it to an empty string

http_response_code(404);

$searchTerm = $_GET['search']??'';
?>
    <section style="text-align: center; padding-bottom: 20px; color: blue; background-color: white;
">
        <h1>404 page not found</h1>
        <p>
            Sorry, the product you are looking for does not exist or moved to different place.
        </p>
        <p>
            <a href="index.php">Return back to home
            </a></p>
    </section>
<?php require './include/footer.php';
?>