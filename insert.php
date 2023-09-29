<?php
require "settings/init.php";

if(!empty($_POST["data"])){
    $data = $_POST["data"];

    $sql = "INSERT INTO books (bookName, bookText, bookPrice, author, publicationDate, isbn, genre, publisher, pageCount, rating, coverImageURL)
        VALUES(:bookName, :bookText, :bookPrice, :author, :publicationDate, :isbn, :genre, :publisher, :pageCount, :rating, :coverImageURL)";

    $bind = [
        ":bookName" => $data["bookName"],
        ":bookText" => $data["bookText"],
        ":bookPrice" => $data["bookPrice"],
        ":author" => $data["author"],
        ":publicationDate" => $data["publicationDate"],
        ":isbn" => $data["isbn"],
        ":genre" => $data["genre"],
        ":publisher" => $data["publisher"],
        ":pageCount" => $data["pageCount"],
        ":rating" => $data["rating"],
        ":coverImageURL" => $data["coverImageURL"] // Replace with the actual cover image URL
    ];

    $db->sql($sql, $bind, false);

    echo "Produktet er nu indsat. <a href='insert.php'>Indsæt et produkt mere</a>";
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

    <script src="https://cdn.tiny.cloud/1/bqcqec3q48h6ukfz7c5dheheg8mf0g4iflqjsh92vtrn5efc/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

</head>

<body>

<form method="post" action="insert.php">
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="bookName">Navn på bog</label>
                <input class="form-control" type="text" name="data[bookName]" id="bookName" placeholder="" value="">
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="bookPrice">Pris på bog</label>
                <input class="form-control" type="number" step="0.1" name="data[bookPrice]" id="bookPrice" placeholder="" value="">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="bookText">Bogbeskrivelse</label>
                <textarea class="form-control" name="data[bookText]" id="bookText"></textarea>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="author">Forfatter(e)</label>
                <input class="form-control" type="text" name="data[author]" id="author" placeholder="" value="">
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="publicationDate">Udgivelsesdato</label>
                <input class="form-control" type="datetime" name="data[publicationDate]" id="publicationDate" placeholder="" value="">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="isbn">ISBN13</label>
                <input class="form-control" type="text" name="data[isbn]" id="isbn" placeholder="" value="">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="coverImageURL">Billede URL</label>
                <input class="form-control" type="url" name=data"[coverImageURL]" id="coverImageURL" placeholder="" value="">
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
                <input class="form-control" type="text" name="data[publisher]" id="publisher" placeholder="" value="">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="pageCount">Antal sider</label>
                <input class="form-control" type="number" name="data[pageCount]" id="pageCount" placeholder="" value="">
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="rating">Bedømmelse</label>
                <input class="form-control" type="decimal" name="data[rating]" id="rating" placeholder="" value="">
            </div>
        </div>
        <div class="col-12 col-md-6 offset-md-6">
            <button class="form-control btn btn-primary" type="submit" id="btnSubmit">Opret produkt</button>
        </div>
    </div>
</form>




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
