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
require "../classes/score.php";     // Score Functions
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
    exit();
// Clean the id.
$id = $clean->toInt($_GET['id']);
// Load the patient data.
$pat = new Patient($id);
$date = $clean->toInt($_GET['date']);


// Load the HTML, CSS.
echo $layout->loadCSS("patient results", "../");
// Load the body.
echo $layout->startBody();
// Main Header
echo $layout->doLinks();

$arr = '';
$var = 0;

//patient demo in the activity table
$demo = $database->doQuery("SELECT COUNT(*) AS number, dateof FROM act_demo WHERE pat_id = '" . $pat->GetId() . "'");
$demos = $database->doArray($demo);

if ($demos['number'] >= 1)
    $arr.='1';

// Patient Exams for SF-36
$sf36_exams = $database->doQueryArray("SELECT COUNT(dateof) AS number FROM pre_opscore where pat_id = '" . $pat->GetId() . "'");
if ($sf36_exams['number'] >= 1)
    $arr.='2';


//patient foot in the activity table
$foot = $database->doQuery("SELECT COUNT(dateof) AS number, dateof FROM act_foot WHERE pat_id = '" . $pat->GetId() . "'");
$foots = $database->doArray($foot);
if ($foots['number'] >= 1)
    $arr.='3';



//patient mcgill pain in the activity table
$mc = $database->doQuery("SELECT COUNT(dateof) AS number, dateof FROM act_mcgillpain WHERE pat_id = '" . $pat->GetId() . "'");
$mcs = $database->doArray($mc);
if ($mcs['number'] >= 1)
    $arr.='4';

for ($k = 0; $k < strlen($arr); $k++) {

    switch ($arr[$k]) {
        case 1:
            $table = "act_demo";
            $ques = "ques_demo";
            $ans = "ans_demo";
            $vals = "vals_demo";
            $name = "Demographic questionnaire";
            break;
        case 2:
            $table = "pre_opscore";
            $ques = "ques_sf36";
            $ans = "ans_sf36";
            $vals = "vals_sf36";
            $name = "SF-36";
            break;
        case 3:
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
            $name = "SF-36";
            break;
    }

    $questions = $database->doQuery("SELECT id, dateof FROM " . $table . " where pat_id = '" . $pat->GetId() . "'");



    for ($i = 0; $question = $database->doArray($questions); $i++) {

        $sel = $database->doQuery("
        SELECT  p.firstname, a.dateof, a.ques_num, q.question, v.val FROM " . $vals . " v RIGHT OUTER JOIN " . $ans . " a       
        ON (a.answer = v.id) LEFT OUTER JOIN patients p ON (p.id = a.pat_id) LEFT OUTER JOIN " . $ques . " q 
        ON(q.num = a.ques_num) LEFT OUTER JOIN " . $table . " ps ON (ps.dateof = a.dateof)
        WHERE p.id = a.pat_id AND a.answer=v.id AND ps.id = '" . $question['id'] . "' GROUP BY a.answer
    ");
        

        echo "
        <table class='data' style= 'margin-bottom: 5px; width: 100%;'>
            <tr>
                <td class='head' colspan= '3'>Results for " . $name . " on " . $time->doDate($question['dateof']) . "</td>
            </tr>
            <tr>
                <td width='5%' class='cate'>#</td>
                <td width='75%' class='cate'>Question</td>
                <td width='30%' class='cate'>Answer</td>
            </tr> 
    ";

        for ($j = 0; $slct = $database->doArray($sel); $j++) {
            echo "
            <tr>
                <td style='text-align: center;' class='" . $func->doRows($j) . "'> " . $clean->toInt($slct['ques_num']) . "</td>
                <td class='" . $func->doRows($j) . "'> " . $slct['question'] . "</td>    
                <td style='text-align: center;' class='" . $func->doRows($j) . "'> " . $slct['val'] . "</td>        
            </tr>
        ";
        }

        echo "
        </table>
    ";
    }
}


echo $layout->doLinksFoot();
// End body.
echo $layout->endBody();
// Footer
echo $layout->doFoot();
?>
