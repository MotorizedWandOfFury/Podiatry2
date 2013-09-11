<?php
date_default_timezone_set("EST");

require_once dirname(__FILE__) . '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));

$session = new SessionManager();
$session->validate();

$nav = new Navigator();
$func = new Functions();
$database = new Database();
$layout = new Layout();
$patientID = $_GET['patid'] or die('Patient ID has not been set in URL');
$type = $_GET['type'] or die('Form Type has not been set in URL');
$patient = $database->read(Patient::createRetrievableDatabaseObject($patientID));
//$patientsf36 = new PatientSF36Association($patient);
//$database->createAssociationObject($patientsf36);
$label = [1 => "Pre-Op ", 2 => "Post-Op ", 3 => "3 Months ", 4 => "6 Months ", 5 => "12 Months "];
?>
<!DOCTYPE html>
<html>
<?php
	echo $layout->loadNavBar('Form Selection Menu', '');
?>
	<link href="bootstrap/css/selectForm.css" rel="stylesheet">
		<div class="container">
			<form class="admin-form">
					<?php
					if ($type == 1)
					{
						$patientmcgill = new PatientMcgillpainAssociation($patient);
						$database->createAssociationObject($patientmcgill);
						echo "<h2 class='text-left'>Filled McGill Pain Forms</h2>
							  <div class='btn-toolbar'>
						      <div class='btn-group'>
						";
						foreach ($patientmcgill->getMcgillpainArray() as $mcgill)
							{
								echo "<a class='btn' id='selectForm' href='viewandmodifymcgillpain.php?patid=" . $patientID . "&type=" . $mcgill->getType() . "&extremity=" . $mcgill->getExtremity() . "'>". $label[$mcgill->getType()] ."McGill Pain (" . $mcgill->getExtremityFormatted() . ")</a>";
							}
					}
					else if ($type == 2)
					{
						$patientsf36 = new PatientSF36Association($patient);
						$database->createAssociationObject($patientsf36);
						echo "<h2 class='text-left'>Filled SF36 Forms</h2>
							  <div class='btn-toolbar'>
						      <div class='btn-group'>
					    ";
						foreach ($patientsf36->getSF36Array() as $sf36)
							{
								echo "<a class='btn' id='selectForm' href='viewandmodifysf36.php?patid=" . $patientID . "&type=" . $sf36->getType() . "'>". $label[$sf36->getType()] ."SF36</a>";
							}
					}
					else if ($type == 3)
					{
						$patientsfoot = new PatientFootAssociation($patient);
						$database->createAssociationObject($patientsfoot);
						echo "<h2 class='text-left'>Filled Foot Health Forms</h2>
						      <div class='btn-toolbar'>
						      <div class='btn-group'>
					    ";
						foreach ($patientsfoot->getFootArray() as $foot)
							{
								echo "<a class='btn' id='selectForm' href='viewandmodifyfoot.php?patid=" . $patientID . "&type=" . $foot->getType() . "'>". $label[$foot->getType()] ."Foot Health</a>";
							}
					}
					else if ($type == 4)
					{
						$patientsxray = new PatientXraysAssociation($patient);
						$database->createAssociationObject($patientsxray);
						echo "<h2 class='text-left'>Filled X-ray Forms</h2>
							  <div class='btn-toolbar'>
						      <div class='btn-group'>
					    ";
						foreach ($patientsxray->getXraysArray() as $xray)
							{
								echo "<a class='btn' id='selectForm' href='doctor/viewandmodifyxray.php?patid=" . $patientID . "&type=" . $xray->getType() . "'>". $label[$xray->getType()] ."X-rays</a>";
							}
					}
					else if ($type == 5)
					{
						$patientspost = new PatientPostAssociation($patient);
						$database->createAssociationObject($patientspost);
						echo "<h2 class='text-left'>Filled Post-Evaluation Forms</h2>
							  <div class='btn-toolbar'>
						      <div class='btn-group'>
					    ";
						foreach ($patientspost->getPostArray() as $post)
							{
								echo "<a class='btn' id='selectForm' href='doctor/viewandmodifyposteval.php?patid=" . $patientID . "&type=" . $post->getType() . "'>". $label[$post->getType()] ."Evaluation</a>";
							}
					}
					else
					{
						echo "<h4>Form type number invalid.</h4>";
					}
					?>
				</div>
				</div>
			</form>
		</div>
	</body>
	<?php
	echo $layout->loadFooter('');
	?>
</html>    