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

class AllPatientsAssociation implements AssociationObject {
    
    private $patientArray = null;
    
    public function __construct() {
        
    }
      
    public function generateAssociationRetrieveQuery() {
        $query = "SELECT * FROM " . Patient::tableName;
        return $query;
    }
    
    public function buildFromMySQLResult($mysqlResult) {
        if($mysqlResult){
            while ($row = mysql_fetch_assoc($mysqlResult)) {
                $patient = new Patient();
                $patient->constructFromDatabaseArray($row);
                $this->patientArray[$patient->getId()] = $patient;
            }
        }
        
    }
    
    public function getPatientsArray(){
        return $this->patientArray;
    }

    
}

?>
