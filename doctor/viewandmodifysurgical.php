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
$func = new Functions();
 
 
$mode = isset($_GET['mode']) ? $_GET['mode'] : "view"; // default mode for page is viewing, if the mode attribute has not been set
 
$database = new Database();
$patientID = filter_var($_GET['patid'], FILTER_VALIDATE_INT) or die("Patient ID not set");
$patient = $database->read(Patient::createRetrievableDatabaseObject($patientID));
$extremity = filter_var($_GET['extremity'], FILTER_VALIDATE_INT, array('options'=> array('min_range' => 1), 'max_range'=>2)) or die("Extremity is needed");
$surgical = $database->read(Surgical::createRetrievableDatabaseObject($patientID, $extremity)) or die("Form has not been filled out yet");
$doctor = $database->read(Physician::createRetrievableDatabaseObject($surgical->getSurID()));
$eval = $database->read(Evals::createRetrievableDatabaseObject($patientID, $extremity)) or die("Pre eval form for patient has not been filled yet."); 
 
if ($mode === 'edit') { // make sure we are in edit mode before we can make changes
    if (isset($_POST['SUBMIT'])) {
        foreach ($_POST as $key => $value) {
         
            if ($key === 'SUBMIT') {
                 
            } else if($key === 'Q5'){
                $surgical->setAnswer($key, implode("|", $value));
            } 
            else {
                $surgical->setAnswer($key, $value);
            }
        }
        //echo $surgical->generateUpdateQuery();
        //var_dump($surgical);
 
        $database->update($surgical);
        $nav->redirectUser($session->getUserType(), Navigator::SUBMISSION_NAVIGATION_ACTION, "Surgical Data successfully updated");
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
        &nbsp;
        <a href="<?php echo $_SERVER['SCRIPT_NAME'] . "?patid= $patientID" . "&extremity=$extremity" . "&mode=view"; ?>">View</a> | <a href="<?php echo $_SERVER['SCRIPT_NAME'] . "?patid= $patientID" . "&extremity=$extremity" . "&mode=edit"; ?>">Edit</a>
        <form action="<?php echo $_SERVER['SCRIPT_NAME'] . "?patid=$patientID" . "&extremity=$extremity" . "&mode=" . $mode; ?>" method="POST">
            <div class='container'>
                <div class='greybox'>
                    <table>
                        <tr>
                            <td>1) Patient: <?php echo $patient->getFirstName() . " " . $patient->getLastName(); ?>&nbsp;</td>
                            <td>2) Surgeon: <?php echo $doctor->getFirstName() . " " . $doctor->getLastName(); ?> </td>
                        </tr>
                        <tr>
                            <td>3) Extremity: <?php echo $eval->getExtremityFormatted(); ?></td>
                            <td>4) <?php echo $surgicalQuestions['Q4'] . ": ". $surgical->getDateOfSurgeryFormatted(); ?></td>
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
                                    echo "<input type = 'checkbox' name = 'Q5[]'  value = '" . $opt['val'] . "' " . (in_array($opt['val'], explode("|", $surgical->getAnswer("Q5"))) ? "checked='checked'" : ""). $func->disableElement($mode)  . "/>" . $opt['name'] . "&nbsp;&nbsp;";
                                    //echo "</td>";
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class='container'>
                <div class='greybox'>
                    <table>
                        <tr>
                            <td>6) <?php echo $surgicalQuestions['Q6'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q6'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q6'  value = '" . $opt['val'] . "' " . ($surgical->getAnswer("Q6") == $opt['val'] ? "checked='checked'" : ""). $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>7) <?php echo $surgicalQuestions['Q7'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q7'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q7'  value = '" . $opt['val'] . "' " . ($surgical->getAnswer("Q7") == $opt['val'] ? "checked='checked'" : ""). $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>8) <?php echo $surgicalQuestions['Q8'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q8'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q8'  value = '" . $opt['val'] . "' " . ($surgical->getAnswer("Q8") == $opt['val'] ? "checked='checked'" : ""). $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>9) <?php echo $surgicalQuestions['Q9'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q9'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q9'  value = '" . $opt['val'] . "' " . ($surgical->getAnswer("Q9") == $opt['val'] ? "checked='checked'" : ""). $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>10) <?php echo $surgicalQuestions['Q10'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q10'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q10'  value = '" . $opt['val'] . "' " . ($surgical->getAnswer("Q10") == $opt['val'] ? "checked='checked'" : ""). $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>11) <?php echo $surgicalQuestions['Q11'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q11'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q11'  value = '" . $opt['val'] . "' " . ($surgical->getAnswer("Q11") == $opt['val'] ? "checked='checked'" : ""). $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>12) <?php echo $surgicalQuestions['Q12'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q12'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q12'  value = '" . $opt['val'] . "' " . ($surgical->getAnswer("Q12") == $opt['val'] ? "checked='checked'" : ""). $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>13) <?php echo $surgicalQuestions['Q13'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q13'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q13'  value = '" . $opt['val'] . "' " . ($surgical->getAnswer("Q13") == $opt['val'] ? "checked='checked'" : ""). $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>14) <?php echo $surgicalQuestions['Q14'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q14'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q14'  value = '" . $opt['val'] . "' " . ($surgical->getAnswer("Q14") == $opt['val'] ? "checked='checked'" : ""). $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>15) <?php echo $surgicalQuestions['Q15'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q15'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q15'  value = '" . $opt['val'] . "' " . ($surgical->getAnswer("Q15") == $opt['val'] ? "checked='checked'" : ""). $func->disableElement($mode) . "/> " . $opt['name'];
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
                                echo "<input type = 'radio' name = 'Q16'  value = '" . $opt['val'] . "' " . ($surgical->getAnswer("Q16") == $opt['val'] ? "checked='checked'" : ""). $func->disableElement($mode) . "/> " . $opt['name'];
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
                                echo "<input type = 'radio' name = 'Q17'  value = '" . $opt['val'] . "' " . ($surgical->getAnswer("Q17") == $opt['val'] ? "checked='checked'" : ""). $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>18) <?php echo $surgicalQuestions['Q18'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q18'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q18'  value = '" . $opt['val'] . "' " . ($surgical->getAnswer("Q18") == $opt['val'] ? "checked='checked'" : ""). $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>19) <?php echo $surgicalQuestions['Q19'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q19'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q19'  value = '" . $opt['val'] . "' " . ($surgical->getAnswer("Q19") == $opt['val'] ? "checked='checked'" : ""). $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>20) <?php echo $surgicalQuestions['Q20'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q20'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q20'  value = '" . $opt['val'] . "' " . ($surgical->getAnswer("Q20") == $opt['val'] ? "checked='checked'" : ""). $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>21) <?php echo $surgicalQuestions['Q21'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q21'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q21'  value = '" . $opt['val'] . "' " . ($surgical->getAnswer("Q21") == $opt['val'] ? "checked='checked'" : ""). $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>22) <?php echo $surgicalQuestions['Q22'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q22'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q22'  value = '" . $opt['val'] . "' " . ($surgical->getAnswer("Q22") == $opt['val'] ? "checked='checked'" : ""). $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>23) <?php echo $surgicalQuestions['Q23'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q23'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q23'  value = '" . $opt['val'] . "' " . ($surgical->getAnswer("Q23") == $opt['val'] ? "checked='checked'" : ""). $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>24) <?php echo $surgicalQuestions['Q24'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q24'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q24'  value = '" . $opt['val'] . "' " . ($surgical->getAnswer("Q24") == $opt['val'] ? "checked='checked'" : ""). $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>25) <?php echo $surgicalQuestions['Q25'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q25'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q25'  value = '" . $opt['val'] . "' " . ($surgical->getAnswer("Q25") == $opt['val'] ? "checked='checked'" : ""). $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>26) <?php echo $surgicalQuestions['Q26'] . ":"; ?></td>
                            <?php
                            foreach ($surgicalValues['Q26'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q26'  value = '" . $opt['val'] . "' " . ($surgical->getAnswer("Q26") == $opt['val'] ? "checked='checked'" : ""). $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>
            </div>
                <div class='container'>
                <div><input type='submit' name='SUBMIT' value='Update Surgical data' <?php echo ($mode === 'view') ? "disabled='disabled'" : ""; ?> ></div>
            </div>
        </form>
    </body>
</html>
