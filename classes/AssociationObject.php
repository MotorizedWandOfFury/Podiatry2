<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Yaw
 */
interface AssociationObject {
    public function generateAssociationRetrieveQuery();
    public function buildFromMySQLResult($mysqlResult);
}

?>
