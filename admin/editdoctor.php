<?php
require_once dirname(dirname(__FILE__)) . '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));

$session = new SessionManager();
$session->validate();

$nav = new Navigator();
$layout = new Layout();


$json = new JSONManager();
$doctorQuestions = $json->loadJSONQuestions("AddNewDoctor", "en");
$doctorValues = $json->loadJSONValues("AddNewDoctor", "en");

if (empty($doctorQuestions) || empty($doctorValues)) {
    die("Unable to load JSON files");
}

$database = new Database();
$doctor_id = $_GET['id'] or die("Doctor ID not provided");
$doc = $database->read(Physician::createRetrievableDatabaseObject($doctor_id));

if (isset($_POST['SUBMIT']) == TRUE) {
    // The first name cannot have HTML within it.
    $doc->setFirstName($_POST['FN']);
    // The last name cannot have HTML within it.
    $doc->setLastName($_POST['LN']);
    // The user name for the registered doctor.
    //$un = strtolower(substr($fn, 0, 1) . $ln);
    $doc->setUsername(strtolower($_POST['USERNAME']));
    // The password must be hashed.
    //$pass = !empty($_POST['PASSWORD']) ? $clean->toPass($_POST['PASSWORD']) : $doc->GetPassword();
    if(!empty($_POST['PASSWORD'])){
        $doc->setPassword($_POST['PASSWORD']);
    } 
    // Date of birth.
    $doc->setDOB($_POST['M'], $_POST['D'], $_POST['Y']);
    // Street, no HTML.
    $doc->setStreet($_POST['STREET']);
    // City, no HTML.
    $doc->setCity($_POST['CITY']);
    // State, no HTML.
    $doc->setState($_POST['STATE']);
    // Zip, must be an integer.
    $doc->setZip($_POST['ZIP']);
    // Clean the gender.
    $doc->setSex($_POST['GENDER']);
    // Clean the age.
    $doc->setAge($_POST['AGE']);
    
    $doc->setPhone($_POST['PHONE']);
    
    $doc->setEmail($_POST['EMAIL']);
    
    $doc->setExperience($_POST['EXPERIENCE']);
    // Execute the query.
    $database->update($doc);
    // Success!
    $nav->redirectUser($session->getUserType(), Navigator::SUBMISSION_NAVIGATION_ACTION, "Doctor Updated!");
}
?>
<html>
<?php
echo $layout->loadNavBar("Edit Doctor", "../");
?>
    <link href='../bootstrap/css/addUsers.css' rel='stylesheet'>
    <body>
        <form action='<?php echo $_SERVER['SCRIPT_NAME'] . "?id=" . $doc->getId(); ?>' onsubmit='return doEditPatient(this)' method='post'>
            <div class='container'>
                <table class='table table-bordered'>
                    <tr style='text-align: center; font-weight: bold;'>
                        <td colspan='2'>General Information</td>
                    </tr>
                    <tr>
                        <td><?php echo $doctorQuestions["fn"]; ?></td> 
                        <td><input class='text' type='text' name='FN' id='FN' value='<?php echo $doc->getFirstName(); ?>' onchange='doUserName(this.value, LN.value, USERNAME);' /></td>
                    </tr>
                    <tr>
                        <td><?php echo $doctorQuestions["ln"]; ?></td>
                        <td><input type='text' class='text' name='LN' id='LN' value='<?php echo $doc->getLastName() ?>' onchange='doUserName(FN.value, this.value, USERNAME);' /></td>
                    </tr>
                    <tr>
                        <td><?php echo $doctorQuestions['gen'] ?></td>
                        <td>
                            <select name='GENDER'>
                                <option value='' selected='selected'>Select</option>
                                <option value='<?php echo $doctorValues['gender']['m']; ?>' <?php echo ($doc->getSex() == $doctorValues['gender']['m']) ? 'selected = "selected"' : '' ?> >Male</option>
                                <option value='<?php echo $doctorValues['gender']['f']; ?>' <?php echo ($doc->getSex() == $doctorValues['gender']['f']) ? 'selected = "selected"' : '' ?> >Female</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                    <tr>
                        <td><?php echo $doctorQuestions['age']; ?></td>
                        <td><input class='text' type='text' name='AGE' placeholder='Age' value='<?php echo $doc->getAge(); ?>' id='AGE' /></td>
                    </tr>
                    </tr>
                    <tr>
                        <td><?php echo $doctorQuestions['dob']; ?></td>
                        <td><input class='text' type='text' size='2' maxlength='2' name='M' placeholder='Month' value='<?php echo $doc->getDOBMonth(); ?>'/> <input class='text' type='text' size='2' maxlength='2' name='D' placeholder='Day' value='<?php echo $doc->getDOBDay(); ?>'/><input class='text' type='text' size='4' maxlength='4' name='Y' placeholder='Year' value='<?php echo $doc->getDOBYear(); ?>'/></td>
                    </tr>
                    <tr style='text-align: center; font-weight: bold;'>
                        <td colspan='2'>Login Information</td>
                    </tr>
                    <tr>
                        <td><?php echo $doctorQuestions['un']; ?></td>
                        <td><input type='text' class='text' name='USERNAME' id='USERNAME' value='<?php echo $doc->getUserName();?>' readonly='true' /> <span style='color: red;'>(Note: Write this username down and give to the Doctor.)</span></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><input class='text' type='text' name='PASSWORD' placeholder='Password' value='' /> <span style='color: red;'>(Note: Leave empty for no change.)</span></td>
                    </tr>
                    <tr style='text-align: center; font-weight: bold;'>
                        <td colspan='2'>Location and Contact</td>
                    </tr>
                    <tr>
                        <td><?php echo $doctorQuestions['street']; ?></td>
                        <td><input class='text' type='text' name='STREET' placeholder='Street' value='<?php echo $doc->getStreet(); ?>' id='STREET'/></td>
                    </tr>

                    <tr>
                        <td><?php echo $doctorQuestions['city']; ?></td>
                        <td><input class='text' type='text' name='CITY' placeholder='City' value='<?php echo $doc->getCity(); ?>' id='CITY'/></td>
                    </tr>
                    <tr>
                        <td><?php echo $doctorQuestions['state']; ?></td>
                        <td><input class='text' type='text' name='STATE' placeholder='State' value='<?php echo $doc->getState(); ?>' id='STATE'/></td>
                    </tr>
                    <tr>
                        <td><?php echo $doctorQuestions['zip']; ?></td>
                        <td><input class='text' type='text' name='ZIP' placeholder='Zip' value='<?php echo $doc->getZip(); ?>' id='ZIP'/></td>
                    </tr>
                    <tr>
                        <td><?php echo $doctorQuestions['phone']; ?></td>
                        <td><input class='text' type='text' name='PHONE' placeholder='Phone' value='<?php echo $doc->getPhone(); ?>' id='PHONE'/></td>
                    </tr>
                    <tr>
                        <td><?php echo $doctorQuestions['email']; ?></td>
                        <td><input class='text' type='text' name='EMAIL' placeholder='Email' value='<?php echo $doc->getEmail(); ?>' id='EMAIL'/></td>
                    </tr>
                    <tr>
                        <td><?php echo $doctorQuestions['exp']; ?></td>
                        <td><input class='text' type='text' name='EXPERIENCE' placeholder='Experience' value='<?php echo $doc->getExperience(); ?>' id='EXPERIENCE'/></td>
                    </tr>
                    <tr>
                        <td><input type='submit' value='Update Doctor' name='SUBMIT' /></td>
                    </tr>
                </table>
            </div>
        </form>
    </body>

</html>