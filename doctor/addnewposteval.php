<?php
date_default_timezone_set("EST");

require_once dirname(dirname(__FILE__)) . '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));

$json = new JSONManager();
$postQuestions = $json->loadJSONQuestions("Post", "en");
$postValues = $json->loadJSONValues("Post", "en");

if (empty($postQuestions) || empty($postValues)) {
    die("Unable to load JSON files");
}

$session = new SessionManager();
$session->validate();

$nav = new Navigator();


$database = new Database();
$patientID = filter_var($_GET['patid'], FILTER_VALIDATE_INT) or die("Patient ID not set");
$type = filter_var($_GET['type'], FILTER_VALIDATE_INT, array('options'=>array('min_range' => 1, 'max_range'=>5))) or die("Type value is invalid");
$patient = $database->read(Patient::createRetrievableDatabaseObject($patientID));
$doctor = $database->read(Physician::createRetrievableDatabaseObject($patient->getDoctor()));
$extremity = filter_var($_GET['extremity'], FILTER_VALIDATE_INT, array('options'=> array('min_range' => 1), 'max_range'=>2)) or die("Extremity is needed");
$eval = $database->read(Evals::createRetrievableDatabaseObject($patientID, $extremity)) or die("Pre eval form for patient has not been filled yet."); 

$currTime = getdate();

$noInvalidFields = true;
if (isset($_POST['SUBMIT'])) {
    foreach ($_POST as $key => $value) {
        if ($value) {
            switch ($key) {
                case 'M':
                    $monthOptions = array(
                        'options' => array(
                            'min_range' => 1,
                            'max_range' => 12,
                        )
                    );
                    if (filter_var($value, FILTER_VALIDATE_INT, $monthOptions) === false) {
                        echo "<p>$key is not valid</p>";
                        $noInvalidFields = false;
                    }
                    break;
                case 'D':
                    $dayOptions = array(
                        'options' => array(
                            'min_range' => 1,
                            'max_range' => 31,
                        )
                    );
                    if (filter_var($value, FILTER_VALIDATE_INT, $dayOptions) == false) {
                        echo "<p>$key is not valid</p>";
                        $noInvalidFields = false;
                    }
                    break;
                case 'Y':
                    $yearOptions = array(
                        'options' => array(
                            'min_range' => 1900,
                            'max_range' => getdate()['year'],
                        )
                    );
                    if (filter_var($value, FILTER_VALIDATE_INT, $yearOptions) == false) {
                        echo "<p>$key is not valid</p>";
                        $noInvalidFields = false;
                    }
                    break;
                case 'painmedused':
                    if (filter_var($_POST['painmedused'], FILTER_VALIDATE_INT) === false) {
                        $noInvalidFields = false;
                        echo "<p>$key is not valid</p>";
                    }
                    break;
                case 'dosepainmedused':
                    if (filter_var($_POST['dosepainmedused'], FILTER_VALIDATE_INT) === false) {
                        $noInvalidFields = false;
                        echo "<p>$key is not valid</p>";
                    }
                    break;
            }
        }
        else {
            echo "<p>" . $key . " is empty" . "</p>";
        }
    }
    
   if($noInvalidFields){
       $post = new Post($patientID, $currTime['mon'], $currTime['mday'], $currTime['year']);
       $post->setDateOfExam($_POST['M'], $_POST['D'], $_POST['Y']);
       $post->setSurId($patient->getDoctor());
       $post->setPainMedUsed($_POST['painmedused']);
       $post->setDosePainMedUsed($_POST['dosepainmedused']);
       $post->setType($type);
       $post->setExtremity($extremity);
       
       foreach ($_POST as $key => $value){
           if($key === 'SUBMIT' || $key === 'M' || $key === 'D' || $key === 'Y' || $key === 'painmedused' || $key === 'dosepainmedused'){   //filtering out unwanted keys
           } else {
               $post->setAnswer($key, $value);
           }
       }
       //echo $post->generateCreateQuery();
       //var_dump($post);
       
       $database->create($post);
       $nav->redirectUser($session->getUserType(), Navigator::SUBMISSION_NAVIGATION_ACTION, "Evaluation successfully submitted");
   } 
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>POST-OPERATIVE Evaluation</title>
        <link rel='stylesheet' href='../bootstrap/css/sf36_css.css' />
    </head>
    <body>
        <?php echo Functions::formTitle($type, "POST-OPERATIVE Evaluation", $extremity)?>
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
                            <td>4) <?php echo $postQuestions['Q4']; ?>: <input class="text" type='text' size='2' name='M' value='<?php echo (isset($_POST['M']) ? $_POST['M'] : $currTime['mon']); ?>'>-
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
                            <td>5) <?php echo $postQuestions['Q5']; ?>:</td>
                            <td><input class="text" name="painmedused" value="<?php echo isset($_POST['painmedused']) ? $_POST['painmedused'] : ""; ?>"/></td>
                        </tr>
                        <tr>
                            <td>6) <?php echo $postQuestions['Q6']; ?>:</td>
                            <td><input class="text" name="dosepainmedused" value="<?php echo isset($_POST['dosepainmedused']) ? $_POST['dosepainmedused'] : ""; ?>"/></td>
                        </tr>
                        <tr>
                            <td>7) <?php echo $postQuestions['Q7']; ?>: 
                                <?php
                                foreach ($postValues['Q7'] as $opt) {
                                    echo "<input type = 'radio' name = 'Q7'  value = '" . $opt['val'] . "' " . (isset($_POST['Q7']) && $_POST['Q7'] == $opt['val'] ? "checked='checked'" : "") . "/> " . $opt['name'];
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>8) <?php echo $postQuestions['Q8']; ?>: 
                                <?php
                                foreach ($postValues['Q8'] as $opt) {
                                    echo "<input type = 'radio' name = 'Q8'  value = '" . $opt['val'] . "' " . (isset($_POST['Q8']) && $_POST['Q8'] == $opt['val'] ? "checked='checked'" : "") . "/> " . $opt['name'];
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div class='greybox'>
                    <table>
                        <tr style='text-align: center;'>
                            <td>&nbsp;</td>
                            <td>None&nbsp;&nbsp;</td>
                            <td>Periwound&nbsp;&nbsp;</td>
                            <td>Dorso-Medial&nbsp;&nbsp;</td>
                            <td>Entire Dorsum&nbsp;&nbsp;</td>
                            <td>Circum-ferential</td>
                        </tr>
                        <tr>
                            <td>9) <?php echo $postQuestions['Q9']; ?>: </td>
                            <?php
                            foreach ($postValues['Q9'] as $opt) {
                                echo "<td style='text-align: center;'>";
                                echo "<input type = 'radio' name = 'Q9'  value = '" . $opt['val'] . "' " . (isset($_POST['Q9']) && $_POST['Q9'] == $opt['val'] ? "checked='checked'" : "") . "/> ";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>10) <?php echo $postQuestions['Q10']; ?>: </td>
                            <?php
                            foreach ($postValues['Q10'] as $opt) {
                                echo "<td style='text-align: center;'>";
                                echo "<input type = 'radio' name = 'Q10'  value = '" . $opt['val'] . "' " . (isset($_POST['Q10']) && $_POST['Q10'] == $opt['val'] ? "checked='checked'" : "") . "/> ";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>11) <?php echo $postQuestions['Q11']; ?>: </td>
                            <?php
                            foreach ($postValues['Q11'] as $opt) {
                                echo "<td style='text-align: center;'>";
                                echo "<input type = 'radio' name = 'Q11'  value = '" . $opt['val'] . "' " . (isset($_POST['Q11']) && $_POST['Q11'] == $opt['val'] ? "checked='checked'" : "") . "/> ";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div class='whitebox'>
                    <table>
                        <tr style='text-align: center;'>
                            <td>&nbsp;</td>
                            <td>None&nbsp;&nbsp;</td>
                            <td>Seeping part of incision&nbsp;&nbsp;</td>
                            <td>Seeping whole incision&nbsp;&nbsp;</td>
                            <td>Hematoma&nbsp;&nbsp;</td>
                            <td>Active bleeding</td>
                        </tr>
                        <tr>
                            <td>12) <?php echo $postQuestions['Q12']; ?>: </td>
                            <?php
                            foreach ($postValues['Q12'] as $opt) {
                                echo "<td style='text-align: center;'>";
                                echo "<input type = 'radio' name = 'Q12'  value = '" . $opt['val'] . "' " . (isset($_POST['Q12']) && $_POST['Q12'] == $opt['val'] ? "checked='checked'" : "") . "/> ";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div class='greybox'>
                    <table>
                        <tr style='text-align: center;'>
                            <td>&nbsp;</td>
                            <td>None&nbsp;&nbsp;</td>
                            <td>< half incision&nbsp;&nbsp;</td>
                            <td>> half incision&nbsp;&nbsp;</td>
                            <td>Whole incision&nbsp;&nbsp;</td>
                            <td>Necrosis</td>
                        </tr>
                        <tr>
                            <td>13) <?php echo $postQuestions['Q13']; ?>: </td>
                            <?php
                            foreach ($postValues['Q13'] as $opt) {
                                echo "<td style='text-align: center;'>";
                                echo "<input type = 'radio' name = 'Q13'  value = '" . $opt['val'] . "' " . (isset($_POST['Q13']) && $_POST['Q13'] == $opt['val'] ? "checked='checked'" : "") . "/> ";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div class='whitebox'>
                    <table>
                        <tr style='text-align: center;'>
                            <td>&nbsp;</td>
                            <td>None&nbsp;&nbsp;</td>
                            <td>Suture abscess&nbsp;&nbsp;</td>
                            <td>Local cellulitis&nbsp;&nbsp;</td>
                            <td>Abscess&nbsp;&nbsp;</td>
                            <td>Osteomyelitis&nbsp;&nbsp;</td>
                        </tr>
                        <tr>
                            <td>14) <?php echo $postQuestions['Q14']; ?>: </td>
                            <?php
                            foreach ($postValues['Q14'] as $opt) {
                                echo "<td style='text-align: center;'>";
                                echo "<input type = 'radio' name = 'Q14'  value = '" . $opt['val'] . "' " . (isset($_POST['Q14']) && $_POST['Q14'] == $opt['val'] ? "checked='checked'" : "") . "/> ";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div><input type='submit' name='SUBMIT' value='Finish Questionaire' /></div>
                <div>Please fill out complications form as needed.</div>
            </div>
        </form>
    </body>
</html>
