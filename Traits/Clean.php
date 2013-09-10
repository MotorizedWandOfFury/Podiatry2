<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

trait Clean{
    function cleanInput($value){
        if(is_string($value)){
            return mysql_real_escape_string(htmlspecialchars($value));
        }
        else if(is_int($value)){
            return mysql_real_escape_string(abs(intval($value)));
        }
    }
    
    function cleanString($value) {
        return filter_var($value, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW | FILTER_FLAG_ENCODE_HIGH);
    }
    
    function cleanInt($value){
        return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }
    
}

?>
