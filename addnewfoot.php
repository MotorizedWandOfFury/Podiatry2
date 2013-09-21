<?php
date_default_timezone_set("EST");

require_once '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));

$json = new JSONManager();
$footQuestions = $json->loadJSONQuestions("Foot", "en");
$footValues = $json->loadJSONValues("Foot", "en");

if (empty($footQuestions) || empty($footValues)) {
    die("Unable to load JSON files");
}

$session = new SessionManager();
$session->validate();

$nav = new Navigator();


$database = new Database();
$type = filter_var($_GET['type'], FILTER_VALIDATE_INT, array('options'=>array('min_range' => 1, 'max_range'=>5))) or die("Type value is invalid");
if($type == 2){ //2 is not a valid type for this form
    die("Type value is invalid");
}
$patient = null;
$patientID = 0;
if ($session->getUserType() === Patient::tableName) {
    $patient = $session->getUserObject();
    $patientID = $patient->getID();
} else {
    $patientID = filter_var($_GET['patid'], FILTER_VALIDATE_INT) or die('Patient ID has not been set in URL');
    $patient = $database->read(Patient::createRetrievableDatabaseObject($patientID));
}
$extremity = filter_var($_GET['extremity'], FILTER_VALIDATE_INT, array('options'=> array('min_range' => 1), 'max_range'=>2)) or die("Extremity is needed");
$eval = $database->read(Evals::createRetrievableDatabaseObject($patientID, $extremity)) or die("Pre eval form for patient has not been filled yet."); 

$currTime = getdate();

$noEmptyFields = true;
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
            }
        }
    }

    if(($session->getUserType() === Patient::tableName) && (count($_POST) < 16)) {
            echo "<p>You are required to answer every question.</p>";
            $noEmptyFields = false;
        }
    
    if ($noInvalidFields && $noEmptyFields) {
        $foot = new Foot($patientID, $_POST['M'], $_POST['D'], $_POST['Y']);
        $foot->setType($type);
        $foot->setExtremity($extremity);
        foreach ($_POST as $key => $val) {
            if ($key === 'SUBMIT' || $key === 'M' || $key === 'D' || $key === 'Y') { //filter out unwanted keys
            } else {
                $foot->setAnswer($key, $val);
            }
        }
        //echo $foot->generateCreateQuery();
        //var_dump($foot);
        
        $database->create($foot);
        $nav->redirectUser($session->getUserType(), Navigator::SUBMISSION_NAVIGATION_ACTION, "Foot Questionnaire successfully submitted");
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Foot Health Status Questionnaire</title>
        <link rel='stylesheet' href='bootstrap/css/sf36_css.css' />
    </head>
    <body>
        <?php echo Functions::formTitle($type, "Foot Health Status Questionnaire", $extremity);?>
        <form action="<?php echo $_SERVER['SCRIPT_NAME'] . "?patid=$patientID" . "&extremity=$extremity" . "&type=$type"; ?>" method="POST">
            <div class='container'>
                <div class='greybox'>
                    <table>
                        <tr>
                            <td>1) Name: <?php echo $patient->getFirstName() . " " . $patient->getLastName(); ?></td>
                            <td>&nbsp;</td>
                            <td>2) Date: <input type='text' size='2' name='M' value='<?php echo (isset($_POST['M']) ? $_POST['M'] : $currTime['mon']); ?>'>-<input type='text' size='2' name='D' value='<?php echo (isset($_POST['D']) ? $_POST['D'] : $currTime['mday']); ?>'>-<input type='text' size='4' name='Y' value='<?php echo (isset($_POST['Y']) ? $_POST['Y'] : $currTime['year']); ?>'></td>
                            <td>&nbsp;</td>
                            <td colspan='3'>3) Extremity: <?php echo $eval->getExtremityFormatted(); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div class='whitebox'>
                    <table>
                        <tr>
                            <td>4) <?php echo $footQuestions['Q4']; ?>:</td>
                            <?php
                            foreach ($footValues['Q4'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q4'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q4']) && $_POST['Q4'] == $opt['val']) ? "checked='checked'" : "") . "/> " . $opt['name'];
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
                        <tr>
                            <td colspan='5'>5) <b><u>DURING THE PAST 4 WEEKS...</u></b></td>
                        </tr>
                        <tr style='text-align: center;'>
                            <td>&nbsp;</td>
                            <td>Never&nbsp;</td>
                            <td>Occasionally&nbsp;</td>
                            <td>Fairly Many Times&nbsp;</td>
                            <td>Very Often&nbsp;</td>
                            <td>Always</td>
                        </tr>
                        <tr>
                            <td>6) <?php echo $footQuestions['Q6']; ?>:</td>
                            <?php
                            foreach ($footValues['Q6'] as $opt) {
                                echo "<td style='text-align: center;'>";
                                echo "<input type = 'radio' name = 'Q6'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q6']) && $_POST['Q6'] == $opt['val']) ? "checked='checked'" : "") . "/>";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>7) <?php echo $footQuestions['Q7']; ?>:</td>
                            <?php
                            foreach ($footValues['Q7'] as $key => $opt) {
                                echo "<td style='text-align: center;'>";
                                echo "<input type = 'radio' name = 'Q7'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q7']) && $_POST['Q7'] == $opt['val']) ? "checked='checked'" : "") . "/>";
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
                        <tr>
                            <td colspan='5'>9) <b><u>DURING THE LAST WEEK...</u></b></td>
                        </tr>
                        <tr style='text-align: center;'>
                            <td>&nbsp;</td>
                            <td>Not at All&nbsp;</td>
                            <td>Slightly&nbsp;</td>
                            <td>Moderately&nbsp;</td>
                            <td>Quite a Bit&nbsp;</td>
                            <td>Extremely</td>
                        </tr>
                        <tr>
                            <td>10) <?php echo $footQuestions['Q10']; ?></td>
                            <?php
                            foreach ($footValues['Q10'] as $key => $opt) {
                                echo "<td style='text-align: center;'>";
                                echo "<input type = 'radio' name = 'Q10'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q10']) && $_POST['Q10'] == $opt['val']) ? "checked='checked'" : "") . "/>";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>11) <?php echo $footQuestions['Q11']; ?></td>
                            <?php
                            foreach ($footValues['Q13'] as $key => $opt) {
                                echo "<td style='text-align: center;'>";
                                echo "<input type = 'radio' name = 'Q11'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q11']) && $_POST['Q11'] == $opt['val']) ? "checked='checked'" : "") . "/>";
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
                        <tr>
                            <td colspan='5'>12) <b><u>DURING THE LAST WEEK...</u></b></td>
                        </tr>
                        <tr style='text-align: center;'>
                            <td>&nbsp;</td>
                            <td>Not at All&nbsp;</td>
                            <td>Slightly&nbsp;</td>
                            <td>Moderately&nbsp;</td>
                            <td>Quite a Bit&nbsp;</td>
                            <td>Extremely</td>
                        </tr>
                        <tr>
                            <td>13) <?php echo $footQuestions['Q13']; ?></td>
                            <?php
                            foreach ($footValues['Q13'] as $key => $opt) {
                                echo "<td style='text-align: center;'>";
                                echo "<input type = 'radio' name = 'Q13'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q13']) && $_POST['Q13'] == $opt['val']) ? "checked='checked'" : "") . "/>";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>14) <?php echo $footQuestions['Q14']; ?></td>
                            <?php
                            foreach ($footValues['Q14'] as $key => $opt) {
                                echo "<td style='text-align: center;'>";
                                echo "<input type = 'radio' name = 'Q14'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q14']) && $_POST['Q14'] == $opt['val']) ? "checked='checked'" : "") . "/>";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>15) <?php echo $footQuestions['Q15']; ?></td>
                            <td style='text-align: center;'>Excellent</td>
                            <td style='text-align: center;'>Very Good</td>
                            <td style='text-align: center;'>Good</td>
                            <td style='text-align: center;'>Fair</td>
                            <td style='text-align: center;'>Poor</td>
                        </tr>
                        <tr>  
                            <td>&nbsp;</td>
                            <?php
                            foreach ($footValues['Q15'] as $key => $opt) {
                                echo "<td style='text-align: center;'>";
                                echo "<input type = 'radio' name = 'Q15'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q15']) && $_POST['Q15'] == $opt['val']) ? "checked='checked'" : "") . "/>";
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
                        <tr>
                            <td colspan='6'>16) <b><u>THE FOLLOWING QUESTIONS ARE ABOUT THE SHOES THAT YOU WEAR. PLEASE CIRCLE THE RESPONSE WHICH BEST DESCRIBES YOUR SITUATION.</u></b></td>
                        </tr>
                        <tr style='text-align: center;'>
                            <td>&nbsp;</td>
                            <td>Strongly Agree&nbsp;</td>
                            <td>Agree&nbsp;</td>
                            <td>Neither agree or Disagree&nbsp;</td>
                            <td>Disagree&nbsp;</td>
                            <td>Strongly Disagree&nbsp;</td>
                        </tr>
                        <tr>
                            <td>17) <?php echo $footQuestions['Q17']; ?></td>
                            <?php
                            foreach ($footValues['Q17'] as $key => $opt) {
                                echo "<td style='text-align: center;'>";
                                echo "<input type = 'radio' name = 'Q17'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q17']) && $_POST['Q17'] == $opt['val']) ? "checked='checked'" : "") . "/>";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>18) <?php echo $footQuestions['Q18']; ?></td>
                            <?php
                            foreach ($footValues['Q18'] as $key => $opt) {
                                echo "<td style='text-align: center;'>";
                                echo "<input type = 'radio' name = 'Q18'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q18']) && $_POST['Q18'] == $opt['val']) ? "checked='checked'" : "") . "/>";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>19) <?php echo $footQuestions['Q19']; ?></td>
                            <?php
                            foreach ($footValues['Q19'] as $key => $opt) {
                                echo "<td style='text-align: center;'>";
                                echo "<input type = 'radio' name = 'Q19'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q19']) && $_POST['Q19'] == $opt['val']) ? "checked='checked'" : "") . "/>";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>20) <?php echo $footQuestions['Q20']; ?></td>
                            <td style='text-align: center;'>Excellent</td>
                            <td style='text-align: center;'>Very Good</td>
                            <td style='text-align: center;'>Good</td>
                            <td style='text-align: center;'>Fair</td>
                            <td style='text-align: center;'>Poor</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <?php
                            foreach ($footValues['Q20'] as $key => $opt) {
                                echo "<td style='text-align: center;'>";
                                echo "<input type = 'radio' name = 'Q20'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q20']) && $_POST['Q20'] == $opt['val']) ? "checked='checked'" : "") . "/>";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div><input type='submit' name='SUBMIT' value='Finish Questionaire' /></div>
            </div>
        </form>
    </body>
</html>
