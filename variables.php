<?php

/**
 * Default timezone.
 */
date_default_timezone_set("America/New_York");
$getTime = time();
$SCRIPT_NAME = $_SERVER['SCRIPT_NAME'];
$sUN = "USERNAME";
$sID = "PATIENTID";
$sDUN = "DOCUSERNAME";
$sDID = "DOCTORID";
$sAUN = "ADMINNAME";
$sAID = "ADMINID";
$doDate = "m/d/y";
$doTime = "h:i:s A";
$doDateFormat = $doDate . ", " . $doTime;
?>