<?php

session_start();                 // Start Session
require "db.php";                // Database Interaction
require "classes/database.php";  // Database Functions
require "classes/clean.php";     // Filter Functions
require "classes/variables.php"; // Global Variables
require "classes/time.php";      // Time Functions
require "classes/functions.php"; // Other Functions
require "classes/layout.php";    // Layout Functions
require "classes/error.php";     // Error Control
require "classes/patient.php";   // Patient Class
require "classes/doctor.php";    // Doctor Class
require "classes/admin.php";     // Admin Class
require "classes/input.php";     // Input Functions
$database = new Database();
$clean = new Clean();
$var = new Variables();
$time = new Time();
$func = new Functions();
$layout = new Layout();
$error = new Error();
$patient = new Patient(@$_SESSION[$var->GetSessionUserId()]);
$doctor = new Doctor(@$_SESSION[$var->GetSessionDoctorId()]);
$admin = new Admin(@$_SESSION[$var->GetSessionAdminId()]);
$in = new Input();

if ($patient->isLogged() == FALSE)
    $error->doGo("index.php", "Patients only.");

// Checks to see if a Patient has already completed a survey before 3 months.
$time->CheckDate($patient->GetId(), "ans_foot", 90);

// Create a query for the questions.
$questions = mysql_query("SELECT * FROM ques_foot");
// Question number to start from.
$s = 4;
// Last question number.
$e = 20;

if (isset($_POST['SUBMIT']) == FALSE)
{
    // Load the HTML, CSS.
    echo $layout->loadCSS("PRE-OPERATIVE Foot Health Status Questionnaire", "");
    // Header
    echo $layout->doHead($func->doText("PRE-OPERATIVE", "grey"), $func->doText("FootHealth Status Questionnaire", "grey"));

    echo "
            <form action='" . $_SERVER['SCRIPT_NAME'] . "' method='post'>
                    <div class='container'>
                            <div class='greybox'>
                                    <table>
                                            <tr>
                                                    <td>1) Patient: " . $in->readonly("text", "", $patient->GetFullName()) . "</td>
                                                    <td>2) " . $func->doReq("Date:") . " <input class='text' type='text' size='4' maxlength='4' name='Y' />-<input class='text' type='text' size='2' maxlength='2' name='M' />-<input class='text' type='text' size='2' maxlength='2' name='D' /></td>
                                                    <td colspan='3'>3) Extremity: " . $patient->GetExtremity() . "</td>
                                            </tr>
                                    </table>
                            </div>
                    </div>
                    <div class='container'>
                        <div class='whitebox'>
                            <table>
	";

    for ($i = $s; $question = mysql_fetch_array($questions); $i++)
    {
        $values = mysql_query("SELECT * FROM vals_foot WHERE ques_num = '" . $question['num'] . "'");

        switch ($i)
        {
            case 4:
                echo "
                        <tr>
                            <td>" . $question['num'] . ") " . $question['question'] . ":</td>
                    ";

                for ($j = 1; $value = mysql_fetch_array($values); $j++)
                {
                    echo "
                                <td>" . $in->radio($question['num'], $value['id']) . " " . $value['val'] . "</td>
                            ";
                }

                echo "</tr>";
                break;
            //
            case 5:
                echo "
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
                                            <td>Never</td>
                                            <td>Occasionally</td>
                                            <td>Fairly Many Times</td>
                                            <td>Very Often</td>
                                            <td>Always</td>
                                    </tr>
                    ";
            case 6:
            case 7:
                echo "
                        <tr>
                            <td>" . $question['num'] . ") " . $question['question'] . ":</td>
                    ";

                for ($j = 1; $value = mysql_fetch_array($values); $j++)
                {
                    echo "
                                <td style='text-align: center;'>" . $in->radio($question['num'], $value['id']) . "</td>
                            ";
                }

                echo "</tr>";
                break;
            // ------------------------------
            case 8:
                echo "
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
                                            <td>Not at All</td>
                                            <td>Slightly</td>
                                            <td>Moderately</td>
                                            <td>Quite a Bit</td>
                                            <td>Extremely</td>
                                    </tr>
                    ";
            case 9:
                echo "
                        <tr>
                            <td>" . $question['num'] . ") " . $question['question'] . "</td>
                    ";

                for ($j = 1; $value = mysql_fetch_array($values); $j++)
                {
                    echo "
                                <td style='text-align: center;'>" . $in->radio($question['num'], $value['id']) . "</td>
                            ";
                }

                echo "</tr>";
                break;
            // -----------------------------------
            case 10:
                echo "
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
                                            <td>Not at All</td>
                                            <td>Slightly</td>
                                            <td>Moderately</td>
                                            <td>Quite a Bit</td>
                                            <td>Extremely</td>
                                    </tr>
                    ";
            case 11:
            case 12:
                echo "
                        <tr>
                            <td>" . $question['num'] . ") " . $question['question'] . "</td>
                    ";

                for ($j = 1; $value = mysql_fetch_array($values); $j++)
                {
                    echo "
                                <td style='text-align: center;'>" . $in->radio($question['num'], $value['id']) . "</td>
                            ";
                }

                echo "</tr>";
                break;
            // -----------------------------
            case 13:
                echo "
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
                                            <td>Strongly Agree</td>
                                            <td>Agree</td>
                                            <td>Neither agree or Disagree</td>
                                            <td>Disagree</td>
                                            <td>Strongly Disagree</td>
                                    </tr>
                    ";
            case 14:
            case 15:
                echo "
                        <tr>
                            <td>" . $question['num'] . ") " . $question['question'] . "</td>
                    ";

                for ($j = 1; $value = mysql_fetch_array($values); $j++)
                {
                    echo "
                                <td style='text-align: center;'>" . $in->radio($question['num'], $value['id']) . "</td>
                            ";
                }

                echo "</tr>";
                break;
            // -------------------------
            case 16:
                echo "
                        <tr>
                            <td>" . $question['num'] . ") " . $question['question'] . "</td>
                            <td style='text-align: center;'>Excellent</td>
                            <td style='text-align: center;'>Very Good</td>
                            <td style='text-align: center;'>Good</td>
                            <td style='text-align: center;'>Fair</td>
                            <td style='text-align: center;'>Poor</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                    ";

                for ($j = 1; $value = mysql_fetch_array($values); $j++)
                {
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
}
else if (isset($_POST['SUBMIT']) == TRUE)
{
    if (empty($_POST['Y']))
    {
        $error->doGo("main.php", "Fill in the date.");
    }
    if (empty($_POST['M']))
    {
        $error->doGo("main.php", "Fill in the date.");
    }
    if (empty($_POST['D']))
    {
        $error->doGo("main.php", "Fill in the date.");
    }
    // Date of when you submitted the answers.
    $dateof = mktime(0, 0, 0, $clean->toInt($_POST['M']), $clean->toInt($_POST['D']), $clean->toInt($_POST['Y']));
    // Add answers to database.
    for ($i = $s; $i <= $e; $i++)
    {
        if ($i != 5 && $i != 9 && $i != 12 && $i != 16)
        {
            if (!empty($_POST[$i]))
            {
                $database->doQuery("INSERT INTO ans_foot (dateof, answer, ques_num, pat_id) VALUES ('" . $dateof . "', '" . $_POST[$i] . "', '" . $i . "', '" . $patient->GetId() . "')");
            }
        }
    }
    
    // Update Activity
    $database->doQuery("INSERT INTO act_foot (pat_id, dateof) VALUES ('". $patient->GetId() ."', '". $dateof ."')");    

    $error->doGo("main.php", "Success!");
}
?>