<?php

/**
 * Handles authentication and retrieval of session variables.
 * @author Ping
 */
class SessionManager {

    private $user, $userType, $sessionStartTime, $lastValidationTime, $page;

    const SESSION_TIMEOUT = 1800; //session timeout set for 30 minutes

    public function __construct() {
        @session_start();
        $this->user = isset($_SESSION[Constants::LOGGED_IN_USER_OBJECT]) ? $_SESSION[Constants::LOGGED_IN_USER_OBJECT] : NULL;
        $this->userType = isset($_SESSION[Constants::LOGGED_IN_USER_TYPE]) ? $_SESSION[Constants::LOGGED_IN_USER_TYPE] : "";
        $this->sessionStartTime = isset($_SESSION[Constants::SESSION_START_TIME]) ? $_SESSION[Constants::SESSION_START_TIME] : -1;
        $this->lastValidationTime = isset($_SESSION[Constants::LAST_VALIDATION_TIME]) ? $_SESSION[Constants::LAST_VALIDATION_TIME] : $this->sessionStartTime;
        $this->page = $_SERVER['SCRIPT_NAME'];
    }

    public function validate() {
        $nav = new Navigator();

        //echo time() . " - " . $this->lastValidationTime . " = " . (time() - $this->lastValidationTime);
        //echo "current folder: " . (dirname($this->page));

        if (!array_key_exists(Constants::LOGGED_IN_USER_TYPE, $_SESSION)) { //have the session variables been set
            if (!($this->page === Constants::PROJECT_PATH . "/" . "index.php")) { //if we're already on the index, no need to redirect
                $nav->doGo("index.php", "Authentication Required"); //if session variables have not been set, redirect
            }
        } else if ((time() - $this->lastValidationTime) > SessionManager::SESSION_TIMEOUT) { //if period between last validation and now is greater than 30 minutes, invalidate     
            //echo "Session timed out";
            $this->invalidate();
            if (!($this->page === Constants::PROJECT_PATH . "/" . "index.php")) { //if we're already on the index, no need to redirect
                $nav->redirectUser($this->userType, Navigator::LOGOUT_NAVIGATION_ACTION, "The session has expired");
            }
        } else {
            $_SESSION[Constants::LAST_VALIDATION_TIME] = time(); //update lastValidationTime
            if ($this->page === Constants::PROJECT_PATH . "/" . "index.php") { // redirect to user main page if we are already on the index page
                $nav->redirectUser($this->userType, Navigator::LOGIN_NAVIGATION_ACTION, "You are already logged in");
            } else {
                switch (dirname($this->page)) {
                    case Constants::PROJECT_PATH . "/" . Constants::ADMIN_DIRECTORY:
                        if (!($this->userType === Admin::tableName)) {
                            //echo "Admins only";
                            $nav->redirectUser($this->userType, Navigator::UNAUTHORIZED_NAVIGATION_ACTION, "Admins only");
                        }
                        break;
                    case Constants::PROJECT_PATH . "/" . Constants::DOCTOR_DIRECTORY:
                        if (($this->userType == Patient::tableName)) {
                            //echo "doctors and admins only";
                            $nav->redirectUser($this->userType, Navigator::UNAUTHORIZED_NAVIGATION_ACTION, "Doctors and Admins only");
                        }
                        break;
                }
            }
        }
    }

    private function invalidate() {
        UserLoginManager::logOut($this->user);
    }

    public function getUserObject() {
        return $this->user;
    }

    public function getUserType() {
        return $this->userType;
    }

}

?>
