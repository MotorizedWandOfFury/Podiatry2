<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PhysicianPatientsAssociation
 *
 * @author Yaw
 */
require_once dirname(dirname(__FILE__)).'/Classes/AssociationObject.php';
require_once dirname(dirname(__FILE__)).'/Classes/Patient.php';
require_once dirname(dirname(__FILE__)).'/Classes/Physician.php';

class PhysicianPatientsAssociation implements AssociationObject {

    private $physician, $patientArray, $physicianId;

    public function __construct() {
        
		 
    }

    public function generateAssociationRetrieveQuery() {
        $query = "";
        if (!isset($this->physicianId)) {
            echo 'Attempting to create AssociationObject with missing parameters';
        } else {
            $query = "SELECT * FROM " . Patient::tableName . " WHERE doctor = " . $this->getPhysicianId() . "";
        }

        return $query;
    }

    public function buildFromMySQLResult($mysqlResult) {
        if ($mysqlResult) {
            while ($row = mysql_fetch_assoc($mysqlResult)) {
                $patient = new Patient();
                $patient->constructFromDatabaseArray($row);
                $this->patientArray[$patient->getId()] = $patient;
            } //var_dump($this->patientArray);
        }
    }

    public function setPhysician(Physician $physician) {
        $this->physician = $physician;
		$this->physicianId = $this->physician->getId();
    }

    public function getPhysician() {
        return $this->physician;
    }
	
	public function getPhysicianId(){
		return $this->physicianId;
	}
	
	public function setPhysicianId($id){
		$this->physicianId = $id;
		//echo "ID SET: ",$this->physicianId;
	}

    public function getPatient($id) {
        return $this->patientArray[$id];
    }
	
	public function getPatientArray(){
		return $this->patientArray;
	}
}

?>
