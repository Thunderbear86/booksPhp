<?php

require "settings/init.php";

$books = $db->sql('SELECT * FROM books ORDER BY bookPrice ASC');
?>


<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="utf-8">

    <title>Indsæt til database</title>

    <meta name="robots" content="All">
    <meta name="author" content="Udgiver">
    <meta name="copyright" content="Information om copyright">

    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/styles.css" rel="stylesheet" type="text/css">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://kit.fontawesome.com/ef424bfb92.js" crossorigin="anonymous"></script>

    <script src="https://cdn.tiny.cloud/1/ul8c9hibtyvcapqu9iwhikjy9z84erdw2bw40aq7kivxno5u/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"></script>

</head>

<body>

<header>
    <?php include 'navbar.php' ?>
</header>
<?php
foreach ($books as $book) {
    ?>
    <div class="container">
    <div class="row mt-2 border-bottom border-3 border-opacity-10 ">
        <div class="col-12 col-md-6">
            <?php
            echo $book->bookName;
            ?>
        </div>
        <div class="col-12 col-md-6 fw-bold text-end">
            <?php
            echo number_format($book->bookPrice, 2, ',', '.') . " kr.<br>";
            ?>
        </div>
    </div>
    </div>
    <!-- echo "" . $book->bookName . " - " . number_format( $book->bookPrice, 2, ',', '.' ) . " kr.<br>"; -->
    <?php
}
?>

<!-- <footer class="pt-3">
    <?php include 'footer.php' ?>
</footer> -->

<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
