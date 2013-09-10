<?php
require_once './Classes/Database.php';
require_once './Classes/SF36.php';

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

foreach ($patIdArray as $id) {
    $query = "SELECT * FROM ans_sf36 WHERE pat_id = " . $id;
    $queryResult = mysql_query($query);
    $row = mysql_fetch_assoc($queryResult);

    //insert first record manually, setting pat_id and date once
    $sf36 = new SF36($row['pat_id']);
    $sf36->setDateOfByTimeStamp($row['dateof']);
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
