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
$time->CheckDate($patient->GetId(), "ans_mcgillpain", 90);

// Create a query for the questions.
$questions = mysql_query("SELECT * FROM ques_mcgillpain");
// Question number to start from.
$s = 5;
// Last question number.
$e = 29;
// We need a doctor object.
$doc = new Doctor($patient->GetDoctor());

if (isset($_POST['SUBMIT']) == FALSE)
{
    // Load the HTML, CSS.
    echo $layout->loadCSS("PRE-OPERATIVE McGill Pain Questionnaire", "");
    // Header
    echo $layout->doHead($func->doText("PRE-OPERATIVE", "grey"), $func->doText("McGill Pain Questionnaire", "grey"));

    echo "
            <form action='" . $_SERVER['SCRIPT_NAME'] . "' method='post'>
                <div class='container'>
                    <div class='greybox'>
                        <table>
                            <tr>
                                <td>1) Patient name: " . $in->readonly("text", "", $patient->GetFullName()) . "</td>
                                <td colspan='2'>2) Surgeon: " . $in->readonly("text", "", $doc->GetFullName()) . "</td>
                            </tr>
                            <tr>
                                <td>3) " .$func->doReq("Date:"). " <input class='text' type='text' size='4' maxlength='4' name='Y' />-<input class='text' type='text' size='2' maxlength='2' name='M' />-<input class='text' type='text' size='2' maxlength='2' name='D' /></td>
                                <td>4) Extremity: " . $patient->GetExtremity() . "</td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </div>
                </div>
	";

    for ($i = $s; $question = mysql_fetch_array($questions); $i++)
    {
        $values = mysql_query("SELECT * FROM vals_mcgillpain WHERE ques_num = '" . $question['num'] . "'");

        switch ($i)
        {
            case 5:
                echo "
                        <div class='container'>
                            <div class='whitebox'>
                                <table>
                    ";
            case 6:
            case 7:
            case 8:
            case 9:
            case 10:
            case 11:
            case 12:

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
            //-----------------------------
            case 13:
                echo "
                                </table>
                            </div>
                        </div>
                    ";
                echo "
                        <div class='container'>
                            <div class='greybox'>
				<div>RATE PAIN OF BUNION DEFORMITY TO DATE:</div>
                                    <table>
                    ";
            case 14:
            case 15:
            case 16:
            case 17:
            case 18:
            case 19:
            case 20:
            case 21:
            case 22:
            case 23:
            case 24:
            case 25:
            case 26:
            case 27:

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
            //--------------------------------
            case 28:
                echo "
                                </table>
                            </div>
                        </div>
                        <div class='container'>
                            <div class='whitebox'>
                                    <table>
                    ";
            case 29:

                echo "
                    <tr>
                        <td>" . $question['num'] . ") " . $question['question'] . ":</td>
                ";

                for ($j = 1; $value = mysql_fetch_array($values); $j++)
                {
                    switch ($value['id'])
                    {
                        case 94:
                            echo "
                                <td colspan='6'>
                            ";
                        case 95:
                        case 96:
                        case 97:
                        case 98:
                        case 99:
                        case 100:
                        case 101:
                        case 102:
                        case 103:
                            echo $in->radio($question['num'], $value['id']) . " " . $value['val'];
                            break;

                        default:
                            echo "
                                <td>" . $in->radio($question['num'], $value['id']) . " " . $value['val'] . "</td>
                            ";
                            break;
                    }
                }

                echo "
                        </td>
                    </tr>
                ";

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
    // Doctor Id.
    $sur_id = $clean->toInt($doc->GetId());
    
    // Add answers to database.
    for ($i = $s; $i <= $e; $i++)
    {
        if (!empty($_POST[$i]))
        {
            $database->doQuery("INSERT INTO ans_mcgillpain (dateof, answer, ques_num, pat_id, sur_id) VALUES ('" . $dateof . "', '" . $_POST[$i] . "', '" . $i . "', '" . $patient->GetId() . "', '" . $sur_id . "')");
        }
    }

    // Update Activity
    $database->doQuery("INSERT INTO act_mcgillpain (pat_id, dateof) VALUES ('". $patient->GetId() ."', '". $dateof ."')");    
    
    $error->doGo("main.php", "Success!");
}
?>