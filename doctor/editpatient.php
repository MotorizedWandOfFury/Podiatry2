<?php
require_once dirname(dirname(__FILE__)) . '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));


$session = new SessionManager();
$session->validate();                // Start Session

$database = new Database();
$layout = new Layout();
$nav = new Navigator();

$json = new JSONManager();
$patientQuestions = $json->loadJSONQuestions("AddNewPatient", "en");
$patientValues = $json->loadJSONValues("AddNewPatient", "en");

if (empty($patientQuestions) || empty($patientValues)) {
    die("Unable to load JSON files");
}

$patient_id = $_GET['id'] or die("Patient id not specified");
$pat = $database->read(Patient::createRetrievableDatabaseObject($patient_id));

if (isset($_POST['SUBMIT']) == TRUE) {
    // The first name cannot have HTML within it.
    $pat->setFirstName($_POST['FN']);
    // The last name cannot have HTML within it.
    $pat->setLastName($_POST['LN']);
    // The user name for the registered patient.
    //$un = strtolower(substr($fn, 0, 1) . $ln);
    $pat->setUsername(strtolower($_POST['USERNAME']));
    // The password must be hashed.
    //$pass = !empty($_POST['PASSWORD']) ? $clean->toPass($_POST['PASSWORD']) : $pat->GetPassword();
    if(!empty($_POST['PASSWORD'])){
        $pat->setPassword($_POST['PASSWORD']);
    } 
    // Date of birth.
    $pat->setDOB($_POST['MONTH'], $_POST['DAY'], $_POST['YEAR']);
    // Street, no HTML.
    $pat->setStreet($_POST['STREET']);
    // City, no HTML.
    $pat->setCity($_POST['CITY']);
    // State, no HTML.
    $pat->setState($_POST['STATE']);
    // Zip, must be an integer.
    $pat->setZip($_POST['ZIP']);
    // Clean the gender.
    $pat->setSex($_POST['GENDER']);
    // Clean the age.
    $pat->setAge($_POST['AGE']);
    
    $pat->setPhone($_POST['PHONE']);
    $pat->setEmail($_POST['EMAIL']);
    // Execute the query.
    $database->update($pat);
    // Success!
    $nav->redirectUser($session->getUserType(), Navigator::SUBMISSION_NAVIGATION_ACTION, "Patient has been updated");
}
?>
<html>
    <head> 
        <meta http-equiv='Content-Type' content='text/html;charset=utf-8' /> 
        <?php
        echo $layout->loadNavBar("Edit Patient", "../");
        ?> 
        <link href='../bootstrap/css/addUsers.css' rel='stylesheet'> 
        <title>Edit Patient</title> 
    </head> 
    <body>
        <form class='form-signin' action='<?php echo $_SERVER['SCRIPT_NAME'] . "?id=" . $pat->getId(); ?>' onsubmit='return doEditPatient(this)' method='post'>
            <div class='container'>
                <table>
                    <tr style='text-align: center; font-weight: bold;'>
                        <td colspan='2'>General Information</td>
                    </tr>
                    <tr>
                    <br/>
                    </tr>
                    <tr> 
                        <td><?php echo $patientQuestions["mednum"]; ?></td>          
                        <td><input class='text' type='text' name='MEDNUM' placeholder='Medical Record Number' value='<?php echo $pat->getMedicalRecordNumber(); ?>' id='MEDNUM' readonly='true' /></td> 
                    </tr> 
                    <tr>
                        <td><?php echo $patientQuestions["fn"]; ?></td> 
                        <td><input class='text' type='text' name='FN' id='FN' value='<?php echo $pat->getFirstName(); ?>' onchange='doUserName(this.value, LN.value, USERNAME);' /></td>
                    </tr>
                    <tr>
                        <td><?php echo $patientQuestions["ln"]; ?></td> 
                        <td><input type='text' class='text' name='LN' id='LN' value='<?php echo $pat->getLastName(); ?>' onchange='doUserName(FN.value, this.value, USERNAME);' /></td>
                    </tr>
                    <tr>
                        <td><?php echo $patientQuestions['gen'] ?></td> 
                        <td> 
                            <select name='GENDER'> 
                                <option value='' selected='selected'>Select</option> 
                                <option value='<?php echo $patientValues['gender']['m']; ?>' <?php echo ($pat->getSex() == $patientValues['gender']['m']) ? 'selected = "selected"' : '' ?> >Male</option> 
                                <option value='<?php echo $patientValues['gender']['f']; ?>' <?php echo ($pat->getSex() == $patientValues['gender']['f']) ? 'selected = "selected"' : '' ?> >Female</option> 
                            </select> 
                        </td> 
                    </tr>
                    <tr>
                        <td><?php echo $patientQuestions['age']; ?></td> 
                        <td><input class='text' type='text' name='AGE' placeholder='Age' value='<?php echo $pat->getAge(); ?>' id='AGE' /></td> 
                    </tr>
                    <tr> 
                        <td><?php echo $patientQuestions['dob']; ?></td> 
                        <td><input class='text' type='text' size='2' maxlength='2' name='MONTH' placeholder='Month' value='<?php echo $pat->getDOBMonth(); ?>'/> <input class='text' type='text' size='2' maxlength='2' name='DAY' placeholder='Day' value='<?php echo $pat->getDOBDay(); ?>'/> <input class='text' type='text' size='4' maxlength='4' name='YEAR' placeholder='Year' value='<?php echo $pat->getDOBYear(); ?>'/></td> 
                    </tr> 
                    <tr style='text-align: center; font-weight: bold;'>
                        <td colspan='2'>Login Information</td>
                    </tr>
                    <tr>
                        <td><?php echo $patientQuestions['un']; ?></td> 
                        <td><input type='text' class='text' name='USERNAME' id='USERNAME' value='<?php echo $pat->getUserName(); ?>' readonly='true' /> <span style='color: red;'>(Note: Write this username down and give to the patient.)</span></td>
                    </tr>
                    <tr>
                       <td><?php echo $patientQuestions['pass']; ?></td> 
                        <td><input class='text' type='text' name='PASSWORD' placeholder='Password' value=''/> <span style='color: red;'>(Note: Leave empty for no change.)</span></td>
                    </tr>
                    <tr style='text-align: center; font-weight: bold;'> 
                        <td colspan='2'>Location and Contact</td> 
                    </tr> 
                    <tr> 
                        <td><?php echo $patientQuestions['street']; ?></td> 
                        <td><input class='text' type='text' name='STREET' placeholder='Street' value='<?php echo $pat->getStreet(); ?>' id='STREET'/></td> 
                    </tr> 

                    <tr> 
                        <td><?php echo $patientQuestions['city']; ?></td> 
                        <td><input class='text' type='text' name='CITY' placeholder='City' value='<?php echo $pat->getCity(); ?>' id='CITY'/></td> 
                    </tr> 
                    <tr> 
                        <td><?php echo $patientQuestions['state']; ?></td> 
                        <td><input class='text' type='text' name='STATE' placeholder='State' value='<?php echo $pat->getState(); ?>' id='STATE'/></td> 
                    </tr> 
                    <tr> 
                        <td><?php echo $patientQuestions['zip']; ?></td> 
                        <td><input class='text' type='text' name='ZIP' placeholder='Zip Code' value='<?php echo $pat->getZip(); ?>' id='ZIP'/></td> 
                    </tr> 
                    <tr> 
                        <td><?php echo $patientQuestions['phone']; ?></td> 
                        <td><input class='text' type='text' name='PHONE' placeholder='Phone' value='<?php echo $pat->getPhone(); ?>' id='PHONE'/></td> 
                    </tr> 
                    <tr> 
                        <td><?php echo $patientQuestions['email']; ?></td> 
                        <td><input class='text' type='text' name='EMAIL' placeholder='Email' value='<?php echo $pat->getEmail(); ?>' id='EMAIL'/></td> 
                    </tr>
                    <tr>
                        <td><input type='submit' value='Update Patient' name='SUBMIT' /></td>
                    </tr>
                </table>
            </div>
        </form>
        <?php echo $layout->loadFooter("../"); ?>
    </body>
</html>
