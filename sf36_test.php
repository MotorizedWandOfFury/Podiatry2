<?php

// Session
session_start();
// Database interaction.
require "db.php";
// Database functions.
require "classes/database.php";
$database = new Database();
// Clean class
require "classes/clean.php";
$clean = new Clean();
// Global variables
require "variables.php";
// Time class
require "classes/time.php";
$time = new Time();
// HTML, CSS class.
require "classes/layout.php";
$layout = new Layout();
// Error control
require "classes/error.php";
$error = new Error();
// Need patient class.
require "classes/patient.php";
$patient = new Patient(@$_SESSION[$sID]);
// Need doctor class.
require "classes/doctor.php";
$doctor = new Doctor(@$_SESSION[$sDID]);
// Need admin class.
require "classes/admin.php";
$admin = new Admin(@$_SESSION[$sAID]);
// Inputs
require "classes/input.php";
$in = new Input();
// Need the score class.
require "classes/score.php";

// Let's first check to see if the patient is logged in.
if ($patient->isLogged() == FALSE)
    $error->doGo("index.php", "Patients only.");

// Check to see if the patient has filled the survey.
$checkans = "SELECT dateof FROM ans_sf36 WHERE pat_id IN ('" . $patient->GetId() . "') LIMIT 1";

$test = $time->timeInterval($checkans, $patient);
if ($test == 0) {
    $error->doMSG("fill in the survey in the rigth time!!!");
} else {

// Otherwise, create a query for the questions
    $questions = mysql_query("SELECT * FROM ques_sf36");
// Question number to start from.
    $s = 4;
// Last question number.
    $e = 45;

    if (isset($_POST['SUBMIT']) == FALSE) {
        // Load the HTML, CSS.
        echo $layout->loadCSS("PRE-OPERATIVE SF-36", "");
        // Header
        echo $layout->doHead($layout->doText("PRE-OPERATIVE", "grey"), $layout->doText("SF-36", "grey"));

        echo "
            <form action='" . $SCRIPT_NAME . "' method='post'>
                <div class='container'>
                    <div class='greybox'>
                                    <table>
                                            <tr>
                                                    <td>1) Patient: " . $in->readonly("text", "", $patient->GetFullName()) . "</td>
                                                    <td>2) Date: " . $in->readonly("text", "", $time->doDate(time())) . "</td>
                                                    <td colspan='3'>3) Extremity: " . $patient->GetExtremity() . "</td>
                                            </tr>
	";

        for ($i = $s; $question = mysql_fetch_array($questions); $i++) {
            $values = mysql_query("SELECT * FROM vals_sf36 WHERE ques_num = '" . $question['num'] . "'");

            switch ($i) {
                case 4:
                case 5:
                    echo "
                        <tr>
                            <td>" . $question['num'] . ") " . $question['question'] . ":</td>
                    ";

                    for ($j = 1; $value = mysql_fetch_array($values); $j++) {
                        echo "
                                <td>" . $in->radio($question['num'], $value['id']) . " " . $value['val'] . "</td>
                            ";
                    }

                    echo "</tr>";
                    break;
                //-------------------------------------------
                case 6:
                    echo "
                                </table>
                            </div>
                        </div>
                        <div class='container'>
                            <div class='whitebox'>
                                <table>
                                    <tr>
                                            <td colspan='3'>6) THE FOLLOWING QUESTIONS ARE ABOUT ACTIVITIES YOU MIGHT DO DURING A TYPICAL DAY. DOES YOUR HEALTH <u>NOW</u> LIMIT YOU IN THESE ACTIVITIES? IF SO, HOW MUCH?</td>
                                    </tr>
                                    <tr style='text-align: center;'>
                                            <td>&nbsp;</td>
                                            <td>Yes, Limited a lot</td>
                                            <td>Yes, Limited a little</td>
                                            <td>No, not limited at all</td>
                                    </tr>
                    ";
                case 7:
                case 8:
                case 9:
                case 10:
                case 11:
                case 12:
                case 13:
                case 14:
                case 15:
                    echo "
                        <tr>
                            <td>" . $question['num'] . ") " . $question['question'] . ":</td>
                    ";

                    for ($j = 1; $value = mysql_fetch_array($values); $j++) {
                        echo "
                                <td style='text-align: center;'>" . $in->radio($question['num'], $value['id']) . "</td>
                            ";
                    }

                    echo "</tr>";
                    break;
                //-------------------------------------------
                case 16:
                    echo "
                                </table>
                            </div>
                        </div>
                        <div class='container'>
                            <div class='greybox'>
                                <table>
                                    <tr>
                                        <td colspan='3'>17) DURING THE PAST 4 WEEKS, HAVE YOU HAD ANY OF THE FOLLOWING PROBLEMS WITH YOUR WORK OR OTHER REGULAR DAILY ACTIVITIES AS A RESULT OF YOUR PHYSICAL HEALTH?</td>
                                    </tr>
                                    <tr style='text-align: center;'>
                                        <td>&nbsp;</td>
                                        <td>Yes</td>
                                        <td>No</td>
                                    </tr>
                    ";
                case 17:
                case 18:
                case 19:
                    echo "
                        <tr>
                            <td>" . $question['num'] . ") " . $question['question'] . ":</td>
                    ";

                    for ($j = 1; $value = mysql_fetch_array($values); $j++) {
                        echo "
                                <td style='text-align: center;'>" . $in->radio($question['num'], $value['id']) . "</td>
                            ";
                    }

                    echo "</tr>";
                    break;
                //-------------------------------------------
                case 20:
                    echo "
                                </table>
                            </div>
                        </div>
                        <div class='container'>
                            <div class='whitebox'>
                                <table>
                                    <tr>
                                            <td colspan='3'>22) DURING THE PAST 4 WEEKS, HAVE YOU HAD ANY OF THE FOLLOWING PROBLEMS WITH YOUR WORK OR OTHER REGULAR DAILY ACTIVITIES AS A RESULT OF ANY EMOTIONAL PROBLEMS (SUCH AS FEELING DEPRESSED OR ANXIOUS)?</td>
                                    </tr>
                                    <tr style='text-align: center;'>
                                        <td>&nbsp;</td>
                                        <td>Yes</td>
                                        <td>No</td>
                                    </tr>
                    ";
                case 21:
                case 22:
                    echo "
                        <tr>
                            <td>" . $question['num'] . ") " . $question['question'] . ":</td>
                    ";

                    for ($j = 1; $value = mysql_fetch_array($values); $j++) {
                        echo "
                                <td style='text-align: center;'>" . $in->radio($question['num'], $value['id']) . "</td>
                            ";
                    }

                    echo "</tr>";
                    break;
                //-------------------------------------------
                case 23:
                    echo "
                            </table>
                        </div>
                    </div>
                    <div class='container'>
                        <div class='greybox'>
                            <table>                
                ";
                case 24:
                case 25:
                    echo "
                        <tr>
                            <td colspan='6'>" . $question['num'] . ") " . $question['question'] . ":</td>
                        </tr>
                        <tr>
                    ";

                    for ($j = 1; $value = mysql_fetch_array($values); $j++) {
                        echo "
                            <td>" . $in->radio($question['num'], $value['id']) . " " . $value['val'] . "</td>
                        ";
                    }

                    echo "</tr>";
                    break;
                //-------------------------------------------
                case 26:
                    echo "
                            </table>
                        </div>
                    </div>
                    <div class='container'>
                        <div class='whitebox'>
                            <table>
                                <tr>
                                    <td colspan='6'>29) THESE QUESTIONS ARE ABOUT HOW YOU FEEL AND HOW THINGS HAVE BEEN WITH YOU DURING THE <u>PAST 4 WEEKS</u>. FOR EACH QUESTION, PLEASE GIVE THE ONE ANSWER THAT COMES CLOSEST TO THE WAY YOU HAVE BEEN FEELING.</td>
                                </tr>
                                <tr>
                                    <td colspan='6'>30) HOW MUCH OF THE TIME DURING THE <u>PAST 4 WEEKS</u>...</td>
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
                ";
                case 27:
                case 28:
                case 29:
                case 30:
                case 31:
                case 32:
                case 33:
                case 34:
                    echo "
                        <tr>
                            <td>" . $question['num'] . ") " . $question['question'] . ":</td>
                    ";

                    for ($j = 1; $value = mysql_fetch_array($values); $j++) {
                        echo "
                                <td style='text-align: center;'>" . $in->radio($question['num'], $value['id']) . "</td>
                            ";
                    }

                    echo "</tr>";
                    break;
                //-------------------------------------------
                case 35:
                    echo "
                                </table>
                            </div>
                        </div>
                        <div class='container'>
                            <div class='greybox'>
                                <table>
                                    <tr>
                                        <td colspan='5'>" . $question['num'] . ") " . $question['question'] . ":</td>
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
                    ";

                    for ($j = 1; $value = mysql_fetch_array($values); $j++) {
                        echo "
                            <td style='text-align: center;'>" . $in->radio($question['num'], $value['id']) . "</td>
                        ";
                    }

                    echo "</tr>";
                    break;
                //-------------------------------------------
                case 36:
                    echo "
                        <tr>
                            <td colspan='5'>41) HOW TRUE OR FALSE IS <u>EACH</u> OF THE FOLLOWING STATEMENTS FOR YOU?</td>
                        </tr>
                        <tr style='text-align: center;'>
                            <td>&nbsp;</td>
                            <td>Definately true</td>
                            <td>Mostly true</td>
                            <td>Don't know</td>
                            <td>Mostly false</td>
                            <td>Definately false</td>
                        </tr>
                    ";
                case 37:
                case 38:
                case 39:
                    echo "
                        <tr>
                            <td>" . $question['num'] . ") " . $question['question'] . ":</td>
                    ";

                    for ($j = 1; $value = mysql_fetch_array($values); $j++) {
                        echo "
                            <td style='text-align: center;'>" . $in->radio($question['num'], $value['id']) . "</td>
                        ";
                    }

                    echo "</tr>";
                    break;
            }
        }

        echo "
                        </table>
                    </div>
                </div>
                <div class='container'>
                    <div><input type='submit' name='SUBMIT' value='Finish Questionaire' /></div>
                </div>
            </form>
	";

        echo $layout->doFoot();
    } else if (isset($_POST['SUBMIT']) == TRUE) {
        // Date of when you submitted the answers.
        $dateof = time();
        // Add answers to database.
        for ($i = $s; $i <= $e; $i++) {
            if (!empty($_POST[$i])) {
                if ($i != 6 && $i != 17 && $i != 22 && $i != 29 && $i != 30 && $i != 41) {
                    $database->doQuery("INSERT INTO ans_sf36 (dateof, answer, ques_num, pat_id) VALUES ('" . $dateof . "', '" . $_POST[$i] . "', '" . $i . "', '" . $patient->GetId() . "')");
                }
            }
        }

        $patient->InsertScores($dateof);
        // Redirect
        $error->doGo("main.php", "Success!");
    }
}
?>