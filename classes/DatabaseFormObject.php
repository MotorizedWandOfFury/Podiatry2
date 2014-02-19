<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Ping
 */
interface DatabaseForm extends DatabaseObject {
    public function getPatientID();
    
    public function getDateOf();
    
    public function setDateOf($month, $day, $year);
    
     public function getAnswer($index);
     
     public function setAnswer($index, $answer);
}

?>
