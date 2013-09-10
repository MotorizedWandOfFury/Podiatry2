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
	echo $layout->loadNavBar('SF36 Selection Menu', '');
?>
	<link href="bootstrap/css/mainForms.css" rel="stylesheet">
		<div class="container">
			<form class="admin-form">
				<div class="btn-toolbar">
				<div class="btn-group">
					<?php
					if ($type == 1)
					{
						$patientmcgill = new PatientMcgillpainAssociation($patient);
						$database->createAssociationObject($patientmcgill);
						//$label = [1 => "Pre-Op SF36", 2 => "Post-Op SF36", 3 => "3 Months SF36", 4 => "6 Months SF36", 5 => "12 Months SF36"];
						echo "<h2 class='text-center'>Filled SF36 Forms</h2>";
						foreach ($patientmcgill->getMcgillpainArray() as $mcgill)
							{
								echo "<a class='btn' id='selectForm' href='viewandmodifysf36.php?patid=" . $patientID . "&type=" . $mcgill->getType() . "'>". $label[$mcgill->getType()] ."McGill Pain</a>";
							}
					}
					 else if ($type == 2)
					{
						$patientsf36 = new PatientSF36Association($patient);
						$database->createAssociationObject($patientsf36);
						//$label = [1 => "Pre-Op SF36", 2 => "Post-Op SF36", 3 => "3 Months SF36", 4 => "6 Months SF36", 5 => "12 Months SF36"];
						echo "<h2 class='text-center'>Filled SF36 Forms</h2>";
						foreach ($patientsf36->getSF36Array() as $sf36)
							{
								echo "<a class='btn' id='selectForm' href='viewandmodifysf36.php?patid=" . $patientID . "&type=" . $sf36->getType() . "'>". $label[$sf36->getType()] ."SF36</a>";
							}
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