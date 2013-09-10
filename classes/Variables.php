<?php

/**
 * Contains $_SESSION keys for accessing items stored in $_SESSION
 *
 * @author Yaw
 */
class Variables {

    public function getLoggedInUserObject(){
        return "LOGGEDINUSEROBJECT";
    }
    
    public function getLoggedInUserType(){
        return "LOGGEDINUSERTYPE";
    }
    
    public function getSessionStartTime(){
        return "SESSIONSTARTTME";
    }
    
    public function getLastValidationTime(){
        return "LASTVALIDATIONTIME";
    }
    
    public function GetSessionUserName() {
        return "USERNAME";
    }

    public function GetSessionUserId() {
        return "PATIENTID";
    }

    public function GetSessionPatientObject() {
        return "PATIENTOBJECT";
    }

    public function GetSessionDoctorName() {
        return "DOCUSERNAME";
    }

    public function GetSessionDoctorId() {
        return "DOCTORID";
    }

    public function GetSessionDoctorObject() {
        return "PHYSICIANOBJECT";
    }

    public function GetSessionAdminName() {
        return "ADMINNAME";
    }

    public function GetSessionAdminId() {
        return "ADMINID";
    }

    public function GetSessionAdminObject() {
        return "ADMINOBJECT";
    }

}

?>
