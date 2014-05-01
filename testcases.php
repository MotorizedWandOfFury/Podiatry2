<!DOCTYPE html>
<html>
<?php
require_once '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));

$foot = new Foot(1);

$foot->setAnswer("Q4", 1);
$foot->setAnswer("Q6", 1);
$foot->setAnswer("Q7", 1);
$foot->setAnswer("Q8", 1);


echo "<p>","Foot Pain index (all 1s): ",$foot->getFootPainIndex(),"<p>";

$foot->setAnswer("Q4", 5);
$foot->setAnswer("Q6", 5);
$foot->setAnswer("Q7", 5);
$foot->setAnswer("Q8", 5);


echo "<p>","Foot Pain index (all 5s): ",$foot->getFootPainIndex(),"<p>";

$foot->setAnswer("Q10", 1);
$foot->setAnswer("Q11", 1);
$foot->setAnswer("Q13", 1);
$foot->setAnswer("Q14", 1);


echo "<p>","Foot Function index (all 1s): ",$foot->getFootFunctionIndex(),"<p>";

$foot->setAnswer("Q10", 5);
$foot->setAnswer("Q11", 5);
$foot->setAnswer("Q13", 5);
$foot->setAnswer("Q14", 5);


echo "<p>","Foot Function index (all 5s): ",$foot->getFootFunctionIndex(),"<p>";

$foot->setAnswer("Q15", 1);
$foot->setAnswer("Q20", 1);


echo "<p>","General Foot health score (all 1s): ",$foot->getGeneralFootHealthScore(),"<p>";

$foot->setAnswer("Q15", 5);
$foot->setAnswer("Q20", 5);


echo "<p>","General Foot health score(all 5s): ",$foot->getGeneralFootHealthScore(),"<p>";

$foot->setAnswer("Q17", 1);
$foot->setAnswer("Q18", 1);
$foot->setAnswer("Q19", 1);


echo "<p>","Footwear score (all 1s): ",$foot->getFootwearScore(),"<p>";

$foot->setAnswer("Q17", 5);
$foot->setAnswer("Q18", 5);
$foot->setAnswer("Q19", 5);


echo "<p>","Footwear score (all 5s): ",$foot->getFootwearScore(),"<p>";

?>

</html>