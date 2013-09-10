<?php

require "../classes/time.php";
$time = new Time();

echo $time->doFullDate(time());
?>