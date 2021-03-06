<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AllDoctorsAssociation
 *
 * @author Yaw
 */

require_once dirname(dirname(__FILE__)).'/Classes/AssociationObject.php';
require_once dirname(dirname(__FILE__)).'/Classes/Patient.php';
require_once dirname(dirname(__FILE__)).'/Classes/PreOpScore.php';
require_once dirname(dirname(__FILE__)).'/Traits/CustomArrayOperations.php';

class PreOpScorePatientAssociation implements AssociationObject {
    
    private $preOpArray = null;
	private $patientArray = null;
    
	use CustomArrayOps {
        mergeTwoArraysIntoString as private;
        subsetOfArray as private;
    }
	
    public function __construct() {
        
    }
      
    public function generateAssociationRetrieveQuery() {
        $query = "SELECT * FROM ".PreOpScore::tableName." LEFT OUTER JOIN ". Patient::tableName ." ON ".PreOpScore::tableName.".pat_id = " .Patient::tableName.".id";
		
		//"SELECT * FROM ".PreOpScore::tableName." LEFT OUTER JOIN ". Patient::tableName ." ON ".PreOpScore::tableName.".patient_id = " .Patient::tableName.".id UNION ALL //SELECT * FROM ".PreOpScore::tableName." RIGHT OUTER JOIN ". Patient::tableName ." ON ".PreOpScore::tableName.".patient_id = " .Patient::tableName.".id";
			
		//"SELECT * FROM " . PreOpScore::tableName . " FULL OUTER JOIN " . Patient::tableName . " ON " . PreOpScore::tableName .".patient_id = ". Patient::tableName.".id";
        return $query;
    }
    
    public function buildFromMySQLResult($mysqlResult) {
        if($mysqlResult){
            while ($row = mysql_fetch_assoc($mysqlResult)) {
                //var_dump($row);
				$patientKeys = array("id", "firstname", "lastname");
				$preOpKeys = array("pat_id", "dateof", "pfunctioning", "rphysical", "bpain", "ghealth", "vitality", "sfunctioning", "remotional", "mhealth");
				
				$patientRow = $this->subsetOfArray($row, $patientKeys);
				$preOpRow = $this->subsetOfArray($row, $preOpKeys);
				
				$patient = new Patient();
                $preOp = new PreOpScore();
				
				$patient->constructFromDatabaseArray($patientRow);
                $this->patientArray[$patient->getId()] = $patient;
				
				$preOp->constructFromDatabaseArray($preOpRow);
				$this->preOpArray[$preOp->getId()] = $preOp;
            }
        }
        
    }
    
    public function getPatientArray(){
        return $this->patientArray;
    
	}
	
	public function getPreOpArray(){
		return $this->preOpArray;
	}

    
}

?>
