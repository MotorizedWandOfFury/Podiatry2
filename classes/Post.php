<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Post
 *
 * @author Ping
 */
class Post implements DatabaseObject{
    
    const tableName = "post_answers";
    private $id, $pat_id, $sur_id, $type, $dateof, $dateofexam = "", $painmedused, $dosepainmedused, $answerArray, $questionArray;

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
        $this->questionArray = array("Q4", "Q5", "Q6", "Q7", "Q8", "Q9", "Q10", "Q11", "Q12", "Q13", "Q14");
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
        
        if(array_key_exists('dateofexam', $paramArray)){
            $this->setDateOfExamByTimeStamp($paramArray['dateofexam']);
        }
        
        if(array_key_exists('sur_id', $paramArray)){
            $this->setSurId($paramArray['sur_id']);
        }
        
        if(array_key_exists('painmedused', $paramArray)){
            $this->setPainMedUsed($paramArray['painmedused']);
        }
        
        if(array_key_exists('dosepainmedused', $paramArray)){
            $this->setDosePainMedUsed($paramArray['dosepainmedused']);
        }
        
        if(array_key_exists('type', $paramArray)){ 
            $this->setType($paramArray['type']); 
        }
        
        foreach ($paramArray as $key => $var) {
            if ($key === 'pat_id' || $key === 'id' || $key === 'dateof' || $key === 'dateofexam' || $key === 'sur_id' || $key === 'painmedused' || $key === 'dosepainmedused' || $key === 'type') {
            } else {
                $this->setAnswer($key, $var);
                //echo "$key => $var", "\n";
            }
        }
    }

    public function generateCreateQuery() {
        $queryString = ""; 
  
        if (isset($this->sur_id) && isset($this->painmedused) && isset($this->dosepainmedused) && isset($this->dateofexam)) { 
            $answers = implode(", ", $this->answerArray); 
            $questions = implode(", ", array_keys($this->answerArray)); 
            $queryString = "INSERT INTO " . Post::tableName.  " (dateof, pat_id, sur_id, dateofexam, painmedused, dosepainmedused, type, " . $questions . ") VALUES ($this->dateof, $this->pat_id, $this->sur_id, $this->dateofexam, $this->painmedused, $this->dosepainmedused, $this->type, " . $answers . ")";  
        } else { 
            echo "Error: Attempting to create a DatabaseObject with missing parameters";
            
        } 
        return $queryString; 
    }

    public function generateDeleteQuery() {
         echo "DatabaseObject can not be deleted.";
    }

    public function generateReadQuery() {
        $queryString = ""; 
        if (isset($this->pat_id) && isset($this->dateof)) { 
            $queryString = "SELECT * FROM  " . Post::tableName.  "  WHERE pat_id = $this->pat_id AND type = $this->type"; 
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
            $queryString = "UPDATE  " . Post::tableName.  "  SET dateofexam = $this->dateofexam, painmedused = $this->painmedused, dosepainmedused = $this->dosepainmedused, " . $fields . "' WHERE id = " . $this->id; 
        } 
  
        return $queryString; 
    }
    
    public static function createRetrievableDatabaseObject($patientid, $type) { 
        $dbObj = new Post($patientid); 
        $dbObj->setType($type);
        return $dbObj;
    }
    
    public function getSurId(){
        return $this->cleanInput($this->sur_id);
    }
    public function setSurId($value){
        $this->sur_id = $this->cleanInt($value);
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
    
    public function getDateOfExam() { 
        return $this->cleanInput($this->dateofexam); 
    } 
  
    public function getDateOfExamFormatted() { 
        return date("m-d-Y", $this->cleanInput($this->dateofexam)); 
    }
    
    public function setDateOfExam($month, $day, $year) { 
        $this->dateofexam = mktime(0, 0, 0, $this->cleanInt($month), $this->cleanInt($day), $this->cleanInt($year)); 
    } 
  
    public function setDateOfExamByTimeStamp($value) { 
        $this->dateofexam = $this->cleanInt($value); 
    }
    
    public function getPainMedUsed(){
        return $this->cleanInput($this->painmedused);
    }
    
    public function setPainMedUsed($value){
        $this->painmedused = $this->cleanInt($value);
    }
    
    public function getDosePainMedUsed(){
        return $this->cleanInput($this->dosepainmedused);
    }
    
    public function setDosePainMedUsed($value){
        $this->dosepainmedused = $this->cleanInt($value);
    }

    public function getAnswer($index) {
        if (array_key_exists($index, $this->answerArray)) {
            return $this->cleanInput($this->answerArray[$index]);
        } else {
            return null;
        }
    }

    public function setAnswer($index, $answer) {
        if(in_array($index, $this->questionArray)){
            $this->answerArray[$this->cleanString($index)] = $this->cleanInt($answer);
        }
        
    }
}

?>
