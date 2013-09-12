<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PatientPostAssociation
 *
 * @author Ping
 */
class PatientPostAssociation implements AssociationObject {
 
    private $patient, $postArray = Array();
    
    public function __construct(Patient $patient) {
        $this->setPatient($patient);
    }
    
    
    public function buildFromMySQLResult($mysqlResult) {
        while ($row = mysql_fetch_assoc($mysqlResult)) {
            $post = new Post();
            $post->constructFromDatabaseArray($row);
            $this->postArray[$post->getType()] = $post;
        }
    }

    public function generateAssociationRetrieveQuery() {
        $query = "";
        if (!isset($this->patient)) {
            echo 'Attempting to create AssociationObject with missing parameters';
        } else {
            $query = "SELECT * FROM  " . Post::tableName . "  WHERE pat_id = " . $this->patient->getId() . "";
        }

        return $query;
    }
    
    public function setPatient(Patient $patient) {
        $this->patient = $patient;
    }

    public function getPatient() {
        return $this->patient;
    }

    public function getPost($type) {
        return $this->postArray[$type];
    }
    
    public function getPostArray(){
        return $this->postArray;
    }
}

?>
