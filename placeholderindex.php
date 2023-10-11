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
                    <img src="uploads/<?php echo $book->coverImageURL; ?>" class="card-img-top" alt="Book Cover">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $book->bookName; ?></h5>
                        <p class="card-text"><?php echo $book->bookText; ?></p>
                        <p class="card-text"><span class="fw-bold">Pris:</span> kr. <?php echo number_format($book->bookPrice, 2, ',', '.'); ?></p>
                        <p class="card-text"><span class="fw-bold">Forfatter:</span> <?php echo $book->author; ?></p>
                        <p class="card-text"><span class="fw-bold">Udgivelses dato:</span> <?php echo date("d-m-Y", strtotime($book->publicationDate)); ?></p>
                        <p class="card-text"><span class="fw-bold">ISBN13:</span> <?php echo $book->isbn; ?></p>
                        <p class="card-text"><span class="fw-bold">Genre:</span> <?php echo $book->genre; ?></p>
                        <p class="card-text"><span class="fw-bold">Forlag:</span> <?php echo $book->publisher; ?></p>
                        <p class="card-text"><span class="fw-bold">Antal sider:</span> <?php echo $book->pageCount; ?></p>
                        <p class="card-text"><span class="fw-bold">Bedømmelse:</span> <?php echo $book->rating; ?></p>
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
