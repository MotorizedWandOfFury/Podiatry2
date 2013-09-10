<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AllDoctorsAssociation
 *
 * @author Yaw
 */

require_once dirname(dirname(__FILE__)).'/Classes/AssociationObject.php';
require_once dirname(dirname(__FILE__)).'/Classes/Physician.php';

class AllDoctorsAssociation implements AssociationObject {
    
    private $physicianArray = null;
    
    public function __construct() {
        
    }
      
    public function generateAssociationRetrieveQuery() {
        $query = "SELECT * FROM " . Physician::tableName;
        return $query;
    }
    
    public function buildFromMySQLResult($mysqlResult) {
        if($mysqlResult){
            while ($row = mysql_fetch_assoc($mysqlResult)) {
                $physician = new Physician();
                $physician->constructFromDatabaseArray($row);
                $this->physicianArray[$physician->getId()] = $physician;
            }
        }
        
    }
    
    public function getPhysiciansArray(){
        return $this->physicianArray;
    }

    
}

?>
