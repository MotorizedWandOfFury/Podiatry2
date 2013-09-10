<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Physician
 *
 * @author Yaw
 */

class Physician implements DatabaseObject {

    const tableName = "physicians";

    private $id, $username = "", $firstname = "", $lastname = "", $password = "", $role = 2, $experience = "",
            $dob = 0, $street = "", $city = "", $state = "", $zip = 0, $sex = 0, $age = 0, $phone, $email;

    use Clean {
        cleanInput as private;
        cleanInt as private;
        cleanString as private;
    }

    public function __construct($firstname = "", $lastname = "", $username = "", $password = "") {
        $this->setUsername($username);
        $this->setFirstName($firstname);
        $this->setLastName($lastname);
        $this->setPassword($password);
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
            $query = "INSERT INTO  " . Physician::tableName . "  (username, role, firstname, lastname, password, dob, street, city, state, zip, sex, age, experience, phone, email)
        VALUES ('$this->username', '$this->role', '$this->firstname', '$this->lastname', '$this->password', '$this->dob', '$this->street', '$this->city', '$this->state', '$this->zip', '$this->sex', '$this->age', '$this->experience', '$this->phone', '$this->email')";
        }

        return $query;
    }

    public function generateDeleteQuery() {
        $query = "";
        if (!isset($this->id)) {
            echo 'Error: Attempting to delete uncreated DatabaseObject';
        } else {

            $query = "DELETE FROM  " . Physician::tableName . "  WHERE id = '$this->id'";
        }

        return $query;
    }

    public function generateReadQuery() {
        $query = "";
        if (isset($this->id)) {
            $query = "SELECT * FROM  " . Physician::tableName . "  WHERE id = '$this->id'";
        } else if (isset($this->firstname) && isset($this->lastname)) {
            $query = "SELECT * FROM  " . Physician::tableName . "  WHERE firstname IN ( '" . $this->firstname . "') AND lastname IN( '" . $this->lastname . "' )";
        }

        return $query;
    }

    public function generateUpdateQuery() {
        $query = "";
        if (!isset($this->id)) {
            echo 'Error: Attempting to update uncreated DatabaseObject';
        } else {
            $query = "UPDATE  " . Physician::tableName . "  SET firstname='$this->firstname', lastname='$this->lastname', username = '$this->username', password = '$this->password', dob = '$this->dob', age = '$this->age', street = '$this->street', city = '$this->city', state = '$this->state', zip = '$this->zip', experience = '$this->experience', phone = '$this->phone', email = '$this->email' WHERE id='$this->id'";
        }

        return $query;
    }

    public function generateUniquenessCheckQuery() {
        $query = "SELECT * FROM  " . Physician::tableName;

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
            if ($firstAndLastSet && $userAndPassSet) {
                $query = $query . " AND username IN( '" . $this->username . "') AND password IN ('" . $this->password . "')";
            }
        }

        return $query;
    }

    public static function createRetrievableDatabaseObject($id, $firstname = "", $lastname = "") {
        $dbObj = new Physician();
        $dbObj->setId($id);
        $dbObj->setFirstName($firstname);
        $dbObj->setLastName($lastname);
        return $dbObj;
    }

    public function getId() {
        return $this->cleanInput($this->id);
    }

    public function setId($value) {
        $this->id = $this->cleanInt($value);
    }

    public function getUsername() {
        return $this->cleanInput($this->username);
    }

    public function setUsername($value) {
        $this->username = $this->cleanString($value);
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

    public function getExperience() {
        return $this->cleanInput($this->experience);
    }

    public function setExperience($value) {
        $this->experience = $this->cleanString($value);
    }

    public function getDOB() {
        return $this->cleanInput($this->dob);
    }

    public function getDOBFormatted() {
       return date("m-d-Y", $this->cleanInput($this->dob));
    }
    
    public function getDOBMonth(){
        return getdate($this->dob)['mon'];
    }
    public function getDOBDay(){
        return getdate($this->dob)['mday'];
    }
    public function getDOBYear(){
        return getdate($this->dob)['year'];
    }

    public function setDOB($month, $day, $year) {
        $this->dob = mktime(0, 0, 0, $this->cleanInt($month), $this->cleanInt($day), $this->cleanInt($year));
    }

    public function setDOBWithTimestamp($value) {
        $this->dob = $this->cleanInt($value);
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

    public function getStreet() {
        return $this->cleanInput($this->street);
    }

    public function setStreet($value) {
        $this->street = $this->cleanString($value);
    }

    public function getCity() {
        return $this->cleanInput($this->city);
    }

    public function setCity($value) {
        $this->city = $this->cleanString($value);
    }

    public function getState() {
        return $this->cleanInput($this->state);
    }

    public function setState($value) {
        $this->state = $this->cleanString($value);
    }

    public function getZip() {
        return $this->cleanInput($this->zip);
    }

    public function setZip($value) {
        $this->zip = $this->cleanInt($value);
    }

    public function getAge() {
        return $this->cleanInput($this->age);
    }

    public function setAge($value) {
        $this->age = $this->cleanInt($value);
    }
    public function getPhone() {
        return $this->cleanInput($this->phone);
    }

    public function setPhone($value) {
        $this->phone = $this->cleanString($value);
    }

    public function getEmail() {
        return $this->cleanInput($this->email);
    }

    public function setEmail($value) {
        $this->email = $this->cleanString($value);
    }

}

?>
