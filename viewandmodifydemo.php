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
$func = new Functions();


$mode = isset($_GET['mode']) ? $_GET['mode'] : "view"; // default mode for page is viewing, if the mode attribute has not been set

$database = new Database();
$patientID = filter_var($_GET['patid'], FILTER_VALIDATE_INT) or die("Patient ID not set");
$patient = $database->read(Patient::createRetrievableDatabaseObject($patientID));
$demo = $database->read(Demo::createRetrievableDatabaseObject($patientID)) or die("Demographic form has not been filled out.");


if ($mode === 'edit') { // make sure we are in edit mode before we can make changes
    if (isset($_POST['SUBMIT'])) {
        foreach ($_POST as $key => $value) {
            if ($key === 'SUBMIT') {
                
            } else {
                $demo->setAnswer($key, $value);
            }
        }
        //echo $demo->generateUpdateQuery();
        //var_dump($demo);

        $database->update($demo);
        $nav->redirectUser($session->getUserType(), Navigator::SUBMISSION_NAVIGATION_ACTION, "Patient Demographics successfully updated");
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
		&nbsp;
        <a href="<?php echo $_SERVER['SCRIPT_NAME'] . "?patid=" . $patientID . "&mode=view"; ?>">View</a> | <a href="<?php echo $_SERVER['SCRIPT_NAME'] . "?patid=" . $patientID . "&mode=edit"; ?>">Edit</a>
        <form action="<?php echo $_SERVER['SCRIPT_NAME'] . "?patid=" . $patientID . "&mode=" . $mode; ?>" method="POST">
            <div class="container">
                <table>
                    <tr>
                        <td>Patient: <?php echo $patient->getFirstName(), " ", $patient->getLastName(); ?></td>
                    </tr>
                    <tr>
                        <td>Date: <?php echo $demo->getDateOfFormatted(); ?></td>
                    </tr>
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
                                echo "<input type = 'radio' name = 'Q1'  value = '" . $opt['val'] . "' " . (($demo->getAnswer("Q1") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
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
                                echo "<input type = 'radio' name = 'Q2'  value = '" . $opt['val'] . "' " . (($demo->getAnswer("Q2") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
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
                                echo "<input type = 'radio' name = 'Q3'  value = '" . $opt['val'] . "' " . (($demo->getAnswer("Q3") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> ", $opt['name'];
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
                                echo "<td width='200px'>";
                                echo "<input type = 'radio' name = 'Q4'  value = '" . $opt['val'] . "' " . (($demo->getAnswer("Q4") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> ", $opt['name'];
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
                                echo "<input type = 'radio' name = 'Q5'  value = '" . $opt['val'] . "' " . (($demo->getAnswer("Q5") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> ", $opt['name'];
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
                                echo "<input type = 'radio' name = 'Q6'  value = '" . $opt['val'] . "' " . (($demo->getAnswer("Q6") == $opt['val']) ? "checked='checked'" : "") . $func->disableElement($mode) . "/> ", $opt['name'];
                                echo "</td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>	
            </div>
            <div class='container'>
                <div><input type='submit' name='SUBMIT' value='Update Demo' <?php echo $func->disableElement($mode); ?> ></div>
            </div>
        </form>
    </body>
</html>
