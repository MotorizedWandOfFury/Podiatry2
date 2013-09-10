
<?php
/**
 * The Podiatry project autoloader. Make sure that this file is placed at the top level. 
 */
class PodiatryAutoloader {
    
    public static function autoLoad($object){        
        //echo 'attempting to load ',$object;
        
        if(file_exists(__DIR__."\\Classes\\".$object.".php")){
            $class = __DIR__."\\Classes\\".$object.".php";
            require_once $class;
            //echo $class, " loaded";
        } 
        else if(file_exists(__DIR__."\\Traits\\".$object.".php")){
            $trait = __DIR__."\\Traits\\".$object.".php";
            require_once $trait;
            //echo $trait, " loaded";
        }
        else {
            echo "$object not found";
        }
        
        
    }
    
    
}
?>
