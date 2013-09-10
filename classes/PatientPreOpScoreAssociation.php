<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PatientPreOpScoreAssociation
 *
 * @author Ping
 */
class PatientPreOpScoreAssociation implements AssociationObject {
    
    private $patient, $preOpArray;
    
    public function __construct(Patient $patient) {
        $this->setPatient($patient);
    }
    
    public function buildFromMySQLResult($mysqlResult) {
        while ($row = mysql_fetch_assoc($mysqlResult)) {
            $preOp = new PreOpScore();
            $preOp->constructFromDatabaseArray($row);
            $this->preOpArray[$preOp->getId()] = $preOp;
        }
    }

    public function generateAssociationRetrieveQuery() {
        $query = "";
        if (!isset($this->patient)) {
            echo 'Attempting to create AssociationObject with missing parameters';
        } else {
            $query = "SELECT * FROM  " . PreOpScore::tableName . "  WHERE pat_id = " . $this->patient->getId() . "";
        }

        return $query;
    }
    
    public function setPatient(Patient $patient) {
        $this->patient = $patient;
    }

    public function getPatient() {
        return $this->patient;
    }

    public function getPreOpScore($id) {
        return $this->preOpArray[$id];
    }
    
    public function getPreOpScoreArray(){
        return $this->preOpArray;
    }

    
}

?>
