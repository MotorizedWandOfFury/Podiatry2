<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PatientDemoAssosciation
 *
 * @author Ping
 */
class PatientDemoAssociation implements AssociationObject {
    
    private $patient, $demo = null;
    
    public function __construct(Patient $patient) {
        $this->setPatient($patient);
    }
    
    public function buildFromMySQLResult($mysqlResult) {
        $row = mysql_fetch_assoc($mysqlResult);
        if (is_array($row)) {
            $demo = new Demo();
            $demo->constructFromDatabaseArray($row);
            $this->demo = $demo;
        }
    }

    public function generateAssociationRetrieveQuery() {
        $query = "";
        if (!isset($this->patient)) {
            echo 'Attempting to create AssociationObject with missing parameters';
        } else {
            $query = "SELECT * FROM  " . Demo::tableName . "  WHERE pat_id = " . $this->patient->getId() . "";
        }

        return $query;
    }    
    
    public function setPatient(Patient $patient) {
        $this->patient = $patient;
    }

    public function getPatient() {
        return $this->patient;
    }
    
    public function getDemo(){
        return $this->demo;
    }
}

?>
