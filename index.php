<?php
require "settings/init.php";

// Retrieve book information from the database
$books = $db->sql("SELECT * FROM books");
?>

<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="utf-8">
    <title>Bogpidia</title>
    <meta name="robots" content="All">
    <meta name="author" content="Thorbjørn Wagner">
    <meta name="copyright" content="Information om copyright">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <script src="https://kit.fontawesome.com/ef424bfb92.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<header>
    <?php include 'navbar.php' ?>
</header>

<div class="container">
    <div class="row m-4">
        <?php foreach ($books as $book): ?>
            <div class="col-sm-12 col-md-4 col-lg-3">
                <div class="card">
                    <img src="<?php echo $book->coverImageURL; ?>" class="card-img-top" alt="Book Cover">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $book->bookName; ?></h5>
                        <p class="card-text"><?php echo $book->bookText; ?></p>
                        <p class="card-text">Price: $<?php echo $book->bookPrice; ?></p>
                        <p class="card-text">Author: <?php echo $book->author; ?></p>
                        <p class="card-text">Publication Date: <?php echo $book->publicationDate; ?></p>
                        <p class="card-text">ISBN: <?php echo $book->isbn; ?></p>
                        <p class="card-text">Genre: <?php echo $book->genre; ?></p>
                        <p class="card-text">Publisher: <?php echo $book->publisher; ?></p>
                        <p class="card-text">Page Count: <?php echo $book->pageCount; ?></p>
                        <p class="card-text">Rating: <?php echo $book->rating; ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<footer class="pt-3">
    <?php include 'footer.php' ?>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="module" src="js/main.js"></script>


<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
