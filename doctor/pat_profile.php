<?php
date_default_timezone_set("EST");

require_once dirname(dirname(__FILE__)) . '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));

$session = new SessionManager();
$session->validate();

$database = new Database();
$nav = new Navigator();

// Destroy the page if id is not loaded.
$patientID = $_GET['patid'] or die('Patient ID has not been set in URL');
$pat = $database->read(Patient::createRetrievableDatabaseObject($patientID));
$docID = $pat->getDoctor();
$doc = $database->read(Physician::createRetrievableDatabaseObject($docID));

/*if ($session->getUserType() != Admin::tableName || $session->getUserType() != Physician::tableName) 
	{
		$nav->redirectUser($session->getUserType(), Navigator::UNAUTHORIZED_NAVIGATION_ACTION, "Unauthorized User. Please log in.");
	}
*/
?>

<table style="padding-left:15px" align="center" width="500px">
    <tr><th colspan="2">General Information</th></tr>
	<tr>
            <td>First Name:</td>
            <td><?php echo $pat->getFirstName(); ?></td>
    </tr>
 	<tr>
            <td>Last Name:</td>
            <td><?php echo $pat->getLastName(); ?></td>
    </tr>
	<tr>
            <td>Gender:</td>
            <td><?php if ($pat->getSex() == 1)
					  echo "Male";
					  else
					  echo "Female";?></td>
    </tr>
	<tr>
            <td>Birth Day:</td>
            <td><?php echo $pat->getDOBFormatted(); ?></td>
    </tr>
    <tr>
            <td>Age:</td>
            <td><?php echo $pat->getAge(); ?></td>
    </tr>
	<tr>
            <td>Address:</td>
            <td><?php if (!$pat->getStreet() == "") {
                      echo $pat->getStreet() . "<br />";
                	    echo $pat->getCity() . "<br />";
                      echo $pat->getState(). " " . $pat->getZip () . "<br />";
                      }
                      else
                          echo "Address not recorded";
		    ?>
            </td>
    </tr>
	<tr>
            <td>Phone Number:</td>
            <td><?php echo $pat->getPhone(); ?></td>
    </tr>
	<tr>
            <td>Email Address:</td>
            <td><?php echo $pat->getEmail(); ?></td>
    </tr>
    <tr><th colspan="2">Medical Information</th></td>
	<tr>
            <td>Medical Record Number:</td>
            <td><?php echo $pat->getMedicalRecordNumber(); ?></td>
	</tr>
    <tr>
            <td>Extremity:</td>
            <td><?php
				
				$patientEval = new PatientEvalsAssociation($pat);
				$database->createAssociationObject($patientEval);
				//$eval = $patientEval->getEval();
				$evalCheck = $patientEval->getEvalArray();
				if(empty($evalCheck))
				{
					echo "Evaluation not filled";
				}
				else
				{	
					foreach ($patientEval->getEvalArray() as $eval)
					{
					echo $eval->getExtremityFormatted() . "&nbsp; &nbsp; &nbsp; &nbsp;";
					
					}
				}
				?></td>
    </tr>
    <tr>
            <td>Doctor:</td>
            <td><?php echo $doc->getFirstName() ." ". $doc->getLastName(); ?></td>
	</tr>
    <tr><th colspan="2">Login Information</th></tr>
    <tr>
            <td>ID:</td>
            <td><?php echo $pat->getID(); ?></td>
    </tr>
    <tr>
            <td>User Name:</td>
            <td><?php echo $pat->getUserName(); ?></td>
    </tr>
	<tr>
		<td colspan="2">
			<div align="right">
				<button type="button" class="btn btn-primary" onclick="location.href='../doctor/editpatient.php?patid=<?php echo $patientID; ?>'">Edit Patient</button> 
				<button type="button" class="btn btn-info" onclick="location.href='../doctor/patscore.php?patid=<?php echo $patientID; ?>'">Patient Scores</button>
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			</div>
		</td>
	</tr>
</table>