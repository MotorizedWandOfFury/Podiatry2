<!DOCTYPE html>
<html>
<?php
require_once '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));

$sf36 = new SF36(1, 10, 31, 1980);

$sf36->setAnswer("Q7", 1);
$sf36->setAnswer("Q8", 1);
$sf36->setAnswer("Q9", 1);
$sf36->setAnswer("Q10", 1);
$sf36->setAnswer("Q11", 1);
$sf36->setAnswer("Q12", 1);
$sf36->setAnswer("Q13", 1);
$sf36->setAnswer("Q14", 1);
$sf36->setAnswer("Q15", 1);
$sf36->setAnswer("Q16", 1);

echo "<p>","Physical Functioning Score (all 1s): ",$sf36->getPhysicalFunctioningScore(),"<p>";

$sf36->setAnswer("Q7", 3);
$sf36->setAnswer("Q8", 3);
$sf36->setAnswer("Q9", 3);
$sf36->setAnswer("Q10", 3);
$sf36->setAnswer("Q11", 3);
$sf36->setAnswer("Q12", 3);
$sf36->setAnswer("Q13", 3);
$sf36->setAnswer("Q14", 3);
$sf36->setAnswer("Q15", 3);
$sf36->setAnswer("Q16", 3);

echo "<p>","Physical Functioning Score (all 3s): ",$sf36->getPhysicalFunctioningScore(),"<p>";

$sf36->setAnswer("Q18", 1);
$sf36->setAnswer("Q19", 1);
$sf36->setAnswer("Q20", 1);
$sf36->setAnswer("Q21", 1);

echo "<p>","Role Physical Score (all 1s): ",$sf36->getRolePhysicalScore(),"</p>";

$sf36->setAnswer("Q18", 2);
$sf36->setAnswer("Q19", 2);
$sf36->setAnswer("Q20", 2);
$sf36->setAnswer("Q21", 2);

echo "<p>","Role Physical Score (all 2s): ",$sf36->getRolePhysicalScore(),"</p>";

$sf36->setAnswer("Q27", 1);
$sf36->setAnswer("Q28", 1);

echo "<p>","Bodily Pain Score (all 1s): ",$sf36->getBodilyPainScore(),"</p>";

$sf36->setAnswer("Q27", 6);
$sf36->setAnswer("Q28", 5);

echo "<p>","Bodily Pain Score (all 6s and 5s): ",$sf36->getBodilyPainScore(),"</p>";

$sf36->setAnswer("Q4", 5);
$sf36->setAnswer("Q42", 1);
$sf36->setAnswer("Q43", 5);
$sf36->setAnswer("Q44", 1);
$sf36->setAnswer("Q45", 5);

echo "<p>","General Health Score (all negative): ",$sf36->getGeneralHealthScore(),"</p>";

$sf36->setAnswer("Q4", 1);
$sf36->setAnswer("Q42", 5);
$sf36->setAnswer("Q43", 1);
$sf36->setAnswer("Q44", 5);
$sf36->setAnswer("Q45", 1);

echo "<p>","General Health Score (all positive): ",$sf36->getGeneralHealthScore(),"</p>";

$sf36->setAnswer("Q31", 6);
$sf36->setAnswer("Q35", 6);
$sf36->setAnswer("Q37", 1);
$sf36->setAnswer("Q39", 1);

echo "<p>","Vitality (all negative): ",$sf36->getVitalityScore(),"</p>";

$sf36->setAnswer("Q31", 1);
$sf36->setAnswer("Q35", 1);
$sf36->setAnswer("Q37", 6);
$sf36->setAnswer("Q39", 6);

echo "<p>","Vitality (all positive): ",$sf36->getVitalityScore(),"</p>";

$sf36->setAnswer("Q23", 1);
$sf36->setAnswer("Q24", 1);
$sf36->setAnswer("Q25", 1);

echo "<p>","Role Emotional (all 1s): ",$sf36->getRoleEmotionalScore(),"</p>";

$sf36->setAnswer("Q23", 2);
$sf36->setAnswer("Q24", 2);
$sf36->setAnswer("Q25", 2);

echo "<p>","Role Emotional (all 2s): ",$sf36->getRoleEmotionalScore(),"</p>";


$sf36->setAnswer("Q32", 6);
$sf36->setAnswer("Q33", 6);
$sf36->setAnswer("Q34", 1);
$sf36->setAnswer("Q36", 6);
$sf36->setAnswer("Q38", 1);

echo "<p>","Mental Health Score (all positive): ",$sf36->getMentalHealthScore(),"</p>";

$sf36->setAnswer("Q32", 1);
$sf36->setAnswer("Q33", 1);
$sf36->setAnswer("Q34", 6);
$sf36->setAnswer("Q36", 1);
$sf36->setAnswer("Q38", 6);

echo "<p>","Mental Health Score (all negative): ",$sf36->getMentalHealthScore(),"</p>";

?>

</html>