<?php

/**
 * Defines project-wide constants
 *
 * @author Yaw
 */
class Constants {
    
    //Session constants
    const LOGGED_IN_USER_OBJECT = "LOGGEDINUSEROBJECT",
            LOGGED_IN_USER_TYPE = "LOGGEDINUSERTYPE",
            SESSION_START_TIME = "SESSIONSTARTTME",
            LAST_VALIDATION_TIME = "LASTVALIDATIONTIME";

    //Directory constants
    const PROJECT_PATH = "/Podiatry2",
            DOCTOR_DIRECTORY = "doctor",
            ADMIN_DIRECTORY = "admin";

    //Form constants
    const PRE_OP = 1,
            POST_OP = 2,
            THREE_MONTH = 3,
            SIX_MONTH = 4,
            TWELVE_MONTH = 5;
}

?>
