<?php

trait TimeComparison {
    
    public static function isAfter90Days($startingTimestamp, $endingTimestamp){
        $interval = $endingTimestamp - $startingTimestamp;
        
        if($interval > 7776000) { //90 days in seconds
            return true;
        } else {
            return false;
        }
        
    }
    
//    public static function isAfterTheeMonths($startingDate, $endingDate){
//        $timeOne = floor($startingDate/86400);
//        $timeTwo = floor($endingDate/86400);
//        $interval = ($timeTwo - $timeOne);
//        //echo 'interval is ', $interval;
//                
//        if($interval >= 90){
//            return true;
//        }
//        else {
//            return false;
//        }
//    }
}
?>
