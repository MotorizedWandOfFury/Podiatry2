<?php
date_default_timezone_set("EST");

require_once dirname(dirname(__FILE__)) . '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));

$session = new SessionManager();
$session->validate();
 
$func = new Functions();
$database = new Database();
$layout = new Layout();
   
$doctor_id = $_GET['docid'] or die('Doctor ID has not been set in URL');
$allPatients = new PhysicianPatientsAssociation();
$allPatients->setPhysicianId($doctor_id);
$database->createAssociationObject($allPatients);
?>
<html>
	<?php
		echo $layout->loadNavBar('Doctor Main', '../');
	?>
		<link href="../bootstrap/css/mainForms.css" rel="stylesheet">
		<div class='container'>
			<table class='table table-striped table-bordered' width='40%'>
				<tr style='text-align: center;'>
					<td class='head' colspan='8' style='text-align: center;'><b> Dr. <?php echo $_GET['lastName']; ?>'s Patients</b></td>
				</tr>
				<tr style='text-align: center;'>
					<td class='cate' style='width: 5%; text-align: center;'>Id</td>
					<td class='cate' style='width: 15%; text-align: center;'>Last Name</td>
					<td class='cate' style='width: 10%; text-align: center;'>First Name</td>
					<td class='cate' style='width: 10%; text-align: center;'>Extremity</td>
					<td class='cate' style='width: 10%; text-align: center;'>Medical Record Number</td>
					<td class='cate' style='width: 10%; text-align: center;'>Date of Birth</td>
                    <td class='cate' style='width: 5%; text-align: center;'>&nbsp;</td>
                    <td class='cate' style='width: 5%; text-align: center;'>&nbsp;</td>
				</tr>
	<?php
	if ($allPatients->getPatientArray() == 0)
	{
		echo "<b><p style='color:red'>No patients are assigned to this doctor</p></b>";
	}
	else
	{
		$i = 0;
		foreach ($allPatients->getPatientArray() as $admin_pat)
		{
			$patientEval = new PatientEvalsAssociation($admin_pat);
			$database->createAssociationObject($patientEval);
			$evalCheck = $patientEval->getEvalArray();
			if(empty($evalCheck))
			{
				echo "
					<tr>
						<td class='" . $func->doRows($i) . "' style='width: 5%; text-align: center;'>" . $admin_pat->getId() . "</td>
						<td class='" . $func->doRows($i) . "' style='width: 15%; text-align: center;'>" . $admin_pat->getLastName() . "</td>
						<td class='" . $func->doRows($i) . "' style='width: 10%; text-align: center;'>" . $admin_pat->getFirstName() . "</td>
						<td class='" . $func->doRows($i) . "' style='width: 10%; text-align: center;'>Evaluation not filled</td>
						<td class='" . $func->doRows($i) . "' style='width: 10%; text-align: center;'>" . $admin_pat->getMedicalRecordNumber() . "</td>
						<td class='" . $func->doRows($i) . "' style='width: 10%; text-align: center;'>" . $admin_pat->getDOBFormatted() . "</td>
						<td class='" . $func->doRows($i) . "' style='width: 5%; text-align: center;'>" .$func->doFormButtonDefault($admin_pat->getId(), $admin_pat->getLastName(), "Forms"). "</td>
						<td class='" . $func->doRows($i) . "' style='width: 5%; text-align: center;'>" .$func->doButton($admin_pat->getId(), $admin_pat->getLastName(), "patProfile", "Profile", 2). "</td>
					</tr>		
				";
			}
			else 
			{
				foreach ($patientEval->getEvalArray() as $eval)
				{
				echo "
					<tr>
						<td class='" . $func->doRows($i) . "' style='width: 5%; text-align: center;'>" . $admin_pat->getId() . "</td>
						<td class='" . $func->doRows($i) . "' style='width: 15%; text-align: center;'>" . $admin_pat->getLastName() . "</td>
						<td class='" . $func->doRows($i) . "' style='width: 10%; text-align: center;'>" . $admin_pat->getFirstName() . "</td>
						<td class='" . $func->doRows($i) . "' style='width: 10%; text-align: center;'>" . $eval->getExtremityFormatted() . " </td>
						<td class='" . $func->doRows($i) . "' style='width: 10%; text-align: center;'>" . $admin_pat->getMedicalRecordNumber() . "</td>
						<td class='" . $func->doRows($i) . "' style='width: 10%; text-align: center;'>" . $admin_pat->getDOBFormatted() . "</td>
						<td class='" . $func->doRows($i) . "' style='width: 5%; text-align: center;'>" .$func->doFormButton($admin_pat->getId(), $admin_pat->getLastName(), "Forms", $eval->getExtremity()). "</td>
						<td class='" . $func->doRows($i) . "' style='width: 5%; text-align: center;'>" .$func->doButton($admin_pat->getId(), $admin_pat->getLastName(), "patProfile", "Profile", 2). "</td>
					</tr>		
				";
				}
			}
		}	
		echo "
				</table>
			</div>
		";
	}
	?>
	<?php
		echo $layout->loadFooter('../');
	?>
	<script src="../bootstrap/js/modal.js"></script>
</html>	
