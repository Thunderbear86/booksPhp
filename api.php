<?php
require "settings/init.php";

// Fetch the data from POST request
$nameSearch = isset($_POST["nameSearch"]) ? $_POST["nameSearch"] : null;

/*
 * password skal udfyrldes og være Swordfish666
 * namesearch: valgfrit
 */

/*
HTTP Status Codes:

Client Errors:
400 - Bad Request: The server cannot or will not process the request due to something perceived to be a client error.
401 - Unauthorized: The request requires user authentication or, if the request included authorization credentials, authorization has been refused for those credentials.
404 - Not Found: The server has not found anything matching the Request-URI.
405 - Method Not Allowed: The method specified in the Request-Line is not allowed for the resource identified by the Request-URI.
422 - Unprocessable Entity: The request was well-formed but was unable to be followed due to semantic errors.

Success Codes:
200 - OK: The request has succeeded.
201 - Created: The request has been fulfilled and resulted in a new resource being created.
204 - No Content: The server has fulfilled the request but there is no representation to return (i.e., the response is empty).
*/

$sql = "SELECT * FROM books WHERE 1=1";
$bind = [];

if (!empty($nameSearch)) {
    $sql .= " AND (bookName LIKE :search OR author LIKE :search OR genre LIKE :search OR publisher LIKE :search)";
    $bind[":search"] = '%' . $nameSearch . '%';  // Using LIKE with wildcard search
}

$books = $db->sql($sql, $bind);
?>

<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="utf-8">
    <title>Search Results - Bogpidia</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<div class="container">
    <h1>Søgeresultat for: <?php echo htmlspecialchars($nameSearch); ?></h1>

    <div class="row g-4">
        <?php if (!empty($books)): ?>
            <?php foreach ($books as $book): ?>
                <div class="col-sm-12 col-md-4 col-lg-3">
                    <div class="book-item">
                        <img class="book-cover img-fluid" src="uploads/<?php echo htmlspecialchars($book->coverImageURL); ?>" alt="Cover of <?php echo htmlspecialchars($book->bookName); ?>">
                        <h3><?php echo htmlspecialchars($book->bookName); ?></h3>
                        <p><span class="fw-bold">Forfatter:</span> <?php echo htmlspecialchars($book->author); ?></p>
                        <p><span class="fw-bold">Genre:</span> <?php echo htmlspecialchars($book->genre); ?></p>
                        <p><span class="fw-bold">Forlag:</span> <?php echo htmlspecialchars($book->publisher); ?></p>
                        <!-- Add other details as needed -->
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <p>Ingen resultater</p>
            </div>
        <?php endif; ?>
    </div>

    <a class="fw-bold mt-3 d-block" href="index.php">Til forsiden</a>
</div>


<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
