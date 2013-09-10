<?php
date_default_timezone_set("EST");

require_once '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));

$json = new JSONManager();
$demoQuestions = $json->loadJSONQuestions("Demo", "en");
$demoValues = $json->loadJSONValues("Demo", "en");

if (empty($demoQuestions) || empty($demoValues)) {
    die("Unable to load JSON files");
}

$session = new SessionManager();
$session->validate();

$nav = new Navigator();

$database = new Database();
$patient = null;
$patientID = 0;
if ($session->getUserType() === Patient::tableName) {
    $patient = $session->getUserObject();
    $patientID = $patient->getID();
} else {
    $patientID = $_GET['patid'] or die('Patient ID has not been set in URL');
    $patient = $database->read(Patient::createRetrievableDatabaseObject($patientID));
}

$currTime = getdate();

$noInvalidFields = true;
$noEmptyFields = true;
if (isset($_POST['SUBMIT'])) {
    foreach ($_POST as $key => $value) {
        if ($value) {
            switch ($key) {
                case 'M':
                    $monthOptions = array(
                        'options' => array(
                            'min_range' => 1,
                            'max_range' => 12,
                        )
                    );
                    if (filter_var($value, FILTER_VALIDATE_INT, $monthOptions) === false) {
                        echo "<p>$key is not valid</p>";
                        $noInvalidFields = false;
                    }
                    break;
                case 'D':
                case "DAY":
                    $dayOptions = array(
                        'options' => array(
                            'min_range' => 1,
                            'max_range' => 31,
                        )
                    );
                    if (filter_var($value, FILTER_VALIDATE_INT, $dayOptions) == false) {
                        echo "<p>$key is not valid</p>";
                        $noInvalidFields = false;
                    }
                    break;
                case 'Y':
                    $yearOptions = array(
                        'options' => array(
                            'min_range' => 1900,
                            'max_range' => getdate()['year'],
                        )
                    );
                    if (filter_var($value, FILTER_VALIDATE_INT, $yearOptions) == false) {
                        echo "<p>$key is not valid</p>";
                        $noInvalidFields = false;
                    }
                    break;
            }
        } 
    }
    if(($session->getUserType() === Patient::tableName) && (count($_POST) < 10)) {
            echo "<p>You are required to answer every question.</p>";
            $noEmptyFields = false;
        }
    if ($noInvalidFields && $noEmptyFields) {
        $demo = new Demo($patientID, $_POST['M'], $_POST['D'], $_POST['Y']);
        foreach ($_POST as $key => $value) {
            if ($key === 'SUBMIT' || $key === 'M' || $key === 'D' || $key === 'Y') {   //filtering out unwanted keys
            } else {
                $demo->setAnswer($key, $value);
            }
        }
        //echo $demo->generateCreateQuery();
        //var_dump($demo);

        $database->create($demo);
        $nav->redirectUser($session->getUserType(), Navigator::SUBMISSION_NAVIGATION_ACTION, "Demographic Survey successfully submitted");
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>PRE-OPERATIVE Demographic Questionnaire</title>
        <link rel='stylesheet' href='bootstrap/css/sf36_css.css' />
    </head>
    <body>
        <form action="<?php echo $_SERVER['SCRIPT_NAME'], "?patid=", $patientID; ?>" method="POST">
            <div class="container">
                <table>
                    <tr>
                        <td>Patient: <?php echo $patient->getFirstName(), " ", $patient->getLastName(); ?></td>
                    </tr>
                    <tr><td>Date: <input type='text' size='2' name='M' value='<?php echo (isset($_POST['M']) ? $_POST['M'] : $currTime['mon']); ?>'>-
                            <input type='text' size='2' name='D' value='<?php echo (isset($_POST['D']) ? $_POST['D'] : $currTime['mday']); ?>'>-
                            <input type='text' size='4' name='Y' value='<?php echo (isset($_POST['Y']) ? $_POST['Y'] : $currTime['year']); ?>'></td></tr>
                </table>
            </div>
            <div class="container">
			<div class='greybox'>
                <b>1) <?php echo $demoQuestions['Q1']; ?></b>
                <table>
                    <tr>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <?php
                        foreach ($demoValues['Q1'] as $opt) {
                            echo "<td width='200px'>";
                            echo "<input type = 'radio' name = 'Q1'  value = '", $opt['val'], "' ", (isset($_POST['Q1']) && $_POST['Q1'] == $opt['val']) ? "checked='checked'" : "", "/> ", $opt['name'];
                            echo "</td>";
                        }
                        ?>
                    </tr>
                </table>
			</div>	
            </div>
            <div class="container">
			<div class='whitebox'>
                <b>2) <?php echo $demoQuestions['Q2']; ?></b>
                <table>
                    <tr>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <?php
                        foreach ($demoValues['Q2'] as $opt) {
                            echo "<td width='200px'>";
                            echo "<input type = 'radio' name = 'Q2'  value = '", $opt['val'], "' ", (isset($_POST['Q2']) && $_POST['Q2'] == $opt['val']) ? "checked='checked'" : "", "/> ", $opt['name'];
                            echo "</td>";
                        }
                        ?>
                    </tr>
                </table>
			</div>	
            </div>
            <div class="container">
			<div class='greybox'>
                <b>3) <?php echo $demoQuestions['Q3']; ?></b>
                <table>
                    <tr>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <?php
                        foreach ($demoValues['Q3'] as $opt) {
                            echo "<td width='200px'>";
                            echo "<input type = 'radio' name = 'Q3'  value = '", $opt['val'], "' ", (isset($_POST['Q3']) && $_POST['Q3'] == $opt['val']) ? "checked='checked'" : "", "/> ", $opt['name'];
                            echo "</td>";
                        }
                        ?>
                    </tr>
                </table>
			</div>
            </div>
            <div class="container">
			<div class='whitebox'>
                <b>4) <?php echo $demoQuestions['Q4']; ?></b>
                <table>
                    <tr>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <?php
                        foreach ($demoValues['Q4'] as $opt) {
                            echo "<td width='100px'>";
                            echo "<input type = 'radio' name = 'Q4'  value = '", $opt['val'], "' ", (isset($_POST['Q4']) && $_POST['Q4'] == $opt['val']) ? "checked='checked'" : "", "/> ", $opt['name'];
                            echo "</td>";
                        }
                        ?>
                    </tr>
                </table>
			</div>
            </div>
            <div class="container">
			<div class='greybox'>
                <b>5) <?php echo $demoQuestions['Q5']; ?></b>
                <table>
                    <tr>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <?php
                        foreach ($demoValues['Q5'] as $opt) {
                            echo "<td width='200px'>";
                            echo "<input type = 'radio' name = 'Q5'  value = '", $opt['val'], "' ", (isset($_POST['Q5']) && $_POST['Q5'] == $opt['val']) ? "checked='checked'" : "", "/> ", $opt['name'];
                            echo "</td>";
                        }
                        ?>
                    </tr>
                </table>
			</div>	
            </div>
            <div class="container">
			<div class='whitebox'>
                <b>6) <?php echo $demoQuestions['Q6']; ?></b>
                <table>
                    <tr>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <?php
                        foreach ($demoValues['Q6'] as $opt) {
                            echo "<td width='200px'>";
                            echo "<input type = 'radio' name = 'Q6'  value = '", $opt['val'], "' ", (isset($_POST['Q6']) && $_POST['Q6'] == $opt['val']) ? "checked='checked'" : "", "/> ", $opt['name'];
                            echo "</td>";
                        }
                        ?>
                    </tr>
                </table>
			</div>	
            </div>
            <div class='container'>
                <div><input type='submit' name='SUBMIT' value='Submit Demo'></div>
            </div>
        </form>
    </body>
</html>
