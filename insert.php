<?php
require "settings/init.php";

if (!empty($_POST["data"])) {
    $data = $_POST["data"];
    $file = $_FILES;

    // Parse the publication date and format it as YYYY-MM-DD
    $publicationDate = DateTime::createFromFormat('d-m-Y', $data["publicationDate"]);
    if ($publicationDate !== false) {
        $publicationDate = $publicationDate->format('Y-m-d');
    } else {
        // Invalid date format, handle the error or set a default value
        $publicationDate = null; // You can set a default date or handle the error as needed
    }

    // Ensure that bookPrice is formatted correctly
    $bookPrice = floatval(str_replace(',', '.', $data["bookPrice"]));

    $sql = "INSERT INTO books (bookName, bookText, bookPrice, author, publicationDate, isbn, genre, publisher, pageCount, rating, coverImageURL)
        VALUES(:bookName, :bookText, :bookPrice, :author, :publicationDate, :isbn, :genre, :publisher, :pageCount, :rating, :coverImageURL)";

    $bind = [
        ":bookName" => $data["bookName"],
        ":bookText" => $data["bookText"],
        ":bookPrice" => $bookPrice,
        ":author" => $data["author"],
        ":publicationDate" => $publicationDate, // Use the formatted date
        ":isbn" => $data["isbn"],
        ":genre" => $data["genre"],
        ":publisher" => $data["publisher"],
        ":pageCount" => $data["pageCount"],
        ":rating" => $data["rating"],
        ":coverImageURL" => (!empty($file["coverImageURL"]["tmp_name"])) ? $file["coverImageURL"]["name"] : NULL,
    ];

    // Insert the book into the database
    $db->sql($sql, $bind, false);

    // Get the last inserted bookId
    $lastInsertedBookId = $db->lastInsertId();

    // Create the filename for the book detail page
    $bookDetailPageFilename = "books/book_" . $lastInsertedBookId . ".php";

// Copy the template file to the new location
    $templateFilePath = "books/book_detail.php";
    if (!file_exists($templateFilePath)) {
        echo "Template file not found: $templateFilePath";
        exit;
    }

    $bookDetailPageFilename = "books/book_" . $lastInsertedBookId . ".php";
    if (!copy($templateFilePath, $bookDetailPageFilename)) {
        echo "Failed to copy the template file to the destination.";
        exit;
    }

// Replace placeholders in the new file with actual content
    $bookDetailContent = file_get_contents($bookDetailPageFilename);
    if ($bookDetailContent === false) {
        echo "Failed to read the newly created file: $bookDetailPageFilename";
        exit;
    }

// Replace placeholders with actual book details (if needed)
    $bookDetailContent = str_replace('{{BOOK_ID}}', $lastInsertedBookId, $bookDetailContent);

// Save the modified content back to the file
    if (file_put_contents($bookDetailPageFilename, $bookDetailContent) === false) {
        echo "Failed to write the modified content back to the file: $bookDetailPageFilename";
        exit;
    }

    echo "Produktet er nu indsat. <a href='insert.php'>Indsæt et produkt mere</a> eller <a href='index.php'>gå til forsiden</a>.";
    exit;

}

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

    <script src="https://cdn.tiny.cloud/1/ul8c9hibtyvcapqu9iwhikjy9z84erdw2bw40aq7kivxno5u/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

</head>

<body>

<header>
    <?php include 'navbar.php' ?>
</header>

<div class="container-fluid form1 pt-3">
    <div class="row">

<div class="col">
    <form method="post" action="insert.php" enctype="multipart/form-data">
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="bookName" class="form-label">Navn på bog</label>
                    <input class="form-control" type="text" name="data[bookName]" id="bookName" placeholder="" value="">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="bookPrice" class="form-label">Pris på bog</label>
                    <input class="form-control" type="text" name="data[bookPrice]" id="bookPrice" placeholder="" value="">

                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="coverImageURL" class="form-label">Upload billede</label>
                    <input class="form-control" type="file" name="coverImageURL" id="coverImageURL" placeholder=""
                           value="">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="bookText" class="form-label">Bogbeskrivelse</label>
                    <textarea class="form-control" name="data[bookText]" id="bookText"></textarea>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="author" class="form-label">Forfatter(e)</label>
                    <input class="form-control" type="text" name="data[author]" id="author" placeholder="" value="">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="publicationDate" class="form-label">Udgivelsesdato</label>
                    <input class="form-control" type="text" name="data[publicationDate]" id="publicationDate" placeholder="DD-MM-ÅÅÅÅ" value="">

                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="isbn" class="form-label">ISBN13</label>
                    <input class="form-control" type="text" name="data[isbn]" id="isbn" placeholder="" value="">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="genre">Genre</label>
                    <select class="form-control" name="data[genre]" id="genre">
                        <option value="Skønlitteratur">Skønlitteratur</option>
                        <option value="Faglitteratur">Faglitteratur</option>
                        <option value="Krimi">Krimi</option>
                        <option value="Thriller">Thriller</option>
                        <option value="Science Fiction">Science Fiction</option>
                        <option value="Fantasy">Fantasy</option>
                        <option value="Romantik">Romantik</option>
                        <option value="Biografi">Biografi</option>
                        <option value="Gyser">Gyser</option>
                        <option value="Ungdomslitteratur">Ungdomslitteratur</option>
                        <option value="Børnebøger">Børnebøger</option>
                        <option value="Videnskab">Videnskab</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="publisher">Forlag</label>
                    <input class="form-control" type="text" name="data[publisher]" id="publisher" placeholder=""
                           value="">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="pageCount">Antal sider</label>
                    <input class="form-control" type="number" name="data[pageCount]" id="pageCount" placeholder=""
                           value="">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="rating">Bedømmelse</label>
                    <input class="form-control" type="decimal" name="data[rating]" id="rating" placeholder="" value="">
                </div>
            </div>
            <div class="col-12 col-md-6 offset-md-6">
                <button class="form-control btn btn-primary" type="submit" id="btnSubmit">Opret bog</button>
            </div>
        </div>
    </form>
</div>

    </div>
</div>

<!-- <footer class="pt-3">
    <?php include 'footer.php' ?>
</footer> -->

<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'ai tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        mergetags_list: [
            { value: 'First.Name', title: 'First Name' },
            { value: 'Email', title: 'Email' },
        ],
        ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant"))
    });
</script>

</body>
</html>
