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
    <div class="books">
        <div class="filter p-5">
            <div class="row">
                <div class="col-md-4 offset-md-4">
                    <input type="search" class="form-control nameSearch" placeholder="Søg her">
                </div>
            </div>
        </div>
        <div class="items">

        </div>
    </div>
</div>

<div class="container">
    <div class="row m-4">
        <?php foreach ($books as $book): ?>
            <div class="col-sm-6 col-md-3 col-lg-3 g-4">
                <div class="card bg-dark h-100">  <!-- Added h-100 to make full height of parent -->
                    <a href="books/book_detail.php?bookId=<?php echo $book->bookId; ?>">
                        <div class="book-cover">  <!-- Image container -->
                            <img src="uploads/<?php echo $book->coverImageURL; ?>" class="img-fluid" alt="Bogens forside">
                        </div>
                        <h5 class="card-title text-white"><?php echo $book->publisher?></h5>
                        <p class="card-text text-white"><?php echo $book->rating?> af 5.0</p>
                        <a href="books/book_detail.php?bookId=<?php echo $book->bookId; ?>" class="btn btn-dark text-white w-100">Læs mere</a>
                    </a>
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

<script type="module" src="js/search.js"></script>


</body>
</html>
