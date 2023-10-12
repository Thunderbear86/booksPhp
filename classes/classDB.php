<?php

class db {
    private $dbCon;
    private $prepare_result;
    public $lastQuery;

    private $DB_SERVER;
    private $DB_NAME;
    private $DB_USER;
    private $DB_PASS;

    /**
     * db constructor.
     * @param null $DB_SERVER
     * @param null $DB_NAME
     * @param null $DB_USER
     * @param null $DB_PASS
     */
    function __construct($DB_SERVER, $DB_NAME, $DB_USER, $DB_PASS) {

        $this->DB_SERVER = $DB_SERVER;
        $this->DB_NAME = $DB_NAME;
        $this->DB_USER = $DB_USER;
        $this->DB_PASS = $DB_PASS;

        $this->openConnection();
    }

    /**
     * db destruct
     */
    function __destruct() {
        $this->closeConnection();
    }

    /**
     * Open connection
     */
    private function openConnection() {
        try{
            $this->dbCon = new PDO("mysql:host=".$this->DB_SERVER.";dbname=".$this->DB_NAME,$this->DB_USER,$this->DB_PASS);
            // Sætter databasen til utf-8
            $this->dbCon->exec("set names utf8");
            $this->dbCon->setAttribute(PDO::ATTR_EMULATE_PREPARES, TRUE);
            $this->dbCon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            if(CONFIG_LIVE == 1) {
                exit('Problems with database. We have been notified');
            } else {
                die($e->getMessage());
            }

        }
    }

    /**
     * Close connection
     */
    private function closeConnection() {
        if(isset($this->dbCon)) {
            $this->dbCon = NULL;
            $this->lastQuery = NULL;
            $this->prepare_result = NULL;
        }
    }

    /**
     * @param $sql  = SQL to run
     */
    private function sqlQuery($sql) {
        $this->lastQuery = $sql;
        try{
            if(!$this->prepare_result = $this->dbCon->prepare($sql)){
                throw new Exception("PDO prepare error");
            }
        }catch (Exception $e){
            if (CONFIG_LIVE == 0) {
                die($e->getMessage());
            }
            exit;
        }
    }

    /**
     * @param $binds = Values to bind in array
     */
    private function sqlBindValues($binds){
        try{
            foreach ($binds as $pKey => $pValue){
                $this->prepare_result->bindValue($pKey, $pValue);
                $this->lastQuery = str_replace($pKey, $pValue, $this->lastQuery);
            }
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    private function sqlExecute(){
        try{
            $this->prepare_result->execute();
            return $this->prepare_result;
        }catch (Exception $e){
            // Test mode shows errors and the last executed SQL
            if (CONFIG_LIVE == "0") {
                $output = "<strong>Error message: </strong>".$e->getMessage()."<br><br>";
                $output .= "<strong>In file:</strong> ".$e->getFile().":".$e->getLine()."<br><br>";
                $output .= "<strong>Stack trace:</strong><pre>".$e->getTraceAsString()."</pre>";
                $output .= "<strong>Last SQL query:</strong><br><code>" . $this->lastQuery . "</code><br>";
            } else {
                $output = "An error has occurred in the database.";
            }
            echo $output;
            exit;
        }
    }

    /**
     * Get the last inserted auto-increment ID.
     * @return string
     */
    public function lastInsertId() {
        return $this->dbCon->lastInsertId();
    }

    public function sql($sql="", $binds=[], $select=true) {
        $result = [];

        $this->sqlQuery($sql);

        if(!empty($binds)) {
            $this->sqlBindValues($binds);
        }

        $dbResult = $this->sqlExecute();

        if($select){
            while($row =  $dbResult->fetch(PDO::FETCH_OBJ)) {
                $result[] = $row;
            }
            return $result;
        } else {
            return $dbResult;
        }
    }
    public function createBookPage($bookId) {
        // Get the book data from the database
        $bookData = $this->sql("SELECT * FROM books WHERE book_id = :bookId", [':bookId' => $bookId]);

        // Check if the book data exists
        if (!$bookData) {
            return false; // Book not found
        }

        // Open the template file and read the contents into a string
        $templateFile = 'books/book_detail.php';
        $template = file_get_contents($templateFile);

        // Replace the placeholder values in the template with the data from the database
        $template = str_replace('{{bookName}}', $bookData[0]->title, $template);
        $template = str_replace('{{bookAuthor}}', $bookData[0]->author, $template);
        $template = str_replace('{{bookText}}', $bookData[0]->description, $template);

        // Write the generated HTML to a new PHP file
        $newPageFile = 'books/' . $bookId . '.php';
        file_put_contents($newPageFile, $template);

        return $newPageFile;
    }
}

?>
