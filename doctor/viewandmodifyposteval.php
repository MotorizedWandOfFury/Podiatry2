<?php
date_default_timezone_set("EST");

require_once dirname(dirname(__FILE__)) . '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));

$json = new JSONManager();
$postQuestions = $json->loadJSONQuestions("Post", "en");
$postValues = $json->loadJSONValues("Post", "en");

if (empty($postQuestions) || empty($postValues)) {
    die("Unable to load JSON files");
}

$session = new SessionManager();
$session->validate();

$nav = new Navigator();
$func = new Functions();


$mode = isset($_GET['mode']) ? $_GET['mode'] : "view"; // default mode for page is viewing, if the mode attribute has not been set

$database = new Database();
$patientID = filter_var($_GET['patid'], FILTER_VALIDATE_INT) or die("Patient ID not set");
$type = filter_var($_GET['type'], FILTER_VALIDATE_INT, array('options' => array('min_range' => 1, 'max_range' => 5))) or die("Type value is invalid");
$patient = $database->read(Patient::createRetrievableDatabaseObject($patientID));
$extremity = filter_var($_GET['extremity'], FILTER_VALIDATE_INT, array('options' => array('min_range' => 1), 'max_range' => 2)) or die("Extremity is needed");
$post = $database->read(Post::createRetrievableDatabaseObject($patientID, $type, $extremity)) or die("Form has not been filled for this patient");
$doctor = $database->read(Physician::createRetrievableDatabaseObject($post->getSurID()));
$eval = $database->read(Evals::createRetrievableDatabaseObject($patientID, $extremity)) or die("Pre eval form for patient has not been filled yet.");

if ($mode === 'edit') { // make sure we are in edit mode before we can make changes
    $noInvalidFields = true;
    if (isset($_POST['SUBMIT'])) {
        foreach ($_POST as $key => $value) {
            if ($value) {
                switch ($key) {
                    case 'painmedused':
                        if (filter_var($_POST['painmedused'], FILTER_VALIDATE_INT) === false) {
                            $noInvalidFields = false;
                            echo "<p>$key is not valid</p>";
                        }
                        break;
                    case 'dosepainmedused':
                        if (filter_var($_POST['dosepainmedused'], FILTER_VALIDATE_INT) === false) {
                            $noInvalidFields = false;
                            echo "<p>$key is not valid</p>";
                        }
                        break;
                }
            }
        }

        if ($noInvalidFields) {
            foreach ($_POST as $key => $value) {
                if ($key === 'SUBMIT' || $key === 'painmedused' || $key === 'dosepainmedused') {   //filtering out unwanted keys
                } else {
                    $post->setAnswer($key, $value);
                }
            }

            $post->setPainMedUsed($_POST['painmedused']);
            $post->setDosePainMedUsed($_POST['dosepainmedused']);

            //echo $post->generateUpdateQuery();
            //var_dump($post);
            $database->update($post);
            $nav->redirectUser($session->getUserType(), Navigator::SUBMISSION_NAVIGATION_ACTION, "Evaluation successfully updated");
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>POST-OPERATIVE Evaluation</title>
        <link rel='stylesheet' href='../bootstrap/css/sf36_css.css' />
    </head>
    <body>
        <?php echo Functions::formTitle($type, "POST-OPERATIVE Evaluation", $extremity) ?><br>
        &nbsp;
        <a href="<?php echo $func->getUserHome($session->getUserObject()); ?>">Home</a> |
        <a href="<?php echo $_SERVER['SCRIPT_NAME'] . "?patid=$patientID" . "&type=$type" . "&extremity=$extremity" . "&mode=view"; ?>">View</a> | <a href="<?php echo $_SERVER['SCRIPT_NAME'] . "?patid=$patientID" . "&type=$type" . "&extremity=$extremity" . "&mode=edit"; ?>">Edit</a>
        <form action="<?php echo $_SERVER['SCRIPT_NAME'] . "?patid=$patientID" . "&type=$type" . "&extremity=$extremity" . "&mode=" . $mode; ?>" method="POST">
            <div class='container'>
                <div class='greybox'>
                    <table>
                        <tr>
                            <td>1) Patient: <?php echo $patient->getFirstName() . " " . $patient->getLastName(); ?>&nbsp;</td>
                            <td>2) Surgeon: <?php echo $doctor->getFirstName() . " " . $doctor->getLastName(); ?> </td>
                        </tr>
                        <tr>
                            <td>3) Extremity: <?php echo $eval->getExtremityFormatted(); ?></td>
                            <td>4) <?php echo $postQuestions['Q4'] . ": " . $post->getDateOfExamFormatted(); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div class='whitebox'>
                    <table>
                        <tr>
                            <td>5) <?php echo $postQuestions['Q5']; ?>:</td>
                            <td><input class="text" name="painmedused" value="<?php echo $post->getPainMedUsed(); ?>" <?php echo $func->disableElement($mode); ?>/></td>
                        </tr>
                        <tr>
                            <td>6) <?php echo $postQuestions['Q6']; ?>:</td>
                            <td><input class="text" name="dosepainmedused" value="<?php echo $post->getDosePainMedUsed(); ?>" <?php echo $func->disableElement($mode); ?>/></td>
                        </tr>
                        <tr>
                            <td>7) <?php echo $postQuestions['Q7']; ?>: 
                                <?php
                                foreach ($postValues['Q7'] as $opt) {
                                    echo "<input type = 'radio' name = 'Q7'  value = '" . $opt['val'] . "' " . ($post->getAnswer("Q7") == $opt['val'] ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>8) <?php echo $postQuestions['Q8']; ?>: 
                                <?php
                                foreach ($postValues['Q8'] as $opt) {
                                    echo "<input type = 'radio' name = 'Q8'  value = '" . $opt['val'] . "' " . ($post->getAnswer("Q8") == $opt['val'] ? "checked='checked'" : "") . $func->disableElement($mode) . "/> " . $opt['name'];
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div class='greybox'>
                    <table>
                        <tr style='text-align: center;'>
                            <td>&nbsp;</td>
                            <td>None&nbsp;&nbsp;</td>
                            <td>Periwound&nbsp;&nbsp;</td>
                            <td>Dorso-Medial&nbsp;&nbsp;</td>
                            <td>Entire Dorsum&nbsp;&nbsp;</td>
                            <td>Circum-ferential</td>
                        </tr>
                        <tr>
                            <td>9) <?php echo $postQuestions['Q9']; ?>: </td>
                            <?php
                            foreach ($postValues['Q9'] as $opt) {
                                echo "<td style='text-align: center;'>";
                                echo "<input type = 'radio' name = 'Q9'  value = '" . $opt['val'] . "' " . ($post->getAnswer("Q9") == $opt['val'] ? "checked='checked'" : "") . $func->disableElement($mode) . "/> ";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>10) <?php echo $postQuestions['Q10']; ?>: </td>
                            <?php
                            foreach ($postValues['Q10'] as $opt) {
                                echo "<td style='text-align: center;'>";
                                echo "<input type = 'radio' name = 'Q10'  value = '" . $opt['val'] . "' " . ($post->getAnswer("Q10") == $opt['val'] ? "checked='checked'" : "") . $func->disableElement($mode) . "/> ";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>11) <?php echo $postQuestions['Q11']; ?>: </td>
                            <?php
                            foreach ($postValues['Q11'] as $opt) {
                                echo "<td style='text-align: center;'>";
                                echo "<input type = 'radio' name = 'Q11'  value = '" . $opt['val'] . "' " . ($post->getAnswer("Q11") == $opt['val'] ? "checked='checked'" : "") . $func->disableElement($mode) . "/> ";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div class='whitebox'>
                    <table>
                        <tr style='text-align: center;'>
                            <td>&nbsp;</td>
                            <td>None&nbsp;&nbsp;</td>
                            <td>Seeping part of incision&nbsp;&nbsp;</td>
                            <td>Seeping whole incision&nbsp;&nbsp;</td>
                            <td>Hematoma&nbsp;&nbsp;</td>
                            <td>Active bleeding</td>
                        </tr>
                        <tr>
                            <td>12) <?php echo $postQuestions['Q12']; ?>: </td>
                            <?php
                            foreach ($postValues['Q12'] as $opt) {
                                echo "<td style='text-align: center;'>";
                                echo "<input type = 'radio' name = 'Q12'  value = '" . $opt['val'] . "' " . ($post->getAnswer("Q12") == $opt['val'] ? "checked='checked'" : "") . $func->disableElement($mode) . "/> ";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div class='greybox'>
                    <table>
                        <tr style='text-align: center;'>
                            <td>&nbsp;</td>
                            <td>None&nbsp;&nbsp;</td>
                            <td>< half incision&nbsp;&nbsp;</td>
                            <td>> half incision&nbsp;&nbsp;</td>
                            <td>Whole incision&nbsp;&nbsp;</td>
                            <td>Necrosis</td>
                        </tr>
                        <tr>
                            <td>13) <?php echo $postQuestions['Q13']; ?>: </td>
                            <?php
                            foreach ($postValues['Q13'] as $opt) {
                                echo "<td style='text-align: center;'>";
                                echo "<input type = 'radio' name = 'Q13'  value = '" . $opt['val'] . "' " . ($post->getAnswer("Q13") == $opt['val'] ? "checked='checked'" : "") . $func->disableElement($mode) . "/> ";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div class='whitebox'>
                    <table>
                        <tr style='text-align: center;'>
                            <td>&nbsp;</td>
                            <td>None&nbsp;&nbsp;</td>
                            <td>Suture abscess&nbsp;&nbsp;</td>
                            <td>Local cellulitis&nbsp;&nbsp;</td>
                            <td>Abscess&nbsp;&nbsp;</td>
                            <td>Osteomyelitis&nbsp;&nbsp;</td>
                        </tr>
                        <tr>
                            <td>14) <?php echo $postQuestions['Q14']; ?>: </td>
                            <?php
                            foreach ($postValues['Q14'] as $opt) {
                                echo "<td style='text-align: center;'>";
                                echo "<input type = 'radio' name = 'Q14'  value = '" . $opt['val'] . "' " . ($post->getAnswer("Q14") == $opt['val'] ? "checked='checked'" : "") . $func->disableElement($mode) . "/> ";
                                echo "</td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='container'>
                <div><input type='submit' name='SUBMIT' value='Update Post eval' <?php echo ($mode === 'view') ? "disabled='disabled'" : ""; ?> ></div>
            </div>
        </form>
    </body>
</html>
