<?php

/**
 * Description of SF36
 *
 * @author Yaw
 */

class SF36 implements DatabaseObject {

    const tableName = "sf36_answers";

    private static $questionArray = array("Q4", "Q5", "Q7", "Q8", "Q9", "Q10", "Q11", "Q12", "Q13", "Q14", "Q15", "Q16", "Q18", "Q19", "Q20", "Q21", "Q23", "Q24", "Q25", "Q26", "Q27", "Q28", "Q31", "Q32", "Q33", "Q34", "Q35", "Q36", "Q37", "Q38", "Q39", "Q40", "Q42", "Q43", "Q44", "Q45");
    private $id, $patient_id, $type, $dateof, $extremity, $answerArray;//, $questionArray;

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
        
        if(array_key_exists('extremity', $paramArray)){
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
        if(in_array($index, SF36::$questionArray)){
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
        $sum = 0.0;
        $numOfAnswers = 0;
        $score = -50;

        $subset = $this->subsetOfArray($this->answerArray, array("Q7", "Q8", "Q9", "Q10", "Q11", "Q12", "Q13", "Q14", "Q15", "Q16"));

        foreach ($subset as $val) {
            if ($val) {
                $sum += $val;
                $numOfAnswers++;
            }
        }

        if ($numOfAnswers > 0) {
            $average = $sum / $numOfAnswers;
            $score = (($numOfAnswers + ($average * (10 - $numOfAnswers)) - 10) / 20) * 100;
        }

        return $score;
    }

    public function getBodilyPainScore() {
        $subset = $this->subsetOfArray($this->answerArray, array("Q27", "Q28"));
        $finalVal27 = 0;
        $finalVal28 = 0;
        $numOfAnswers = 0;
        $score = -50;

        if ($subset["Q27"] != 0) {
            $numOfAnswers++;
            switch ($subset["Q27"]) {
                case 1:
                    $finalVal27 = 6.0;
                    break;
                case 2:
                    $finalVal27 = 5.4;
                    break;
                case 3:
                    $finalVal27 = 4.2;
                    break;
                case 4:
                    $finalVal27 = 3.1;
                    break;
                case 5:
                    $finalVal27 = 2.2;
                    break;
                case 6:
                    $finalVal27 = 1.0;
                    break;
            }
            if ($subset["Q28"] != 0) {
                $numOfAnswers++;
                switch ($subset["Q28"]) {
                    case 1:
                        if ($subset["Q27"] == 1) {
                            $finalVal28 = 6;
                        } else {
                            $finalVal28 = 5;
                        }
                        break;
                    case 2:
                        $finalVal28 = 4;
                        break;
                    case 3:
                        $finalVal28 = 3;
                        break;
                    case 4:
                        $finalVal28 = 2;
                        break;
                    case 5:
                        $finalVal28 = 1.0;
                        break;
                }
            }
        } else if ($subset["Q28"] != 0) {
            $numOfAnswers++;
            switch ($subset["Q28"]) {
                case 1:
                    $finalVal28 = 6.0;
                    break;
                case 2:
                    $finalVal28 = 4.75;
                    break;
                case 3:
                    $finalVal28 = 3.5;
                    break;
                case 4:
                    $finalVal28 = 2.25;
                    break;
                case 5:
                    $finalVal28 = 1.0;
                    break;
            }
        }

        if ($numOfAnswers > 0) {
            $average = ($finalVal27 + $finalVal28) / $numOfAnswers;
            $score = ((($finalVal27 + $finalVal28) + ($average * (2 - $average)) - 2) / 10) * 100;
        }
        
        return $score;
    }

    public function getGeneralHealthScore() {
        $sum = 0;
        $numOfAnswers = 0;
        $score = -50;
        //echo "\ngetGeneralHealth() called";

        if ($this->answerArray['Q4']) {
            switch ($this->answerArray['Q4']) {
                case 1:
                    $sum = 5.0;
                    break;
                case 2:
                    $sum = 4.4;
                    break;
                case 3:
                    $sum = 3.4;
                    break;
                case 4:
                    $sum = 2.0;
                    break;
                case 5:
                    $sum = 1.0;
                    break;
            }
        }
        // echo "\nAfter Q4, sum = ", $sum;
        $subset = $this->subsetOfArray($this->answerArray, array("Q42", "Q43", "Q44", "Q45"));

        foreach ($subset as $key => $val) {

            if ($val) {
                if ($key == "Q42" || $key == "Q44") {
                    $sum += $val;
                } else {
                    $sum = $sum + (6 - $val);
                }
                $numOfAnswers++;
            }
        }
        // echo "\nAfter Q42-45, sum = ", $sum;

        if ($numOfAnswers > 0) {
            $average = $sum / $numOfAnswers;
            $score = (($sum + ($average * (5 - $numOfAnswers)) - 5) / 20) * 100;
        }
        return $score;
    }

    public function getVitalityScore() {
        $sum = 0;
        $numOfAnswers = 0;
        $score = -50;


        if ($this->answerArray['Q31']) {
            $sum = $sum + (7 - $this->answerArray['Q31']);
            $numOfAnswers++;
        }

        if ($this->answerArray['Q35']) {
            $sum = $sum + (7 - $this->answerArray['Q35']);
            $numOfAnswers++;
        }

        if ($this->answerArray['Q37']) {
            $sum = $sum + $this->answerArray['Q37'];
            $numOfAnswers++;
        }
        if ($this->answerArray['Q31']) {
            $sum = $sum + $this->answerArray['Q39'];
            $numOfAnswers++;
        }

        if ($numOfAnswers > 0) {
            $average = $sum / $numOfAnswers;
            $score = (($score + ($average * (4 - $numOfAnswers)) - 4) / 20) * 100;
        }


        return $score;
    }

    public function getSocialFunctioningScore() {
        $sum = 0;
        $numOfAnswers = 0;
        $score = -50;

        if ($this->answerArray['Q26']) {
            $sum = $sum + (6 - $this->answerArray['Q26']);
            $numOfAnswers++;
        }
        if ($this->answerArray['Q40']) {
            $sum = $sum + ($this->answerArray['Q40']);
            $numOfAnswers++;
        }

        if ($numOfAnswers > 0) {
            $average = $sum / $numOfAnswers;
            $score = (($score + ($average * (2 - $numOfAnswers)) - 2) / 8) * 100;
        }

        return $score;
    }

    public function getRoleEmotionalScore() {
        $sum = 0;
        $numOfAnswers = 0;
        $score = -50;

        $subset = $this->subsetOfArray($this->answerArray, array("Q23", "Q24", "Q25"));

        foreach ($subset as $val) {
            if ($val) {
                $sum += $val;
                $numOfAnswers++;
            }
        }

        if ($numOfAnswers > 0) {
            $average = $sum / $numOfAnswers;
            $score = (($score + ($average * (3 - $numOfAnswers)) - 3) / 3) * 100;
        }

        return $score;
    }

    public function getMentalHealthScore() {
        $sum = 0;
        $numOfAnswers = 0;
        $score = -50;

        $subset = $this->subsetOfArray($this->answerArray, array("Q32", "Q33", "Q34", "Q35"));

        foreach ($subset as $key => $val) {
            if ($val) {
                if ($key == "Q34") {
                    $score = $score + (7 - $val);
                } else {
                    $score += $val;
                }
                $numOfAnswers++;
            }
        }

        if ($this->answerArray['Q38']) {
            $score = $score + (7 - $this->answerArray['Q38']);
            $numOfAnswers++;
        }

        if ($numOfAnswers > 0) {
            $average = $sum / $numOfAnswers;
            $score = (($sum + ($average * (5 - $average)) - 5) / 25) * 100;
        }

        return $score;
    }

}

?>
