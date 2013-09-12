<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PatientSurgicalAssociation
 *
 * @author Ping
 */
class PatientSurgicalAssociation implements AssociationObject {

    private $patient, $surgicalArray = Array();

    public function __construct(Patient $patient) {
        $this->setPatient($patient);
    }

    public function buildFromMySQLResult($mysqlResult) {
        while ($row = mysql_fetch_assoc($mysqlResult)) {
            $surgical = new Surgical();
            $surgical->constructFromDatabaseArray($row);
            $this->surgical[$surgical->getID()] = $surgical;
        }
    }

    public function generateAssociationRetrieveQuery() {
        $query = "";
        if (!isset($this->patient)) {
            echo 'Attempting to create AssociationObject with missing parameters';
        } else {
            $query = "SELECT * FROM  " . Surgical::tableName . "  WHERE pat_id = " . $this->patient->getId() . "";
        }

        return $query;
    }

    public function setPatient(Patient $patient) {
        $this->patient = $patient;
    }

    public function getPatient() {
        return $this->patient;
    }

    public function getSurgicalArray() {
        return $this->surgicalArray;
    }

}

?>
