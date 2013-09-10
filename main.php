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

if ($patient->isLogged() == FALSE)
    $error->doGo("index.php", "Patients only.");

//patient demo in the activity table
$demo = $database->doQuery("SELECT dateof FROM act_demo WHERE pat_id = '" .$patient->GetId(). "'");
// Patient Exams for SF-36
$sf36_exams = $database->doQuery("SELECT dateof FROM pre_opscore where pat_id = '" . $patient->GetId() . "'");
//patient foot in the activity table
$foot = $database->doQuery("SELECT dateof FROM act_foot WHERE pat_id = '" .$patient->GetId(). "'");
//patient mcgill pain in the activity table
$mc = $database->doQuery("SELECT dateof FROM act_mcgillpain WHERE pat_id = '" .$patient->GetId(). "'");


// Load the HTML, CSS.
echo $layout->loadCSS("Patient Page", "");
// Load the body of the page.
echo $layout->startBody();

echo "<h3>Main Patient Page</h3>";

// Main Header
echo $layout->doLinks();

// Each survey will be displayed here.
/**
echo "
    	<form action='" . $_SERVER['SCRIPT_NAME'] . "' method='post'>
		<div class='container'>
			<div>
				Demographic ss: <select id='users' onchange='doLoad(\"exam.php?id=" . $patient->GetId() . "&exam=1&date=\" + this.value, false, \"#page\");'>
					<optgroup label='Demographic Examinations'>
						<option value='' selected='selected'>Demographic Exam:</option>";


for ($i = 1; $demo = $database->doArray($demo); $i++) {
    // Get the id of patients that belong to the doctor.
    $date = $clean->toInt($demo['dateof']);

    echo "
		<option value='" . $date . "'>" . $time->doDate($date) . "</option>
	";
}

echo "
                        </optgroup>
                        </select>
                        SF-36: <select id='userss' onchange='doLoad(\"exam.php?id=" . $patient->GetId() . "&exam=3&date=\" + this.value, false, \"#page\");'>
                                        <optgroup label='SF-36 questionnaire'>
                                            <option value='' selected='selected'>SF-36 Exam:</option>
";


for ($i = 1; $sf36_exam = $database->doArray($sf36_exams); $i++) {
    // Get the id of patients that belong to the doctor.
    $date = $clean->toInt($sf36_exam['dateof']);

    echo "
		<option value='" . $date . "'>" . $time->doDate($date) . "</option>
	";
}

echo "
                        </optgroup>
                        </select>
                        Foot Health: <select id='userss' onchange='doLoad(\"exam.php?id=" . $patient->GetId() . "&exam=2&date=\" + this.value, false, \"#page\");'>
                                        <optgroup label='Foot health examination'>
                                             <option value='' selected='selected'>Foot Health:</option>
";

for ($i = 1; $foot = $database->doArray($foot); $i++) {
    // Get the id of patients that belong to the doctor.
    $date = $clean->toInt($foot['dateof']);

    echo "
		<option value='" . $date . "'>" . $time->doDate($date) . "</option>
	";
}

echo "
                        </optgroup>
                        </select>
                        Mc gill pain: <select id='userss' onchange='doLoad(\"exam.php?id=" . $patient->GetId() . "&exam=4&date=\" + this.value, false, \"#page\");'>
                                        <optgroup label='Mc gill pain examination'>
                                             <option value='' selected='selected'>Mc gill pain:</option>
";

for ($i = 1; $mc = $database->doArray($mc); $i++) {
    // Get the id of patients that belong to the doctor.
    $date = $clean->toInt($mc['dateof']);

    echo "
		<option value='" . $date . "'>" . $time->doDate($date) . "</option>
	";
}
*/
echo "
                            </optgroup>
                        </select>
                    </div>
            </div>
            <div class='container'>
                <div id='page'>&nbsp;</div>
            </div>
        </form>
";

// Main Header
echo $layout->doLinksFoot();
// End the body of the page.
echo $layout->endBody();
// Footer
echo $layout->doFoot();
?>
