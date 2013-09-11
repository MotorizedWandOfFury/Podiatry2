<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PatientEvalsAssociation
 *
 * @author Ping
 */
class PatientEvalsAssociation implements AssociationObject {

    private $patient, $evalArray = Array();

    public function __construct(Patient $patient) {
        $this->setPatient($patient);
    }

    public function buildFromMySQLResult($mysqlResult) {
        while ($row = mysql_fetch_assoc($mysqlResult)) {
            $evals = new Evals($this->patient->getID());
            $evals->constructFromDatabaseArray($row);
            $this->evalArray[$evals->getExtremity()] = $evals;
        }
    }

    public function generateAssociationRetrieveQuery() {
        $query = "";
        if (!isset($this->patient)) {
            echo 'Attempting to create AssociationObject with missing parameters';
        } else {
            $query = "SELECT * FROM  " . Evals::tableName . "  WHERE pat_id = " . $this->patient->getId() . "";
        }

        return $query;
    }

    public function setPatient(Patient $patient) {
        $this->patient = $patient;
    }

    public function getPatient() {
        return $this->patient;
    }

    public function getEvalArray() {
        return $this->evalArray;
    }

}

?>
