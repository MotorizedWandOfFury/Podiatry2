<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Complications
 *
 * @author Ping
 */
class Complications implements DatabaseObject {

    const tableName = "complications_answers";

    private static $questionArray = array("Q5", "Q6", "Q7", "Q8", "Q9", "Q10", "Q11", "Q12", "Q13");
    private $id, $pat_id, $sur_id, $dateofexam, $dateof, $dateofrevisionalsurgery = 0, $dateofothercomplications = 0, $extremity, $answerArray;

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
        if (array_key_exists('pat_id', $paramArray)) {
            $this->setPatientID($paramArray['patientid']);
        }

        if (array_key_exists('id', $paramArray)) {
            $this->setID($paramArray['id']);
        }

        if (array_key_exists('dateof', $paramArray)) {
            $this->setDateOfByTimeStamp($paramArray['dateof']);
        }
          
        if(array_key_exists('extremity', $paramArray)){
            $this->setExtremity($paramArray['extremity']);
        }
        
        if(array_key_exists('sur_id', $paramArray)){
            $this->setExtremity($paramArray['sur_id']);
        }
        
        if(array_key_exists('dateofexam', $paramArray)){
            $this->setExtremity($paramArray['dateofexam']);
        }
        
        if(array_key_exists('dateofrevisionalsurgery', $paramArray)){
            $this->setExtremity($paramArray['dateofrevisionalsurgery']);
        }
        
        if(array_key_exists('dateofothercomplications', $paramArray)){
            $this->setExtremity($paramArray['dateofothercomplications']);
        }

        foreach ($paramArray as $key => $var) {
           $this->setAnswer($key, $var);
           //echo "$key => $var", "\n"; 
        }
    }

    public function generateCreateQuery() {
        $queryString = "";

        if (isset($this->pat_id) && isset($this->sur_id) && isset($this->extremity) && isset($this->dateofexam)) {
            $answers = implode("', '", $this->answerArray);
            $questions = implode(", ", array_keys($this->answerArray));
            $queryString = "INSERT INTO " . Complications::tableName . " (dateof, pat_id, sur_id, dateofexam, extremity, dateofrevisionalsurgery, dateofothercomplications, " . $questions . ") VALUES ($this->dateof, $this->pat_id, $this->sur_id, $this->dateofexam, $this->extremity, $this->dateofrevisionalsurgery, $this->dateofothercomplications, '" . $answers . "')";
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
        if (isset($this->pat_id) && isset($this->extremity)) {
            $queryString = "SELECT * FROM  " . Complications::tableName . "  WHERE pat_id = $this->pat_id AND extremity = $this->extremity";
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
            $queryString = "UPDATE  " . Complications::tableName . "  SET " . $fields . "' WHERE id = " . $this->id;
        }

        return $queryString;
    }
    
    public static function createRetrievableDatabaseObject($patientid, $extremity) {
        $dbObj = new Complications($patientid);
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
        return $this->cleanInput($this->patient_id);
    }

    public function setPatientID($value) {
        $this->pat_id = $this->cleanInt($value);
    }
    
    public function getSurID(){
        return $this->sur_id;
    }
    
    public function setSurID($value){
        $this->sur_id = $this->cleanInput($value);
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
    
    public function getDateOfRevisionalSurgery() {
        return $this->cleanInput($this->dateofrevisionalsurgery);
    }

    public function getDateOfRevisionalFormatted() {
        return date("m-d-Y", $this->cleanInput($this->dateofrevisionalsurgery));
    }

    public function setDateOfRevisionalSurgery($month, $day, $year) {
        $this->dateofrevisionalsurgery = mktime(0, 0, 0, $this->cleanInt($month), $this->cleanInt($day), $this->cleanInt($year));
    }

    public function setDateOfRevisionalSurgeryByTimeStamp($value) {
        $this->dateofrevisionalsurgery = $this->cleanInt($value);
    }
    
    public function getDateOfOtherComplications() {
        return $this->cleanInput($this->dateofothercomplications);
    }

    public function getDateOfOtherComplicationsFormatted() {
        return date("m-d-Y", $this->cleanInput($this->dateofothercomplications));
    }

    public function setDateOfOtherComplications($month, $day, $year) {
        $this->dateof = mktime(0, 0, 0, $this->cleanInt($month), $this->cleanInt($day), $this->cleanInt($year));
    }

    public function setDateOfOtherComplicationsByTimeStamp($value) {
        $this->dateof = $this->cleanInt($value);
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
    
     public static function getQuestionArray(){
        return Complications::$questionArray;
    }
    

    public function getAnswer($index) {
        if (array_key_exists($index, $this->answerArray)) {
            return $this->cleanInput($this->answerArray[$index]);
        } else {
            return null;
        }
    }

    public function setAnswer($index, $answer) {
        if(in_array($index, Complications::$questionArray)){
            $this->answerArray[$this->cleanString($index)] = $this->cleanInt($answer);
        }      
    }

}

?>
