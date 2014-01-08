<?php
date_default_timezone_set("EST");

require_once dirname(dirname(__FILE__)) . '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));

$json = new JSONManager();
$surgicalQuestions = $json->loadJSONQuestions("Surgical", "en");
$surgicalValues = $json->loadJSONValues("Surgical", "en");

if (empty($surgicalQuestions) || empty($surgicalValues)) {
    die("Unable to load JSON files");
}

$session = new SessionManager();
$session->validate();

$nav = new Navigator();



$database = new Database();
$patientID = filter_var($_GET['patid'], FILTER_VALIDATE_INT) or die("Patient ID not set");
$patient = $database->read(Patient::createRetrievableDatabaseObject($patientID));
$doctor = $database->read(Physician::createRetrievableDatabaseObject($patient->getDoctor()));
$extremity = filter_var($_GET['extremity'], FILTER_VALIDATE_INT, array('options' => array('min_range' => 1), 'max_range' => 2)) or die("Extremity is needed");
$eval = $database->read(Evals::createRetrievableDatabaseObject($patientID, $extremity)) or die("Pre eval form for patient has not been filled yet.");

$currTime = getdate();

$noInvalidFields = true;
if (isset($_POST['SUBMIT'])) {

    if (!empty($_POST['M']) && !empty($_POST['D']) && !empty($_POST['Y'])) {
        $dateCheck = checkdate($_POST['M'], $_POST['D'], $_POST['Y']);
        if (!$dateCheck) { //if check fails
            $noInvalidFields = false;
            echo "<p>Date is invalid</p>";
        }
    }

    if ($noInvalidFields) {
        $surgical = new Surgical($patientID, $currTime['mon'], $currTime['mday'], $currTime['year']);
        if (!empty($_POST['M']) && !empty($_POST['D']) && !empty($_POST['Y'])) {
            $surgical->setDateOfSurgery($_POST['M'], $_POST['D'], $_POST['Y']);
        }
        $surgical->setSurId($doctor->getID());
        $surgical->setExtremity($extremity);
        $surgical->setQ5Other($_POST['Q5Other']);
        $surgical->setQ17Other($_POST['Q17Other']);
        $surgical->setQ26Other($_POST['Q26Other']);

        foreach ($_POST as $key => $value) {
            if ($key === 'Q5' || $key === 'Q22') {
                $surgical->setAnswer($key, implode("|", $value));
            } else {
                $surgical->setAnswer($key, $value);
            }
        }
        //echo $surgical->generateCreateQuery();
        //var_dump($surgical);
        $database->create($surgical);
        $nav->redirectUser($session->getUserType(), Navigator::SUBMISSION_NAVIGATION_ACTION, "Surgical data successfully submitted");
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>SURGICAL DATA</title>
        <link rel='stylesheet' href='../bootstrap/css/sf36_css.css' />
    </head>
    <body>
        <?php echo Functions::formTitle("", "Surgical Evaluation", $extremity) ?>
        <form action="<?php echo $_SERVER['SCRIPT_NAME'] . "?patid=$patientID" . "&extremity=$extremity"; ?>" method="POST">
            <div class='container'>
                <div class='greybox'>
                    <table>
                        <tr>
                            <td>1) Patient: <?php echo $patient->getFirstName() . " " . $patient->getLastName(); ?>&nbsp;</td>
                            <td>2) Surgeon: <?php echo $doctor->getFirstName() . " " . $doctor->getLastName(); ?> </td>
                        </tr>
                        <tr>
                            <td>3) Extremity: <?php echo $eval->getExtremityFormatted(); ?></td>
                            <td>4) <?php echo $surgicalQuestions['Q4']; ?>: <input class="text" type='text' size='2' name='M' value='<?php echo (isset($_POST['M']) ? $_POST['M'] : $currTime['mon']); ?>'>-
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
                            <td rowspan="5">5) <?php echo $surgicalQuestions['Q5'] . ":"; ?></td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                foreach ($surgicalValues['Q5'] as $opt) {
                                    //echo "<td>";
                                    echo "<input type = 'checkbox' name = 'Q5[]'  value = '" . $opt['val'] . "' " . (isset($_POST['Q5']) && in_array($opt['val'], $_POST['Q5']) ? "checked='checked'" : "") . "/>" . $opt['name'];
                                    //echo "</td>";
                                }
                                ?>
                                (Specify Other: <input class="text" type="text" size="6" name="Q5Other" value="<?php echo (isset($_POST['Q5Other']) ? $_POST['Q5Other'] : "");?>"/>)
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div class='greybox'>
                    <table>
                        <tr>
                            <td>6) <?php echo $surgicalQuestions['Q6'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q6'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q6'  value = '" . $opt['val'] . "' " . (isset($_POST['Q6']) && $_POST['Q6'] == $opt['val'] ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>7) <?php echo $surgicalQuestions['Q7'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q7'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q7'  value = '" . $opt['val'] . "' " . (isset($_POST['Q7']) && $_POST['Q7'] == $opt['val'] ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>8) <?php echo $surgicalQuestions['Q8'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q8'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q8'  value = '" . $opt['val'] . "' " . (isset($_POST['Q8']) && $_POST['Q8'] == $opt['val'] ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>9) <?php echo $surgicalQuestions['Q9'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q9'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q9'  value = '" . $opt['val'] . "' " . (isset($_POST['Q9']) && $_POST['Q9'] == $opt['val'] ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>10) <?php echo $surgicalQuestions['Q10'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q10'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q10'  value = '" . $opt['val'] . "' " . (isset($_POST['Q10']) && $_POST['Q10'] == $opt['val'] ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>11) <?php echo $surgicalQuestions['Q11'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q11'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q11'  value = '" . $opt['val'] . "' " . (isset($_POST['Q11']) && $_POST['Q11'] == $opt['val'] ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>12) <?php echo $surgicalQuestions['Q12'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q12'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q12'  value = '" . $opt['val'] . "' " . (isset($_POST['Q12']) && $_POST['Q12'] == $opt['val'] ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>13) <?php echo $surgicalQuestions['Q13'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q13'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q13'  value = '" . $opt['val'] . "' " . (isset($_POST['Q13']) && $_POST['Q13'] == $opt['val'] ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>14) <?php echo $surgicalQuestions['Q14'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q14'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q14'  value = '" . $opt['val'] . "' " . (isset($_POST['Q14']) && $_POST['Q14'] == $opt['val'] ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>15) <?php echo $surgicalQuestions['Q15'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q15'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q15'  value = '" . $opt['val'] . "' " . (isset($_POST['Q15']) && $_POST['Q15'] == $opt['val'] ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>

                    </table>
                </div>
            </div>
            <div class="container">
                <div class="whitebox">
                    <table>
                        <tr>
                            <td>16) <?php echo $surgicalQuestions['Q16'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q16'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q16'  value = '" . $opt['val'] . "' " . (isset($_POST['Q16']) && $_POST['Q16'] == $opt['val'] ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td rowspan="2">17) <?php echo $surgicalQuestions['Q17'] . ":"; ?></td>
                        </tr>
                        <tr>
                            <?php
                            foreach ($surgicalValues['Q17'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q17'  value = '" . $opt['val'] . "' " . (isset($_POST['Q17']) && $_POST['Q17'] == $opt['val'] ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                            <td>(Specify "Other": <input class="text" type="text" size="6" name="Q17Other" value="<?php echo (isset($_POST['Q17Other']) ? $_POST['Q17Other'] : "");?>"/>)</td>
                        </tr>
                        <tr>
                            <td>18) <?php echo $surgicalQuestions['Q18'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q18'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q18'  value = '" . $opt['val'] . "' " . (isset($_POST['Q18']) && $_POST['Q18'] == $opt['val'] ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>19) <?php echo $surgicalQuestions['Q19'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q19'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q19'  value = '" . $opt['val'] . "' " . (isset($_POST['Q19']) && $_POST['Q19'] == $opt['val'] ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>20) <?php echo $surgicalQuestions['Q20'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q20'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q20'  value = '" . $opt['val'] . "' " . (isset($_POST['Q20']) && $_POST['Q20'] == $opt['val'] ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>21) <?php echo $surgicalQuestions['Q21'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q21'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q21'  value = '" . $opt['val'] . "' " . (isset($_POST['Q21']) && $_POST['Q21'] == $opt['val'] ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>22) <?php echo $surgicalQuestions['Q22'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q22'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'checkbox' name = 'Q22[]'  value = '" . $opt['val'] . "' " . (isset($_POST['Q22']) && in_array($opt['val'], $_POST['Q22']) ? "checked='checked'" : "") . "/>" . $opt['name'];
                                //echo "<input type = 'radio' name = 'Q22'  value = '" . $opt['val'] . "' " . (isset($_POST['Q22']) && $_POST['Q22'] == $opt['val'] ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>23) <?php echo $surgicalQuestions['Q23'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q23'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q23'  value = '" . $opt['val'] . "' " . (isset($_POST['Q23']) && $_POST['Q23'] == $opt['val'] ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>24) <?php echo $surgicalQuestions['Q24'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q24'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q24'  value = '" . $opt['val'] . "' " . (isset($_POST['Q24']) && $_POST['Q24'] == $opt['val'] ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>25) <?php echo $surgicalQuestions['Q25'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q25'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q25'  value = '" . $opt['val'] . "' " . (isset($_POST['Q25']) && $_POST['Q25'] == $opt['val'] ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>26) <?php echo $surgicalQuestions['Q26'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q26'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q26'  value = '" . $opt['val'] . "' " . (isset($_POST['Q26']) && $_POST['Q26'] == $opt['val'] ? "checked='checked'" : "") . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?><td>
                            (Specify Other: <input class="text" type="text" size="6" name="Q26Other" value="<?php echo (isset($_POST['Q26Other']) ? $_POST['Q26Other'] : "");?>"/>)</td>
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
