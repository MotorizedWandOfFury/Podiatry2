<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * The Navigator class provides page to page navigation functionality
 *
 * @author Ping
 */
class Navigator {

    const SUBMISSION_NAVIGATION_ACTION = "submitted";
    const FAILURE_NAVIGATION_ACTION = "failure";
    const LOGIN_NAVIGATION_ACTION = "loggedin";
    const LOGOUT_NAVIGATION_ACTION = "loggedout";
    const UNAUTHORIZED_NAVIGATION_ACTION = "unauthorized";

    private function doMSG($msg) {
        // Print the error.
        $func = exit("<html><body style='background-color: white; font-size: 20px; font-weight: bold; color: black;'><div style='text-align: center;'>" . $msg . "</div></body></html>");
        // Return the function.
        return $func;
    }

    public function doGo($to, $msg) {
        header("refresh: 1; url=" . Constants::PROJECT_PATH . "/" . $to);
        // Print the message.
        echo $this->doMSG($msg);
    }

    public function redirectUser($userType, $action, $message = "") {
        switch ($userType) {
            case Admin::tableName:
                switch ($action) {
                    case Navigator::UNAUTHORIZED_NAVIGATION_ACTION:
                    case Navigator::LOGIN_NAVIGATION_ACTION:
                    //$this->doGo("admin/main.php", $message);
                    //break;
                    case Navigator::SUBMISSION_NAVIGATION_ACTION:
                        $this->doGo("admin/main.php", $message);
                        break;
                    case Navigator::LOGOUT_NAVIGATION_ACTION:
                        $this->doGo("index.php", $message);
                        break;
                }
                break;
            case Patient::tableName:
                switch ($action) {
                    case Navigator::UNAUTHORIZED_NAVIGATION_ACTION:
                    case Navigator::LOGIN_NAVIGATION_ACTION:
                    // $this->doGo("main.php", $message);
                    // break;
                    case Navigator::SUBMISSION_NAVIGATION_ACTION:
                        $this->doGo("main.php", $message);
                        break;
                    case Navigator::LOGOUT_NAVIGATION_ACTION:
                        $this->doGo("index.php", $message);
                        break;
                }
                break;
                break;
            case Physician::tableName:
                switch ($action) {
                    case Navigator::UNAUTHORIZED_NAVIGATION_ACTION:
                    case Navigator::LOGIN_NAVIGATION_ACTION:
                    // $this->doGo("doctor/main.php", $message);
                    // break;
                    case Navigator::SUBMISSION_NAVIGATION_ACTION:
                        $this->doGo("doctor/main.php", $message);
                        break;
                    case Navigator::LOGOUT_NAVIGATION_ACTION:
                        $this->doGo("index.php", $message);
                        break;
                }
                break;
                break;
        }
    }

}

?>
