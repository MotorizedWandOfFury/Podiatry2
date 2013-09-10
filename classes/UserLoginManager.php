<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Handles authentication and setting session variables.
 * session_start() must have been called before using this class
 * @author Ping
 */
class UserLoginManager {

    public static function logIn($username, $password, $table, Database $database) {
        $login = new LoginAssociation($username, $password, $table);
        $database->createAssociationObject($login);
        $loggedInUser = $login->getDbObj();

        if ($loggedInUser) { //if credentials were used successfully
            //set session variables
            $_SESSION[Constants::LOGGED_IN_USER_OBJECT] = $loggedInUser;
            $_SESSION[Constants::LOGGED_IN_USER_TYPE] = $loggedInUser::tableName;
            $_SESSION[Constants::SESSION_START_TIME] = time();
            
            //we logged in
            return true;
        } else {
            //credentials failed
            return false;
        }
    }

    public static function logOut(DatabaseObject $account) {

        if (isset($account)) {
            //unset session variables
            unset($_SESSION[Constants::LOGGED_IN_USER_OBJECT], $_SESSION[Constants::LOGGED_IN_USER_TYPE], $_SESSION[Constants::SESSION_START_TIME], $_SESSION[Constants::LAST_VALIDATION_TIME]);
        }

        //end session        
        session_unset();
        session_destroy();
        session_regenerate_id(true);
    }

}

?>
