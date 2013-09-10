<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Database
 *
 * @author Yaw
 */

class Database {

    private $dbHOST = "localhost";
    private $dbUSER = "root";
    private $dbPASS = "";//"cselab29";
    private $dbNAME = "Podiatry";
    private $db_connection;

    public function __construct() {

        $this->db_connection = mysql_connect($this->dbHOST, $this->dbUSER, $this->dbPASS) or die(mysql_error());
        mysql_select_db($this->dbNAME) or die("
     <div style='color: red;'>
          <div>Don't be afraid... <b>You need the database first!</b></div>
          <div>You need to:</div>
          <div>1. Go to phpmyadmin.</div>
          <div>2. Find the import tab.</div>
          <div>3. Import the .sql file from the main folder.</div>
          <div>4. Click \"Go\" in the interface.</div>
          <div>This page will then be disabled.</div>
     </div>
");
    }

    public function __destruct() {
        mysql_close($this->db_connection);
    }
    
    public function createAssociationObject(AssociationObject $ascObj){
        $result = $this->runQuery($ascObj->generateAssociationRetrieveQuery());
        $ascObj->buildFromMySQLResult($result);
        return $ascObj;
        
    }

    public function create(DatabaseObject $dbObj) {
        if ($this->checkIfExists($dbObj)) {
            //trigger_error("DatabaseObject already exists in the database", E_USER_NOTICE);
        } else {
            $this->runQuery($dbObj->generateCreateQuery());
        }
    }

    public function read(DatabaseObject $dbObj) {
        if ($this->checkIfExists($dbObj)) {
            $result = $this->runQuery($dbObj->generateReadQuery());
            $row = mysql_fetch_assoc($result);
            $dbObj->constructFromDatabaseArray($row);
            return $dbObj;
        } else {
            //trigger_error("DatabaseObject does not exist in the database", E_USER_NOTICE);
        }
    }

    /**
     *
     * Updates a previously created DatabaseObject. It will return an error if the object wasn't inserted into the database!
     */
    public function update(DatabaseObject $dbObj) {
        if ($this->checkIfExists($dbObj)) {
            $this->runQuery($dbObj->generateUpdateQuery());
        } else {
            //trigger_error("Attempting to update a DatabaseObject that does not exist in the database", E_USER_NOTICE);
        }
    }

    public function delete(DatabaseObject $dbObj) {
        if ($this->checkIfExists($dbObj)) {
            $this->runQuery($dbObj->generateDeleteQuery());
        } else {
            //trigger_error("Attempting to delete a DatabaseObject that does not exist in the database or has not been saved to it", E_USER_NOTICE);
        }
    }

    private function runQuery($query) {
       // echo "<p>executing query: ",$query, "</p>";
        $queryResult = mysql_query($query);
        if ($queryResult) {
            return $queryResult;
        } else {
            echo "<p>", mysql_error($this->db_connection), "</p>";
        }
    }

    private function checkIfExists(DatabaseObject $dbObj) {
        $check = $this->runQuery($dbObj->generateUniquenessCheckQuery());
        $numRow = @mysql_num_rows($check);
        if ($numRow > 0) {
            //echo "Nonunique item of type ", $dbObj::tableName, " found", PHP_EOL;
            return True;
        } else {
            //echo "item of type ", $dbObj::tableName, " is unique", PHP_EOL;
            return False;
        }
    }

}

?>
