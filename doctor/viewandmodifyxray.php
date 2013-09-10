<?php
date_default_timezone_set("EST");
 
require_once dirname(dirname(__FILE__)) . '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));
 
$json = new JSONManager();
$xrayQuestions = $json->loadJSONQuestions("Xrays", "en");
 
if (empty($xrayQuestions)) {
    die("Unable to load JSON files");
}
 
$session = new SessionManager();
$session->validate();
 
$nav = new Navigator();
$func = new Functions();
 
 
$mode = isset($_GET['mode']) ? $_GET['mode'] : "view"; // default mode for page is viewing, if the mode attribute has not been set
 
$database = new Database();
$patientID = filter_var($_GET['patid'], FILTER_VALIDATE_INT) or die("Patient ID not set");
$type = filter_var($_GET['type'], FILTER_VALIDATE_INT, array('options'=>array('min_range' => 1, 'max_range'=>5))) or die("Type value is invalid");
if($type == 2){ //2 is not a valid type for this form
    die("Type value is invalid");
}
$patient = $database->read(Patient::createRetrievableDatabaseObject($patientID));
$extremity = filter_var($_GET['extremity'], FILTER_VALIDATE_INT, array('options'=> array('min_range' => 1), 'max_range'=>2)) or die("Extremity is needed");
$xray = $database->read(Xrays::createRetrievableDatabaseObject($patientID, $type, $extremity)) or die("Form has not been filled for this patient");
$doctorID = $xray->getSurID();
$doctor = $database->read(Physician::createRetrievableDatabaseObject($doctorID));

$eval = $database->read(Evals::createRetrievableDatabaseObject($patientID, $extremity)) or die("Pre eval form for patient has not been filled yet."); 
if ($mode === 'edit') { // make sure we are in edit mode before we can make changes
    if (isset($_POST['SUBMIT'])) {
        foreach ($_POST as $key => $value) {
            if ($key === 'SUBMIT') {   //filtering out unwanted keys
            } else {
                $xray->setAnswer($key, $value);
            }
        }
        //echo $xray->generateUpdateQuery();
        //var_dump($xray);
        $database->update($xray);
        $nav->redirectUser($session->getUserType(), Navigator::SUBMISSION_NAVIGATION_ACTION, "Xray Evaluation successfully updated");
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>X-Ray Evaluation</title>
        <link rel='stylesheet' href='../bootstrap/css/sf36_css.css' />
    </head>
    <body>
        <?php echo Functions::formTitle($type, "X-Ray Evaluation");?>
        &nbsp;
        <a href="<?php echo $_SERVER['SCRIPT_NAME'] . "?patid=$patientID" . "&type=$type" . "&extremity=$extremity" . "&mode=view"; ?>">View</a> | <a href="<?php echo $_SERVER['SCRIPT_NAME'] . "?patid=$patientID" . "&type=$type" . "&extremity=$extremity" . "&mode=edit"; ?>">Edit</a>
        <form action="<?php echo $_SERVER['SCRIPT_NAME'] . "?patid=$patientID" . "&type=$type" . "&extremity=$extremity" . "&mode=$mode"; ?>" method="POST">
            <div class='container'>
                <div class='greybox'>
                    <table>
                        <tr>
                            <td>1) Patient: <?php echo $patient->getFirstName() . " " . $patient->getLastName(); ?>&nbsp;</td>
                            <td>2) Surgeon: <?php echo $doctor->getFirstName() . " " . $doctor->getLastName(); ?> </td>
                        </tr>
                        <tr>
                            <td>3) Extremity: <?php echo $eval->getExtremityFormatted(); ?></td>
                            <td>4) <?php echo $xrayQuestions['Q4'] . ": " . $xray->getDateOfXraysFormatted(); ?> </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div class='whitebox'>
                    <table>
                        <tr>
                            <td>5) <?php echo $xrayQuestions['Q5'] . ":"; ?></td>
                            <td><input type='text' name='Q5' <?php echo "value = '" . $xray->getAnswer("Q5") . "' " . $func->disableElement($mode); ?>></td>
                        </tr>
                        <tr>
                            <td>6) <?php echo $xrayQuestions['Q6'] . ":"; ?></td>
                            <td><input type='text' name='Q6' <?php echo "value = '" . $xray->getAnswer("Q6") . "' " . $func->disableElement($mode); ?>></td>
                        </tr>
                        <tr>
                            <td>7) <?php echo $xrayQuestions['Q7'] . ":"; ?></td>
                            <td><input type='text' name='Q7' <?php echo "value = '" . $xray->getAnswer("Q7") . "' " . $func->disableElement($mode); ?>> </td>
                        </tr>
                        <tr>
                            <td>8) <?php echo $xrayQuestions['Q8'] . ":"; ?></td>
                            <td><input type='text' name='Q8' <?php echo "value = '" . $xray->getAnswer("Q8") . "' " . $func->disableElement($mode); ?>> </td>
                        </tr>
                        <tr>
                            <td>9) <?php echo $xrayQuestions['Q9'] . ":"; ?></td>
                            <td><input type='text' name='Q9' <?php echo "value = '" . $xray->getAnswer("Q9") . "' " . $func->disableElement($mode); ?>> </td>
                        </tr>
                        <tr>
                            <td>10) <?php echo $xrayQuestions['Q10'] . ":"; ?></td>
                            <td><input type='text' name='Q10' <?php echo "value = '" . $xray->getAnswer("Q10") . "' " . $func->disableElement($mode); ?>> </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div class='greybox'>
                    <div>If measuring by hand do not complete the remaining items beyond number 10.</div>
                    <div style='float: left;'>
                        <table>
                            <tr>
                                <td>11) <?php echo $xrayQuestions['Q11'] . ":"; ?></td>
                                <td><input type='text' name='Q11' <?php echo "value = '" . $xray->getAnswer("Q11") . "' " . $func->disableElement($mode); ?>> </td>
                            </tr>
                            <tr>
                                <td>12) <?php echo $xrayQuestions['Q12'] . ":"; ?></td>
                                <td><input type='text' name='Q12' <?php echo "value = '" . $xray->getAnswer("Q12") . "' " . $func->disableElement($mode); ?>> </td>
                            </tr>
                            <tr>
                                <td>13) <?php echo $xrayQuestions['Q13'] . ":"; ?></td>
                                <td><input type='text' name='Q13' <?php echo "value = '" . $xray->getAnswer("Q13") . "' " . $func->disableElement($mode); ?>> </td>
                            </tr>
                            <tr>
                                <td>14) <?php echo $xrayQuestions['Q14'] . ":"; ?></td>
                                <td><input type='text' name='Q14' <?php echo "value = '" . $xray->getAnswer("Q14") . "' " . $func->disableElement($mode); ?>'> </td>
                            </tr>
                            <tr>
                                <td>15) <?php echo $xrayQuestions['Q15'] . ":"; ?></td>
                                <td><input type='text' name='Q15' <?php echo "value = '" . $xray->getAnswer("Q15") . "' " . $func->disableElement($mode); ?>> </td>
                            </tr>
                            <tr>
                                <td>16) <?php echo $xrayQuestions['Q16'] . ":"; ?></td>
                                <td><input type='text' name='Q16' <?php echo "value = '" . $xray->getAnswer("Q16") . "' " . $func->disableElement($mode); ?>> </td>
                            </tr>
                            <tr>
                                <td>17) <?php echo $xrayQuestions['Q17'] . ":"; ?></td>
                                <td><input type='text' name='Q17' <?php echo "value = '" . $xray->getAnswer("Q17") . "' " . $func->disableElement($mode); ?>> </td>
                            </tr>
                            <tr>
                                <td>18) <?php echo $xrayQuestions['Q18'] . ":"; ?></td>
                                <td><input type='text' name='Q18' <?php echo "value = '" . $xray->getAnswer("Q18") . "' " . $func->disableElement($mode); ?>> </td>
                            </tr>
                            <tr>
                                <td>19) <?php echo $xrayQuestions['Q19'] . ":"; ?></td>
                                <td><input type='text' name='Q19' <?php echo "value = '" . $xray->getAnswer("Q19") . "' " . $func->disableElement($mode); ?>> </td>
                            </tr>
                            <tr>
                                <td>20) <?php echo $xrayQuestions['Q20'] . ":"; ?></td>
                                <td><input type='text' name='Q20' <?php echo "value = '" . $xray->getAnswer("Q20") . "' " . $func->disableElement($mode); ?>> </td>
                            </tr>
                            <tr>
                                <td>21) <?php echo $xrayQuestions['Q21'] . ":"; ?></td>
                                <td><input type='text' name='Q21' <?php echo "value = '" . $xray->getAnswer("Q21") . "' " . $func->disableElement($mode); ?>> </td>
                            </tr>
                            <tr>
                                <td>22) <?php echo $xrayQuestions['Q22'] . ":"; ?></td>
                                <td><input type='text' name='Q22' <?php echo "value = '" . $xray->getAnswer("Q22") . "' " . $func->disableElement($mode); ?>> </td>
                            </tr>
                            <tr>
                                <td>23) <?php echo $xrayQuestions['Q23'] . ":"; ?></td>
                                <td><input type='text' name='Q23' <?php echo "value = '" . $xray->getAnswer("Q23") . "' " . $func->disableElement($mode); ?>> </td>
                            </tr>
                            <tr>
                                <td>24) <?php echo $xrayQuestions['Q24'] . ":"; ?></td>
                                <td><input type='text' name='Q24' <?php echo "value = '" . $xray->getAnswer("Q24") . "' " . $func->disableElement($mode); ?>> </td>
                            </tr>
                            <tr>
                                <td>25) <?php echo $xrayQuestions['Q25'] . ":"; ?></td>
                                <td><input type='text' name='Q25' <?php echo "value = '" . $xray->getAnswer("Q25") . "' " . $func->disableElement($mode); ?>> </td>
                            </tr>
                            <tr>
                                <td>26) <?php echo $xrayQuestions['Q26'] . ":"; ?></td>
                                <td><input type='text' name='Q26' <?php echo "value = '" . $xray->getAnswer("Q26") . "' " . $func->disableElement($mode); ?>> </td>
                            </tr>
                            <tr>
                                <td>27) <?php echo $xrayQuestions['Q27'] . ":"; ?></td>
                                <td><input type='text' name='Q27' <?php echo "value = '" . $xray->getAnswer("Q27") . "' " . $func->disableElement($mode); ?>> </td>
                            </tr>
                            <tr>
                                <td>28) <?php echo $xrayQuestions['Q28'] . ":"; ?></td>
                                <td><input type='text' name='Q28' <?php echo "value = '" . $xray->getAnswer("Q28") . "' " . $func->disableElement($mode); ?>> </td>
                            </tr>
                            <tr>
                                <td>29) <?php echo $xrayQuestions['Q29'] . ":"; ?></td>
                                <td><input type='text' name='Q29' <?php echo "value = '" . $xray->getAnswer("Q29") . "' " . $func->disableElement($mode); ?>> </td>
                            </tr>
                        </table>
                    </div>
                    <div style='float: left;'>
                        <table>
                            <tr>
                                <td>30) <?php echo $xrayQuestions['Q30'] . ":"; ?></td>
                                <td><input type='text' name='Q30' <?php echo "value = '" . $xray->getAnswer("Q30") . "' " . $func->disableElement($mode); ?>> </td>
                            </tr>
                            <tr>
                                <td>31) <?php echo $xrayQuestions['Q31'] . ":"; ?></td>
                                <td><input type='text' name='Q31' <?php echo "value = '" . $xray->getAnswer("Q31") . "' " . $func->disableElement($mode); ?>> </td>
                            </tr>
                            <tr>
                                <td>32) <?php echo $xrayQuestions['Q32'] . ":"; ?></td>
                                <td><input type='text' name='Q32' <?php echo "value = '" . $xray->getAnswer("Q32") . "' " . $func->disableElement($mode); ?>> </td>
                            </tr>
                            <tr>
                                <td>33) <?php echo $xrayQuestions['Q33'] . ":"; ?></td>
                                <td><input type='text' name='Q33' <?php echo "value = '" . $xray->getAnswer("Q33") . "' " . $func->disableElement($mode); ?>> </td>
                            </tr>
                            <tr>
                                <td>34) <?php echo $xrayQuestions['Q34'] . ":"; ?></td>
                                <td><input type='text' name='Q34' <?php echo "value = '" . $xray->getAnswer("Q34") . "' " . $func->disableElement($mode); ?>> </td>
                            </tr>
                            <tr>
                                <td>35) <?php echo $xrayQuestions['Q35'] . ":"; ?></td>
                                <td><input type='text' name='Q35' <?php echo "value = '" . $xray->getAnswer("Q35") . "' " . $func->disableElement($mode); ?>> </td>
                            </tr>
                            <tr>
                                <td>36) <?php echo $xrayQuestions['Q36'] . ":"; ?></td>
                                <td><input type='text' name='Q36' <?php echo "value = '" . $xray->getAnswer("Q36") . "' " . $func->disableElement($mode); ?>> </td>
                            </tr>
                            <tr>
                                <td>37) <?php echo $xrayQuestions['Q37'] . ":"; ?></td>
                                <td><input type='text' name='Q37' <?php echo "value = '" . $xray->getAnswer("Q37") . "' " . $func->disableElement($mode); ?>> </td>
                            </tr>
                            <tr>
                                <td>38) <?php echo $xrayQuestions['Q38'] . ":"; ?></td>
                                <td><input type='text' name='Q38' <?php echo "value = '" . $xray->getAnswer("Q38") . "' " . $func->disableElement($mode); ?>> </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class='container'>
                <div><input type='submit' name='SUBMIT' value='Update Xrays' <?php echo ($mode === 'view') ? "disabled='disabled'" : ""; ?> ></div>
            </div>
        </form>
    </body>
</html>
