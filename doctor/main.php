<?php


require_once "../db.php";                // Database Interaction
require_once "../classes/database.php";  // Database Functions
//require "../classes/clean.php";     // Filter Functions
require_once "../classes/variables.php"; // Global Variables
require_once "../classes/time.php";      // Time Functions
require_once "../classes/functions.php"; // Other Functions
require_once "../classes/layout.php";    // Layout Functions
require_once "../classes/error.php";     // Error Control
require_once "../classes/patient.php";   // Patient Class
require_once "../classes/doctor.php";    // Doctor Class
require_once "../classes/admin.php";     // Admin Class
require_once "../classes/input.php";     // Input Functions
require_once dirname(dirname(__FILE__)).'/classes/PhysicianPatientsAssociation.php';
session_start();                    // Start Session
$database = new Database();
//$clean = new Clean();
$var = new Variables();
$time = new Time();
$func = new Functions();
$layout = new Layout();
$error = new Error();
//$patient = new Patient(@$_SESSION[$var->GetSessionUserId()]);
$physician = $_SESSION[$var->GetSessionDoctorObject()];
//var_dump($physician);
$allPatients = new PhysicianPatientsAssociation($physician);
$database->createAssociationObject($allPatients);
//var_dump($allPatients->getPatientArray());

//$admin = new Admin(@$_SESSION[$var->GetSessionAdminId()]);
$in = new Input();

//if ($doctor->isLogged() == FALSE && $admin->isLogged())
 //   $error->doGo("index.php", "Only for doctors and administrators.");

//$doctor_patients = $database->doQuery("SELECT p.* FROM patients p LEFT OUTER JOIN physicians pp ON (p.doctor = pp.id) WHERE p.doctor = '" . $doctor->GetId() . "' GROUP BY p.username");

// Load the HTML, CSS.
echo $layout->loadCSS("Physician Main Page", "../");
// Load the body.
echo $layout->startBody();

echo "<h3>Physician Main Page</h3>";

// Main Header
//echo $layout->doLinks();

echo "
	<form action='" . $_SERVER['SCRIPT_NAME'] . "' method='post'>
		<div class='container'>
			<div>
				<div>Profile for:</div>
                <div>
                    <select id='users' onchange='doLoad(\"pat_profile.php?id=\" + this.value, true, \"#page\"); doDoctorLinks(this.value)'>
                        <optgroup label='Patients'>
                            <option value='' selected='selected'>Select a Patient:</option>
";

//for ($i = 1; $doctor_patient = $database->doArray($doctor_patients); $i++)
foreach($allPatients->getPatientArray() as $patient)
{
    // Get the id of patients that belong to the doctor.
    //$id = $clean->toInt($doctor_patient['id']);
    // Create an object for each patient.
    //$doc_pat = new Patient($id);
	
    echo "<option value='" . $patient->getId() . "'>" . $patient->getFirstName() . " " . $patient->getLastName() . "</option>";
}

echo "
                        </optgroup>
                    </select>
                </div>
			</div>
		</div>
		<div class='container'>
			<div id='page'>&nbsp;</div>
		</div>
	</form>
";

echo $layout->doLinksFoot();
// End body.
echo $layout->endBody();
// Footer
echo $layout->doFoot();
?>