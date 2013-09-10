<?php

require_once '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));

session_start();                    // Start Session

$nav = new Navigator();

if(!(array_key_exists(Constants::LOGGED_IN_USER_TYPE, $_SESSION))){
    $nav->doGo("index.php", "");
}

$user = $_SESSION[Constants::LOGGED_IN_USER_OBJECT];
UserLoginManager::logOut($user);
$nav->redirectUser($user::tableName, Navigator::LOGOUT_NAVIGATION_ACTION, "You have logged out");

?>