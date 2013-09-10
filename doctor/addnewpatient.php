<?php
require_once dirname(dirname(__FILE__)) . '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));


$session = new SessionManager();
$session->validate();

$nav = new Navigator();
$layout = new Layout();


$loggedInUser = $session->getUserObject();


$json = new JSONManager();
$patientQuestions = $json->loadJSONQuestions("AddNewPatient", "en");
$patientValues = $json->loadJSONValues("AddNewPatient", "en");

if (empty($patientQuestions) || empty($patientValues)) {
    die("Unable to load JSON files");
}

$database = new Database();

$errors = "";
$noMissingFields = true;
$noInvalidFields = true;

if (isset($_POST['SUBMIT'])) {
    foreach ($_POST as $key => $value) {
        if (!$value) { //check for empty fields
            $errors = $errors . "<p>$key is empty</p>";
            $noMissingFields = false;
        } else { //validate data
            switch ($key) {
                case "AGE":
                    $ageOptions = array(
                        'options' => array(
                            'min_range' => 5,
                            'max_range' => 120,
                        )
                    );
                    if (filter_var($value, FILTER_VALIDATE_INT, $ageOptions) == false) {
                        $errors = $errors . "<p>$key is not valid</p>";
                        $noInvalidFields = false;
                    }
                    break;
                case "MONTH":
                    $monthOptions = array(
                        'options' => array(
                            'min_range' => 1,
                            'max_range' => 12,
                        )
                    );
                    if (filter_var($value, FILTER_VALIDATE_INT, $monthOptions) == false) {
                       $errors = $errors . "<p>$key is not valid</p>";
                        $noInvalidFields = false;
                    }
                    break;
                case "YEAR":
                    $yearOptions = array(
                        'options' => array(
                            'min_range' => 1900,
                            'max_range' => getdate()['year'],
                        )
                    );
                    if (filter_var($value, FILTER_VALIDATE_INT, $yearOptions) == false) {
                        $errors = $errors . "<p>$key is not valid</p>";
                        $noInvalidFields = false;
                    }
                    break;
                case "DAY":
                    $dayOptions = array(
                        'options' => array(
                            'min_range' => 1,
                            'max_range' => 31,
                        )
                    );
                    if (filter_var($value, FILTER_VALIDATE_INT, $dayOptions) == false) {
                        $errors = $errors . "<p>$key is not valid</p>";
                        $noInvalidFields = false;
                    }
                    break;
                
                case "ZIP":
                    $zipOptions = array(
                        'options' => array(
                            'regexp' => '/^\d{5}(?:[-\s]\d{4})?$/'
                        )
                    );
                    if (filter_var($value, FILTER_VALIDATE_REGEXP, $zipOptions) == false) {
                        $errors = $errors . "<p>$key is not valid</p>";
                        $noInvalidFields = false;
                    }
                    break;
                case "PHONE":
                    $phoneOptions = array(
                        'options' => array(
                            'regexp' => '/(\()?[0-9]{3}(\))?(.)?[0-9]{3}(.)?[0-9]{4}/'
                        )
                    );
                    //echo "phone is: " . $value;
                    if (filter_var($value, FILTER_VALIDATE_REGEXP, $phoneOptions) == false) {
                        $errors = $errors . "<p>$key is not valid</p>";
                        $noInvalidFields = false;
                    }
                    break;
                case "EMAIL":
                    if (filter_var($value, FILTER_VALIDATE_EMAIL) == false) {
                        $errors = $errors . "<p>$key is not valid</p>";
                        $noInvalidFields = false;
                    }
                    break;
            }
        }
    }

    if ($noMissingFields && $noInvalidFields) { //all fields have been validated
        $patient = new Patient();
        $patient->setFirstName($_POST['FIRSTNAME']);
        $patient->setLastName($_POST['LASTNAME']);
        $patient->setSex($_POST['GENDER']);
        $patient->setAge($_POST['AGE']);
        $patient->setDOB($_POST['MONTH'], $_POST['DAY'], $_POST['YEAR']);
        $patient->setDoctor($session->getUserType() === Physician::tableName ? $loggedInUser->getId() : $_POST["DOCTOR"]); //checks to see type of logged in user. If it's a physician, use the id, otherwise, use $_POST['DOCTOR']
        $patient->setUsername($_POST['USERNAME']);
        $patient->setPassword($_POST['PASSWORD']);
        $patient->setStreet($_POST['STREET']);
        $patient->setCity($_POST['CITY']);
        $patient->setState($_POST['STATE']);
        $patient->setZip($_POST['ZIP']);
        $patient->setMedicalRecordNumber($_POST['MEDNUM']);
        $patient->setPhone($_POST['PHONE']);
        $patient->setEmail($_POST['EMAIL']);

        //var_dump($patient);
        //echo "<p>", $patient->generateCreateQuery(), "</p>";
        $database->create($patient);
        $nav->redirectUser($session->getUserType(), Navigator::SUBMISSION_NAVIGATION_ACTION, "New Patient added successfully");
    }
}
?>


<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'> 
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'> 
    <head> 
        <meta http-equiv='Content-Type' content='text/html;charset=utf-8' /> 
        <?php
        echo $layout->loadNavBar("Add New Patient", "../");
        ?> 
        <link href='../bootstrap/css/addUsers.css' rel='stylesheet'> 
            <title>Add New Patient</title> 
    </head> 
    <body> 
        <form class="form-signin" action="" method="post"> 
            <div class='container'> 
                <table> 
                    <tr style='text-align: center; font-weight: bold;'> 
                        <td colspan='2'>General Information</td> 
                    </tr> 
                    <tr> 
                        <td><?php echo $patientQuestions["mednum"]; ?></td>          
                        <td><input class='text' type='text' name='MEDNUM' placeholder='Medical Record Number' value='<?php echo array_key_exists("MEDNUM", $_POST) ? $_POST['MEDNUM'] : ""; ?>' id='MEDNUM' onchange='' /></td> 
                    </tr> 
                    <tr> 
                        <td><?php echo $patientQuestions["fn"]; ?></td>          
                        <td><input class='text' type='text' name='FIRSTNAME' placeholder='First Name' value='<?php echo array_key_exists("FIRSTNAME", $_POST) ? $_POST['FIRSTNAME'] : ""; ?>' id='FN' onchange='' /></td> 
                    </tr> 
                    <tr> 
                        <td><?php echo $patientQuestions["ln"]; ?></td> 
                        <td><input type='text' class='text' name='LASTNAME' placeholder='Last Name' value='<?php echo array_key_exists("LASTNAME", $_POST) ? $_POST['LASTNAME'] : ""; ?>' id='LN'/></td> 
                    </tr> 
                    <tr> 
                        <td><?php echo $patientQuestions['gen'] ?></td> 
                        <td> 
                            <select name='GENDER'> 
                                <option value='' selected='selected'>Select</option> 
                                <option value='<?php echo $patientValues['gender']['m']; ?>' <?php echo (isset($_POST['GENDER']) && $_POST['GENDER'] == $patientValues['gender']['m']) ? 'selected = "selected"' : '' ?> >Male</option> 
                                <option value='<?php echo $patientValues['gender']['f']; ?>' <?php echo (isset($_POST['GENDER']) && $_POST['GENDER'] == $patientValues['gender']['f']) ? 'selected = "selected"' : '' ?> >Female</option> 
                            </select> 
                        </td> 
                    </tr> 
                    <tr> 
                        <td><?php echo $patientQuestions['age']; ?></td> 
                        <td><input class='text' type='text' name='AGE' placeholder='Age' value='<?php echo array_key_exists("AGE", $_POST) ? $_POST['AGE'] : ""; ?>' id='AGE' /></td> 
                    </tr> 
                    <tr> 
                        <td><?php echo $patientQuestions['dob']; ?></td> 
                        <td><input class='text' type='text' size='2' maxlength='2' name='MONTH' placeholder='Month' value='<?php echo array_key_exists("MONTH", $_POST) ? $_POST['MONTH'] : ""; ?>'/> <input class='text' type='text' size='2' maxlength='2' name='DAY' placeholder='Day' value='<?php echo array_key_exists("DAY", $_POST) ? $_POST['DAY'] : ""; ?>'/> <input class='text' type='text' size='4' maxlength='4' name='YEAR' placeholder='Year' value='<?php echo array_key_exists("YEAR", $_POST) ? $_POST['YEAR'] : ""; ?>'/></td> 
                    </tr> 
                    <tr style='text-align: center; font-weight: bold;'> 
                        <td colspan='2'>Login Information</td> 
                    </tr> 
                    <tr> 
                        <td><?php echo $patientQuestions['un']; ?></td> 
                        <td><input type='text' class='text' name='USERNAME' placeholder='Username' id='USERNAME' value='<?php echo array_key_exists("USERNAME", $_POST) ? $_POST['USERNAME'] : ""; ?>'/> <span style='color: red;'>(Note: Write this username down and give to the patient.)</span></td> 
                    </tr> 
                    <tr> 
                        <td><?php echo $patientQuestions['pass']; ?></td> 
                        <td><input class='text' type='text' name='PASSWORD' placeholder='Password' value='<?php echo array_key_exists("PASSWORD", $_POST) ? $_POST['PASSWORD'] : str_shuffle("abcdef12345"); ?>'/> <span style='color: red;'>(Note: Write this password down and give to the patient.)</td> 
                    </tr> 
                    <tr style='text-align: center; font-weight: bold;'> 
                        <td colspan='2'>Location and Contact</td> 
                    </tr> 
                    <tr> 
                        <td><?php echo $patientQuestions['street']; ?></td> 
                        <td><input class='text' type='text' name='STREET' placeholder='Street' value='<?php echo array_key_exists("STREET", $_POST) ? $_POST['STREET'] : ""; ?>' id='STREET'/></td> 
                    </tr> 

                    <tr> 
                        <td><?php echo $patientQuestions['city']; ?></td> 
                        <td><input class='text' type='text' name='CITY' placeholder='City' value='<?php echo array_key_exists("CITY", $_POST) ? $_POST['CITY'] : ""; ?>' id='CITY'/></td> 
                    </tr> 
                    <tr> 
                        <td><?php echo $patientQuestions['state']; ?></td> 
                        <td><input class='text' type='text' name='STATE' placeholder='State' value='<?php echo array_key_exists("STATE", $_POST) ? $_POST['STATE'] : ""; ?>' id='STATE'/></td> 
                    </tr> 
                    <tr> 
                        <td><?php echo $patientQuestions['zip']; ?></td> 
                        <td><input class='text' type='text' name='ZIP' placeholder='Zip Code' value='<?php echo array_key_exists("ZIP", $_POST) ? $_POST['ZIP'] : ""; ?>' id='ZIP'/></td> 
                    </tr> 
                    <tr> 
                        <td><?php echo $patientQuestions['phone']; ?></td> 
                        <td><input class='text' type='text' name='PHONE' placeholder='Phone' value='<?php echo array_key_exists("PHONE", $_POST) ? $_POST['PHONE'] : ""; ?>' id='PHONE'/></td> 
                    </tr> 
                    <tr> 
                        <td><?php echo $patientQuestions['email']; ?></td> 
                        <td><input class='text' type='text' name='EMAIL' placeholder='Email' value='<?php echo array_key_exists("EMAIL", $_POST) ? $_POST['EMAIL'] : ""; ?>' id='EMAIL'/></td> 
                    </tr> 
                    <tr style='text-align: center; font-weight: bold;'> 
                        <td colspan='2'>Health</td> 
                    </tr> 

                    <?php
                    if ($session->getUserType() === Admin::tableName) {
                        $allDoctors = new AllDoctorsAssociation();
                        $database->createAssociationObject($allDoctors);

                        echo "<tr>";
                        echo "<td>", $patientQuestions['doc'], "</td>";
                        echo "<td>";
                        echo "<select name='DOCTOR'>";
                        echo "<option value=''", (!isset($_POST['DOCTOR'])) ? 'selected = "selected"' : '', ">Select</option>";
                        foreach ($allDoctors->getPhysiciansArray() as $physician) { //dynamically create a dropdown list of doctors 
                            echo "<option value = '", $physician->getId(), "'", (isset($_POST['DOCTOR']) && $_POST['DOCTOR'] === $physician->getId()) ? 'selected = "selected"' : '', ">", $physician->getFirstName(), " ", $physician->getLastName(), "</option>";
                        }
                        echo "</select></td>";
                        echo "</tr>";
                    }
                    ?>  
                    <tr> 
                        <td><input type='submit' value='Add Patient' name='SUBMIT' /></td> 
                    </tr> 
                </table> 
            </div> 
        </form> 
        <div id="PHPMESSAGES">
            <?php
                echo $errors;
            ?>
        </div>
    </body> 
    <?php
    echo $layout->loadFooter("../");
    ?> 
</html>