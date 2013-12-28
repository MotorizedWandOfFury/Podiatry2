<?php
date_default_timezone_set("EST");

require_once dirname(dirname(__FILE__)) . '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));

$json = new JSONManager();
$complicationQuestions = $json->loadJSONQuestions("Complications", "en");
$complicationsValues = $json->loadJSONValues("Complications", "en");

if (empty($complicationQuestions) || empty($complicationsValues)) {
    die("Unable to load JSON files");
}

$session = new SessionManager();
$session->validate();

$nav = new Navigator();

$database = new Database();
$patientID = filter_var($_GET['patid'], FILTER_VALIDATE_INT) or die("Patient ID not set");
$patient = $database->read(Patient::createRetrievableDatabaseObject($patientID));
$extremity = filter_var($_GET['extremity'], FILTER_VALIDATE_INT, array('options'=> array('min_range' => 1), 'max_range'=>2)) or die("Extremity is needed");
$doctor = null;
if($session->getUserType() === Physician::tableName ){
    $doctor = $session->getUserObject();
}
else {
     $doctor =  $database->read(Physician::createRetrievableDatabaseObject($patient->getDoctor()));
}

$currTime = getdate();
$noInvalidFields = true;
if (isset($_POST['SUBMIT'])) {
    if (!empty($_POST['M']) && !empty($_POST['D']) && !empty($_POST['Y'])) {
      $dateCheck =  checkdate($_POST['M'], $_POST['D'], $_POST['Y']);
      if(!$dateCheck){ //if check fails
          $noInvalidFields = false;
          echo "<p>Exam Date is invalid</p>";
      }
    }
    if (!empty($_POST['RM']) && !empty($_POST['RD']) && !empty($_POST['RY'])) {
      $dateCheck =  checkdate($_POST['RM'], $_POST['RD'], $_POST['RY']);
      if(!$dateCheck){ //if check fails
          $noInvalidFields = false;
          echo "<p>Revisional Date is invalid</p>";
      }
    }
    if (!empty($_POST['OM']) && !empty($_POST['OD']) && !empty($_POST['OY'])) {
      $dateCheck =  checkdate($_POST['OM'], $_POST['OD'], $_POST['OY']);
      if(!$dateCheck){ //if check fails
          $noInvalidFields = false;
          echo "<p>Other Complications Date is invalid</p>";
      }
    }
    
    if($noInvalidFields){
        $complications = new Complications($patientID);
        $complications->setDateOf($currTime['mon'], $currTime['mday'], $currTime['year']);    
        $complications->setDateOfExam($_POST['M'], $_POST['D'], $_POST['Y']);
        if (!empty($_POST['RM']) && !empty($_POST['RD']) && !empty($_POST['RY'])) { //insert date only when there is something entered
            $complications->setDateOfRevisionalSurgery($_POST['RM'], $_POST['RD'], $_POST['RY']);
        }
        if (!empty($_POST['OM']) && !empty($_POST['OD']) && !empty($_POST['OY'])) { //insert date only when there is something entered
             $complications->setDateOfOtherComplications($_POST['OM'], $_POST['OD'], $_POST['OY']);
        }
        $complications->setExtremity($extremity);
        $complications->setSurID($doctor->getID());
        $complications->setPatientID($patientID);
        
        foreach ($_POST as $key => $value) {
           if($key === 'Q7' || $key === 'Q8' || $key === 'Q9'){
                $complications->setAnswer($key, implode("|", $value));
           } else{
                 $complications->setAnswer($key, $value);
            }
           
        }
        echo $complications->generateCreateQuery();
        //var_dump($complications);
        //$database->create($complications);
        //$nav->redirectUser($session->getUserType(), Navigator::SUBMISSION_NAVIGATION_ACTION, "Complications Form successfully submitted");
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
       <head>
        <meta http-equiv='Content-Type' content='text/html;charset=utf-8' />
        <title>Complications Form</title>
        <link rel='stylesheet' href='../bootstrap/css/sf36_css.css' />
        
    </head>
    </head>
    <body>
        
        <form id="form1" action="<?php echo $_SERVER['SCRIPT_NAME'], "?patid=$patientID&extremity=$extremity"; ?>" method="POST" onsubmit="return validateFormData('form1')">
            <div class='container'>
                <div class='greybox'>
                    <table>
                        <tr>
                            <td>1) <b>Patient:</b> <?php echo $patient->getFirstName()." ". $patient->getLastName(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>2) <b>Patient# </b><?php echo $patient->getMedicalRecordNumber(); ?></td>
                        </tr>
                        <tr>
                            <td>3) <b>Surgeon: <?php echo $doctor->getFirstName(). " ". $doctor->getLastName() ?></b></td>
                            <td>4) <b>Date of Exam: </b>
                            <input type='text' size='2' name='M' value='<?php echo (isset($_POST['M']) ? $_POST['M'] : $currTime['mon']); ?>'>-
                                <input type='text' size='2' name='D' value='<?php echo (isset($_POST['D']) ? $_POST['D'] : $currTime['mday']); ?>'>-
                                <input type='text' size='4' name='Y' value='<?php echo (isset($_POST['Y']) ? $_POST['Y'] : $currTime['year']); ?>'>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div class='whitebox'>
                    <table>
                        <tr>
                            <td>5) <?php echo $complicationQuestions['Q5'] . ":"; ?></td>
                            <?php
                            foreach ($complicationsValues['Q5'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q5' id='Q5'  value = '" . $opt['val'] . "' " . (isset($_POST['Q5']) && $_POST['Q5'] == $opt['val'] ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="container">
                <div class ="greybox">
                    <table>
                        <tr>
                            <td>6) <?php echo $complicationQuestions['Q6'] . ":"; ?></td>
                            <td> <input type='text' name='Q6' value='<?php echo isset($_POST['Q6']) ? $_POST['Q6'] : ""; ?>'/> </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="container">
                <div class="whitebox">
                    <table>
                        <tr>
                            <td>7) <?php echo $complicationQuestions['Q7'] . ": "; ?></td>
                            <?php
                            foreach ($complicationsValues['Q7'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'checkbox' name = 'Q7[]'  value = '", $opt['val'], "' ", (isset($_POST['Q7']) && in_array($opt['val'], $_POST['Q7'])) ? "checked='checked'" : "", "/> ", $opt['name'], "";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>8) <?php echo $complicationQuestions['Q8'] . ": "; ?></td>
                            <?php
                            foreach ($complicationsValues['Q8'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'checkbox' name = 'Q8[]'  value = '", $opt['val'], "' ", (isset($_POST['Q8']) && in_array($opt['val'], $_POST['Q8'])) ? "checked='checked'" : "", "/> ", $opt['name'], "";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>9) <?php echo $complicationQuestions['Q9'] . ": "; ?></td>
                            <?php
                            foreach ($complicationsValues['Q9'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'checkbox' name = 'Q9[]'  value = '", $opt['val'], "' ", (isset($_POST['Q9']) && in_array($opt['val'], $_POST['Q9'])) ? "checked='checked'" : "", "/> ", $opt['name'], "";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="container">
                <div class="greybox">
                    <table>
                        <tr>
                            <td>10) <?php echo $complicationQuestions['Q10'] . ": "; ?></td>
                            <td><input type='text' name='Q10' size="120" value='<?php echo isset($_POST['Q10']) ? $_POST['Q10'] : ""; ?>'/></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="container">
                <div class="whitebox">
                    <table>
                        <tr>
                            <td>11) <?php echo $complicationQuestions['Q11'] . ": "; ?></td>
                            <td><input type='text' name='Q11' size="60" value='<?php echo isset($_POST['Q11']) ? $_POST['Q11'] : ""; ?>'/></td>
                            <td>Date: <input type='text' size='2' name='RM' value='<?php echo (isset($_POST['RM']) ? $_POST['RM'] : null); ?>'>-
                                <input type='text' size='2' name='RD' value='<?php echo (isset($_POST['RD']) ? $_POST['RD'] : null); ?>'>-
                                <input type='text' size='4' name='RY' value='<?php echo (isset($_POST['RY']) ? $_POST['RY'] : null); ?>'>
                            </td>
                        </tr>
                        <tr>
                            <td>12) <?php echo $complicationQuestions['Q12'] . ": "; ?></td>
                            <td><input type='text' name='Q12' size="60" value='<?php echo isset($_POST['Q12']) ? $_POST['Q12'] : ""; ?>'/></td>
                            <td>Date: <input type='text' size='2' name='OM' value='<?php echo (isset($_POST['OM']) ? $_POST['OM'] : null); ?>'>-
                                <input type='text' size='2' name='OD' value='<?php echo (isset($_POST['OD']) ? $_POST['OD'] : null); ?>'>-
                                <input type='text' size='4' name='OY' value='<?php echo (isset($_POST['OY']) ? $_POST['OY'] : null); ?>'>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="container">
                <div class="whitebox">
                    <table>
                        <tr>
                            <td>13) <?php echo $complicationQuestions['Q13'] . ": "; ?></td>
                            <td><input type='text' name='Q13' size="200" value='<?php echo isset($_POST['Q13']) ? $_POST['Q13'] : ""; ?>'/></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div><input type='submit' name='SUBMIT' value='Finish Questionaire'></div>
        </div>
        </form>
        
        <script type="text/javascript" src="../bootstrap/js/validator.js"></script>
    </body>
</html>
