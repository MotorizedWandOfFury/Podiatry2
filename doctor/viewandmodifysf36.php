<?php
date_default_timezone_set("EST");

require_once dirname(dirname(__FILE__)) . '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));

$json = new JSONManager();
$sf36Questions = $json->loadJSONQuestions("SF36", "en");
$sf36Values = $json->loadJSONValues("SF36", "en");

if (empty($sf36Questions) || empty($sf36Values)) {
    die("Unable to load JSON files");
}

$session = new SessionManager();
$session->validate();

$nav = new Navigator();
$func = new Functions();


$mode = isset($_GET['mode']) ? $_GET['mode'] : "view"; // default mode for page is viewing, if the mode attribute has not been set

$database = new Database();
$patientID = filter_var($_GET['patid'], FILTER_VALIDATE_INT) or die('Patient ID has not been set in URL');
$type = filter_var($_GET['type'], FILTER_VALIDATE_INT, array('options' => array('min_range' => 1, 'max_range' => 5))) or die("Type value is invalid");
if ($type == 2) { //2 is not a valid type for this form
    die("Type value is invalid");
}
$patient = ($session->getUserType() === Patient::tableName) ? $session->getUserObject() : $database->read(Patient::createRetrievableDatabaseObject($patientID)); //if the logged in user is a patient use that patient, else pull the patient from database
$extremity = filter_var($_GET['extremity'], FILTER_VALIDATE_INT, array('options' => array('min_range' => 1), 'max_range' => 2)) or die("Extremity is needed");
$sf36 = $database->read(SF36::createRetrievableDatabaseObject($patientID, $type, $extremity)) or die("Form has not been filled out for this patient");
$eval = $database->read(Evals::createRetrievableDatabaseObject($patientID, $extremity)) or die("Pre eval form for patient has not been filled yet.");

if ($mode === 'edit') { // make sure we are in edit mode before we can make changes
    if (isset($_POST['SUBMIT'])) {
        foreach ($_POST as $key => $value) {
            if ($key === 'SUBMIT') {
                
            } else {
                $sf36->setAnswer($key, $value);
            }
        }

        //echo $sf36->generateUpdateQuery();

        $database->update($sf36);
        $nav->redirectUser($session->getUserType(), Navigator::SUBMISSION_NAVIGATION_ACTION, "SF36 successfully updated");
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html;charset=utf-8' />
        <title>SF-36</title>
        <link rel='stylesheet' href='../bootstrap/css/sf36_css.css' />
    </head>
    <body>
        <?php echo Functions::formTitle($type, "SF-36", $extremity); ?>
        &nbsp;
        <a href="<?php echo $func->getUserHome($session->getUserObject()); ?>">Home</a> |
        <a href="<?php echo $_SERVER['SCRIPT_NAME'] . "?patid=$patientID" . "&type=$type" . "&extremity=$extremity" . "&mode=view"; ?>">View</a> | <a href="<?php echo $_SERVER['SCRIPT_NAME'] . "?patid=$patientID" . "&type=$type" . "&extremity=$extremity" . "&mode=edit"; ?>">Edit</a>
        <form action="<?php echo $_SERVER['SCRIPT_NAME'] . "?patid=$patientID" . "&type=$type" . "&extremity=$extremity" . "&mode=$mode"; ?>" method="POST">
            <div class='container'>
                <div class='greybox'>
                    <p>1) Patient: <?php echo $patient->getFirstName(); ?>&nbsp;&nbsp;&nbsp;
                        2) Date: <?php echo $sf36->getDateOfFormatted(); ?> &nbsp;&nbsp;&nbsp;
                        3) Extremity: <?php echo $eval->getExtremityFormatted(); ?>
                    </p>


                    <p>4) <?php echo $sf36Questions['Q4']; ?> &nbsp;&nbsp;&nbsp;</p>
                    <?php
                    foreach ($sf36Values['Q4'] as $opt)
                        echo "<input type='radio' name ='Q4' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q4") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input>";
                    ?>

                    <p>5) <?php echo $sf36Questions['Q5']; ?> &nbsp;&nbsp;&nbsp;</p>
                    <?php
                    foreach ($sf36Values['Q5'] as $opt)
                        echo "<input type='radio' name ='Q5' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q5") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input>";
                    ?>
                    <br>&nbsp;&nbsp;&nbsp;<br/>
                </div>
            </div>
            <div class='container'>
                <div class='whitebox'>
                    <table>
                        <tr>
                            <td colspan='4'>6) THE FOLLOWING QUESTIONS ARE ABOUT ACTIVITIES YOU MIGHT DO DURING A TYPICAL DAY. DOES YOUR HEALTH <u>NOW</u> LIMIT YOU IN THESE ACTIVITIES? IF SO, HOW MUCH?</td>
                        </tr>
                        <tr style='text-align: center;'>
                            <td>&nbsp;</td>
                            <td>Yes, Limited <br />a lot</td>
                            <td>Yes, Limited <br />a little</td>
                            <td>No, not <br />limited at all</td>
                        </tr>
                        <tr>
                            <td>
                                7) <?php echo $sf36Questions['Q7']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q7'] as $opt) {
                                echo "<td align='center'><input type='radio' name = 'Q7' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q7") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                8) <?php echo $sf36Questions['Q8']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q8'] as $opt) {
                                echo "<td align='center'><input type='radio' name = 'Q8' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q8") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                9) <?php echo $sf36Questions['Q9']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q9'] as $opt) {
                                echo "<td align='center'><input type='radio' name = 'Q9' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q9") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                10) <?php echo $sf36Questions['Q10']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q10'] as $opt) {
                                echo "<td align='center'><input type='radio' name = 'Q10' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q10") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                11) <?php echo $sf36Questions['Q11']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q11'] as $opt) {
                                echo "<td align='center'><input type='radio' name = 'Q11' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q11") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                12) <?php echo $sf36Questions['Q12']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q12'] as $opt) {
                                echo "<td align='center'><input type='radio' name = 'Q12' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q12") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                13) <?php echo $sf36Questions['Q13']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q13'] as $opt) {
                                echo "<td align='center'><input type='radio' name = 'Q13' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q13") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                14) <?php echo $sf36Questions['Q14']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q14'] as $opt) {
                                echo "<td align='center'><input type='radio' name = 'Q14' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q14") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                15) <?php echo $sf36Questions['Q15']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q15'] as $opt) {
                                echo "<td align='center'><input type='radio' name = 'Q15' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q15") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                16) <?php echo $sf36Questions['Q16']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q16'] as $opt) {
                                echo "<td align='center'><input type='radio' name = 'Q16' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q16") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/></td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div> 
            </div>
            <div class='container'>
                <div class='greybox'>
                    <p>17) DURING THE PAST 4 WEEKS, HAVE YOU HAD ANY OF THE FOLLOWING PROBLEMS WITH YOUR WORK OR OTHER REGULAR DAILY ACTIVITIES AS A RESULT OF YOUR PHYSICAL HEALTH?</p>
                    <table>
                        <tr>
                            <td>&nbsp;</td>
                            <td align='center'>Yes</td>
                            <td align='center'>No</td>
                        </tr>
                        <tr>
                            <td>
                                18) <?php echo $sf36Questions['Q18']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q18'] as $opt) {
                                echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name = 'Q18' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q18") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/>&nbsp;&nbsp;&nbsp;</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                19) <?php echo $sf36Questions['Q19']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q19'] as $opt) {
                                echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name = 'Q19' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q19") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/>&nbsp;&nbsp;&nbsp;</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                20) <?php echo $sf36Questions['Q20']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q20'] as $opt) {
                                echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name = 'Q20' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q20") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/>&nbsp;&nbsp;&nbsp;</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                21) <?php echo $sf36Questions['Q21']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q21'] as $opt) {
                                echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name = 'Q21' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q21") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/>&nbsp;&nbsp;&nbsp;</td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div class='whitebox'>
                    <p>22) DURING THE PAST 4 WEEKS, HAVE YOU HAD ANY OF THE FOLLOWING PROBLEMS WITH YOUR WORK OR OTHER REGULAR DAILY ACTIVITIES AS A RESULT OF ANY EMOTIONAL PROBLEMS (SUCH AS FEELING DEPRESSED OR ANXIOUS)?
                    </p>
                    <table>
                        <tr>
                            <td>&nbsp;</td>
                            <td align='center'>Yes</td>
                            <td align='center'>No</td>
                        </tr>
                        <tr>
                            <td>
                                23) <?php echo $sf36Questions['Q23']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q23'] as $opt) {
                                echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name = 'Q23' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q23") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/>&nbsp;&nbsp;&nbsp;</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                24) <?php echo $sf36Questions['Q24']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q24'] as $opt) {
                                echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name = 'Q24' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q24") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/>&nbsp;&nbsp;&nbsp;</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                25) <?php echo $sf36Questions['Q25']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q25'] as $opt) {
                                echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name = 'Q25' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q25") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/>&nbsp;&nbsp;&nbsp;</td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div class='greybox'>
                    <table>
                        <tr><td colspan='7'>26) <?php echo $sf36Questions['Q26']; ?> &nbsp;&nbsp;&nbsp;</td></tr>
                        <tr>
                            <td>&nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($sf36Values['Q26'] as $opt)
                                echo "<td><input type='radio' name ='Q26' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q26") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input></td>";
                            ?>
                        </tr>
                        <tr>
                            <td colspan='7'>27) <?php echo $sf36Questions['Q27']; ?> &nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($sf36Values['Q27'] as $opt)
                                echo "<td><input type='radio' name ='Q27' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q27") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input></td>";
                            ?>
                        </tr>
                        <tr><td colspan='7'>28) <?php echo $sf36Questions['Q28']; ?> &nbsp;&nbsp;&nbsp;</td></tr>
                        <tr>
                            <td>&nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($sf36Values['Q28'] as $opt)
                                echo "<td><input type='radio' name ='Q28' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q28") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input></td>";
                            ?>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div class='whitebox'>
                    <table>
                        <tr>
                            <td colspan='7'>29) THESE QUESTIONS ARE ABOUT HOW YOU FEEL AND HOW THINGS HAVE BEEN WITH YOU DURING THE <u>PAST 4 WEEKS</u>. FOR EACH QUESTION, PLEASE GIVE THE ONE ANSWER THAT COMES CLOSEST TO THE WAY YOU HAVE BEEN FEELING.<br /><br /></td>
                        </tr>
                        <tr>
                            <td colspan='7'>30) HOW MUCH OF THE TIME DURING THE <u>PAST 4 WEEKS</u>...</td>
                        </tr>
                        <tr style='text-align: center;'>
                            <td>&nbsp;</td>
                            <td>All of the time</td>
                            <td>Most of the time</td>
                            <td>A good bit of the time</td>
                            <td>Some of the time</td>
                            <td>A little of the time</td>
                            <td>None of the time</td>
                        </tr>
                        <tr>
                            <td>31) <?php echo $sf36Questions['Q31']; ?> &nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($sf36Values['Q31'] as $opt) {
                                echo "<td align='center'><input type='radio' name ='Q31' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q31") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input></td>";
                            }
                            ?>

                        </tr>
                        <tr>
                            <td>32) <?php echo $sf36Questions['Q32']; ?> &nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($sf36Values['Q32'] as $opt) {
                                echo "<td align='center'><input type='radio' name ='Q32' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q32") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>33) <?php echo $sf36Questions['Q33']; ?> &nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($sf36Values['Q31'] as $opt) {
                                echo "<td align='center'><input type='radio' name ='Q33' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q33") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>34) <?php echo $sf36Questions['Q34']; ?> &nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($sf36Values['Q31'] as $opt) {
                                echo "<td align='center'><input type='radio' name ='Q34' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q34") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>35) <?php echo $sf36Questions['Q35']; ?> &nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($sf36Values['Q31'] as $opt) {
                                echo "<td align='center'><input type='radio' name ='Q35' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q35") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>36) <?php echo $sf36Questions['Q36']; ?> &nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($sf36Values['Q36'] as $opt) {
                                echo "<td align='center'><input type='radio' name ='Q36' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q36") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>37) <?php echo $sf36Questions['Q37']; ?> &nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($sf36Values['Q37'] as $opt) {
                                echo "<td align='center'><input type='radio' name ='Q37' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q37") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>38) <?php echo $sf36Questions['Q38']; ?> &nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($sf36Values['Q38'] as $opt) {
                                echo "<td align='center'><input type='radio' name ='Q38' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q38") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>39) <?php echo $sf36Questions['Q39']; ?> &nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($sf36Values['Q39'] as $opt) {
                                echo "<td align='center'><input type='radio' name ='Q39' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q39") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input></td>";
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
                            <td colspan='6'>40) <?php echo $sf36Questions['Q40']; ?>:</td>
                        </tr>
                        <tr style='text-align: center;'>
                            <td>&nbsp;</td>
                            <td>All of the time</td>
                            <td>Most of the time</td>
                            <td>Some of the time</td>
                            <td>A little of the time</td>
                            <td>None of the time</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <?php
                            foreach ($sf36Values['Q40'] as $opt) {
                                echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name ='Q40' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q40") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/>&nbsp;&nbsp;&nbsp;</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td colspan='6'>41) HOW TRUE OR FALSE IS <u>EACH</u> OF THE FOLLOWING STATEMENTS FOR YOU?</td></tr>
                        <tr style='text-align: center;'>
                            <td>&nbsp;</td>
                            <td>Definitely true</td>
                            <td>Mostly true</td>
                            <td>Don't know</td>
                            <td>Mostly false</td>
                            <td>Definitely false</td>
                        </tr>
                        <tr><td>
                                42) <?php echo $sf36Questions['Q42']; ?> &nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($sf36Values['Q42'] as $opt) {
                                echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name ='Q42' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q42") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/>&nbsp;&nbsp;&nbsp;</td>";
                            }
                            ?>
                        </tr>
                        <tr><td>
                                43) <?php echo $sf36Questions['Q43']; ?> &nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($sf36Values['Q43'] as $opt) {
                                echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name ='Q43' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q43") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/>&nbsp;&nbsp;&nbsp;</td>";
                            }
                            ?>
                        </tr>
                        <tr><td>
                                44) <?php echo $sf36Questions['Q44']; ?> &nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($sf36Values['Q44'] as $opt) {
                                echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name ='Q44' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q44") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/>&nbsp;&nbsp;&nbsp;</td>";
                            }
                            ?>
                        </tr>
                        <tr><td>
                                45) <?php echo $sf36Questions['Q45']; ?> &nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($sf36Values['Q45'] as $opt) {
                                echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name ='Q45' value='" . $opt['pre_val'] . "'" . ($sf36->getAnswer("Q45") == $opt['pre_val'] ? 'checked = "checked"' : '') . $func->disableElement($mode) . "/>&nbsp;&nbsp;&nbsp;</td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div><input type='submit' name='SUBMIT' value='Update Questionnaire' <?php echo ($mode === 'view') ? "disabled='disabled'" : ""; ?> ></div>
            </div>
        </form>
    </body>
</html>
