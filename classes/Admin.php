<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Admin
 *
 * @author Yaw
 */

class Admin implements DatabaseObject {
    
    const tableName = "login";
    private $id, $username, $password, $role = 3, $firstname, $lastname, $sex;
    
    use Clean {
        cleanInput as private;
        cleanInt as private;
        cleanString as private;
    }

    public function __construct($username = "", $password = "", $firstname = "", $lastname = "", $sex = 1) {
        $this->setUsername($username);
        $this->setFirstName($firstname);
        $this->setLastName($lastname);
        $this->setPassword($password);
        $this->setSex($sex);
    }
    
    public function constructFromDatabaseArray(array $paramArray) {
        foreach ($this as $var => &$value) {
            if (array_key_exists($var, $paramArray))
                $value = $this->cleanInput($paramArray[$var]);
            //echo "$var => $value", "\n";
        }
        unset($value);
    }

    public function generateCreateQuery() {
        $query = "";
        if (isset($this->id)) {
            echo 'Error: Creating a DatabaseObject that already exists';
        } else {
            $query = "INSERT INTO  " . Admin::tableName .  "  (username, role, firstname, lastname, password, sex)
        VALUES ('$this->username', '$this->role', '$this->firstname', '$this->lastname', '$this->password', '$this->sex')";
        }
        
        return $query;
    }

    public function generateDeleteQuery() {
        $query = "";
        if (!isset($this->id)) {
            echo 'Error: Attempting to delete uncreated DatabaseObject';
        } else {

            $query = "DELETE FROM  " . Admin::tableName .  "  WHERE id = '$this->id'";
        }

        return $query;
    }

    public function generateReadQuery() {
        $query = "";
        if (isset($this->firstname) && isset($this->lastname)) {
            $query = "SELECT * FROM  " . Admin::tableName .  "  WHERE firstname IN ( '" . $this->firstname . "' ) AND lastname IN( '" . $this->lastname . "' )";
        }

        return $query;
    }

    public function generateUpdateQuery() {
        $query = "";
        if (!isset($this->id)) {
            echo 'Error: Attempting to update uncreated DatabaseObject';
        } else {
            $query = "UPDATE  " . Admin::tableName .  "  SET firstname='$this->firstname', lastname='$this->lastname', username = '$this->username', password = '$this->password' WHERE id='$this->id'";
        }

        return $query;
    }
    
    public function generateUniquenessCheckQuery(){
        $query = "SELECT * FROM  " . Admin::tableName;

        $firstAndLastSet = isset($this->firstname) && isset($this->lastname);
        $userAndPassSet = isset($this->username) && isset($this->password);
        
        if (isset($this->id)) {
            $query = $query . "  WHERE id = '$this->id'";
        } else {
            if ($firstAndLastSet) {
                $query = $query . " WHERE firstname IN ( '" . $this->firstname . "') AND lastname IN( '" . $this->lastname . "' )";
            } else {
                echo 'Error: Not enough parameters defined to determine uniqeness';
                $query = "";
            }
            if($firstAndLastSet && $userAndPassSet){
                $query = $query . " AND username IN( '" .$this->username. "') AND password IN ('".$this->password."')";
            }
        }
        
        return $query;
    }

    public static function createRetrievableDatabaseObject($firstname = NULL, $lastname = NULL, $param3 = NULL, $param4 = NULL) {
        $dbObj = new Admin();
        $dbObj->setFirstName($firstname);
        $dbObj->setLastName($lastname);
        return $dbObj;
    }
    
    public function getID() {
        return $this->cleanInput($this->id);
    }

    public function getUsername() {
        return $this->cleanInput($this->username);
    }

    public function setUsername($value) {
        $this->username = $this->cleanString($value);
    }
    
    public function getRole() {
        return $this->cleanInput($this->role);
    }

    
    public function getSex() {
        return $this->cleanInput($this->sex);
    }

    public function setSex($value) {
        $this->sex = $this->cleanInt($value);
    }
    
    public function getFirstName() {
        return $this->cleanInput($this->firstname);
    }

    public function setFirstName($value) {
        $this->firstname = $this->cleanString($value);
        
    }

    public function getLastName() {
        return $this->cleanInput($this->lastname);
    }

    public function setLastName($value) {
        $this->lastname = $this->cleanString($value);
    }

    public function getPassword() {
        return $this->cleanInput($this->password);
    }

    public function setPassword($value) {
        $this->password = mysql_real_escape_string(sha1($this->cleanString($value)));
    }

}

?>
