<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Foot
 *
 * @author Ping
 */
class Foot implements DatabaseObject {

     const tableName = "foot_answers"; 
    private $id, $pat_id, $dateof, $type, $extremity, $answerArray, $questionArray; 
    
    
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
        $this->questionArray = array("Q4", "Q6", "Q7", "Q8", "Q10", "Q11", "Q13", "Q14", "Q15", "Q17", "Q18", "Q19", "Q20");
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
        
        if(array_key_exists('type', $paramArray)){ 
            $this->setType($paramArray['type']); 
        }
        
        if(array_key_exists('extremity', $paramArray)){
            $this->setExtremity($paramArray['extremity']);
        }
          
        foreach ($paramArray as $key => $var) { 
            if ($key === 'pat_id' || $key === 'id' || $key === 'dateof' || $key === 'type' || $key === 'extremity') {   
            } else {
                $this->setAnswer($key, $var);
                //echo "key: $key", "=>", $val, "\n";
            } 
        } 
    }

    public function generateCreateQuery() {
        $queryString = "";

        if (!isset($this->pat_id)) {
            echo "Error: Attempting to create a DatabaseObject with missing parameters";
        } else {
            $answers = implode(", ", $this->answerArray);
            $questions = implode(", ", array_keys($this->answerArray));
            $queryString = "INSERT INTO " . Foot::tableName.  " (dateof, pat_id, type, extremity, " . $questions . ") VALUES ($this->dateof, $this->pat_id, $this->type, $this->extremity, " . $answers . ")";
        }
        return $queryString;
    }

    public function generateDeleteQuery() {
        echo "DatabaseObject can not be deleted.";
    }

    public function generateReadQuery() {
        $queryString = "";
        if (isset($this->pat_id) && isset($this->type) && isset($this->extremity)) {
            $queryString = "SELECT * FROM  " . Foot::tableName.  "  WHERE pat_id = $this->pat_id AND type = $this->type AND extremity = $this->extremity";
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
        $fields = $this->mergeTwoArraysIntoString(array_keys($this->answerArray), $this->answerArray, " = '", "', ");
        if (!isset($this->id)) {
            echo "Error: attempting to update uncreated DatabaseObject";
        } else {
            $queryString = "UPDATE  " . Foot::tableName.  "  SET " . $fields . "' WHERE id = " . $this->id;
        }

        return $queryString;
    }
    
     public static function createRetrievableDatabaseObject($patientid, $type, $extremity) {
        $dbObj = new Foot($patientid);
        $dbObj->setType($type);
        $dbObj->setExtremity($extremity);
         return $dbObj;
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
    
     public function setType($value) {
        $this->type = $this->cleanInt($value);
    }

    public function getType() {
        return $this->cleanInput($this->type);
    }
    
     public function getExtremity(){
        return $this->cleanInput($this->extremity);
    }
    
    public function getExtremityFormatted(){
        switch($this->extremity){
            case 1:
                return 'L';
                break;
            case 2:
                return 'R';
                break;
        }
    }
    
    public function setExtremity($value){
        $this->extremity = $this->cleanInt($value);
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
