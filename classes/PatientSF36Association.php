<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PatientSF36Association
 *
 * @author Yaw
 */

class PatientSF36Association implements AssociationObject {

    private $patient, $sf36Array = Array();

    public function __construct(Patient $patient) {
        $this->setPatient($patient);
    }

    public function generateAssociationRetrieveQuery() {
        $query = "";
        if (!isset($this->patient)) {
            echo 'Attempting to create AssociationObject with missing parameters';
        } else {
            $query = "SELECT * FROM  " . SF36::tableName . "  WHERE patientid = " . $this->patient->getId() . "";
        }

        return $query;
    }

    public function buildFromMySQLResult($mysqlResult) {

        while ($row = mysql_fetch_assoc($mysqlResult)) {
            $sf36 = new SF36();
            $sf36->constructFromDatabaseArray($row);
            $this->sf36Array[$sf36->getType()] = $sf36;
        }
    }

    public function setPatient(Patient $patient) {
        $this->patient = $patient;
    }

    public function getPatient() {
        return $this->patient;
    }

    public function getSF36($type) {
        return $this->sf36Array[$type];
    }
    
    public function getSF36Array(){
        return $this->sf36Array;
    }

}

?>
