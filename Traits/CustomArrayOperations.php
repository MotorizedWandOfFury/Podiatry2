<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

trait CustomArrayOperations {
    public function mergeTwoArraysIntoString($array1, $array2, $seperator = " ", $delim = ""){
        $array1 = array_values($array1);
        $array2 = array_values($array2);
        $string = "";
        $sizeOfSmallerArray = (count($array1) < count($array2) ? count($array1) : count($array2));
        
        for($i = 0; $i < $sizeOfSmallerArray - 1; $i++){
            $string = $string . $array1[$i] . $seperator  . $array2[$i] . $delim . " ";
        }
         $string = $string . $array1[$sizeOfSmallerArray - 1] . $seperator . $array2[$sizeOfSmallerArray - 1];
         
         return $string;
        
    }
    /*
     * Returns an an associative array with the specified keys and their associated values
     * Note: the returned array has its keys in the order given in the parameter
     */
    public function subsetOfArray(Array $array1, Array $keysWanted){
        $resultArray = Array();
        
        foreach($keysWanted as $key){
            if(array_key_exists($key, $array1)){
                $resultArray[$key] = $array1[$key];
                //echo "\n$key => $array1[$key]";
            }
        }
        
        return $resultArray;
    }
}
?>
