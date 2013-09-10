<?php

/**
 * Description of PreOpScore
 *
 * @author Yaw
 */

class PreOpScore implements DatabaseObject {

    const tableName = "pre_opscore";
    private $id, $pat_id, $dateof, $answerArray;

    use Clean {
        cleanInput as private;
        cleanString as private;
        cleanInt as private;
    }

use CustomArrayOperations {
        mergeTwoArraysIntoString as private;
        subsetOfArray as private;
    }

    public function __construct($patientid = 0, $month = 1, $day = 1, $year = 1900) {
        $this->setPatientID($patientid);
        $this->setDateOf($month, $day, $year);
    }

    public function constructFromDatabaseArray(array $paramArray) {
        if(array_key_exists('pat_id', $paramArray)){
            $this->setPatientID($paramArray['pat_id']);
        }
        
        if(array_key_exists('id', $paramArray)){
            $this->setID($paramArray['id']);
        }
        
        if(array_key_exists('dateof', $paramArray)){
            $this->setDateOfByTimeStamp($paramArray['dateof']);
        }
        
        foreach ($paramArray as $key => $var) {
            if ($key === 'pat_id' || $key === 'id' || $key === 'dateof') {
            } else {
                $this->setAnswer($key, $var);
                //echo "$key => $var", "\n";
            }
        }
    }

    public function generateCreateQuery() {
        $queryString = "";

        if (!isset($this->pat_id) || !isset($this->dateof)) {
            echo "Error: Attempting to create a DatabaseObject with missing parameters";
        } else {
            $answers = implode(", ", $this->answerArray);
            $questions = implode(", ", array_keys($this->answerArray));
            $queryString = "INSERT INTO " . PreOpScore::tableName.  " (dateof, pat_id, " . $questions . ") VALUES ($this->dateof, $this->pat_id, " . $answers . ")";
        }
        return $queryString;
    }

    public function generateReadQuery() {
        $queryString = "";
        if (isset($this->pat_id) && isset($this->dateof)) {
            $queryString = "SELECT * FROM  " . PreOpScore::tableName.  "  WHERE dateof = $this->dateof AND pat_id = $this->pat_id";
        } else {
            echo "Error: there was an error in the parameters of the retrievable DatabaseObject";
        }

        return $queryString;
    }

    public function generateDeleteQuery() {
        echo "DatabaseObject can not be deleted.";
    }

    public function generateUpdateQuery() {
        $queryString = "";
        $fields = $this->mergeTwoArraysIntoString(array_keys($this->answerArray), $this->answerArray, " = ", ", ");
        if (!isset($this->id)) {
            echo "Error: attempting to update uncreated DatabaseObject";
        } else {
            $queryString = "UPDATE  " . PreOpScore::tableName.  "  SET " . $fields . " WHERE id = " . $this->id;
        }

        return $queryString;
    }
    
    public function generateUniquenessCheckQuery(){
        $query = $this->generateReadQuery();      
        return $query;
    }

    public static function createRetrievableDatabaseObject($patientid = "", $month = 0, $day = 0, $year = 0) {
        return new PreOpScore($patientid, $month, $day, $year);
    }

    public function getID() {
        return $this->cleanInput($this->id);
    }

    private function setID($value) {
        $this->id = $this->cleanInt($value);
    }

    public function getPatientID() {
        return $this->cleanInput($this->pat_id);
    }

    private function setPatientID($value) {
        $this->pat_id = $this->cleanInt($value);
    }

    public function getDateOf() {
        return $this->cleanInput($this->dateof);
    }

    public function getDateOfFormatted() {
        return date("m-d-Y", $this->cleanInput($this->dateof));
    }

    public function setDateOf($month, $day, $year) {
        $this->dateof = mktime(0, 0, 0, $this->cleanInt($month), $this->cleanInt($day), $this->cleanInt($year));
    }

    public function setDateOfByTimeStamp($value) {
        $this->dateof = $this->cleanInt($value);
    }

    public function getAnswer($index) {
        if (array_key_exists($index, $this->answerArray)) {
            return $this->cleanInput($this->answerArray[$index]);
        } else {
            return null;
        }
    }

    public function setAnswer($index, $answer) {
        $this->answerArray[$this->cleanString($index)] = $this->cleanInt($answer);
    }


}

?>
