<?php
date_default_timezone_set("EST");

require_once dirname(dirname(__FILE__)) . '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));

$session = new SessionManager();
$session->validate();

$database = new Database();
$nav = new Navigator();
$layout = new Layout();

// Destroy the page if id is not loaded.
$patientID = $_GET['patid'] or die('Patient ID has not been set in URL');
$pat = $database->read(Patient::createRetrievableDatabaseObject($patientID));
$docID = $pat->getDoctor();
$patientsf36 = new PatientSF36Association($pat);
$database->createAssociationObject($patientsf36);
$counter = 0;
//$sf36 = $patientsf36->getSF36Array();
//var_dump($patientsf36->getSF36Array());
/*if ($session->getUserType() != Admin::tableName || $session->getUserType() != Physician::tableName) 
	{
		$nav->redirectUser($session->getUserType(), Navigator::UNAUTHORIZED_NAVIGATION_ACTION, "Unauthorized User. Please log in.");
	}
*/
?>
<html>
<?php
	echo $layout->loadNavBar('Form Selection Menu', '../');
?>
<link href="../bootstrap/css/mainForms.css" rel="stylesheet">
<div align="center">
	<h3>Patient: <?php echo $pat->getFirstName() . " " . $pat->getLastName()  ?></h3>
	<table class='table table-striped table-bordered' style="width: 10%" >
    <tr><th style='text-align: center;' colspan='9'>SF36 Scores</th></tr>
	<tr>
		<td></td><td>Pre</td><td>3 Mo</td><td>6 Mo</td><td>12 Mo</td>		
	</tr>
	<tr>
            <td>Role Physical Score:</td>
			<?php
			foreach ($patientsf36->getSF36Array() as $sf36)
			{
				echo "<td>". $sf36->getRolePhysicalScore() ."</td>";
				$counter++;
			}
			if ($counter < 5)
			{
				$counter = 4 - $counter;
			}
			for ($i = 0; $i < $counter; $i++)
			{
				echo "<td><p>N/A</p></td>";
			}
			?>
    </tr>
 	<tr>
            <td>Physical Functioning Score:</td>
            <?php
			foreach ($patientsf36->getSF36Array() as $sf36)
			{
				echo "<td>". $sf36->getPhysicalFunctioningScore() ."</td>";
				
			}
			for ($i = 0; $i < $counter; $i++)
			{
				echo "<td><p>N/A</p></td>";
			}
			?>
    </tr>
	<tr>
            <td>Bodily Pain Score:</td>
            <?php
			foreach ($patientsf36->getSF36Array() as $sf36)
			{
				echo "<td>". $sf36->getBodilyPainScore() ."</td>";
				
			}
			for ($i = 0; $i < $counter; $i++)
			{
				echo "<td><p>N/A</p></td>";
			}
			?>
    </tr>
	<tr>
            <td>General Health Score:</td>
            <?php
			foreach ($patientsf36->getSF36Array() as $sf36)
			{
				echo "<td>". $sf36->getGeneralHealthScore() ."</td>";
				
			}
			for ($i = 0; $i < $counter; $i++)
			{
				echo "<td><p>N/A</p></td>";
			}
			?>
    </tr>
    <tr>
            <td>Vitality Score:</td>
            <?php
			foreach ($patientsf36->getSF36Array() as $sf36)
			{
				echo "<td>". $sf36->getVitalityScore() ."</td>";
				
			}
			for ($i = 0; $i < $counter; $i++)
			{
				echo "<td><p>N/A</p></td>";
			}
			?>
    </tr>
	<tr>
            <td>Social Functioning Score:</td>
            <?php
			foreach ($patientsf36->getSF36Array() as $sf36)
			{
				echo "<td>". $sf36->getSocialFunctioningScore() ."</td>";
				
			}
			for ($i = 0; $i < $counter; $i++)
			{
				echo "<td><p>N/A</p></td>";
			}
			?>
    </tr>
	<tr>
            <td>Role Emotional Score:</td>
            <?php
			foreach ($patientsf36->getSF36Array() as $sf36)
			{
				echo "<td>". $sf36->getRoleEmotionalScore() ."</td>";
				
			}
			for ($i = 0; $i < $counter; $i++)
			{
				echo "<td><p>N/A</p></td>";
			}
			?>
    </tr>
	<tr>
            <td>Mental Health Score:</td>
            <?php
			foreach ($patientsf36->getSF36Array() as $sf36)
			{
				echo "<td>". $sf36->getMentalHealthScore() ."</td>";
				
			}
			for ($i = 0; $i < $counter; $i++)
			{
				echo "<td><p>N/A</p></td>";
			}
			?>
    </tr>
    <tr><th style='text-align: center;' colspan='9'>FHSQ</th></td>
	<tr>
            <td>Medical Record Number:</td>
            <td><?php ?></td>
	</tr>
    <tr>
            <td>Extremity:</td>
            <td><?php
				
				
				?></td>
    </tr>
    <tr>
            <td>Doctor:</td>
            <td><?php ?></td>
	</tr>
    <tr><th style='text-align: center;' colspan='9'>McGill Pain Scores</th></tr>
    <tr>
            <td>ID:</td>
            <td><?php ?></td>
    </tr>
    <tr>
            <td>User Name:</td>
            <td><?php ?></td>
    </tr>
	<tr><th style='text-align: center;' colspan='9'>Bristol Foot Index Scores</th></tr>
</table>
</div>
<?php
	echo $layout->loadFooter('../');
?>
</html>