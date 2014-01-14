<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Patient
 *
 * @author Yaw
 */

class Patient implements DatabaseUserObject {

    const tableName = "patients";

    private $id, $username = "", $role = 1, $firstname = "", $lastname = "", $password = "", $doctor = 0,
            $dob = 0, $street = "", $city = "", $state = "", $zip = 0, $sex, $email, $phone, $medicalrecordnumber;

    use Clean {
        cleanInput as private;
        cleanInt as private;
        cleanString as private;
    }

    public function __construct($username = "", $firstname = "", $lastname = "", $password = "", $doctor = 0, $sex = 0) {

        $this->setUsername($username);
        $this->setFirstName($firstname);
        $this->setLastName($lastname);
        $this->setPassword($password);
        $this->setDoctor($doctor);
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
            $query = "INSERT INTO " . Patient::tableName . " (username, role, firstname, lastname, password, doctor, dob, street, city, state, zip, sex, email, phone, medicalrecordnumber)
        VALUES ('$this->username', '$this->role', '$this->firstname', '$this->lastname', '$this->password', '$this->doctor', '$this->dob', '$this->street', '$this->city', '$this->state', '$this->zip', '$this->sex', '$this->email', '$this->phone', '$this->medicalrecordnumber')";
        }

        return $query;
    }

    public function generateReadQuery() {
        $query = "";
        if (isset($this->id)) {
            $query = "SELECT * FROM  " . Patient::tableName . "  WHERE id = '$this->id'";
        } else if (isset($this->firstname) && isset($this->lastname)) {
            $query = "SELECT * FROM  " . Patient::tableName . "  WHERE firstname IN ( '" . $this->firstname . "') AND lastname IN( '" . $this->lastname . "' )";
        }

        return $query;
    }

    public function generateUpdateQuery() {
        $query = "";
        if (!isset($this->id)) {
            echo 'Error: Attempting to update uncreated DatabaseObject';
        } else {
            $query = "UPDATE  " . Patient::tableName . "  SET firstname='$this->firstname', lastname='$this->lastname', username = '$this->username', password = '$this->password', dob = '$this->dob', street = '$this->street', city = '$this->city', state = '$this->state', zip = '$this->zip', phone = '$this->phone', email = '$this->email' WHERE id='$this->id'";
        }

        return $query;
    }

    public function generateDeleteQuery() {
        $query = "";
        if (!isset($this->id)) {
            echo 'Error: Attempting to delete uncreated DatabaseObject';
        } else {

            $query = "DELETE FROM  " . Patient::tableName . "  WHERE id = '$this->id'";
        }

        return $query;
    }

    public function generateUniquenessCheckQuery() {
        $query = "SELECT * FROM  " . Patient::tableName;

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

    public static function createRetrievableDatabaseObject($id, $firstname = "", $lastname = "") {
        $dbObj = new Patient();
        $dbObj->setId($id);
        $dbObj->setFirstName($firstname);
        $dbObj->setLastName($lastname);
        return $dbObj;
    }

    public function getID() {
        return $this->cleanInput($this->id);
    }

    public function setID($value) {
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

    public function getDoctor() {
        return $this->cleanInput($this->doctor);
    }

    public function setDoctor($value) {
        $this->doctor = $this->cleanInt($value);
    }

    
    public function getMedicalRecordNumber() {
        return $this->cleanInput($this->medicalrecordnumber);
    }

    public function setMedicalRecordNumber($value) {
        $this->medicalrecordnumber = $this->cleanString($value);
    }
    

    public function getRole() {
        return $this->cleanInput($this->role);
    }

    public function setRole($value) {
        $this->role = $this->cleanInt($value);
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

    public function setDOBWithDate($value) {
        $this->dob = $this->cleanInt($value);
    }

    public function getSex() {
        return $this->cleanInput($this->sex);
    }
    
    public function getSexFormatted(){
        switch ($this->sex) {
            case 1:
                return 'M';
                break;
            case 2:
                return 'F';
                break;

        }    
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
        if($this->dob <= 0){
            return "Birthdate not set";
        }
        
        $age = date("Y") - date("Y", $this->dob);
        
        $currMonth = date("n");
        $birthMonth = date("n", $this->dob);
        $currDay = date("j");
        $birthDay = date("j", $this->dob);
        if($currMonth <  $birthMonth || $currMonth == $birthMonth && $currDay < $birthDay){ //subtract a year if birthday has not yet been reached
            $age--;
        }
        
        return $age;
    }

    public function getPhone() {
        return $this->cleanInput($this->phone);
    }

    public function setPhone($value) {
        $this->phone = $this->cleanInt($value);
    }

    public function getEmail() {
        return $this->cleanInput($this->email);
    }

    public function setEmail($value) {
        $this->email = $this->cleanString($value);
    }

}

?>
