<?php

require_once '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));

$database = new Database();
$patientIdQuery = "SELECT DISTINCT pat_id from ans_surgical";
$patIDResult = mysql_query($patientIdQuery);
$patIdArray = array();
$i = 0;
//build array of pat_ids
while ($row = mysql_fetch_assoc($patIDResult)) {
    $patIdArray[$i++] = $row['pat_id'];
}

var_dump($patIdArray); //confirm query returns expected result



foreach ($patIdArray as $id) {
    $query = "SELECT * FROM ans_surgical WHERE pat_id = " . $id;
    $queryResult = mysql_query($query);
    $row = mysql_fetch_assoc($queryResult);
    
    //get extremity from old version of patient table
    $queryForExtremity = mysql_query("SELECT extremity FROM patients WHERE id = " . $id);
    $rowExtremityResult = mysql_fetch_assoc($queryForExtremity);

    //insert first record manually, setting pat_id and date once
    $dbObj = new Surgical($row['pat_id']);
    $dbObj->setDateOfByTimeStamp($row['dateof']);
    $dbObj->setSurId($row['sur_id']);
    $dbObj->setDateOfSurgeryByTimeStamp($row['dateofsurgery']);
    $dbObj->setExtremity($rowExtremityResult['extremity']);
    
    $index = "Q" . $row['ques_num'];
    $answer = $row['answer'];
    $dbObj->setAnswer($index, $answer);

    //add rest of answers
    while ($row = mysql_fetch_assoc($queryResult)) {
        $index = "Q" . $row['ques_num'];
        $answer = $row['answer'];
        $dbObj->setAnswer($index, $answer);
    }

    var_dump($dbObj); //confirm query returns expected results
    //$database->create($dbObj);
   }
?>
