<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Represents Patient Demographics
 *
 * @author Yaw
 */
class Demo implements DatabaseObject {

    const tableName = "demo_answers";

    private $id, $pat_id, $dateof, $answerArray, $questionArray;

    use Clean {
        cleanInput as private;
        cleanString as private;
        cleanInt as private;
    }

use CustomArrayOperations {
        mergeTwoArraysIntoString as private;
        subsetOfArray as private;
    }

    public function __construct($patientid, $month = 1, $day = 1, $year = 1900) {
        $this->setPatientID($patientid);
        $this->setDateOf($month, $day, $year);
        $this->questionArray = array("Q1","Q2","Q3", "Q4", "Q5", "Q6");
    }

    public function constructFromDatabaseArray(array $paramArray) {
        if (array_key_exists('pat_id', $paramArray)) {
            $this->setPatientID($paramArray['pat_id']);
        }

        if (array_key_exists('id', $paramArray)) {
            $this->setId($paramArray['id']);
        }

        if (array_key_exists('dateof', $paramArray)) {
            $this->setDateOfByTimeStamp($paramArray['dateof']);
        }

        foreach ($paramArray as $key => $var) {
            if ($key === 'pat_id' || $key === 'id' || $key === 'dateof') {     
            } else {
                $this->setAnswer($key, $var);
                //echo "key: $key", "=>", $val, "\n";
            }
        }
    }

    public function generateCreateQuery() {
        $queryString = "";

        $answers = implode(", ", $this->answerArray);
        $questions = implode(", ", array_keys($this->answerArray));
        $queryString = "INSERT INTO " . Demo::tableName . " (dateof, pat_id, " . $questions . ") VALUES ($this->dateof, $this->pat_id, " . $answers . ")";
        return $queryString;
    }

    public function generateDeleteQuery() {
        echo "DatabaseObject can not be deleted.";
    }

    public function generateReadQuery() {
        $queryString = "";
        if (isset($this->pat_id)) {
            $queryString = "SELECT * FROM  " . Demo::tableName . "  WHERE pat_id = $this->pat_id";
        } else {
            echo "Error: there was an error in the parameters of the retrievable DatabaseObject";
        }

        return $queryString;
    }

    public function generateUniquenessCheckQuery() {
        $query = $this->generateReadQuery();
        return $query;
    }

    public function generateUpdateQuery() {
        $queryString = "";
        $fields = $this->mergeTwoArraysIntoString(array_keys($this->answerArray), $this->answerArray, " = ", ", ");
        if (!isset($this->id)) {
            echo "Error: attempting to update uncreated DatabaseObject";
        } else {
            $queryString = "UPDATE  " . Demo::tableName . "  SET " . $fields . " WHERE id = " . $this->id;
        }

        return $queryString;
    }
    
    public static function createRetrievableDatabaseObject($patientid) { 
        return new Demo($patientid); 
    }

    public function getId() {
        return $this->cleanInput($this->id);
    }

    private function setId($value) {
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
        if (in_array($index, $this->questionArray)) {
            $this->answerArray[$this->cleanString($index)] = $this->cleanInt($answer);
        }
    }

}

?>
