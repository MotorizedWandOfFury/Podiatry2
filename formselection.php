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
$counter = 1;
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
						echo "<h2 class='text-left'>Filled McGill Pain Forms</h2>";
						foreach ($patientmcgill->getMcgillpainArray() as $mcgill)
						{
							if ($counter < 6)
							{
								echo "<a class='btn' id='selectForm' href='viewandmodifymcgillpain.php?patid=" . $patientID . "&type=" . $mcgill->getType() . "&extremity=" . $mcgill->getExtremity() . "'>". $label[$mcgill->getType()] ."McGill Pain (" . $mcgill->getExtremityFormatted() . ")</a>";
							}
							else if ($counter == 6)
							{	
								echo "<br> </br>
								<a class='btn' id='selectForm' href='viewandmodifymcgillpain.php?patid=" . $patientID . "&type=" . $mcgill->getType() . "&extremity=" . $mcgill->getExtremity() . "'>". $label[$mcgill->getType()] ."McGill Pain (" . $mcgill->getExtremityFormatted() . ")</a>";
							}
							else
							{	
								echo "<a class='btn' id='selectForm' href='viewandmodifymcgillpain.php?patid=" . $patientID . "&type=" . $mcgill->getType() . "&extremity=" . $mcgill->getExtremity() . "'>". $label[$mcgill->getType()] ."McGill Pain (" . $mcgill->getExtremityFormatted() . ")</a>";
							}
								$counter++;
						}
					}
					else if ($type == 2)
					{
						$patientsf36 = new PatientSF36Association($patient);
						$database->createAssociationObject($patientsf36);
						echo "<h2 class='text-left'>Filled SF36 Forms</h2>";
						foreach ($patientsf36->getSF36Array() as $sf36)
						{
							if ($counter < 5)
							{
								echo "<a class='btn' id='selectForm' href='viewandmodifysf36.php?patid=" . $patientID . "&type=" . $sf36->getType() . "&extremity=" .  $sf36->getExtremity() . "'>". $label[$sf36->getType()] ."SF36 (" . $sf36->getExtremityFormatted() . ")</a>";
							}
							else if ($counter = 5)
							{
								echo "<br> <bf />
								<a class='btn' id='selectForm' href='viewandmodifysf36.php?patid=" . $patientID . "&type=" . $sf36->getType() . "&extremity=" .  $sf36->getExtremity() . "'>". $label[$sf36->getType()] ."SF36 (" . $sf36->getExtremityFormatted() . ")</a>";
							}
							else
							{
								echo "<a class='btn' id='selectForm' href='viewandmodifysf36.php?patid=" . $patientID . "&type=" . $sf36->getType() . "&extremity=" .  $sf36->getExtremity() . "'>". $label[$sf36->getType()] ."SF36 (" . $sf36->getExtremityFormatted() . ")</a>";
							}
							$counter++;
						}
					}	
					else if ($type == 3)
					{
						$patientsfoot = new PatientFootAssociation($patient);
						$database->createAssociationObject($patientsfoot);
						echo "<h2 class='text-left'>Filled Foot Health Forms</h2>";
						foreach ($patientsfoot->getFootArray() as $foot)
						{
							if ($counter < 5)
							{
								echo "<a class='btn' id='selectForm' href='viewandmodifyfoot.php?patid=" . $patientID . "&type=" . $foot->getType() . "&extremity=" . $foot->getExtremity() . "'>". $label[$foot->getType()] ."Foot Health (" . $foot->getExtremityFormatted() . ")</a>";
							}
							else if ($counter = 5)
							{
								echo "<br> <br/>
								<a class='btn' id='selectForm' href='viewandmodifyfoot.php?patid=" . $patientID . "&type=" . $foot->getType() . "&extremity=" . $foot->getExtremity() . "'>". $label[$foot->getType()] ."Foot Health (" . $foot->getExtremityFormatted() . ")</a>";
							}
							else
							{
								echo "<a class='btn' id='selectForm' href='viewandmodifyfoot.php?patid=" . $patientID . "&type=" . $foot->getType() . "&extremity=" . $foot->getExtremity() . "'>". $label[$foot->getType()] ."Foot Health (" . $foot->getExtremityFormatted() . ")</a>";
							}
							$counter++;
						}
					}
					else if ($type == 4)
					{
						$patientsxray = new PatientXraysAssociation($patient);
						$database->createAssociationObject($patientsxray);
						echo "<h2 class='text-left'>Filled X-ray Forms</h2>";
						foreach ($patientsxray->getXraysArray() as $xray)
						{
							if ($counter < 5)
							{
								echo "<a class='btn' id='selectForm' href='doctor/viewandmodifyxray.php?patid=" . $patientID . "&type=" . $xray->getType() . "&extremity=" . $xray->getExtremity() . "'>". $label[$xray->getType()] ."X-rays (" . $xray->getExtremityFormatted() . ")</a>";
							}
							else if ($counter = 5)
							{
								echo "<br><br />
								<a class='btn' id='selectForm' href='doctor/viewandmodifyxray.php?patid=" . $patientID . "&type=" . $xray->getType() . "&extremity=" . $xray->getExtremity() . "'>". $label[$xray->getType()] ."X-rays (" . $xray->getExtremityFormatted() . ")</a>";
							}
							else
							{
								echo "<a class='btn' id='selectForm' href='doctor/viewandmodifyxray.php?patid=" . $patientID . "&type=" . $xray->getType() . "&extremity=" . $xray->getExtremity() . "'>". $label[$xray->getType()] ."X-rays (" . $xray->getExtremityFormatted() . ")</a>";
							}
							$counter++;
						}
					}
					else if ($type == 5)
					{
						$patientspost = new PatientPostAssociation($patient);
						$database->createAssociationObject($patientspost);
						echo "<h2 class='text-left'>Filled Post-Evaluation Forms</h2>";
						foreach ($patientspost->getPostArray() as $post)
						{
							if ($counter < 5)
							{
								echo "<a class='btn' id='selectForm' href='doctor/viewandmodifyposteval.php?patid=" . $patientID . "&type=" . $post->getType() . "&extremity=" . $post->getExtremity() . "'>". $label[$post->getType()] ."Evaluation (" . $post->getExtremityFormatted() . ")</a>";
							}
							else if ($counter = 5)
							{
								echo "<br> </br>
								<a class='btn' id='selectForm' href='doctor/viewandmodifyposteval.php?patid=" . $patientID . "&type=" . $post->getType() . "&extremity=" . $post->getExtremity() . "'>". $label[$post->getType()] ."Evaluation (" . $post->getExtremityFormatted() . ")</a>";
							}
							else
							{
								echo "<a class='btn' id='selectForm' href='doctor/viewandmodifyposteval.php?patid=" . $patientID . "&type=" . $post->getType() . "&extremity=" . $post->getExtremity() . "'>". $label[$post->getType()] ."Evaluation (" . $post->getExtremityFormatted() . ")</a>";
							}
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