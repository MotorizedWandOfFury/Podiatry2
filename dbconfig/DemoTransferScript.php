<?php
require_once '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));

$database = new Database();
$patientIdQuery = "SELECT DISTINCT pat_id from ans_demo";
$patIDResult = mysql_query($patientIdQuery);
$patIdArray = array();
$i = 0;
//build array of pat_ids
while ($row = mysql_fetch_assoc($patIDResult)) {
    $patIdArray[$i++] = $row['pat_id'];
}

var_dump($patIdArray); //confirm query returns expected result

foreach ($patIdArray as $id) {
    $query = "SELECT * FROM ans_demo WHERE pat_id = " . $id;
    $queryResult = mysql_query($query);
    $row = mysql_fetch_assoc($queryResult);

    //insert first record manually, setting pat_id and date once
    $demo = new Demo($row['pat_id']);
    $demo->setDateOfByTimeStamp($row['dateof']);
    $index = "Q" . $row['ques_num'];
    $answer = $row['answer'];
    $demo->setAnswer($index, $answer);

    //add rest of answers
    while ($row = mysql_fetch_assoc($queryResult)) {
        $index = "Q" . $row['ques_num'];
        $answer = $row['answer'];
        $demo->setAnswer($index, $answer);
    }

    var_dump($demo); //confirm query returns expected results
    //$database->create($demo);
   }
?>
