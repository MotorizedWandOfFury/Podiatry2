<!DOCTYPE html>
<html>
<?php
require_once './classes/PreOpScore.php';
require_once './classes/PreOpScorePatientAssociation.php';
require_once './classes/Database.php';

$preOpObj = new PreOpScore(2, 10, 31, 1990);
$preOpObj->setAnswer("vitality", 2);
$preOpObj->setAnswer("bpain", 25);

echo "<p>","Create: ", $preOpObj->generateCreateQuery(),"</p>";
echo "<p>","Update: ",$preOpObj->generateUpdateQuery(),"</p>";
echo "<p>","Read: ",$preOpObj->generateReadQuery(),"</p>";

$prePat = new PreOpScorePatientAssociation();
echo "<p>","Read: ",$prePat->generateAssociationRetrieveQuery(),"</p>";
$database = new Database();
$database->createAssociationObject($prePat);

var_dump($prePat->getPreOpArray());
var_dump($prePat->getPatientArray());
?>

</html>