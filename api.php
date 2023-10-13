<?php
    require "settings/init.php";

    $data = json_decode(file_get_contents("php://input"), true);

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

header('Content-Type: application/json, charset=utf-8');

    if ($data["password"] == "Swordfish666"){

        $sql = "SELECT * FROM books WHERE 1=1";
        $bind = [];

        if (!empty($data["nameSearch"])) {
            $sql .= $sql. " AND bookName = :bookName ";
            $bind[":bookName"] = $data["nameSearch"];
        }

        $books = $db ->sql($sql, $bind);
        header("HTTP/1.1 200 - OK");

        echo json_encode($books);
    }
    else {

        header("HTTP/1.1 401 Unauthorized");
        $error["errorMessage"] = "Password is incorrect";
        echo json_encode($error);


    }
?>