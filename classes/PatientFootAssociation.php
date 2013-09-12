<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PatientFootAssociation
 *
 * @author Ping
 */
class PatientFootAssociation implements AssociationObject {
    
    private $patient, $footArray = Array();
    
    public function __construct(Patient $patient) {
        $this->setPatient($patient);
    }
    
    public function buildFromMySQLResult($mysqlResult) {
        while ($row = mysql_fetch_assoc($mysqlResult)) {
            $foot = new Foot($this->patient->getID());
            $foot->constructFromDatabaseArray($row);
            $this->footArray[$foot->getID()] = $foot;
        }
    }

    public function generateAssociationRetrieveQuery() {
        $query = "";
        if (!isset($this->patient)) {
            echo 'Attempting to create AssociationObject with missing parameters';
        } else {
            $query = "SELECT * FROM  " . Foot::tableName . "  WHERE pat_id = " . $this->patient->getId() . "";
        }

        return $query;
    }    
    
    public function setPatient(Patient $patient) {
        $this->patient = $patient;
    }

    public function getPatient() {
        return $this->patient;
    }
    
    /*
     * Selects a Foot health form from the array by timestamp
     */
    public function getFoot($type){
        return $this->footArray[$type];
    }
    public function getFootArray(){
        return $this->footArray;
    }
}

?>
