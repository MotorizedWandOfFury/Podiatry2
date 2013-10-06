<?php

require_once '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));

$database = new Database();
$patientIdQuery = "SELECT DISTINCT pat_id from ans_eval";
$patIDResult = mysql_query($patientIdQuery);
$patIdArray = array();
$i = 0;
//build array of pat_ids
while ($row = mysql_fetch_assoc($patIDResult)) {
    $patIdArray[$i++] = $row['pat_id'];
}

var_dump($patIdArray); //confirm query returns expected result

foreach ($patIdArray as $id) {
    $query = "SELECT * FROM ans_eval WHERE pat_id = " . $id;
    $queryResult = mysql_query($query);
    $row = mysql_fetch_assoc($queryResult);
    
    //get extremity, height, and weight from old version of patient table
    $queryForHeightWeightExtremity = mysql_query("SELECT height,weight,extremity FROM patients WHERE id = " . $id);
    $rowForResult = mysql_fetch_assoc($queryForHeightWeightExtremity);

    //insert first record manually, setting pat_id, date, height, weight, extremity once
    $eval = new Evals($row['pat_id']);
    $eval->setDateOfByTimeStamp($row['dateof']);
    $eval->setDateOfExamByTimeStamp($row['dateofexam']);
    $eval->setExtremity($rowForResult['extremity']);
    $eval->setHeight($rowForResult['height']);
    $eval->setWeight($rowForResult['weight']);
    $eval->setSurId($row['sur_id']);
    
   
    $index = "Q" . $row['ques_num'];
    $answer = $row['answer'];
    $eval->setAnswer($index, $answer);

    //add rest of answers
    while ($row = mysql_fetch_assoc($queryResult)) {
        $index = "Q" . $row['ques_num'];
        $answer = $row['answer'];
        $eval->setAnswer($index, $answer);
    }

    var_dump($eval); //confirm query returns expected results
    //$database->create($eval);
   }
?>
