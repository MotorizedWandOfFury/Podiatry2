<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoginAssociation
 *
 * @author Yaw
 */

class LoginAssociation implements AssociationObject {

    private $username, $password, $table, $dbObj;

    use Clean {
        cleanInput as private;
        cleanInt as private;
        cleanString as private;
    }

    public function __construct($username, $password, $table) {
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setTable($table);
    }

    public function generateAssociationRetrieveQuery() {
        $query = "";

        if (!isset($this->username) || !isset($this->password) || !isset($this->table)) {
            echo 'Attempting to create AssociationObject with missing parameters';
        } else {
            $query = "SELECT * FROM " . $this->table . " WHERE username IN ('" . $this->username . "') AND `password` IN ('" . $this->password . "')";
            //echo $query;
        }

        return $query;
    }

    public function buildFromMySQLResult($mysqlResult) {
        $row = mysql_fetch_assoc($mysqlResult);
        if ($row) {
            $dbObj = null;
            switch ($this->table) {
                case Physician::tableName:
                    $dbObj = new Physician();
                    break;
                case Patient::tableName:
                    $dbObj = new Patient();
                    break;
                case Admin::tableName:
                    $dbObj = new Admin();
                    break;
            }
            $dbObj->constructFromDatabaseArray($row);
            $this->dbObj = $dbObj;
        } else {
            //echo 'DatabaseObject not found with given parameters';
        }
    }

    public function setUsername($value) {
        $this->username = $this->cleanString($value);
    }

    public function getUsername() {
        return $this->cleanInput($this->username);
    }

    public function getPassword() {
        return $this->cleanInput($this->password);
    }

    public function setPassword($value) {
        $this->password = mysql_real_escape_string(sha1($this->cleanString($value)));
    }

    public function setTable($value) {
        $this->table = $this->cleanString($value);
    }

    public function getTable() {
        return $this->cleanInput($this->table);
    }

    public function getDbObj() {
        return $this->dbObj;
    }

}

?>
