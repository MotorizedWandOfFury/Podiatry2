<?php

session_start();                    // Start Session
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
require "classes/score.php";     // Score Class
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

// Destroy the page if id is not loaded.
if (empty($_GET['id']))
    die();

if (empty($_GET['date']))
    die();

if (empty($_GET['exam'])) {
    die();
} else if (!empty($_GET['exam'])) {
    // Clean the Id.
    $exam = $clean->toInt($_GET['exam']);
    // Determine which exam we would like to view results of.
    switch ($exam) {
        case 1:
            $table = "act_demo";
            $ques = "ques_demo";
            $ans = "ans_demo";
            $vals = "vals_demo";
            $name="Demographic questionnaire";
            break;
        case 3:
            $table = "pre_opscore";
            $ques = "ques_sf36";
            $ans = "ans_sf36";
            $vals = "vals_sf36";
            $name= "SF-36";
            break;
        case 2:
            $table = "act_foot";
            $ques = "ques_foot";
            $ans = "ans_foot";
            $vals = "vals_foot";
            $name = "Foot health";
            break;
        case 4:
            $table = "act_mcgillpain";
            $ques = "ques_mcgillpain";
            $ans = "ans_mcgillpain";
            $vals = "vals_mcgillpain";
            $name = "Mc gill pain";
            break;
        default:
            $table = "pre_opscore";
            $ques = "ques_sf36";
            $ans = "ans_sf36";
            $vals = "vals_sf36";
            break;
    }
}

// Clean the date.
$dateof = $clean->toInt($_GET['date']);
// Clean the id.
$id = $clean->toInt($_GET['id']);
// Load the patient data.
$pat = new Patient($id);

$questions = $database->doQuery("SELECT id, dateof FROM " . $table . " where pat_id = '" . $pat->GetId() . "' AND dateof = '" . $dateof . "'");

for ($i = 0; $question = $database->doArray($questions); $i++) {

    $questions = $database->doQuery("
        SELECT  p.firstname, a.dateof, a.ques_num, q.question, v.val FROM " . $vals . " v RIGHT OUTER JOIN " . $ans . " a       
        ON (a.answer = v.id) LEFT OUTER JOIN patients p ON (p.id = a.pat_id) LEFT OUTER JOIN " . $ques . " q 
        ON(q.num = a.ques_num) LEFT OUTER JOIN " . $table . " ps ON (ps.dateof = a.dateof)
        WHERE p.id = a.pat_id AND a.answer=v.id AND ps.id = '" . $question['id'] . "' GROUP BY a.answer
    ");

    echo "
        <table class='data' style= 'margin:auto;'>
            <tr>
                <td class='head' colspan= '3'>Results for ". $name ." on " . $time->doDate($dateof) . "</td>
            </tr>
            <tr>
                <td width='5%' class='cate'>#</td>
                <td width='75%' class='cate'>Question</td>
                <td width='30%' class='cate'>Answer</td>
            </tr> 
    ";

    for ($j = 0; $question = $database->doArray($questions); $j++) {
        echo "
            <tr>
                <td style='text-align: center;' class='" . $func->doRows($j) . "'> " . $clean->toInt($question['ques_num']) . "</td>
                <td class='" . $func->doRows($j) . "'> " . $question['question'] . "</td>    
                <td style='text-align: center;' class='" . $func->doRows($j) . "'> " . $question['val'] . "</td>        
            </tr>
        ";
    }

    echo "
        </table>
    ";
}
?>
