<?php

echo "We made it to process eval";
echo (int)$_POST[15];

// Date form submitted
    $dateof = time();
    
    if (empty($_POST['Y']) || empty($_POST['M']) || empty($_POST['D'])) {
        $dateofexam = $dateof;
    }
    else {
          $dateofexam = mktime(0, 0, 0, (int)$_POST['M'], (int)$_POST['D'], (int)$_POST['Y']);
    }

    // Days of pain meds.
    $durofsymp = (int)$_POST[15];
    // Max dorsiflexion.
    $maxdors = (int)$_POST[19];
    // Max plantarflexion
    $maxplans = (int)$_POST[20];

    $ins_query = "INSERT INTO ans_eval (dateof, dateofexam, durofsymp, maxdors, maxplans, answer, ques_num, pat_id) VALUES (3,3,3,3,3,3,3,3)"; 
    echo $ins_query;

    mysql_query($ins_query);

?>

