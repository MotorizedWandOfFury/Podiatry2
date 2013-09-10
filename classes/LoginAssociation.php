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
require_once './Classes/AssociationObject.php';
require_once './Classes/DatabaseObject.php';
require_once './Traits/Clean.php';

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
            $query = "SELECT * FROM " . $this->table . " WHERE username IN ('" . $this->username . "') AND password IN ('" . $this->password . "')";
        }

        return $query;
    }

    public function buildFromMySQLResult($mysqlResult) {
        $row = mysql_fetch_assoc($mysqlResult);
        if ($row) {
            $dbObj = null;
            switch ($this->table) {
                case 'physicians':
                    $dbObj = new Physician();
                    break;
                case 'patients':
                    $dbObj = new Patient();
                    break;
                case 'login':
                    $dbObj = new Admin();
                    break;
            }
            $dbObj->constructFromDatabaseArray($row);
            $this->dbObj = $dbObj;
        } else {
            echo '';
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
