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
$errors = "";

$noMissingFields = true;
$noInvalidFields = true;

if (isset($_POST['SUBMIT'])) {
    foreach ($_POST as $key => $value) {
        if (!$value) { //check for empty fields
            $errors = $errors . "<p>$key requires a value</p>";
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
        $doctor = new Physician();
        $doctor->setFirstName($_POST['FIRSTNAME']);
        $doctor->setLastName($_POST['LASTNAME']);
        $doctor->setSex($_POST['GENDER']);
        $doctor->setAge($_POST['AGE']);
        $doctor->setDOB($_POST['MONTH'], $_POST['DAY'], $_POST['YEAR']);
        $doctor->setUsername($_POST['USERNAME']);
        $doctor->setPassword($_POST['PASSWORD']);
        $doctor->setStreet($_POST['STREET']);
        $doctor->setCity($_POST['CITY']);
        $doctor->setState($_POST['STATE']);
        $doctor->setZip($_POST['ZIP']);
        $doctor->setExperience($_POST['EXPERIENCE']);
        $doctor->setPhone($_POST['PHONE']);
        $doctor->setEmail($_POST['EMAIL']);

        //var_dump($doctor);
        //echo "<p>", $doctor->generateCreateQuery(), "</p>";
        //echo "<p>", $doctor->getDOBFormatted(), "</p>";
        $database = new Database();
        $database->create($doctor);
        $nav->redirectUser($session->getUserType(), Navigator::SUBMISSION_NAVIGATION_ACTION, "New Doctor added successfully");
    }
}
?>
<!DOCTYPE html>
<html>
    <!--<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Add New Doctor</title>
    </head>-->
    <?php
        echo $layout->loadNavBar("Add New Doctor", "../");
    ?>
    <link href='../bootstrap/css/addUsers.css' rel='stylesheet'>
    
        <form class="form-signin" action="" method='post'>
            <div class='container'>
                <table>
                    <tr style='text-align: center; font-weight: bold;'>
                        <td colspan='2'>General Information</td>
                    </tr>
                    <tr>
                        <td><?php echo $doctorQuestions["fn"]; ?></td>         
                        <td><input class='text' type='text' name='FIRSTNAME' placeholder='First Name' value='<?php echo array_key_exists("FIRSTNAME", $_POST) ? $_POST['FIRSTNAME'] : ""; ?>' id='FN' onchange='' /></td>
                    </tr>

                    <tr>
                        <td><?php echo $doctorQuestions["ln"]; ?></td>
                        <td><input type='text' class='text' name='LASTNAME' placeholder='Last Name' value='<?php echo array_key_exists("LASTNAME", $_POST) ? $_POST['LASTNAME'] : ""; ?>' id='LN'/></td>
                    </tr>
                    <tr>
                        <td><?php echo $doctorQuestions['gen'] ?></td>
                        <td>
                            <select name='GENDER'>
                                <option value='' selected='selected'>Select</option>
                                <option value='<?php echo $doctorValues['gender']['m']; ?>' <?php echo (isset($_POST['GENDER']) && $_POST['GENDER'] == $doctorValues['gender']['m']) ? 'selected = "selected"' : '' ?> >Male</option>
                                <option value='<?php echo $doctorValues['gender']['f']; ?>' <?php echo (isset($_POST['GENDER']) && $_POST['GENDER'] == $doctorValues['gender']['f']) ? 'selected = "selected"' : '' ?> >Female</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $doctorQuestions['age']; ?></td>
                        <td><input class='text' type='text' name='AGE' placeholder='Age' value='<?php echo array_key_exists("AGE", $_POST) ? $_POST['AGE'] : ""; ?>' id='AGE' /></td>
                    </tr>
                    <tr>
                        <td><?php echo $doctorQuestions['dob']; ?></td>
                        <td><input class='text' type='text' size='2' maxlength='2' name='MONTH' placeholder='Month' value='<?php echo array_key_exists("MONTH", $_POST) ? $_POST['MONTH'] : ""; ?>'/> <input class='text' type='text' size='2' maxlength='2' name='DAY' placeholder='Day' value='<?php echo array_key_exists("DAY", $_POST) ? $_POST['DAY'] : ""; ?>'/> <input class='text' type='text' size='4' maxlength='4' name='YEAR' placeholder='Year' value='<?php echo array_key_exists("YEAR", $_POST) ? $_POST['YEAR'] : ""; ?>'/></td>
                    </tr>
                    <tr style='text-align: center; font-weight: bold;'>
                        <td colspan='2'>Login Information</td>
                    </tr>
                    <tr>
                        <td><?php echo $doctorQuestions['un']; ?></td>
                        <td><input type='text' class='text' name='USERNAME' id='USERNAME' placeholder='UserName' value='<?php echo array_key_exists("USERNAME", $_POST) ? $_POST['USERNAME'] : ""; ?>'/> <span style='color: red;'>(Note: Write this username down and give to the Doctor.)</span></td>
                    </tr>
                    <tr>
                        <td><?php echo $doctorQuestions['pass']; ?></td>
                        <td><input class='text' type='text' name='PASSWORD' placeholder='Password' value='<?php echo array_key_exists("PASSWORD", $_POST) ? $_POST['PASSWORD'] : str_shuffle("abcdef12345"); ?>' /> <span style='color: red;'>(Note: Write this password down and give to the Doctor.)</td>
                    </tr>
                    <tr style='text-align: center; font-weight: bold;'>
                        <td colspan='2'>Location</td>
                    </tr>
                    <tr>
                        <td><?php echo $doctorQuestions['street']; ?></td>
                        <td><input class='text' type='text' name='STREET' placeholder='Street' value='<?php echo array_key_exists("STREET", $_POST) ? $_POST['STREET'] : ""; ?>' id='STREET'/></td>
                    </tr>

                    <tr>
                        <td><?php echo $doctorQuestions['city']; ?></td>
                        <td><input class='text' type='text' name='CITY' placeholder='City' value='<?php echo array_key_exists("CITY", $_POST) ? $_POST['CITY'] : ""; ?>' id='CITY'/></td>
                    </tr>
                    <tr>
                        <td><?php echo $doctorQuestions['state']; ?></td>
                        <td><input class='text' type='text' name='STATE' placeholder='State' value='<?php echo array_key_exists("STATE", $_POST) ? $_POST['STATE'] : ""; ?>' id='STATE'/></td>
                    </tr>
                    <tr>
                        <td><?php echo $doctorQuestions['zip']; ?></td>
                        <td><input class='text' type='text' name='ZIP' placeholder='Zip' value='<?php echo array_key_exists("ZIP", $_POST) ? $_POST['ZIP'] : ""; ?>' id='ZIP'/></td>
                    </tr>
                    <tr>
                        <td><?php echo $doctorQuestions['phone']; ?></td>
                        <td><input class='text' type='text' name='PHONE' placeholder='Phone' value='<?php echo array_key_exists("PHONE", $_POST) ? $_POST['PHONE'] : ""; ?>' id='PHONE'/></td>
                    </tr>
                    <tr>
                        <td><?php echo $doctorQuestions['email']; ?></td>
                        <td><input class='text' type='text' name='EMAIL' placeholder='Email' value='<?php echo array_key_exists("EMAIL", $_POST) ? $_POST['EMAIL'] : ""; ?>' id='EMAIL'/></td>
                    </tr>
                    <tr>
                        <td><?php echo $doctorQuestions['exp']; ?></td>
                        <td><input class='text' type='text' name='EXPERIENCE' placeholder='Experience' value='<?php echo array_key_exists("EXPERIENCE", $_POST) ? $_POST['EXPERIENCE'] : ""; ?>' id='EXPERIENCE'/></td>
                    </tr>
                    <tr>
                        <td><input type='submit' value='Add Doctor' name='SUBMIT' /></td>
                    </tr>
                </table>
            </div>
        </form>
        <div id="PHPMESSAGES">
            <?php echo $errors; ?>
        </div>
        <?php
        echo $layout->loadFooter("../");
        ?>
    </body>
</html>
