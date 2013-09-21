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


$database = new Database();
$patientID = filter_var($_GET['patid'], FILTER_VALIDATE_INT) or die("Patient ID not set");
$type = filter_var($_GET['type'], FILTER_VALIDATE_INT, array('options'=>array('min_range' => 1, 'max_range'=>5))) or die("Type value is invalid");
if($type == 2){ //2 is not a valid type for this form
    die("Type value is invalid");
}
$patient = $database->read(Patient::createRetrievableDatabaseObject($patientID));
$doctor = $database->read(Physician::createRetrievableDatabaseObject($patient->getDoctor()));
$extremity = filter_var($_GET['extremity'], FILTER_VALIDATE_INT, array('options'=> array('min_range' => 1), 'max_range'=>2)) or die("Extremity is needed");
$eval = $database->read(Evals::createRetrievableDatabaseObject($patientID, $extremity)) or die("Pre eval form for patient has not been filled yet."); 

$currTime = getdate();


if (isset($_POST['SUBMIT'])) {

    $xray = new Xrays($patientID, $currTime['mon'], $currTime['mday'], $currTime['year']);
    $xray->setDateOfXrays($_POST['M'], $_POST['D'], $_POST['Y']);
    $xray->setSurId($patient->getDoctor());
    $xray->setType($type);
    $xray->setExtremity($extremity);
    
    foreach ($_POST as $key => $value){
           if($key === 'SUBMIT' || $key === 'M' || $key === 'D' || $key === 'Y'){   //filtering out unwanted keys
           } else {
               $xray->setAnswer($key, $value);
           }
       }
       //echo $xray->generateCreateQuery();
       //var_dump($xray);
       
       $database->create($xray);
       $nav->redirectUser($session->getUserType(), Navigator::SUBMISSION_NAVIGATION_ACTION, "Xray Evaluation successfully submitted");
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
        <?php echo Functions::formTitle($type, "X-Ray Evaluation", $extremity);?>
        <form action="<?php echo $_SERVER['SCRIPT_NAME'] . "?patid=$patientID" . "&extremity=$extremity" . "&type=$type"; ?>" method="POST">
            <div class='container'>
                <div class='greybox'>
                    <table>
                        <tr>
                            <td>1) Patient: <?php echo $patient->getFirstName() . " " . $patient->getLastName(); ?>&nbsp;</td>
                            <td>2) Surgeon: <?php echo $doctor->getFirstName() . " " . $doctor->getLastName(); ?> </td>
                        </tr>
                        <tr>
                            <td>3) Extremity: <?php echo $eval->getExtremityFormatted(); ?></td>
                            <td>4) <?php echo $xrayQuestions['Q4']; ?>: <input class="text" type='text' size='2' name='M' value='<?php echo (isset($_POST['M']) ? $_POST['M'] : $currTime['mon']); ?>'>-
                                <input class="text" type='text' size='2' name='D' value='<?php echo (isset($_POST['D']) ? $_POST['D'] : $currTime['mday']); ?>'>-
                                <input class="text" type='text' size='4' name='Y' value='<?php echo (isset($_POST['Y']) ? $_POST['Y'] : $currTime['year']); ?>'></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div class='whitebox'>
                    <table>
                        <tr>
                            <td>5) <?php echo $xrayQuestions['Q5'] . ":"; ?></td>
                            <td><input type='text' name='Q5' value='<?php echo isset($_POST['Q5']) ? $_POST['Q5'] : ""; ?>'></td>
                        </tr>
                        <tr>
                            <td>6) <?php echo $xrayQuestions['Q6'] . ":"; ?></td>
                            <td><input type='text' name='Q6' value='<?php echo isset($_POST['Q6']) ? $_POST['Q6'] : ""; ?>'></td>
                        </tr>
                        <tr>
                            <td>7) <?php echo $xrayQuestions['Q7'] . ":"; ?></td>
                            <td><input type='text' name='Q7' value='<?php echo isset($_POST['Q7']) ? $_POST['Q7'] : ""; ?>'> </td>
                        </tr>
                        <tr>
                            <td>8) <?php echo $xrayQuestions['Q8'] . ":"; ?></td>
                            <td><input type='text' name='Q8' value='<?php echo isset($_POST['Q8']) ? $_POST['Q8'] : ""; ?>'> </td>
                        </tr>
                        <tr>
                            <td>9) <?php echo $xrayQuestions['Q9'] . ":"; ?></td>
                            <td><input type='text' name='Q9' value='<?php echo isset($_POST['Q9']) ? $_POST['Q9'] : ""; ?>'> </td>
                        </tr>
                        <tr>
                            <td>10) <?php echo $xrayQuestions['Q10'] . ":"; ?></td>
                            <td><input type='text' name='Q10' value='<?php echo isset($_POST['Q10']) ? $_POST['Q10'] : ""; ?>'> </td>
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
                                <td><input type='text' name='Q11' value='<?php echo isset($_POST['Q11']) ? $_POST['Q11'] : ""; ?>'> </td>
                            </tr>
                            <tr>
                                <td>12) <?php echo $xrayQuestions['Q12'] . ":"; ?></td>
                                <td><input type='text' name='Q12' value='<?php echo isset($_POST['Q12']) ? $_POST['Q12'] : ""; ?>'> </td>
                            </tr>
                            <tr>
                                <td>13) <?php echo $xrayQuestions['Q13'] . ":"; ?></td>
                                <td><input type='text' name='Q13' value='<?php echo isset($_POST['Q13']) ? $_POST['Q13'] : ""; ?>'> </td>
                            </tr>
                            <tr>
                                <td>14) <?php echo $xrayQuestions['Q14'] . ":"; ?></td>
                                <td><input type='text' name='Q14' value='<?php echo isset($_POST['Q14']) ? $_POST['Q14'] : ""; ?>'> </td>
                            </tr>
                            <tr>
                                <td>15) <?php echo $xrayQuestions['Q15'] . ":"; ?></td>
                                <td><input type='text' name='Q15' value='<?php echo isset($_POST['Q15']) ? $_POST['Q15'] : ""; ?>'> </td>
                            </tr>
                            <tr>
                                <td>16) <?php echo $xrayQuestions['Q16'] . ":"; ?></td>
                                <td><input type='text' name='Q16' value='<?php echo isset($_POST['Q16']) ? $_POST['Q16'] : ""; ?>'> </td>
                            </tr>
                            <tr>
                                <td>17) <?php echo $xrayQuestions['Q17'] . ":"; ?></td>
                                <td><input type='text' name='Q17' value='<?php echo isset($_POST['Q17']) ? $_POST['Q17'] : ""; ?>'> </td>
                            </tr>
                            <tr>
                                <td>18) <?php echo $xrayQuestions['Q18'] . ":"; ?></td>
                                <td><input type='text' name='Q18' value='<?php echo isset($_POST['Q18']) ? $_POST['Q18'] : ""; ?>'> </td>
                            </tr>
                            <tr>
                                <td>19) <?php echo $xrayQuestions['Q19'] . ":"; ?></td>
                                <td><input type='text' name='Q19' value='<?php echo isset($_POST['Q19']) ? $_POST['Q19'] : ""; ?>'> </td>
                            </tr>
                            <tr>
                                <td>20) <?php echo $xrayQuestions['Q20'] . ":"; ?></td>
                                <td><input type='text' name='Q20' value='<?php echo isset($_POST['Q20']) ? $_POST['Q20'] : ""; ?>'> </td>
                            </tr>
                            <tr>
                                <td>21) <?php echo $xrayQuestions['Q21'] . ":"; ?></td>
                                <td><input type='text' name='Q21' value='<?php echo isset($_POST['Q21']) ? $_POST['Q21'] : ""; ?>'> </td>
                            </tr>
                            <tr>
                                <td>22) <?php echo $xrayQuestions['Q22'] . ":"; ?></td>
                                <td><input type='text' name='Q22' value='<?php echo isset($_POST['Q22']) ? $_POST['Q22'] : ""; ?>'> </td>
                            </tr>
                            <tr>
                                <td>23) <?php echo $xrayQuestions['Q23'] . ":"; ?></td>
                                <td><input type='text' name='Q23' value='<?php echo isset($_POST['Q23']) ? $_POST['Q23'] : ""; ?>'> </td>
                            </tr>
                            <tr>
                                <td>24) <?php echo $xrayQuestions['Q24'] . ":"; ?></td>
                                <td><input type='text' name='Q24' value='<?php echo isset($_POST['Q24']) ? $_POST['Q24'] : ""; ?>'> </td>
                            </tr>
                            <tr>
                                <td>25) <?php echo $xrayQuestions['Q25'] . ":"; ?></td>
                                <td><input type='text' name='Q25' value='<?php echo isset($_POST['Q25']) ? $_POST['Q25'] : ""; ?>'> </td>
                            </tr>
                            <tr>
                                <td>26) <?php echo $xrayQuestions['Q26'] . ":"; ?></td>
                                <td><input type='text' name='Q26' value='<?php echo isset($_POST['Q26']) ? $_POST['Q26'] : ""; ?>'> </td>
                            </tr>
                            <tr>
                                <td>27) <?php echo $xrayQuestions['Q27'] . ":"; ?></td>
                                <td><input type='text' name='Q27' value='<?php echo isset($_POST['Q27']) ? $_POST['Q27'] : ""; ?>'> </td>
                            </tr>
                            <tr>
                                <td>28) <?php echo $xrayQuestions['Q28'] . ":"; ?></td>
                                <td><input type='text' name='Q28' value='<?php echo isset($_POST['Q28']) ? $_POST['Q28'] : ""; ?>'> </td>
                            </tr>
                            <tr>
                                <td>29) <?php echo $xrayQuestions['Q29'] . ":"; ?></td>
                                <td><input type='text' name='Q29' value='<?php echo isset($_POST['Q29']) ? $_POST['Q29'] : ""; ?>'> </td>
                            </tr>
                        </table>
                    </div>
                    <div style='float: left;'>
                        <table>
                            <tr>
                                <td>30) <?php echo $xrayQuestions['Q30'] . ":"; ?></td>
                                <td><input type='text' name='Q30' value='<?php echo isset($_POST['Q30']) ? $_POST['Q30'] : ""; ?>'> </td>
                            </tr>
                            <tr>
                                <td>31) <?php echo $xrayQuestions['Q31'] . ":"; ?></td>
                                <td><input type='text' name='Q31' value='<?php echo isset($_POST['Q31']) ? $_POST['Q31'] : ""; ?>'> </td>
                            </tr>
                            <tr>
                                <td>32) <?php echo $xrayQuestions['Q32'] . ":"; ?></td>
                                <td><input type='text' name='Q32' value='<?php echo isset($_POST['Q32']) ? $_POST['Q32'] : ""; ?>'> </td>
                            </tr>
                            <tr>
                                <td>33) <?php echo $xrayQuestions['Q33'] . ":"; ?></td>
                                <td><input type='text' name='Q33' value='<?php echo isset($_POST['Q33']) ? $_POST['Q33'] : ""; ?>'> </td>
                            </tr>
                            <tr>
                                <td>34) <?php echo $xrayQuestions['Q34'] . ":"; ?></td>
                                <td><input type='text' name='Q34' value='<?php echo isset($_POST['Q34']) ? $_POST['Q34'] : ""; ?>'> </td>
                            </tr>
                            <tr>
                                <td>35) <?php echo $xrayQuestions['Q35'] . ":"; ?></td>
                                <td><input type='text' name='Q35' value='<?php echo isset($_POST['Q35']) ? $_POST['Q35'] : ""; ?>'> </td>
                            </tr>
                            <tr>
                                <td>36) <?php echo $xrayQuestions['Q36'] . ":"; ?></td>
                                <td><input type='text' name='Q36' value='<?php echo isset($_POST['Q36']) ? $_POST['Q36'] : ""; ?>'> </td>
                            </tr>
                            <tr>
                                <td>37) <?php echo $xrayQuestions['Q37'] . ":"; ?></td>
                                <td><input type='text' name='Q37' value='<?php echo isset($_POST['Q37']) ? $_POST['Q37'] : ""; ?>'> </td>
                            </tr>
                            <tr>
                                <td>38) <?php echo $xrayQuestions['Q38'] . ":"; ?></td>
                                <td><input type='text' name='Q38' value='<?php echo isset($_POST['Q38']) ? $_POST['Q38'] : ""; ?>'> </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class='container'>
                <div><input type='submit' name='SUBMIT' value='Finish Questionaire' /></div>
            </div>
        </form>
    </body>
</html>
