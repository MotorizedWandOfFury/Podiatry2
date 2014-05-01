<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mcgillpain
 *
 * @author Ping
 */
class Mcgillpain implements DatabaseObject {
    
    const tableName = "mcgillpain_answers";
    private $id, $pat_id, $sur_id, $type, $dateof, $extremity, $answerArray, $questionArray;

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
        $this->questionArray = array("Q5", "Q6", "Q7", "Q8", "Q9", "Q10", "Q11", "Q12", "Q13", "Q14", "Q15", "Q16", "Q17", "Q18", "Q19", "Q20", "Q21", "Q22", "Q23", "Q24", "Q25", "Q26", "Q27", "Q28", "Q29");
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
        
        if(array_key_exists('sur_id', $paramArray)){
            $this->setSurId($paramArray['sur_id']);
        }
        
        if (array_key_exists('type', $paramArray)) {
            $this->setType($paramArray['type']);
        }
        
        if(array_key_exists('extremity', $paramArray)){
            $this->setExtremity($paramArray['extremity']);
        }
        
        foreach ($paramArray as $key => $var) {
            if ($key === 'pat_id' || $key === 'id' || $key === 'dateof' || $key === 'sur_id' || $key === 'type' || $key === 'extremity') {
            } else {
                $this->setAnswer($key, $var);
                //echo "$key => $var", "\n";
            }
        }
    }

    public function generateCreateQuery() {
        $queryString = "";

        if (!isset($this->pat_id) || !isset($this->sur_id)) {
            echo "Error: Attempting to create a DatabaseObject with missing parameters";
        } else {
            $answers = implode(", ", $this->answerArray);
            $questions = implode(", ", array_keys($this->answerArray));
            $queryString = "INSERT INTO " . Mcgillpain::tableName.  " (dateof, pat_id, sur_id, type, extremity, " . $questions . ") VALUES ($this->dateof, $this->pat_id, $this->sur_id, $this->type, $this->extremity, " . $answers . ")";
        }
        return $queryString;
    }

    public function generateDeleteQuery() {
        echo "DatabaseObject can not be deleted.";
    }

    public function generateReadQuery() {
        $queryString = "";
        if (isset($this->pat_id) && isset($this->type) && isset($this->extremity)) {
            $queryString = "SELECT * FROM  " . Mcgillpain::tableName.  "  WHERE pat_id = $this->pat_id AND type = $this->type AND extremity = $this->extremity";
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
            $queryString = "UPDATE  " . Mcgillpain::tableName.  "  SET " . $fields . "' WHERE id = " . $this->id;
        }

        return $queryString;
    }   
    
    public static function createRetrievableDatabaseObject($patientid, $type, $extremity) {
        $dbObj = new Mcgillpain($patientid);
        $dbObj->setType($type);
        $dbObj->setExtremity($extremity);
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
    
    public function getPainSensoryDimensionScore(){
        $subset = $this->subsetOfArray($this->answerArray, array("Q13","Q14", "Q15", "Q16", "Q17", "Q18", "Q19", "Q20", "Q21", "Q22", "Q23"));
        $sum = 0;
        
        foreach ($subset as $val){
            $valModified = $val - 1; 
            if($valModified >= 0){ //valid range is 0-3
            $sum += $valModified;
            }
        }
       return $sum;
    }
    
    public function getPainAffectiveDimensionScore(){
        $subset = $this->subsetOfArray($this->answerArray, array("Q24", "Q25", "Q26", "Q12"));
        
         $sum = 0;
        
        foreach ($subset as $val){
            $valModified = $val - 1; 
            if($valModified >= 0){ //valid range is 0-3
            $sum += $valModified;
            }
        }
       return $sum;
    }
    
    public function getHalluxScore(){
       $rawScore = 0;
        $Q10FinalValue = 0;
       
       if(array_key_exists("Q10", $this->answerArray)){
           switch($this->answerArray["Q10"]){
               case 1:
                   $Q10FinalValue = 40;
                   $rawScore += 40;
                   break;
               case 2:
                   $Q10FinalValue = 30;
                   $rawScore += 30;
                   break;
               case 3:
                   $Q10FinalValue = 20;
                   $rawScore += 20;
                   break;
               case 4:
                   $Q10FinalValue = 0;
                   $rawScore += 0;
                   break;
           }
       }
       
       $subset = $this->subsetOfArray($this->answerArray, array("Q5", "Q7"));
       
       
       
      // $subset = $this->subsetOfArray($this->answerArray, array("Q5", "Q6", "Q7", "Q8", "Q9", "Q11", "Q12"));
       
    }
}

?>
