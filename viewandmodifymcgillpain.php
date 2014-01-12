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
$type = $session->getUserType();
 
$func = new Functions();
$nav = new Navigator();
 
 
$mode = isset($_GET['mode']) ? $_GET['mode'] : "view"; // default mode for page is viewing, if the mode attribute has not been set
 
$database = new Database();
$patientID = filter_var($_GET['patid'], FILTER_VALIDATE_INT) or die("Patient ID not set");
$type = filter_var($_GET['type'], FILTER_VALIDATE_INT, array('options'=>array('min_range' => 1, 'max_range'=>5))) or die("Type value is invalid");

$patient = $database->read(Patient::createRetrievableDatabaseObject($patientID));
$doctor = $database->read(Physician::createRetrievableDatabaseObject($patient->getDoctor()));
$extremity = filter_var($_GET['extremity'], FILTER_VALIDATE_INT, array('options'=> array('min_range' => 1), 'max_range'=>2)) or die("Extremity is needed");
$mcgill = $database->read(Mcgillpain::createRetrievableDatabaseObject($patientID, $type, $extremity)) or die("Form has not been filled out for this patient");
$eval = $database->read(Evals::createRetrievableDatabaseObject($patientID, $extremity)) or die("Pre eval form for patient has not been filled yet."); 
 
if ($mode === 'edit') { // make sure we are in edit mode before we can make changes
    if (isset($_POST['SUBMIT'])) {
        foreach ($_POST as $key => $value) {
            if ($key === 'SUBMIT') {      
            } else {
                $mcgill->setAnswer($key, $value);
            }
        }
        //echo $mcgill->generateUpdateQuery();
        //var_dump($mcgill);
         
        $database->update($mcgill);
        $nav->redirectUser($session->getUserType(), Navigator::SUBMISSION_NAVIGATION_ACTION, "Mcgill Pain Questionnaire successfully updated");
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
        <?php echo Functions::formTitle($type, "McGill Pain Questionnaire", $extremity)?>
        &nbsp;
		<?php if ($type == Admin::tableName) echo '<a href="admin/main.php">Home</a>'; else echo '<a href="main.php">Home</a>'; ?> |
        <a href="<?php echo $_SERVER['SCRIPT_NAME'] . "?patid=$patientID" . "&type=$type" . "&extremity=$extremity" . "&mode=view"; ?>">View</a> | <a href="<?php echo $_SERVER['SCRIPT_NAME'] . "?patid=$patientID" . "&type=$type" . "&extremity=$extremity" . "&mode=edit"; ?>">Edit</a>
        <form action="<?php echo $_SERVER['SCRIPT_NAME'] . "?patid=$patientID" . "&type=$type". "&extremity=$extremity" . "&mode=$mode"; ?>" method="POST">
            <div class='container'>
                <div class='greybox'>
                    <table>
                        <tr>
                            <td>1) Name: <?php echo $patient->getFirstName() . " " . $patient->getLastName(); ?></td>
                            <td>2) Surgeon: <?php echo $doctor->getFirstName() . " " . $doctor->getLastName(); ?> </td>
                        </tr>
                        <tr>
                            <td>3) Date: <?php echo $mcgill->getDateOfFormatted(); ?></td>
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
                                echo "<input type = 'radio' name = 'Q5'  value = '" . $opt['val'] . "' " . (($mcgill->getAnswer("Q5") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>6) <?php echo $mcgillpainQuestions['Q6']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q6'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q6'  value = '" . $opt['val'] . "' " . (($mcgill->getAnswer("Q6") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>7) <?php echo $mcgillpainQuestions['Q7']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q7'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q7'  value = '" . $opt['val'] . "' " . (($mcgill->getAnswer("Q7") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>8) <?php echo $mcgillpainQuestions['Q8']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q8'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q8'  value = '" . $opt['val'] . "' " . (($mcgill->getAnswer("Q8") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>9) <?php echo $mcgillpainQuestions['Q9']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q9'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q9'  value = '" . $opt['val'] . "' " . (($mcgill->getAnswer("Q9") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>10) <?php echo $mcgillpainQuestions['Q10']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q10'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q10'  value = '" . $opt['val'] . "' " . (($mcgill->getAnswer("Q10") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>11) <?php echo $mcgillpainQuestions['Q11']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q11'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q11'  value = '" . $opt['val'] . "' " . (($mcgill->getAnswer("Q11") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>12) <?php echo $mcgillpainQuestions['Q12']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q12'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q12'  value = '" . $opt['val'] . "' " . (($mcgill->getAnswer("Q12") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
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
                                echo "<input type = 'radio' name = 'Q13'  value = '" . $opt['val'] . "' " . (($mcgill->getAnswer("Q13") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>12) <?php echo $mcgillpainQuestions['Q14']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q14'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q14'  value = '" . $opt['val'] . "' " . (($mcgill->getAnswer("Q14") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>15) <?php echo $mcgillpainQuestions['Q15']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q15'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q15'  value = '" . $opt['val'] . "' " . (($mcgill->getAnswer("Q15") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>16) <?php echo $mcgillpainQuestions['Q16']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q16'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q16'  value = '" . $opt['val'] . "' " . (($mcgill->getAnswer("Q16") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>17) <?php echo $mcgillpainQuestions['Q17']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q17'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q17'  value = '" . $opt['val'] . "' " . (($mcgill->getAnswer("Q17") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>18) <?php echo $mcgillpainQuestions['Q18']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q18'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q18'  value = '" . $opt['val'] . "' " . (($mcgill->getAnswer("Q18") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>19) <?php echo $mcgillpainQuestions['Q19']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q19'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q19'  value = '" . $opt['val'] . "' " . (($mcgill->getAnswer("Q19") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>20) <?php echo $mcgillpainQuestions['Q20']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q20'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q20'  value = '" . $opt['val'] . "' " . (($mcgill->getAnswer("Q20") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>21) <?php echo $mcgillpainQuestions['Q21']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q21'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q21'  value = '" . $opt['val'] . "' " . (($mcgill->getAnswer("Q21") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>22) <?php echo $mcgillpainQuestions['Q22']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q22'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q22'  value = '" . $opt['val'] . "' " . (($mcgill->getAnswer("Q22") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>23) <?php echo $mcgillpainQuestions['Q23']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q23'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q23'  value = '" . $opt['val'] . "' " . (($mcgill->getAnswer("Q23") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>24) <?php echo $mcgillpainQuestions['Q24']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q24'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q24'  value = '" . $opt['val'] . "' " . (($mcgill->getAnswer("Q24") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>25) <?php echo $mcgillpainQuestions['Q25']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q25'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q25'  value = '" . $opt['val'] . "' " . (($mcgill->getAnswer("Q25") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>26) <?php echo $mcgillpainQuestions['Q26']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q26'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q26'  value = '" . $opt['val'] . "' " . (($mcgill->getAnswer("Q26") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>27) <?php echo $mcgillpainQuestions['Q27']; ?>:</td>
                            <?php
                            foreach ($mcgillpainValues['Q27'] as $opt) {
                                echo "<td>";
                                echo "<input type = 'radio' name = 'Q27'  value = '" . $opt['val'] . "' " . (($mcgill->getAnswer("Q27") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
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
                                echo "<input type = 'radio' name = 'Q28'  value = '" . $opt['val'] . "' " . (($mcgill->getAnswer("Q28") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>29) <?php echo $mcgillpainQuestions['Q29']; ?>:</td>
                            <td colspan='6'>
                                <?php
                            foreach ($mcgillpainValues['Q29'] as $opt) {
                                echo "<input type = 'radio' name = 'Q29'  value = '" . $opt['val'] . "' " . (($mcgill->getAnswer("Q29") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
                            }
                            ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div><input type='submit' name='SUBMIT' value='Update Questionaire' <?php echo $func->disableElement($mode); ?> /></div>
            </div>
        </form>
    </body>
</html>
