<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Xrays
 *
 * @author Ping
 */
class Xrays implements DatabaseObject {
 
    
    const tableName = "xrays_answers"; 
    private $id, $pat_id, $sur_id, $type, $dateof, $dateofxrays, $extremity, $answerArray, $questionArray; 
  
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
        $this->questionArray = array("Q4", "Q5", "Q6", "Q7", "Q8", "Q9", "Q10", "Q11", "Q12", "Q13", "Q14", "Q15", "Q16", "Q17", "Q18", "Q19", "Q20", "Q21", "Q22", "Q23", "Q24", "Q25", "Q26", "Q27", "Q28", "Q29", "Q30", "Q31", "Q32", "Q33", "Q34", "Q35", "Q36", "Q37", "Q38");
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
        
        if(array_key_exists('dateofxrays', $paramArray)){ 
            $this->setDateOfXraysByTimeStamp($paramArray['dateofxrays']); 
        }
        
        if(array_key_exists('sur_id', $paramArray)){ 
            $this->setSurId($paramArray['sur_id']); 
        }
        
        if(array_key_exists('type', $paramArray)){ 
            $this->setType($paramArray['type']); 
        }
        
        if(array_key_exists('extremity', $paramArray)){
            $this->setExtremity($paramArray['extremity']);
        }
          
        foreach ($paramArray as $key => $var) { 
            if ($key === 'pat_id' || $key === 'id' || $key === 'dateof' || $key === 'dateofxrays' || $key === 'sur_id' || $key === 'type' || $key === 'extremity') {
            } else {
              $this->setAnswer($key, $var);
                //echo "$key => $var", "\n";  
            }
        }
    }

    public function generateCreateQuery() {
         $queryString = ""; 
  
        if (isset($this->sur_id) && isset($this->dateofxrays)) { 
            $answers = implode("', '", $this->answerArray); 
            $questions = implode(", ", array_keys($this->answerArray)); 
            $queryString = "INSERT INTO " . Xrays::tableName.  " (dateof, pat_id, sur_id, dateofxrays, type, extremity, " . $questions . ") VALUES ($this->dateof, $this->pat_id, $this->sur_id, $this->dateofxrays, $this->type, $this->extremity, '" . $answers . "')";
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
        if (isset($this->pat_id) && isset($this->type) && isset($this->extremity)) { 
            $queryString = "SELECT * FROM  " . Xrays::tableName.  "  WHERE pat_id = $this->pat_id AND type = $this->type AND extremity = $this->extremity"; 
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
            $queryString = "UPDATE  " . Xrays::tableName.  "  SET " . $fields . "' WHERE id = " . $this->id; 
        } 
  
        return $queryString;
    }
    
    public static function createRetrievableDatabaseObject($patientid, $type, $extremity) { 
        $dbObj = new Xrays($patientid); 
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
        //echo "m: ", $month, " d: ", $day, " y: ", $year;
        $this->dateof = mktime(0, 0, 0, $this->cleanInt($month), $this->cleanInt($day), $this->cleanInt($year)); 
    } 
  
    public function setDateOfByTimeStamp($value) { 
        $this->dateof = $this->cleanInt($value); 
    }
    
   public function getDateOfXrays() { 
        return $this->cleanInput($this->dateofxrays); 
    } 
  
    public function getDateOfXraysFormatted() { 
        return date("m-d-Y", $this->cleanInput($this->dateofxrays)); 
    }
    
    public function setDateOfXrays($month, $day, $year) { 
        $this->dateofxrays = mktime(0, 0, 0, $this->cleanInt($month), $this->cleanInt($day), $this->cleanInt($year)); 
    } 
  
    public function setDateOfXraysByTimeStamp($value) { 
        $this->dateofxrays = $this->cleanInt($value); 
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
            $this->answerArray[$this->cleanString($index)] = $this->cleanString($answer);
        }
    }
}

?>
