<?php


require_once "../db.php";                // Database Interaction
require_once "../classes/database.php";  // Database Functions
require_once "../classes/variables.php"; // Global Variables
require_once "../classes/time.php";      // Time Functions
require_once "../classes/functions.php"; // Other Functions
require_once "../classes/error.php";     // Error Control
require_once "../classes/patient.php";   // Patient Class
require_once "../classes/physician.php";    // Doctor Class
require_once "../classes/admin.php";     // Admin Class
require_once "../classes/input.php";     // Input Functions
session_start();                    // Start Session
$database = new Database();
$var = new Variables();
$time = new Time();
$func = new Functions();
$error = new Error();
//$patient = new Patient(@$_SESSION[$var->GetSessionUserId()]);
//$doctor = new Doctor(@$_SESSION[$var->GetSessionDoctorId()]);
//$admin = new Admin(@$_SESSION[$var->GetSessionAdminId()]);
$in = new Input();

//if ($doctor->isLogged() == FALSE && $admin->isLogged() == FALSE)
    $//error->doGo("index.php", "Only for doctors and adminsitrators.");

//echo $layout->loadCSS("Patients SF-36 Score Table", "../");
// Header
//echo $layout->doHead($func->doText("Patients SF-36", "grey"), $func->doText("Score Table", "grey"));

// Create a query for the questions
$scr = $database->doQuery("SELECT * FROM pre_opscore");


echo "
    <table style='margin: auto;' class='data'>
        
        <tr>
            <td width='10%' class='cate'>Patient</td> 
            <td width='10%' class='cate'>Date</td>
            <td width='10%' class='cate'>Physical Functioning</td>
            <td width='10%' class='cate'>Role-Physical</td>
            <td width='10%' class='cate'>Bodily Pain</td>
            <td width='10%' class='cate'>General Health</td>
            <td width='10%' class='cate'>Vitality</td>
            <td width='10%' class='cate'>Social Functioning</td>
            <td width='10%' class='cate'>Role-Emotional</td>
            <td width='10%' class='cate'>Mental Health</td>
       </tr> 
";

for ($i = 0; $sc = $database->doArray($scr); $i++)
{
    // Create a patient.
    $p = new Patient($sc['pat_id']);
    // Generate the scores for the patient.
    $score = new Score($sc['id']);

    echo "
        <tr style='text-align: center;'>
            <td class='" . $func->doRows($i) . "'>" . $p->GetFullName() . "</td> 
            <td class='" . $func->doRows($i) . "'>" . $time->doDate($score->GetDate()) . "</td>
            <td class='" . $func->doRows($i) . "'>" . $clean->toPercent($score->GetPhysicalFunctioning(), 2) . "%</td>
            <td class='" . $func->doRows($i) . "'>" . $clean->toPercent($score->GetRolePhysical(), 2) . "%</td>
            <td class='" . $func->doRows($i) . "'>" . $clean->toPercent($score->GetBodilyPain(), 2) . "%</td>
            <td class='" . $func->doRows($i) . "'>" . $clean->toPercent($score->GetGeneralHealth(), 2) . "%</td>
            <td class='" . $func->doRows($i) . "'>" . $clean->toPercent($score->GetVitality(), 2) . "%</td>
            <td class='" . $func->doRows($i) . "'>" . $clean->toPercent($score->GetSocialFunctioning(), 2) . "%</td>
            <td class='" . $func->doRows($i) . "'>" . $clean->toPercent($score->GetRoleEmotional(), 2) . "%</td>
            <td class='" . $func->doRows($i) . "'>" . $clean->toPercent($score->GetMentalHealth(), 2) . "%</td>
        </tr>
    ";
}

echo"
    </table>
";
?>