<?php
require_once '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));

$database = new Database();
$patientIdQuery = "SELECT DISTINCT pat_id from ans_sf36";
$patIDResult = mysql_query($patientIdQuery);
$patIdArray = array();
$i = 0;
//build array of pat_ids
while ($row = mysql_fetch_assoc($patIDResult)) {
    $patIdArray[$i++] = $row['pat_id'];
}

var_dump($patIdArray); //confirm query returns expected result

$formDateResult = mysql_query("SELECT DISTINCT dateof FROM ans_sf36 ORDER BY dateof ASC"); //we pull all the dates from the table so that we can use it to figure out the type field for each object
$dateArray = array();
$typeVal = 1;
while($rowDates = mysql_fetch_assoc($formDateResult)){
    $dateArray[$rowDates['dateof']] = $typeVal;
    $typeVal++;
    if($typeVal == 2){
        $typeVal++; //2 is not a valid type for this form, so skip it
    }
}

var_dump($dateArray); //confirm we have expected results



foreach ($patIdArray as $id) {
    $query = "SELECT * FROM ans_sf36 WHERE pat_id = " . $id;
    $queryResult = mysql_query($query);
    $row = mysql_fetch_assoc($queryResult);
    
    //get extremity from old version of patient table
    $queryForExtremity = mysql_query("SELECT extremity FROM patients WHERE id = " . $id);
    $rowExtremityResult = mysql_fetch_assoc($queryForExtremity);

    //insert first record manually, setting pat_id and date once
    $sf36 = new SF36($row['pat_id']);
    $sf36->setDateOfByTimeStamp($row['dateof']);
    $sf36->setType($dateArray[$row['dateof']]);
    $sf36->setExtremity($rowExtremityResult['extremity']);
    
    $index = "Q" . $row['ques_num'];
    $answer = $row['answer'];
    $sf36->setAnswer($index, $answer);

    //add rest of answers
    while ($row = mysql_fetch_assoc($queryResult)) {
        $index = "Q" . $row['ques_num'];
        $answer = $row['answer'];
        $sf36->setAnswer($index, $answer);
    }

    var_dump($sf36); //confirm query returns expected results
    //$database->create($sf36);
}
?>
