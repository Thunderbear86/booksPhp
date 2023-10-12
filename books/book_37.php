<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="utf-8">
    <title>Book Details</title>
    <meta name="robots" content="All">
    <meta name="author" content="Udgiver">
    <meta name="copyright" content="Information om copyright">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<header>
    <?php include 'navbar.php' ?>
</header>

<div class="container">
    <?php
    // Include your database connection code here
    require "settings/init.php"; // Include your database connection code from init.php

    // Ensure that the $db object is available for database queries
    if (!isset($db)) {
        echo "Database connection not established.";
        exit;
    }

    // Retrieve the book details using the bookId from the URL
    if (isset($_GET['bookId'])) {
        $bookId = $_GET['bookId'];

        // Query the database to fetch book details based on $bookId
        // Replace this with your actual database query
        $sql = "SELECT * FROM books WHERE bookId = :bookId";
        $bind = [":bookId" => $bookId];

        // Execute the query and retrieve the book details
        $book = $db->queryOne($sql, $bind);

        if ($book) {
            // Display book details
            echo '<div class="card">';
            echo '<img src="uploads/' . $book->coverImageURL . '" class="card-img-top" alt="' . $book->bookName . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $book->bookName . '</h5>';
            echo '<p class="card-text">' . $book->bookText . '</p>';
            echo '<p class="card-text"><span class="fw-bold">Pris:</span> kr. ' . number_format($book->bookPrice, 2, ',', '.') . '</p>';
            echo '<p class="card-text"><span class="fw-bold">Forfatter:</span> ' . $book->author . '</p>';
            echo '<p class="card-text"><span class="fw-bold">Udgivelses dato:</span> ' . date("d-m-Y", strtotime($book->publicationDate)) . '</p>';
            echo '<p class="card-text"><span class="fw-bold">ISBN13:</span> ' . $book->isbn . '</p>';
            echo '<p class="card-text"><span class="fw-bold">Genre:</span> ' . $book->genre . '</p>';
            echo '<p class="card-text"><span class="fw-bold">Forlag:</span> ' . $book->publisher . '</p>';
            echo '<p class="card-text"><span class="fw-bold">Antal sider:</span> ' . $book->pageCount . '</p>';
            echo '<p class="card-text"><span class="fw-bold">Bedømmelse:</span> ' . $book->rating . '</p>';
            echo '</div>';
            echo '</div>';
        } else {
            echo '<p>Book not found.</p>';
        }
    } else {
        echo '<p>Invalid URL. Please provide a bookId.</p>';
    }
    ?>
</div>
<footer class="pt-3">
    <?php include 'footer.php' ?>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="module" src="js/main.js"></script>


<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
