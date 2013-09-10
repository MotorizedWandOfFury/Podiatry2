<?php

session_start();                    // Start Session
require "../db.php";                // Database Interaction
require "../classes/database.php";  // Database Functions
require "../classes/clean.php";     // Filter Functions
require "../classes/variables.php"; // Global Variables
require "../classes/time.php";      // Time Functions
require "../classes/functions.php"; // Other Functions
require "../classes/layout.php";    // Layout Functions
require "../classes/error.php";     // Error Control
require "../classes/patient.php";   // Patient Class
require "../classes/doctor.php";    // Doctor Class
require "../classes/admin.php";     // Admin Class
require "../classes/input.php";     // Input Functions
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

if ($doctor->isLogged() == FALSE)
    $error->doGo("index.php", "Only for doctors.");

if (empty($_GET['id']))
    $error->doGo("index.php", "Id not specified.");

// Clean Id.
$pat_id = $clean->toInt($_GET['id']);
// Get Patient
$pat = new Patient($pat_id);
// Create a query for the questions.
$questions = mysql_query("SELECT * FROM ques_xrays");
// Question number to start from.
$s = 4;
// Last question number.
$e = 29;

if (isset($_POST['SUBMIT']) == FALSE)
{
    // Load the HTML, CSS.
    echo $layout->loadCSS("PRE-OPERATIVE X-Ray Evaluation", "../");
    // Header
    echo $layout->doHead($func->doText("PRE-OPERATIVE", "grey"), $func->doText("X-Ray Evaluation", "grey"));

    echo "
            <form action='" . $_SERVER['SCRIPT_NAME'] . "?id=" . $pat_id . "' method='post'>
                    <div class='container'>
                            <div class='greybox'>
                                    <table>
                                            <tr>
                                                    <td>1) Patient: " . $in->readonly("text", "", $pat->GetFullName()) . "</td>
                                                    <td>2) Surgeon: " . $in->readonly("text", "", $doctor->GetFullName()) . "</td>
                                            </tr>
                                            <tr>
                                                    <td>3) Extremity: " . $pat->GetExtremity() . "</td>
                                            
	";

    for ($i = $s; $question = mysql_fetch_array($questions); $i++)
    {

        switch ($i)
        {
            case 4:
                echo "
                            <td>" . $question['num'] . ") " . $question['question'] . ": <input class='text' type='text' size='4' maxlength='4' name='Y' />-<input class='text' type='text' size='2' maxlength='2' name='M' />-<input class='text' type='text' size='2' maxlength='2' name='D' /></td>
                        </tr>
                    ";
                break;
            // ----------------
            case 5:
                echo "
                                </table>
                            </div>
                        </div>
                        <div class='container'>
                            <div class='whitebox'>
                                <table>
                    ";
            case 6:
            case 7:
            case 8:
            case 9:
            case 10:
                echo "
                        <tr>
                            <td>" . $question['num'] . ") " . $question['question'] . ":</td>
                            <td>" . $in->text("text", $question['num']) . "</td>
                        </tr>
                    ";
                break;
            // ------------------------------------
            case 11:
                echo "
                                </table>
                            </div>
                        </div>
                        <div class='container'>
                            <div class='greybox'>
                                <div>If measuring by hand do not complete the remaining items beyond number 10.</div>
                                <div style='float: left;'>
                                    <table>
                    ";
            case 12:
            case 13:
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
            case 28:
            case 29:
                echo "
                        <tr>
                            <td>" . $question['num'] . ") " . $question['question'] . ":</td>
                            <td>" . $in->text("text", $question['num']) . "</td>
                        </tr>
                    ";
                break;
            // ----------------------
            case 30:
                echo "
                                    </table>
                                </div>
                                <div style='float: left;'>
                                    <table>
                    ";
            case 31:
            case 32:
            case 33:
            case 34:
            case 35:
            case 36:
            case 37:
            case 38:
                echo "
                        <tr>
                            <td>" . $question['num'] . ") " . $question['question'] . ":</td>
                            <td>" . $in->text("text", $question['num']) . "</td>
                        </tr>
                    ";
                break;
        }
    }

    echo "
                            </table>
                        </div>
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
        $error->doGo("main.php", "Enter the date.");
    }
    if (empty($_POST['M']))
    {
        $error->doGo("main.php", "Enter the date.");
    }
    if (empty($_POST['D']))
    {
        $error->doGo("main.php", "Enter the date.");
    }

    // Date of submission.
    $dateof = time();
    // Date of xray.
    $dateofxray = mktime(0, 0, 0, $clean->toInt($_POST['M']), $clean->toInt($_POST['D']), $clean->toInt($_POST['Y']));

    // Add answers to database.
    for ($i = $s; $i <= $e; $i++)
    {
        if ($i != 4)
        {
            if (!empty($_POST[$i]))
            {
                $database->doQuery("INSERT INTO ans_xrays (dateof, dateofxrays, answer, ques_num, pat_id, sur_id) VALUES ('" . $dateof . "', '" . $dateofxray . "', '" . $_POST[$i] . "', '" . $i . "', '" . $pat->GetId() . "', '" . $doctor->GetId() . "')");
            }
        }
    }

    $error->doGo("main.php", "Success!");
}
?>