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
$func = new Functions();
 
 
$mode = isset($_GET['mode']) ? $_GET['mode'] : "view"; // default mode for page is viewing, if the mode attribute has not been set
 
$database = new Database();
$patientID = filter_var($_GET['patid'], FILTER_VALIDATE_INT) or die("Patient ID not set");
$patient = $database->read(Patient::createRetrievableDatabaseObject($patientID));
$extremity = filter_var($_GET['extremity'], FILTER_VALIDATE_INT, array('options'=> array('min_range' => 1), 'max_range'=>2)) or die("Extremity is needed");
$eval = $database->read(Evals::createRetrievableDatabaseObject($patientID, $extremity)) or die("Pre eval form for patient has not been filled yet."); 
$doctorID = $eval->getSurID();
$doctor = $database->read(Physician::createRetrievableDatabaseObject($doctorID));
 
if ($mode === 'edit') { // make sure we are in edit mode before we can make changes
    $noInvalidFields = true;
    if (isset($_POST['SUBMIT'])) {
        foreach ($_POST as $key => $value) {
            if ($value) {
                switch ($key) {
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
            foreach ($_POST as $key => $value) {
                if ($key === 'SUBMIT') {   //filtering out unwanted keys
                } else if ($key === 'Q10' || $key === 'Q11' || $key === 'Q17' || $key === 'Q18' || $key === 'Q21' || $key === 'Q24' || $key === 'Q27') { //handling the answers with multiple values
                    $eval->setAnswer($key, implode("|", $value));
                } else {
                    $eval->setAnswer($key, $value);
                }
            }
 
            //echo $eval->generateUpdateQuery();
            //var_dump($eval);
            $database->update($eval);
            $nav->redirectUser($session->getUserType(), Navigator::SUBMISSION_NAVIGATION_ACTION, "Evaluation successfully updated");
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
        &nbsp;
        <a href="<?php echo $_SERVER['SCRIPT_NAME'] . "?patid=$patientID&extremity=$extremity&mode=view"; ?>">View</a> | <a href="<?php echo $_SERVER['SCRIPT_NAME'] . "?patid=$patientID&extremity=$extremity&mode=edit"; ?>">Edit</a>
        <form action="<?php echo $_SERVER['SCRIPT_NAME'] . "?patid=$patientID&extremity=$extremity&mode=$mode"; ?>" method="POST">
            <div class='container'>
                <div class='greybox'>
                    <table>
                        <tr>
                            <td><b>1) Last Name:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td><td><?php echo $patient->getLastName(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td><b>2) First Name:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td><td><?php echo $patient->getFirstName(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <tr>
                            <td><b>3) Surgeon:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td><?php echo $doctor->getFirstName(), " ", $doctor->getLastName(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td><b>4) <?php echo $evalQuestions['Q4']; ?>:&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                            <td><?php echo $eval->getDateOfExamFormatted(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td><b>5) Extremity:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td><td><?php echo $eval->getExtremityFormatted(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <tr>
                            <td><b>6) Age:</b></td><td><?php echo $patient->getAge(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td><b>7) Sex:</b></td><td><?php echo $patient->getSexFormatted(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td><b>8) Height:</b></td><td><?php echo $eval->getHeight(); ?> in&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td><b>9) Weight:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td><td><?php echo $eval->getWeight(); ?> lbs</td>
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
                                echo "<input type = 'checkbox' name = 'Q10[]'  value = '" . $opt['val'] . "' " . (in_array($opt['val'], explode("|", $eval->getAnswer("Q10"))) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'] . "&nbsp;&nbsp;&nbsp;&nbsp;";
                                //echo "<input type = 'radio' name = 'Q10'  value = '" . $opt['val'] . "' " . (($eval->getAnswer("Q10") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'] . "&nbsp;&nbsp;&nbsp;&nbsp;";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td><b>11) <?php echo $evalQuestions['Q11']; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($evalValues['Q11'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'checkbox' name = 'Q11[]'  value = '" . $opt['val'] . "' " . (in_array($opt['val'], explode("|", $eval->getAnswer("Q11"))) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'] . "&nbsp;&nbsp;&nbsp;&nbsp;";
                                //echo "<input type = 'radio' name = 'Q11'  value = '" . $opt['val'] . "' " . ($eval->getAnswer("Q11") == $opt['val'] ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'] . "&nbsp;&nbsp;&nbsp;&nbsp;";
                                echo "</td>";
                            }
                            ?></tr>
                        <tr>
                            <td><b>12) <?php echo $evalQuestions['Q12']; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($evalValues['Q12'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q12'  value = '" . $opt['val'] . "' " . ($eval->getAnswer("Q12") == $opt['val'] ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'] . "&nbsp;&nbsp;&nbsp;&nbsp;";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td><b>13) <?php echo $evalQuestions['Q13']; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($evalValues['Q13'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q13'  value = '" . $opt['val'] . "' " . ($eval->getAnswer("Q13") == $opt['val'] ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'] . "&nbsp;&nbsp;&nbsp;&nbsp;";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td><b>14) <?php echo $evalQuestions['Q14']; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($evalValues['Q14'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q14'  value = '" . $opt['val'] . "' " . ($eval->getAnswer("Q14") == $opt['val'] ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'] . "&nbsp;&nbsp;&nbsp;&nbsp;";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td><b>15) <?php echo $evalQuestions['Q15']; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td><input type='text' name='Q15' value='<?php echo $eval->getAnswer("Q15"); ?>' <?php echo $func->disableElement($mode); ?>> months</td>
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
                                echo "<input type = 'radio' name = 'Q16'  value = '" . $opt['val'] . "' " . ($eval->getAnswer("Q16") == $opt['val'] ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'] . "&nbsp;&nbsp;&nbsp;&nbsp;";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td><b>17) <?php echo $evalQuestions['Q17']; ?>:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($evalValues['Q17'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'checkbox' name = 'Q17[]'  value = '" . $opt['val'] . "' " . (in_array($opt['val'], explode("|", $eval->getAnswer("Q17"))) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'] . "&nbsp;&nbsp;&nbsp;&nbsp;";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td><b>18) <?php echo $evalQuestions['Q18']; ?>:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($evalValues['Q18'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'checkbox' name = 'Q18[]'  value = '" . $opt['val'] . "' " . (in_array($opt['val'], explode("|", $eval->getAnswer("Q18"))) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'] . "&nbsp;&nbsp;&nbsp;&nbsp;";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='whitebox'>
                <h4>Pre-op ROM:<img style='width: 200px; height: 200px;' src='../images/picture.bmp' align='right'/></h4>
                <p>If above long axis of metatarsal enter a positive value.<br>
                    If below long axis of metatarsal enter a negative value.</p>
                <table>
                    <tr>
                        <td><b>19) <?php echo $evalQuestions['Q19']; ?>:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td> <input type='text' name='Q19' value='<?php echo $eval->getAnswer("Q19"); ?>' <?php echo $func->disableElement($mode); ?>> </td>
                    </tr>
                    <tr>
                        <td><b>20) <?php echo $evalQuestions['Q20']; ?>:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td> <input type='text' name='Q20' value='<?php echo $eval->getAnswer("Q20"); ?>' <?php echo $func->disableElement($mode); ?>> </td>
                    </tr>
                    <tr>
                        <td><b>21) <?php echo $evalQuestions['Q21']; ?>:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <?php
                        foreach ($evalValues['Q21'] as $opt) {
                            echo "<td>";
                            echo "<input type = 'checkbox' name = 'Q21[]'  value = '" . $opt['val'] . "' " . (in_array($opt['val'], explode("|", $eval->getAnswer("Q21"))) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'] . "&nbsp;&nbsp;&nbsp;&nbsp;";
                            //echo "<input type = 'radio' name = 'Q21'  value = '" . $opt['val'] . "' " . ($eval->getAnswer("Q21") == $opt['val'] ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'] . "&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "</td>";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td><b>22) <?php echo $evalQuestions['Q22']; ?>:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <?php
                        foreach ($evalValues['Q22'] as $opt) {
                            echo "<td>";
                            echo "<input type = 'radio' name = 'Q22'  value = '" . $opt['val'] . "' " . ($eval->getAnswer("Q22") == $opt['val'] ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'] . "&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "</td>";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td><b>23) <?php echo $evalQuestions['Q23']; ?>:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <?php
                        foreach ($evalValues['Q23'] as $opt) {
                            echo "<td>";
                            echo "<input type = 'radio' name = 'Q23'  value = '" . $opt['val'] . "' " . ($eval->getAnswer("Q23") == $opt['val'] ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'] . "&nbsp;&nbsp;&nbsp;&nbsp;";
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
                            echo "<input type = 'checkbox' name = 'Q24[]'  value = '" . $opt['val'] . "' " . (in_array($opt['val'], explode("|", $eval->getAnswer("Q24"))) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'] . "&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "</td>";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td><b>25) <?php echo $evalQuestions['Q25']; ?>:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <?php
                        foreach ($evalValues['Q25'] as $opt) {
                            echo "<td>";
                            echo "<input type = 'radio' name = 'Q25'  value = '" . $opt['val'] . "' " . ($eval->getAnswer("Q25") == $opt['val'] ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'] . "&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "</td>";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td><b>26) <?php echo $evalQuestions['Q26']; ?>:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <?php
                        foreach ($evalValues['Q26'] as $opt) {
                            echo "<td>";
                            echo "<input type = 'radio' name = 'Q26'  value = '" . $opt['val'] . "' " . ($eval->getAnswer("Q26") == $opt['val'] ? "checked='checked'" : "") . $func->disableElement($mode) . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "</td>";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td><b>27) <?php echo $evalQuestions['Q27']; ?>:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <?php
                        foreach ($evalValues['Q27'] as $opt) {
                            echo "<td>";
                            echo "<input type = 'checkbox' name = 'Q27[]'  value = '" . $opt['val'] . "' " . (in_array($opt['val'], explode("|", $eval->getAnswer("Q27"))) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'] . "&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "</td>";
                        }
                        ?>
                    </tr>
 
                </table>
            </div>
            <div class='container'>
                <div><input type='submit' name='SUBMIT' value='Update Eval' <?php echo ($mode === 'view') ? "disabled='disabled'" : ""; ?> ></div>
            </div>
        </form>
    </body>
</html>
