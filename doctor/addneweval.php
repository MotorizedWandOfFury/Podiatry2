<?php
date_default_timezone_set("EST");

require_once dirname(dirname(__FILE__)) . '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));

$json = new JSONManager();
$evalQuestions = $json->loadJSONQuestions("Eval", "en");
$evalValues = $json->loadJSONValues("Eval", "en");

if (empty($evalQuestions) || empty($evalValues)) {
    die("Unable to load JSON files");
}

$session = new SessionManager();
$session->validate();

$nav = new Navigator();

$database = new Database();
$loggedInUser = $session->getUserObject();
$patientID = $_GET['patid'] or die("Patient ID not set");
$patient = $database->read(Patient::createRetrievableDatabaseObject($patientID));

$currTime = getdate();

$errors = "";

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
                case "HEIGHT":
                    $heightOptions = array(
                        'options' => array(
                            'min_range' => 20,
                            'max_range' => 90,
                        )
                    );
                    if (filter_var($value, FILTER_VALIDATE_INT, $heightOptions) == false) {
                        $errors = $errors . "<p>$key is not valid</p>";
                        $noInvalidFields = false;
                    }
                    break;
                case "WEIGHT":
                    $weightOptions = array(
                        'options' => array(
                            'min_range' => 30,
                            'max_range' => 800,
                        )
                    );
                    if (filter_var($value, FILTER_VALIDATE_INT, $weightOptions) == false) {
                        $errors = $errors . "<p>$key is not valid</p>";
                        $noInvalidFields = false;
                    }
                    break;
                case 'Q15':
                    if (filter_var($_POST['Q15'], FILTER_VALIDATE_INT) === false) {
                        $noInvalidFields = false;
                        echo "<p>$key is not valid</p>";
                    }
                    break;
                case 'Q19':
                    if (filter_var($_POST['Q19'], FILTER_VALIDATE_INT) === false) {
                        $noInvalidFields = false;
                        echo "<p>$key is not valid</p>";
                    }
                    break;
                case 'Q20':
                    if (filter_var($_POST['Q20'], FILTER_VALIDATE_INT) === false) {
                        $noInvalidFields = false;
                        echo "<p>$key is not valid</p>";
                    }
                    break;
            }
        }
    }

    if ($noInvalidFields) {
        $eval = new Evals($patientID, $currTime['mon'], $currTime['mday'], $currTime['year']);
        $eval->setDateOfExam($_POST['M'], $_POST['D'], $_POST['Y']);
        $eval->setSurId(isset($_POST['DOCTOR']) ? $_POST['DOCTOR'] : $loggedInUser->getId());
        $eval->setExtremity($_POST['EXTREMITY']);
        $eval->setHeight($_POST['HEIGHT']);
        $eval->setWeight($_POST['WEIGHT']);

        foreach ($_POST as $key => $value) {
            if ($key === 'SUBMIT' || $key === 'M' || $key === 'D' || $key === 'Y' || $key === 'DOCTOR') {   //filtering out unwanted keys
            } else if ($key === 'Q17' || $key === 'Q18' || $key === 'Q24' || $key === 'Q27') { //handling the answers with multiple values
                $eval->setAnswer($key, implode("|", $value));
            } else {
                $eval->setAnswer($key, $value);
            }
        }
        //echo $eval->generateCreateQuery();
        //var_dump($eval);
        if ($database->create($eval)) {
            $nav->redirectUser($session->getUserType(), Navigator::SUBMISSION_NAVIGATION_ACTION, "Evaluation successfully submitted");
        } else {
            die("Form has already been filled for patient");
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html;charset=utf-8' />
        <title>PRE-OPERATIVE Evaluation</title>
        <link rel='stylesheet' href='../bootstrap/css/sf36_css.css' />
    </head>
    <body>
        <form action="<?php echo $_SERVER['SCRIPT_NAME'], "?patid=", $patientID; ?>" method="POST">
            <div class='container'>
                <div class='greybox'>
                    <table>
                        <tr>
                            <td><b>1) Last Name:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td><td><?php echo $patient->getLastName(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td><b>2) First Name:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td><td><?php echo $patient->getFirstName(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <tr>
                            <td><b>3) Surgeon:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>
                                <?php
                                if ($session->getUserType() === Physician::tableName) {
                                    echo $loggedInUser->getFirstName(), " ", $loggedInUser->getLastName();
                                } else {
                                    $allDoctors = new AllDoctorsAssociation();
                                    $database->createAssociationObject($allDoctors);
                                    echo "<select name='DOCTOR'>";
                                    echo "<option value=''", (!isset($_POST['DOCTOR'])) ? 'selected = "selected"' : '', ">Select</option>";
                                    foreach ($allDoctors->getPhysiciansArray() as $physician) { //dynamically create a dropdown list of doctors
                                        echo "<option value = '", $physician->getId(), "'", (isset($_POST['DOCTOR']) && $_POST['DOCTOR'] == $physician->getId()) ? 'selected = "selected"' : '', ">", $physician->getFirstName(), " ", $physician->getLastName(), "</option>";
                                    }
                                    echo "</select>";
                                }
                                ?>&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>
                            <td><b>4) <?php echo $evalQuestions['Q4']; ?> (MM-DD-YYYY)</b></td>
                            <td><input type='text' size='2' name='M' value='<?php echo (isset($_POST['M']) ? $_POST['M'] : $currTime['mon']); ?>'>-
                                <input type='text' size='2' name='D' value='<?php echo (isset($_POST['D']) ? $_POST['D'] : $currTime['mday']); ?>'>-
                                <input type='text' size='4' name='Y' value='<?php echo (isset($_POST['Y']) ? $_POST['Y'] : $currTime['year']); ?>'>
                            </td>
                            <td>5) Extremity: </td> 
                            <td> 
                                <select name='EXTREMITY'> 
                                    <option value='' <?php echo (!isset($_POST['EXTREMITY'])) ? 'selected = "selected"' : ''; ?> >Select</option> 
                                    <option value='1' <?php echo (isset($_POST['EXTREMITY']) && $_POST['EXTREMITY'] == 1) ? 'selected = "selected"' : ''; ?> ><?php echo $evalValues['extremity']['left']; ?></option> 
                                    <option value='2' <?php echo (isset($_POST['EXTREMITY']) && $_POST['EXTREMITY'] == 2) ? 'selected = "selected"' : ''; ?> ><?php echo $evalValues['extremity']['right']; ?></option> 
                                </select> 
                            </td> 
                        </tr>
                        <tr>
                            <td><b>6) Age:</b></td><td><?php echo $patient->getAge(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td><b>7) Sex:</b></td><td><?php echo $patient->getSexFormatted(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td><b>8) Height:</b></td><td><input class='text' type='text' name='HEIGHT' value='<?php echo array_key_exists("HEIGHT", $_POST) ? $_POST['HEIGHT'] : ""; ?>' id='HEIGHT'/> in&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td><b>9) Weight:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input class='text' type='text' name='WEIGHT' value='<?php echo array_key_exists("WEIGHT", $_POST) ? $_POST['WEIGHT'] : ""; ?>' id='WEIGHT'/> lbs</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div class='whitebox'>
                    <table>
                        <tr>
                            <td><b>10) <?php echo $evalQuestions['Q10']; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($evalValues['Q10'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q10'  value = '", $opt['val'], "' ", (isset($_POST['Q10']) && $_POST['Q10'] == $opt['val']) ? "checked='checked'" : "", "/> ", $opt['name'], "&nbsp;&nbsp;&nbsp;&nbsp;";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td><b>11) <?php echo $evalQuestions['Q11']; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($evalValues['Q11'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q11'  value = '", $opt['val'], "' ", (isset($_POST['Q11']) && $_POST['Q11'] == $opt['val']) ? "checked='checked'" : "", "/> ", $opt['name'], "&nbsp;&nbsp;&nbsp;&nbsp;";
                                echo "</td>";
                            }
                            ?></tr>
                        <tr>
                            <td><b>12) <?php echo $evalQuestions['Q12']; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($evalValues['Q12'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q12'  value = '", $opt['val'], "' ", (isset($_POST['Q12']) && $_POST['Q12'] == $opt['val']) ? "checked='checked'" : "", "/> ", $opt['name'], "&nbsp;&nbsp;&nbsp;&nbsp;";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td><b>13) <?php echo $evalQuestions['Q13']; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($evalValues['Q13'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q13'  value = '", $opt['val'], "' ", (isset($_POST['Q13']) && $_POST['Q13'] == $opt['val']) ? "checked='checked'" : "", "/> ", $opt['name'], "&nbsp;&nbsp;&nbsp;&nbsp;";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td><b>14) <?php echo $evalQuestions['Q14']; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($evalValues['Q14'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q14'  value = '", $opt['val'], "' ", (isset($_POST['Q14']) && $_POST['Q14'] == $opt['val']) ? "checked='checked'" : "", "/> ", $opt['name'], "&nbsp;&nbsp;&nbsp;&nbsp;";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td><b>15) <?php echo $evalQuestions['Q15']; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td><input type='text' name='Q15' value='<?php echo isset($_POST['Q15']) ? $_POST['Q15'] : ""; ?>'> months</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div class='greybox'>
                    <table>
                        <tr>
                            <td><b>16) <?php echo $evalQuestions['Q16']; ?>:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($evalValues['Q16'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q16'  value = '", $opt['val'], "' ", (isset($_POST['Q16']) && $_POST['Q16'] == $opt['val']) ? "checked='checked'" : "", "/> ", $opt['name'], "&nbsp;&nbsp;&nbsp;&nbsp;";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td><b>17) <?php echo $evalQuestions['Q17']; ?>:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($evalValues['Q17'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'checkbox' name = 'Q17[]'  value = '", $opt['val'], "' ", (isset($_POST['Q17']) && in_array($opt['val'], $_POST['Q17'])) ? "checked='checked'" : "", "/> ", $opt['name'], "&nbsp;&nbsp;&nbsp;&nbsp;";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td><b>18) <?php echo $evalQuestions['Q18']; ?>:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($evalValues['Q18'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'checkbox' name = 'Q18[]'  value = '", $opt['val'], "' ", (isset($_POST['Q18']) && in_array($opt['val'], $_POST['Q18'])) ? "checked='checked'" : "", "/> ", $opt['name'], "&nbsp;&nbsp;&nbsp;&nbsp;";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>
                <div class='whitebox'>
                    <h4>Pre-op ROM:<img style='width: 200px; height: 200px;' src='../images/picture.bmp' align='right'/></h4>
                    <p>If above long axis of metatarsal enter a positive value.<br>
                        If below long axis of metatarsal enter a negative value.</p>
                    <table>
                        <tr>
                            <td><b>19) <?php echo $evalQuestions['Q19']; ?>:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td> <input type='text' name='Q19' value='<?php echo isset($_POST['Q19']) ? $_POST['Q19'] : ""; ?>'> </td>
                        </tr>
                        <tr>
                            <td><b>20) <?php echo $evalQuestions['Q20']; ?>:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td> <input type='text' name='Q20' value='<?php echo isset($_POST['Q20']) ? $_POST['Q20'] : ""; ?>'> </td>
                        </tr>
                        <tr>
                            <td><b>21) <?php echo $evalQuestions['Q21']; ?>:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($evalValues['Q21'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q21'  value = '", $opt['val'], "' ", (isset($_POST['Q21']) && $_POST['Q21'] == $opt['val']) ? "checked='checked'" : "", "/> ", $opt['name'], "&nbsp;&nbsp;&nbsp;&nbsp;";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td><b>22) <?php echo $evalQuestions['Q22']; ?>:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($evalValues['Q22'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q22'  value = '", $opt['val'], "' ", (isset($_POST['Q22']) && $_POST['Q22'] == $opt['val']) ? "checked='checked'" : "", "/> ", $opt['name'], "&nbsp;&nbsp;&nbsp;&nbsp;";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td><b>23) <?php echo $evalQuestions['Q23']; ?>:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($evalValues['Q23'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q23'  value = '", $opt['val'], "' ", (isset($_POST['Q23']) && $_POST['Q23'] == $opt['val']) ? "checked='checked'" : "", "/> ", $opt['name'], "&nbsp;&nbsp;&nbsp;&nbsp;";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>
                <div class='greybox'>
                    <table>
                        <tr>
                            <td><b>24) <?php echo $evalQuestions['Q24']; ?>:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($evalValues['Q24'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'checkbox' name = 'Q24[]'  value = '", $opt['val'], "' ", (isset($_POST['Q24']) && in_array($opt['val'], $_POST['Q24'])) ? "checked='checked'" : "", "/> ", $opt['name'], "&nbsp;&nbsp;&nbsp;&nbsp;";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td><b>25) <?php echo $evalQuestions['Q25']; ?>:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($evalValues['Q25'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q25'  value = '", $opt['val'], "' ", (isset($_POST['Q25']) && $_POST['Q25'] == $opt['val']) ? "checked='checked'" : "", "/> ", $opt['name'], "&nbsp;&nbsp;&nbsp;&nbsp;";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td><b>26) <?php echo $evalQuestions['Q26']; ?>:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($evalValues['Q26'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q26'  value = '", $opt['val'], "' ", (isset($_POST['Q26']) && $_POST['Q26'] == $opt['val']) ? "checked='checked'" : "", "/> ", $opt['name'], "&nbsp;&nbsp;&nbsp;&nbsp;";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td><b>27) <?php echo $evalQuestions['Q27']; ?>:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($evalValues['Q27'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'checkbox' name = 'Q27[]'  value = '", $opt['val'], "' ", (isset($_POST['Q27']) && in_array($opt['val'], $_POST['Q27'])) ? "checked='checked'" : "", "/> ", $opt['name'], "&nbsp;&nbsp;&nbsp;&nbsp;";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div><input type='submit' name='SUBMIT' value='Submit Eval'></div>
            </div>
        </form>
    </body>
</html>