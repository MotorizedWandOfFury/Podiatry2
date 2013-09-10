<?php
date_default_timezone_set("EST");

require_once '\PodiatryAutoloader.php';
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


$database = new Database();
$patient = null;
$patientID = 0;
$type = filter_var($_GET['type'], FILTER_VALIDATE_INT, array('options'=>array('min_range' => 1, 'max_range'=>5))) or die("Type value is invalid");
if($type == 2){ //2 is not a valid type for this form
    die("Type value is invalid");
}
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

$noMissingFields = true;
$noInvalidFields = true;

if (isset($_POST['SUBMIT'])) {
    foreach ($_POST as $key => $value) {
        if ($value){ //validate fields have proper values
            switch ($key) {
                case 'M':
                    $monthOptions = array(
                        'options' => array(
                            'min_range' => 1,
                            'max_range' => 12,
                        )
                    );
                    if (filter_var($value, FILTER_VALIDATE_INT, $monthOptions) == false) {
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
    
    if(($session->getUserType() === Patient::tableName) && (count($_POST) < 40)) {
            echo "<p>You are required to answer every question.</p>";
            $noMissingFields = false;
        }

    if ($noInvalidFields && $noMissingFields) { //everything has been validated
        $sf36 = new SF36($patient->getId());
        $sf36->setDateOf($_POST['M'], $_POST['D'], $_POST['Y']);
        $sf36->setType($type);
        $sf36->setExtremity($extremity);

        foreach ($_POST as $key => $value) {
            if (($key === 'M') || ($key === 'D') || ($key === 'Y') || ($key === 'SUBMIT')) {
                
            } //do nothing
            else {
                $sf36->setAnswer($key, $value);  //get the answers
            }
        }

        //echo $sf36->generateCreateQuery();
        //var_dump($sf36);
        $database->create($sf36);
        $nav->redirectUser($session->getUserType(), Navigator::SUBMISSION_NAVIGATION_ACTION, "SF36 Form successfully submitted");
    }
}
?>

<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>
    <head>
        <meta http-equiv='Content-Type' content='text/html;charset=utf-8' />
        <title>SF-36</title>
        <link rel='stylesheet' href='bootstrap/css/sf36_css.css' />
    </head>
    <body>
        <?php echo Functions::formTitle($type, "SF-36");?>
        <form action="<?php echo $_SERVER['SCRIPT_NAME'] . "?patid=$patientID" . "&extremity=$extremity" . "&type=$type"; ?>" method='post'>
            <div class='container'>
                <div class='greybox'>
                    <p>1) Patient: <?php echo $patient->getFirstName(); ?>&nbsp;&nbsp;&nbsp;
                        2) Date (M-D-YYYY) <input class="text" type='text' size='2' maxlength='2' name='M' value ='<?php echo $currTime['mon']; ?>'/>
                        -<input class="text" type='text' size='2' maxlength='2' name='D' value='<?php echo $currTime['mday']; ?>'/>
                        -<input class="text" type='text' size='4' maxlength='4' name='Y' value='<?php echo $currTime['year']; ?>'/>&nbsp;&nbsp;&nbsp;
                        3) Extremity: <?php echo $eval->getExtremityFormatted(); ?>
                    </p>


                    <p>4) <?php echo $sf36Questions['Q4']; ?> &nbsp;&nbsp;&nbsp;</p>
                    <?php
                    foreach ($sf36Values['Q4'] as $opt)
                        echo "<input type='radio' name ='Q4' value='" . $opt['pre_val'] . "'" . (isset($_POST['Q4']) && $_POST['Q4'] == $opt['pre_val'] ? 'checked = "checked"' : '') . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input>";
                    ?>

                    <p>5) <?php echo $sf36Questions['Q5']; ?> &nbsp;&nbsp;&nbsp;</p>
                    <?php
                    foreach ($sf36Values['Q5'] as $opt)
                        echo "<input type='radio' name ='Q5' value='" . $opt['pre_val'] . "'" . (isset($_POST['Q5']) && $_POST['Q5'] == $opt['pre_val'] ? 'checked = "checked"' : '') . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input>";
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
                                echo "<td align='center'><input type='radio' name = 'Q7' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q7']) && $_POST['Q7'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                8) <?php echo $sf36Questions['Q8']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q8'] as $opt) {
                                echo "<td align='center'><input type='radio' name = 'Q8' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q8']) && $_POST['Q8'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                9) <?php echo $sf36Questions['Q9']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q9'] as $opt) {
                                echo "<td align='center'><input type='radio' name = 'Q9' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q9']) && $_POST['Q9'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                10) <?php echo $sf36Questions['Q10']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q10'] as $opt) {
                                echo "<td align='center'><input type='radio' name = 'Q10' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q10']) && $_POST['Q10'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                11) <?php echo $sf36Questions['Q11']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q11'] as $opt) {
                                echo "<td align='center'><input type='radio' name = 'Q11' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q11']) && $_POST['Q11'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                12) <?php echo $sf36Questions['Q12']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q12'] as $opt) {
                                echo "<td align='center'><input type='radio' name = 'Q12' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q12']) && $_POST['Q12'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                13) <?php echo $sf36Questions['Q13']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                             <?php
                            foreach ($sf36Values['Q13'] as $opt) {
                                echo "<td align='center'><input type='radio' name = 'Q13' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q13']) && $_POST['Q13'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                14) <?php echo $sf36Questions['Q14']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q14'] as $opt) {
                                echo "<td align='center'><input type='radio' name = 'Q14' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q14']) && $_POST['Q14'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                15) <?php echo $sf36Questions['Q15']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q15'] as $opt) {
                                echo "<td align='center'><input type='radio' name = 'Q15' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q15']) && $_POST['Q15'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                16) <?php echo $sf36Questions['Q16']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q16'] as $opt) {
                                echo "<td align='center'><input type='radio' name = 'Q16' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q16']) && $_POST['Q16'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/></td>";
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
                                echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name = 'Q18' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q18']) && $_POST['Q18'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/>&nbsp;&nbsp;&nbsp;</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                19) <?php echo $sf36Questions['Q19']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q19'] as $opt) {
                                echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name = 'Q19' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q19']) && $_POST['Q19'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/>&nbsp;&nbsp;&nbsp;</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                20) <?php echo $sf36Questions['Q20']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q20'] as $opt) {
                                echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name = 'Q20' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q20']) && $_POST['Q20'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/>&nbsp;&nbsp;&nbsp;</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                21) <?php echo $sf36Questions['Q21']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q21'] as $opt) {
                                echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name = 'Q21' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q21']) && $_POST['Q21'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/>&nbsp;&nbsp;&nbsp;</td>";
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
                                echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name = 'Q23' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q23']) && $_POST['Q23'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/>&nbsp;&nbsp;&nbsp;</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                24) <?php echo $sf36Questions['Q24']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q24'] as $opt) {
                                echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name = 'Q24' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q24']) && $_POST['Q24'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/>&nbsp;&nbsp;&nbsp;</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                25) <?php echo $sf36Questions['Q25']; ?> &nbsp;&nbsp;&nbsp;
                            </td>
                            <?php
                            foreach ($sf36Values['Q25'] as $opt) {
                                echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name = 'Q25' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q25']) && $_POST['Q25'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/>&nbsp;&nbsp;&nbsp;</td>";
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
                                echo "<td><input type='radio' name ='Q26' value='" . $opt['pre_val'] . "'" . (isset($_POST['Q26']) && $_POST['Q26'] == $opt['pre_val'] ? 'checked = "checked"' : '') . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input></td>";
                            ?>
                        </tr>
                        <tr>
                            <td colspan='7'>27) <?php echo $sf36Questions['Q27']; ?> &nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($sf36Values['Q27'] as $opt)
                                echo "<td><input type='radio' name ='Q27' value='" . $opt['pre_val'] . "'" . (isset($_POST['Q27']) && $_POST['Q27'] == $opt['pre_val'] ? 'checked = "checked"' : '') . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input></td>";
                            ?>
                        </tr>
                        <tr><td colspan='7'>28) <?php echo $sf36Questions['Q28']; ?> &nbsp;&nbsp;&nbsp;</td></tr>
                        <tr>
                            <td>&nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($sf36Values['Q28'] as $opt)
                                echo "<td><input type='radio' name ='Q28' value='" . $opt['pre_val'] . "'" . (isset($_POST['Q28']) && $_POST['Q28'] == $opt['pre_val'] ? 'checked = "checked"' : '') . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input></td>";
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
                                echo "<td align='center'><input type='radio' name ='Q31' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q31']) && $_POST['Q31'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input></td>";
                            }
                            ?>

                        </tr>
                        <tr>
                            <td>32) <?php echo $sf36Questions['Q32']; ?> &nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($sf36Values['Q32'] as $opt) {
                                echo "<td align='center'><input type='radio' name ='Q32' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q32']) && $_POST['Q32'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>33) <?php echo $sf36Questions['Q33']; ?> &nbsp;&nbsp;&nbsp;</td>
                           <?php
                            foreach ($sf36Values['Q31'] as $opt) {
                                echo "<td align='center'><input type='radio' name ='Q33' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q33']) && $_POST['Q33'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>34) <?php echo $sf36Questions['Q34']; ?> &nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($sf36Values['Q31'] as $opt) {
                                echo "<td align='center'><input type='radio' name ='Q34' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q34']) && $_POST['Q34'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>35) <?php echo $sf36Questions['Q35']; ?> &nbsp;&nbsp;&nbsp;</td>
                           <?php
                            foreach ($sf36Values['Q31'] as $opt) {
                                echo "<td align='center'><input type='radio' name ='Q35' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q35']) && $_POST['Q35'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>36) <?php echo $sf36Questions['Q36']; ?> &nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($sf36Values['Q36'] as $opt) {
                                echo "<td align='center'><input type='radio' name ='Q36' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q36']) && $_POST['Q36'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>37) <?php echo $sf36Questions['Q37']; ?> &nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($sf36Values['Q37'] as $opt) {
                                echo "<td align='center'><input type='radio' name ='Q37' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q37']) && $_POST['Q37'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>38) <?php echo $sf36Questions['Q38']; ?> &nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($sf36Values['Q38'] as $opt) {
                                echo "<td align='center'><input type='radio' name ='Q38' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q38']) && $_POST['Q38'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>39) <?php echo $sf36Questions['Q39']; ?> &nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach ($sf36Values['Q39'] as $opt) {
                                echo "<td align='center'><input type='radio' name ='Q39' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q39']) && $_POST['Q39'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/>" . $opt['name'] . "&nbsp;&nbsp;&nbsp;</input></td>";
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
                            foreach($sf36Values['Q40'] as $opt){
                                echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name ='Q40' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q40']) && $_POST['Q40'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/>&nbsp;&nbsp;&nbsp;</td>";
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
                            foreach($sf36Values['Q42'] as $opt){
                                echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name ='Q42' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q42']) && $_POST['Q42'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/>&nbsp;&nbsp;&nbsp;</td>";
                            }
                            ?>
                        </tr>
                        <tr><td>
                                43) <?php echo $sf36Questions['Q43']; ?> &nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach($sf36Values['Q43'] as $opt){
                                echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name ='Q43' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q43']) && $_POST['Q43'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/>&nbsp;&nbsp;&nbsp;</td>";
                            }
                            ?>
                        </tr>
                        <tr><td>
                                44) <?php echo $sf36Questions['Q44']; ?> &nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach($sf36Values['Q44'] as $opt){
                                echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name ='Q44' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q44']) && $_POST['Q44'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/>&nbsp;&nbsp;&nbsp;</td>";
                            }
                            ?>
                        </tr>
                        <tr><td>
                                45) <?php echo $sf36Questions['Q45']; ?> &nbsp;&nbsp;&nbsp;</td>
                            <?php
                            foreach($sf36Values['Q45'] as $opt){
                                echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name ='Q45' value='" . $opt['pre_val'] . "'" . ((isset($_POST['Q45']) && $_POST['Q45'] == $opt['pre_val']) ? 'checked = "checked"' : '') . "/>&nbsp;&nbsp;&nbsp;</td>";
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