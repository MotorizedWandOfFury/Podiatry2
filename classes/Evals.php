<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Evals
 *
 * @author Ping
 */
class Evals implements DatabaseObject {

    const tableName = "eval_answers";

    private $id, $pat_id, $sur_id, $extremity, $height = 0, $weight = 0, $dateof, $dateofexam, $answerArray, $questionArray;

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
        $this->questionArray = array("Q4", "Q10", "Q11", "Q12", "Q13", "Q14", "Q15", "Q16", "Q17", "Q18", "Q19", "Q20", "Q21", "Q22", "Q23", "Q24", "Q25", "Q26", "Q27");
    }

    public function constructFromDatabaseArray(array $paramArray) {
        if (array_key_exists('pat_id', $paramArray)) {
            $this->setPatientID($paramArray['pat_id']);
        }

        if (array_key_exists('id', $paramArray)) {
            $this->setID($paramArray['id']);
        }

        if (array_key_exists('dateof', $paramArray)) {
            $this->setDateOfByTimeStamp($paramArray['dateof']);
        }

        if (array_key_exists('dateofexam', $paramArray)) {
            $this->setDateOfExamByTimeStamp($paramArray['dateofexam']);
        }

        if (array_key_exists('sur_id', $paramArray)) {
            $this->setSurId($paramArray['sur_id']);
        }
        
        if(array_key_exists('extremity', $paramArray)){
            $this->setExtremity($paramArray['extremity']);
        }
        if(array_key_exists('height', $paramArray)){
            $this->setHeight($paramArray['height']);
        }
        if(array_key_exists('weight', $paramArray)){
            $this->setWeight($paramArray['weight']);
        }

        foreach ($paramArray as $key => $var) {
            if ($key === 'pat_id' || $key === 'id' || $key === 'dateof' || $key === 'dateofexam' || $key === 'sur_id' || $key === 'extremity') {
            } else {
                //filtered out keys we don't want in answerArray
                $this->setAnswer($key, $var);
                //echo "$key => $var", "\n";
            }
        }
    }

    public function generateCreateQuery() {
        $queryString = "";

        if (isset($this->sur_id) && isset($this->extremity)) {
            $answers = implode("', '", $this->answerArray);
            $questions = implode(", ", array_keys($this->answerArray));
            $queryString = "INSERT INTO " . Evals::tableName . " (dateof, pat_id, sur_id, dateofexam, extremity, height, weight, " . $questions . ") VALUES ('$this->dateof', '$this->pat_id', '$this->sur_id', '$this->dateofexam', '$this->extremity', '$this->height', '$this->weight', '" . $answers . "')";
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
            $queryString = "SELECT * FROM  " . Evals::tableName . "  WHERE pat_id = '$this->pat_id' AND extremity = '$this->extremity'";
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
            $queryString = "UPDATE  " . Evals::tableName . "  SET " . $fields . "' WHERE id = " . $this->id;
        }

        return $queryString;
    }

    public static function createRetrievableDatabaseObject($patientid, $extremity) {
        $dbObj = new Evals($patientid);
        $dbObj->setExtremity($extremity);
        return $dbObj;
    }

    /*
     * Gets doctor id for this evaluation
     */
    public function getSurId() {
        return $this->cleanInput($this->sur_id);
    }

    public function setSurId($value) {
        $this->sur_id = $this->cleanInt($value);
    }

    public function getId() {
        return $this->cleanInput($this->id);
    }

    private function setId($value) {
        $this->id = $this->cleanInt($value);
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
    
    public function getHeight(){
        return $this->cleanInput($this->height);
    }
    public function setHeight($value){
        $this->height = $this->cleanInt($value);
    }
    public function getWeight(){
        return $this->cleanInput($this->weight);
    }
    public function setWeight($value){
        $this->weight = $this->cleanInt($value);
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
        //echo "m: ", $month, " d: ", $day, " y: ", $year;
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

    public function getAnswer($index) {
        if (array_key_exists($index, $this->answerArray)) {
            return $this->cleanInput($this->answerArray[$index]);
        } else {
            return null;
        }
    }

    public function setAnswer($index, $answer) {
        if (in_array($index, $this->questionArray)) {
            $this->answerArray[$this->cleanString($index)] = $this->cleanString($answer);
        }
    }

}

?>
