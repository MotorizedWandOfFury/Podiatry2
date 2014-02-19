<?php

/**
 * Description of SF36
 *
 * @author Yaw
 */
class SF36 implements DatabaseObject {

    const tableName = "sf36_answers";

    private static $questionArray = array("Q4", "Q5", "Q7", "Q8", "Q9", "Q10", "Q11", "Q12", "Q13", "Q14", "Q15", "Q16", "Q18", "Q19", "Q20", "Q21", "Q23", "Q24", "Q25", "Q26", "Q27", "Q28", "Q31", "Q32", "Q33", "Q34", "Q35", "Q36", "Q37", "Q38", "Q39", "Q40", "Q42", "Q43", "Q44", "Q45");
    private $id, $patient_id, $type, $dateof, $extremity, $answerArray = Array(); //, $questionArray;

    use Clean {
        cleanInput as private;
        cleanString as private;
        cleanInt as private;
    }

use CustomArrayOperations {
        mergeTwoArraysIntoString as private;
        subsetOfArray as private;
    }

use TimeComparison;

    public function __construct($patientid = 0, $month = 1, $day = 1, $year = 1900) {
        $this->setPatientID($patientid);
        $this->setDateOf($month, $day, $year);
        //$this->questionArray = array("Q4", "Q5", "Q7", "Q8", "Q9", "Q10", "Q11", "Q12", "Q13", "Q14", "Q15", "Q16", "Q18", "Q19", "Q20", "Q21", "Q23", "Q24", "Q25", "Q26", "Q27", "Q28", "Q31", "Q32", "Q33", "Q34", "Q35", "Q36", "Q37", "Q38", "Q39", "Q40", "Q42", "Q43", "Q44", "Q45");
    }

    public function constructFromDatabaseArray(array $paramArray) {
        if (array_key_exists('patientid', $paramArray)) {
            $this->setPatientID($paramArray['patientid']);
        }

        if (array_key_exists('id', $paramArray)) {
            $this->setID($paramArray['id']);
        }

        if (array_key_exists('dateof', $paramArray)) {
            $this->setDateOfByTimeStamp($paramArray['dateof']);
        }

        if (array_key_exists('type', $paramArray)) {
            $this->setType($paramArray['type']);
        }

        if (array_key_exists('extremity', $paramArray)) {
            $this->setExtremity($paramArray['extremity']);
        }

        foreach ($paramArray as $key => $var) {
            if ($key === 'patientid' || $key === 'id' || $key === 'dateof' || $key === 'type' || $key === 'extremity') {
                
            } else {
                $this->setAnswer($key, $var);
                //echo "$key => $var", "\n";
            }
        }
    }

    public function generateCreateQuery() {
        $queryString = "";

        $answers = implode(", ", $this->answerArray);
        $questions = implode(", ", array_keys($this->answerArray));
        $queryString = "INSERT INTO " . SF36::tableName . " (dateof, patientid, type, extremity, " . $questions . ") VALUES ($this->dateof, $this->patient_id, $this->type, $this->extremity, " . $answers . ")";
        return $queryString;
    }

    public function generateReadQuery() {
        $queryString = "";
        if (isset($this->patient_id) && isset($this->type) && isset($this->extremity)) {
            $queryString = "SELECT * FROM  " . SF36::tableName . "  WHERE type = $this->type AND patientid = $this->patient_id AND extremity = $this->extremity";
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
            $queryString = "UPDATE  " . SF36::tableName . "  SET " . $fields . " WHERE id = " . $this->id;
        }

        return $queryString;
    }

    public function generateUniquenessCheckQuery() {
        $query = $this->generateReadQuery();
        return $query;
    }

    public static function createRetrievableDatabaseObject($patientid, $type, $extremity) {
        $dbObj = new SF36($patientid);
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
        return $this->cleanInput($this->patient_id);
    }

    private function setPatientID($value) {
        $this->patient_id = $this->cleanInt($value);
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

    public function getExtremity() {
        return $this->cleanInput($this->extremity);
    }

    public function getExtremityFormatted() {
        switch ($this->extremity) {
            case 1:
                return 'L';
                break;
            case 2:
                return 'R';
                break;
        }
    }

    public function setExtremity($value) {
        $this->extremity = $this->cleanInt($value);
    }

    public static function getQuestionArray() {
        return SF36::$questionArray;
    }

    public function getAnswer($index) {
        if (array_key_exists($index, $this->answerArray)) {
            return $this->cleanInput($this->answerArray[$index]);
        } else {
            return null;
        }
    }

    public function setAnswer($index, $answer) {
        if (in_array($index, SF36::$questionArray)) {
            $this->answerArray[$this->cleanString($index)] = $this->cleanInt($answer);
        }
    }

    public function getRolePhysicalScore() {
        $sum = 0.0;
        $numOfAnswers = 0;
        $score = -50;

        $subset = $this->subsetOfArray($this->answerArray, array("Q18", "Q19", "Q20", "Q21"));

        //var_dump($subset);

        foreach ($subset as $val) {
            if ($val) {
                $sum += $val;
                $numOfAnswers++;
            }
        }

        if ($numOfAnswers > 0) {
            $average = $sum / $numOfAnswers;

            $score = (($sum + ($average * (4 - $numOfAnswers)) - 4) / 4) * 100;
        }

        return $score;
    }

    public function getPhysicalFunctioningScore() {
        $sum = 0;
        $numOfAnswers = 0;
        $subset = $this->subsetOfArray($this->answerArray, array("Q7", "Q8", "Q9", "Q10", "Q11", "Q12", "Q13", "Q14", "Q15", "Q16"));

        foreach ($subset as $val) {
            $sum += $val;
            $numOfAnswers++;
        }

        $score = (($sum - 10) / 20) * 100;

        return $score;
    }

    public function getBodilyPainScore() {
        $subset = $this->subsetOfArray($this->answerArray, array("Q27", "Q28"));
        $Q27FinalValue = 0;
        $Q28FinalValue = 0;

        if (array_key_exists("Q27", $subset)) {
            switch ($subset["Q27"]) {
                case 1:
                    $Q27FinalValue = 6;
                    break;
                case 2:
                    $Q27FinalValue = 5.4;
                    break;
                case 3:
                    $Q27FinalValue = 4.2;
                    break;
                case 4:
                    $Q27FinalValue = 3.1;
                    break;
                case 5:
                    $Q27FinalValue = 2.2;
                    break;
                case 6:
                    $Q27FinalValue = 1;
                    break;
                default:
                    $Q27FinalValue = 0;
                    break;
            }
        } else {
            $Q27FinalValue = 0;
        }

        if(array_key_exists("Q28", $subset)){
            switch ($subset["Q28"]) {
            case 1:
                if ($Q27FinalValue == 6) { //if precoded value of Q27 is 1
                    $Q28FinalValue = 6;
                } else if ($Q27FinalValue <= 5.4) { //if precoded value of Q27 is 2 or greater
                    $Q28FinalValue = 5;
                } else { //if Q27 has not been answered
                    $Q28FinalValue = 6;
                }
                break;
            case 2:
                if ($Q27FinalValue > 0) { //if Q27 has been answered
                    $Q28FinalValue = 4;
                } else {
                    $Q28FinalValue = 4.75;
                }
                break;
            case 3:
                if ($Q27FinalValue > 0) { //if Q27 has been answered
                    $Q28FinalValue = 3;
                } else {
                    $Q28FinalValue = 3.5;
                }
                break;
            case 4:
                if ($Q27FinalValue > 0) { //if Q27 has been answered
                    $Q28FinalValue = 2;
                } else {
                    $Q28FinalValue = 2.25;
                }
                break;
            case 5:
                if ($Q27FinalValue > 0) { //if Q27 has been answered
                    $Q28FinalValue = 1;
                } else {
                    $Q28FinalValue = 1;
                }
                break;
        }
        } else {
            $Q28FinalValue = -1;
        }
        

        $sum = $Q27FinalValue + $Q28FinalValue;
        $score = (($sum - 2) / 10) * 100;
        return $score;
    }
    
    public function getGeneralHealthScore(){
        $subset = $this->subsetOfArray($this->answerArray, array("Q4", "Q42", "Q43", "Q44", "Q45"));
        $Q4FinalValue = 0;
        $Q43FinalValue = 0;
        $Q45FinalValue = 0;
        
        switch($subset["Q4"]){
            case 1:
                $Q4FinalValue = 5;
                break;
            case 2:
                $Q4FinalValue = 4.4;
                break;
            case 3:
                $Q4FinalValue = 3.4;
                break;
            case 4:
                $Q4FinalValue = 2;
                break;
            case 5:
                $Q4FinalValue = 1;
                break;
        }
        
        switch($subset["Q43"]){
            case 1:
                $Q43FinalValue = 5;
                break;
            case 2:
                $Q43FinalValue = 4;
                break;
            case 3:
                $Q43FinalValue = 3;
                break;
            case 4:
                $Q43FinalValue = 2;
                break;
            case 5:
                $Q43FinalValue = 1;
                break;
        }
        switch($subset["Q45"]){
            case 1:
                $Q45FinalValue = 5;
                break;
            case 2:
                $Q45FinalValue = 4;
                break;
            case 3:
                $Q45FinalValue = 3;
                break;
            case 4:
                $Q45FinalValue = 2;
                break;
            case 5:
                $Q45FinalValue = 1;
                break;
        }
        
        $rawScore = $Q4FinalValue + $subset["Q42"] + $Q43FinalValue + $subset["Q44"] + $Q45FinalValue;
        
       $score = (($rawScore - 5)/20)*100;
       return $score;
    }

    public function getVitalityScore() {
        $Q31FinalValue = 0;
        $Q35FinalValue = 0;
        $subset = $this->subsetOfArray($this->answerArray, array("Q31", "Q35", "Q37", "Q39"));
        
        switch($subset["Q31"]){
            case 1:
                $Q31FinalValue = 6;
                break;
            case 2:
                $Q31FinalValue = 5;
                break;
            case 3:
                $Q31FinalValue = 4;
                break;
            case 4:
                $Q31FinalValue = 3;
                break;
            case 5:
                $Q31FinalValue = 2;
                break;
            case 6:
                $Q31FinalValue = 1;
                break;
        }
        
        switch($subset["Q35"]){
            case 1:
                $Q35FinalValue = 6;
                break;
            case 2:
                $Q35FinalValue = 5;
                break;
            case 3:
                $Q35FinalValue = 4;
                break;
            case 4:
                $Q35FinalValue = 3;
                break;
            case 5:
                $Q35FinalValue = 2;
                break;
            case 6:
                $Q35FinalValue = 1;
                break;
        }
        $rawScore = $Q31FinalValue + $Q35FinalValue + $subset["Q37"] + $subset["Q39"];
        $score = (($rawScore - 4)/20)*100;
        return $score;
    }

    public function getSocialFunctioningScore() {
       $subset = $this->subsetOfArray($this->answerArray, array("Q26", "Q40"));
       $Q26FinalValue = 0;
       
       switch($subset["Q26"]){
           case 1:
                $Q26FinalValue = 5;
                break;
            case 2:
                $Q26FinalValue = 4;
                break;
            case 3:
                $Q26FinalValue = 3;
                break;
            case 4:
                $Q26FinalValue = 2;
                break;
            case 5:
                $Q26FinalValue = 1;
                break;
       }
       
       $rawScore = $Q26FinalValue + $subset["Q40"];
       $score = (($rawScore - 2)/8)*100;
       return $score;
    }

    public function getRoleEmotionalScore() {
       $subset = $this->subsetOfArray($this->answerArray, array("Q23", "Q24", "Q25"));
       $rawScore = 0;
       
       foreach ($subset as $val) {
           $rawScore += $val;
       }
       
       $score = (($rawScore - 3)/3)*100;
       return $score;
    }

    public function getMentalHealthScore() {

        $subset = $this->subsetOfArray($this->answerArray, array("Q32", "Q33", "Q34", "Q36", "Q38"));
        $Q34FinalValue = 0;
        $Q38FinalValue = 0;
        
        switch($subset["Q34"]){
            case 1:
                $Q34FinalValue = 6;
                break;
            case 2:
                $Q34FinalValue = 5;
                break;
            case 3:
                $Q34FinalValue = 4;
                break;
            case 4:
                $Q34FinalValue = 3;
                break;
            case 5:
                $Q34FinalValue = 2;
                break;
            case 6:
                $Q34FinalValue = 1;
                break;
        }
        
        switch($subset["Q38"]){
            case 1:
                $Q38FinalValue = 6;
                break;
            case 2:
                $Q38FinalValue = 5;
                break;
            case 3:
                $Q38FinalValue = 4;
                break;
            case 4:
                $Q38FinalValue = 3;
                break;
            case 5:
                $Q38FinalValue = 2;
                break;
            case 6:
                $Q38FinalValue = 1;
                break;
        }
        
        $rawScore = $subset["Q32"] + $subset["Q33"] + $subset["Q36"] + $Q34FinalValue + $Q38FinalValue;
        $score = (($rawScore - 5)/25)*100;
        return $score;
        
    }

}

?>
