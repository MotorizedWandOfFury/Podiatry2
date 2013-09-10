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
// Create a query for the questions
$questions = mysql_query("SELECT * FROM ques_post");
// Question number to start from.
$s = 4;
// Last question number.
$e = 14;

if (isset($_POST['SUBMIT']) == FALSE)
{
    // Load the HTML, CSS.
    echo $layout->loadCSS("1ST POST-OPERATVE Evaluation", "../");
    // Header
    echo $layout->doHead($func->doText("1st POST-OPERATIVE", "grey"), $func->doText("Evaluation", "grey"));

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
        $values = mysql_query("SELECT * FROM vals_post WHERE ques_num = '" . $question['num'] . "'");

        switch ($i)
        {
            case 4:
                echo "
                            <td>" . $question['num'] . ") " . $question['question'] . ": <input class='text' type='text' size='4' maxlength='4' name='Y' />-<input class='text' type='text' size='2' maxlength='2' name='M' />-<input class='text' type='text' size='2' maxlength='2' name='D' /></td>
                        </tr>
                    ";
                break;
            // --------------
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
                echo "
                        <tr>
                            <td>" . $question['num'] . ") " . $question['question'] . ":</td>
                            <td>" . $in->text("text", $question['num']) . "</td>
                        </tr>
                    ";
                break;
            // ------------
            case 7:
            case 8:
                echo "
                        <tr>
                            <td>" . $question['num'] . ") " . $question['question'] . ":
                    ";

                for ($j = 1; $value = mysql_fetch_array($values); $j++)
                {
                    echo $in->radio($question['num'], $value['id']) . " " . $value['val'];
                }

                echo "
                            </td>
                        </tr>
                    ";
                break;
            // ---------------------
            case 9:
                echo "
                                </table>
                            </div>
                        </div>
                        <div class='container'>
                            <div class='greybox'>
                                <table>
                                    <tr style='text-align: center;'>
                                        <td>&nbsp;</td>
                                        <td>None</td>
                                        <td>Periwound</td>
                                        <td>Dorso-Medial</td>
                                        <td>Entire Dorsum</td>
                                        <td>Circum-ferential</td>
                                    </tr>
                    ";
            case 10:
            case 11:
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
            // ------------------------
            case 12:
                echo "
                                </table>
                            </div>
                        </div>
                        <div class='container'>
                            <div class='whitebox'>
                                <table>
                                    <tr style='text-align: center;'>
                                        <td>&nbsp;</td>
                                        <td>None</td>
                                        <td>Seeping part of incision</td>
                                        <td>Seeping whole incision</td>
                                        <td>Hematoma</td>
                                        <td>Active bleeding</td>
                                    </tr>
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
            case 13:
                echo "
                                </table>
                            </div>
                        </div>
                        <div class='container'>
                            <div class='greybox'>
                                <table>
                                    <tr style='text-align: center;'>
                                        <td>&nbsp;</td>
                                        <td>None</td>
                                        <td>< half incision</td>
                                        <td>> half incision</td>
                                        <td>Whole incision</td>
                                        <td>Necrosis</td>
                                    </tr>
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
            // -----------------
            case 14:
                echo "
                                </table>
                            </div>
                        </div>
                        <div class='container'>
                            <div class='whitebox'>
                                <table>
                                    <tr style='text-align: center;'>
                                        <td>&nbsp;</td>
                                        <td>None</td>
                                        <td>Suture abscess</td>
                                        <td>Local cellulitis</td>
                                        <td>Abscess</td>
                                        <td>Osteomyelitis</td>
                                    </tr>
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
        }
    }


    echo "
                        </table>
                    </div>
                </div>
                <div class='container'>
                    <div><input type='submit' name='SUBMIT' value='Finish Questionaire' /></div>
                    <div>Please fill out complications form as needed.</div>
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
    $dateofexam = mktime(0, 0, 0, $clean->toInt($_POST['M']), $clean->toInt($_POST['D']), $clean->toInt($_POST['Y']));
    // Days of pain meds.
    $days = $clean->toInt($_POST['5']);
    // Dose of pain meds.
    $dose = $clean->toInt($_POST['6']);

    // Add answers to database.
    for ($i = $s; $i <= $e; $i++)
    {
        if ($i != 4)
        {
            if (!empty($_POST[$i]))
            {
                $database->doQuery("INSERT INTO ans_post (dateof, dateofexam, painmedused, dosepainmedused, answer, ques_num, pat_id, sur_id) VALUES ('" . $dateof . "', '" . $dateofexam . "', '" . $days . "', '" . $dose . "', '" . $_POST[$i] . "', '" . $i . "', '" . $pat->GetId() . "', '" . $doctor->GetId() . "')");
            }
        }
    }

    $error->doGo("main.php", "Success!");
}
?>
