<?php
date_default_timezone_set("EST");

require_once dirname(dirname(__FILE__)) . '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));

$session = new SessionManager();
$session->validate();

$database = new Database();
$nav = new Navigator();

$func = new Functions();
$layout = new Layout();

echo $layout->loadNavBar("All Patients", "../");
echo "
<link href='../bootstrap/css/mainForms.css' rel='stylesheet'>
	<div class='container'>
		<div id='page'>
			<table class='table table-striped table-bordered'>
				<tr>
					<td style='text-align: center;' colspan='9'><b>Patients in Database</b></td>
				</tr>
				<tr style='text-align: center;'>
					<td class='cate' style='width: 5%; text-align: center;'>Id</td>
					<td class='cate' style='width: 15%; text-align: center;'>Last Name</td>
					<td class='cate' style='width: 10%; text-align: center;'>First Name</td>
					<td class='cate' style='width: 10%; text-align: center;'>Extremity</td>
					<td class='cate' style='width: 10%; text-align: center;'>Medical Record Number</td>
					<td class='cate' style='width: 10%; text-align: center;'>Date of Birth</td>
					<td class='cate' style='width: 10%; text-align: center;'>Doctor</td>
                    <td class='cate' style='width: 5%; text-align: center;'>&nbsp;</td>
                    <td class='cate' style='width: 5%; text-align: center;'>&nbsp;</td>
				</tr>
";

$allPatients = new AllPatientsAssociation();
$database->createAssociationObject($allPatients);
$count = 0;
foreach ($allPatients->getPatientsArray() as $admin_pat)
	{
		$patientEval = new PatientEvalsAssociation($admin_pat);
		$database->createAssociationObject($patientEval);
		$doctor = $database->read(Physician::createRetrievableDatabaseObject($admin_pat->getDoctor()));
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
					<td class='" . $func->doRows($i) . "' style='width: 10%; text-align: center;'>" . $doctor->getLastName() . "</td>
					<td class='" . $func->doRows($i) . "' style='width: 5%; text-align: center;'>" .$func->doFormButtonDefault($admin_pat->getId(), $admin_pat->getLastName(), "Forms"). "</td>
					<td class='" . $func->doRows($i) . "' style='width: 5%; text-align: center;'>" .$func->doButton($admin_pat->getId(), $admin_pat->getLastName(), "patProfile", "Profile", 2, $count). "</td>
				</tr>		
			";
			$count++;
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
					<td class='" . $func->doRows($i) . "' style='width: 10%; text-align: center;'>" . $doctor->getLastName() . "</td>
					<td class='" . $func->doRows($i) . "' style='width: 5%; text-align: center;'>" .$func->doFormButton($admin_pat->getId(), $admin_pat->getLastName(), "Forms", $eval->getExtremity()). "</td>
					<td class='" . $func->doRows($i) . "' style='width: 5%; text-align: center;'>" .$func->doButton($admin_pat->getId(), $admin_pat->getLastName(), "patProfile", "Profile", 2, $count). "</td>
				</tr>		
			";
			$count++;
			}
		}
	}

echo "
			</table>
		</div>
	</div>
";
echo $layout->loadFooter("../");
echo "<script src='../bootstrap/js/modal.js'></script>";

?>