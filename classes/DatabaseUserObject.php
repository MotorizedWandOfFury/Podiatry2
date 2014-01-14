<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Ping
 */
interface DatabaseUserObject extends DatabaseObject {

    public function getUsername();

    public function setUsername($value);

    public function getPassword();

    public function setPassword($value);

    public function getRole();
}

?>
