<?php
require "../settings/init.php";

// Ensure bookId is passed and not empty
if (!isset($_GET['bookId']) || empty($_GET['bookId'])) {
    die("Invalid URL. Please provide a bookId.");
}

$bookId = $_GET['bookId'];

// Fetch the book data from the database
$bookDetails = $db->sql("SELECT * FROM books WHERE bookId = :bookId", [":bookId" => $bookId]);

if (!$bookDetails || empty($bookDetails)) {
    die("Book not found.");
}

$book = $bookDetails[0];  // since the result will be an array of one item

// Start your HTML display here
?>

<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="utf-8">
    <title>Book Details</title>
    <meta name="robots" content="All">
    <meta name="author" content="Udgiver">
    <meta name="copyright" content="Information om copyright">
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../css/styles.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<header>
    <?php include '../navbar.php' ?>
</header>

<div class="container pt-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <img src="../uploads/<?= $book->coverImageURL ?>" class="card-img-top" alt="<?= $book->bookName ?>">
                <div class="card-body">
                    <h5 class="card-title"><span class="fw-bold">Titel:</span> <?= $book->bookName ?></h5>
                    <p class="card-text"><span class="fw-bold">Beskrivelse:</span> <?= $book->bookText ?></p>
                    <p class="card-text"><span class="fw-bold">Pris:</span>
                        kr. <?= number_format($book->bookPrice, 2, ',', '.') ?></p>
                    <p class="card-text"><span class="fw-bold">Forfatter:</span> <?= $book->author ?></p>
                    <p class="card-text"><span
                                class="fw-bold">Udgivelses dato:</span> <?= date("d-m-Y", strtotime($book->publicationDate)) ?>
                    </p>
                    <p class="card-text"><span class="fw-bold">ISBN13:</span> <?= $book->isbn ?></p>
                    <p class="card-text"><span class="fw-bold">Genre:</span> <?= $book->genre ?></p>
                    <p class="card-text"><span class="fw-bold">Forlag:</span> <?= $book->publisher ?></p>
                    <p class="card-text"><span class="fw-bold">Antal sider:</span> <?= $book->pageCount ?></p>
                    <p class="card-text"><span class="fw-bold">Bedømmelse:</span> <?= $book->rating ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="pt-3">
    <?php include '../footer.php' ?>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="module" src="../js/main.js"></script>
<script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
