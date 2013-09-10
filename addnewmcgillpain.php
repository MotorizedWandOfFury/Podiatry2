<?php
date_default_timezone_set("EST");

require_once '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));

$json = new JSONManager();
$mcgillpainQuestions = $json->loadJSONQuestions("Mcgillpain", "en");
$mcgillpainValues = $json->loadJSONValues("Mcgillpain", "en");

if (empty($mcgillpainQuestions) || empty($mcgillpainValues)) {
    die("Unable to load JSON files");
}

$session = new SessionManager();
$session->validate();

$nav = new Navigator();


$database = new Database();
$type = filter_var($_GET['type'], FILTER_VALIDATE_INT, array('options'=>array('min_range' => 1, 'max_range'=>5))) or die("Type value is invalid");
$patient = null;
$patientID = 0;
if ($session->getUserType() === Patient::tableName) {
    $patient = $session->getUserObject();
    $patientID = $patient->getID();
} else {
    $patientID = $_GET['patid'] or die('Patient ID has not been set in URL');
    $patient = $database->read(Patient::createRetrievableDatabaseObject($patientID));
}
$eval = $database->read(Evals::createRetrievableDatabaseObject($patientID)) or die("Pre eval form for patient has not been filled yet.");
$doctor = $database->read(Physician::createRetrievableDatabaseObject($patient->getDoctor()));

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
    
     if(($session->getUserType() === Patient::tableName) && (count($_POST) < 29)) {
            echo "<p>You are required to answer every question.</p>";
            $noEmptyFields = false;
        }
    
    if ($noInvalidFields && $noEmptyFields) {
        $mcgill = new Mcgillpain($patientID, $_POST['M'], $_POST['D'], $_POST['Y']);
        $mcgill->setSurId($doctor->getID());
        $mcgill->setType($type);
        foreach ($_POST as $key => $val) {
            if ($key === 'SUBMIT' || $key === 'M' || $key === 'D' || $key === 'Y') { //filter out unwanted keys
            } else {
                $mcgill->setAnswer($key, $val);
            }
        }
        //echo $mcgill->generateCreateQuery();
        //var_dump($mcgill);
        $database->create($mcgill);
        $nav->redirectUser($session->getUserType(), Navigator::SUBMISSION_NAVIGATION_ACTION, "McGill Pain Questionnaire successfully submitted");
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>McGill Pain Questionnaire</title>
        <link rel='stylesheet' href='bootstrap/css/sf36_css.css' />
    </head>
    <body>
       <?php echo Functions::formTitle($type, "McGill Pain Questionnaire")?>
        <form action="<?php echo $_SERVER['SCRIPT_NAME'].  "?patid=$patientID" . "&type=$type"; ?>" method="POST">
            <div class='container'>
                <div class='greybox'>
                    <table>
                        <tr>
                            <td>1) Name: <?php echo $patient->getFirstName() . " " . $patient->getLastName(); ?></td>
                            <td>2) Surgeon: <?php echo $doctor->getFirstName() . " " . $doctor->getLastName(); ?> </td>
                        </tr>
                        <tr>
                            <td>3) Date: <input type='text' size='2' name='M' value='<?php echo (isset($_POST['M']) ? $_POST['M'] : $currTime['mon']); ?>'>-<input type='text' size='2' name='D' value='<?php echo (isset($_POST['D']) ? $_POST['D'] : $currTime['mday']); ?>'>-<input type='text' size='4' name='Y' value='<?php echo (isset($_POST['Y']) ? $_POST['Y'] : $currTime['year']); ?>'></td>
                            <td>4) Extremity: <?php echo $eval->getExtremityFormatted(); ?></td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div class='whitebox'>
                    <table>
                        <tr>
                            <td>5) <?php echo $mcgillpainQuestions['Q5']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q5'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q5'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q5']) && $_POST['Q6'] == $opt['val']) ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>6) <?php echo $mcgillpainQuestions['Q6']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q6'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q6'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q6']) && $_POST['Q6'] == $opt['val']) ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>7) <?php echo $mcgillpainQuestions['Q7']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q7'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q7'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q7']) && $_POST['Q7'] == $opt['val']) ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>8) <?php echo $mcgillpainQuestions['Q8']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q8'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q8'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q8']) && $_POST['Q8'] == $opt['val']) ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>9) <?php echo $mcgillpainQuestions['Q9']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q9'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q9'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q9']) && $_POST['Q9'] == $opt['val']) ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>10) <?php echo $mcgillpainQuestions['Q10']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q10'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q10'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q10']) && $_POST['Q10'] == $opt['val']) ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>11) <?php echo $mcgillpainQuestions['Q11']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q11'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q11'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q11']) && $_POST['Q11'] == $opt['val']) ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>12) <?php echo $mcgillpainQuestions['Q12']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q12'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q12'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q12']) && $_POST['Q12'] == $opt['val']) ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div class='greybox'>
                    <div>RATE PAIN OF BUNION DEFORMITY TO DATE:</div>
                    <table>
                        <tr>
                            <td>13) <?php echo $mcgillpainQuestions['Q13']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q13'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q13'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q13']) && $_POST['Q13'] == $opt['val']) ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>12) <?php echo $mcgillpainQuestions['Q14']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q14'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q14'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q14']) && $_POST['Q14'] == $opt['val']) ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>15) <?php echo $mcgillpainQuestions['Q15']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q15'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q15'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q15']) && $_POST['Q15'] == $opt['val']) ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>16) <?php echo $mcgillpainQuestions['Q16']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q16'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q16'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q16']) && $_POST['Q16'] == $opt['val']) ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>17) <?php echo $mcgillpainQuestions['Q17']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q17'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q17'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q17']) && $_POST['Q17'] == $opt['val']) ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>18) <?php echo $mcgillpainQuestions['Q18']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q18'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q18'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q18']) && $_POST['Q18'] == $opt['val']) ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>19) <?php echo $mcgillpainQuestions['Q19']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q19'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q19'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q19']) && $_POST['Q19'] == $opt['val']) ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>20) <?php echo $mcgillpainQuestions['Q20']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q20'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q20'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q20']) && $_POST['Q20'] == $opt['val']) ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>21) <?php echo $mcgillpainQuestions['Q21']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q21'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q21'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q21']) && $_POST['Q21'] == $opt['val']) ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>22) <?php echo $mcgillpainQuestions['Q22']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q22'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q22'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q22']) && $_POST['Q22'] == $opt['val']) ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>23) <?php echo $mcgillpainQuestions['Q23']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q23'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q23'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q23']) && $_POST['Q23'] == $opt['val']) ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>24) <?php echo $mcgillpainQuestions['Q24']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q24'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q24'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q24']) && $_POST['Q24'] == $opt['val']) ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>25) <?php echo $mcgillpainQuestions['Q25']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q25'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q25'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q25']) && $_POST['Q25'] == $opt['val']) ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>26) <?php echo $mcgillpainQuestions['Q26']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q26'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q26'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q26']) && $_POST['Q26'] == $opt['val']) ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>27) <?php echo $mcgillpainQuestions['Q27']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q27'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q27'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q27']) && $_POST['Q27'] == $opt['val']) ? "checked='checked'" : "") . "/> " . $opt['name'];
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
                            <td>28) <?php echo $mcgillpainQuestions['Q28']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q28'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q28'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q28']) && $_POST['Q28'] == $opt['val']) ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>29) <?php echo $mcgillpainQuestions['Q29']; ?>:</td>
                            <td colspan='6'>
                                <?php
                            foreach ($mcgillpainValues['Q29'] as $opt) {
                                echo "<input type = 'radio' name = 'Q29'  value = '" . $opt['val'] . "' " . ((isset($_POST['Q29']) && $_POST['Q29'] == $opt['val']) ? "checked='checked'" : "") . "/> " . $opt['name'];
                            }
                            ?>
                            </td>
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
