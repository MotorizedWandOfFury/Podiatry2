<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Yaw
 */
interface DatabaseObject {

    //public static function createRetrievableDatabaseObject($param1 = NULL, $param2 = NULL, $param3 = NULL, $param4 = NULL);

    public function constructFromDatabaseArray(Array $paramArray);

    public function generateCreateQuery();

    public function generateReadQuery();

    public function generateUpdateQuery();

    public function generateDeleteQuery();
    
    public function generateUniquenessCheckQuery();
    
    public function getID();
    
}

?>
