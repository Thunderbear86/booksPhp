<?php
require "settings/init.php";

$books = $db->sql("SELECT * FROM books");

foreach ($books as $book){
    echo $book->bookName . "<br>";
}