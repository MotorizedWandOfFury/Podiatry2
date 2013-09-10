<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JSONManager
 *
 * @author Ping
 */
class JSONManager {
    private $jsonBase;
    
    public function __construct(){
        $this->jsonBase =  dirname(dirname(__FILE__))."\\JSON\\";
    }


    public function loadJSONQuestions($form, $language){
        return $this->loadJSON($form, "Questions", $language);
        
    }
    
    public function loadJSONValues($form, $language){
        return $this->loadJSON($form, "Values", $language);
    }
    
    private function loadJSON($form, $type, $language){
        $jsonFile = $this->jsonBase . $form . $type . "-".$language.".json";
        //echo "\nloading file: ", $jsonFile;
        if(file_exists($jsonFile)){
            $loadJSONString = file_get_contents($jsonFile);
            $jsonArray = json_decode($loadJSONString, true);
            if(json_last_error() == JSON_ERROR_NONE){
                return $jsonArray;
            }
            else {
                $this->JSONError(json_last_error());
                return null;
            }
            
        }
        else {
            echo "JSON file not found";
            return NULL;
        }
    }
    
    private function JSONError($error){
        switch($error){
            case JSON_ERROR_DEPTH:
                echo "The maximum stack depth has been exceeded";
                break;
            case JSON_ERROR_STATE_MISMATCH:
                echo "Invalid or malformed JSON";
                break;
            case JSON_ERROR_SYNTAX:
                echo "Syntax error";
                break;
            case JSON_ERROR_UTF8: 
                echo "Malformed UTF-8 characters, possibly incorrectly encoded";
                break;
            case JSON_ERROR_CTRL_CHAR:
                echo "Control character error, possibly incorrectly encoded";
                break;
        }
    }
}

?>
