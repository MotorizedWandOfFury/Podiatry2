<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PatientXraysAssociation
 *
 * @author Ping
 */
class PatientXraysAssociation implements AssociationObject {
    private $patient, $xraysArray = null;
    
    public function __construct(Patient $patient) {
        $this->setPatient($patient);
    }

    public function buildFromMySQLResult($mysqlResult) {
        while ($row = mysql_fetch_assoc($mysqlResult)) {
            $xray = new Xrays();
            $xray->constructFromDatabaseArray($row);
            $this->xraysArray[$xray->getType()] = $xray;
        }
    }

    public function generateAssociationRetrieveQuery() {
        $query = "";
        if (!isset($this->patient)) {
            echo 'Attempting to create AssociationObject with missing parameters';
        } else {
            $query = "SELECT * FROM  " . Xrays::tableName . "  WHERE pat_id = " . $this->patient->getId() . "";
        }

        return $query;
    }
    
    public function setPatient(Patient $patient) {
        $this->patient = $patient;
    }

    public function getPatient() {
        return $this->patient;
    }

    public function getXray($type) {
        return $this->xraysArray[$type];
    }
    
    public function getXraysArray(){
        return $this->xraysArray;
    }
}

?>
