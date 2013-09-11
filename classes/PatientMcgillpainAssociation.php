<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PatientMcgillpainAssociation
 *
 * @author Ping
 */
class PatientMcgillpainAssociation implements AssociationObject{
    
     private $patient, $mcgillpainArray = null;
    
    public function __construct(Patient $patient) {
        $this->setPatient($patient);
    }
    
    
    public function buildFromMySQLResult($mysqlResult) {
        while ($row = mysql_fetch_assoc($mysqlResult)) {
            $mcgill = new Mcgillpain();
            $mcgill->constructFromDatabaseArray($row);
            $this->mcgillpainArray[$mcgill->getID()] = $mcgill;
        }
    }

    public function generateAssociationRetrieveQuery() {
        $query = "";
        if (!isset($this->patient)) {
            echo 'Attempting to create AssociationObject with missing parameters';
        } else {
            $query = "SELECT * FROM  " . Mcgillpain::tableName . "  WHERE pat_id = " . $this->patient->getId() . "";
        }

        return $query;
    }
    
    public function setPatient(Patient $patient) {
        $this->patient = $patient;
    }

    public function getPatient() {
        return $this->patient;
    }

    //public function getMcgillpain($type) {
    //    return $this->mcgillpainArray[$type];
    //}
    
    public function getMcgillpainArray(){
        return $this->mcgillpainArray;
    }
}

?>
