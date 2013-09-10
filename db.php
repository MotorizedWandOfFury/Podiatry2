<?php

$dbHOST = "localhost";
$dbUSER = "root";
$dbPASS = "";
$dbNAME = "podiatry";
$db_connection = mysql_connect($dbHOST, $dbUSER, $dbPASS) || die(mysql_error());
$db_select = mysql_select_db($dbNAME) || die("
	<div style='color: red;'>
		<div>Don't be afraid... <b>You need the database first!</b></div>
		<div>You need to:</div>
		<div>1. Go to phpmyadmin.</div>
		<div>2. Find the import tab.</div>
		<div>3. Import the .sql file from the main folder.</div>
		<div>4. Click \"Go\" in the interface.</div>
		<div>This page will then be disabled.</div>
	</div>
");
?>