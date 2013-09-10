<?php

session_start();                    // Start Session
require "../db.php";                // Database Interaction
require "../classes/database.php";  // Database Functions
require "../classes/clean.php";     // Filter Functions
require "../classes/variables.php"; // Global Variables
require "../classes/time.php";      // Time Functions
require "../classes/functions.php"; // Other Functions
require "../classes/layout.php";    // Layout Functions
require "../classes/error.php";     // Error Control
require "../classes/patient.php";   // Patient Class
require "../classes/doctor.php";    // Doctor Class
require "../classes/admin.php";     // Admin Class
require "../classes/input.php";     // Input Functions
$database = new Database();
$clean = new Clean();
$var = new Variables();
$time = new Time();
$func = new Functions();
$layout = new Layout();
$error = new Error();
$patient = new Patient(@$_SESSION[$var->GetSessionUserId()]);
$doctor = new Doctor(@$_SESSION[$var->GetSessionDoctorId()]);
$admin = new Admin(@$_SESSION[$var->GetSessionAdminId()]);
$in = new Input();

if ($doctor->isLogged() == TRUE)
    $error->doGo("main.php", "Logged as doctor.");

if (isset($_POST['SUBMIT']) == FALSE)
{
    // Load the HTML, CSS.
    ?>

    <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
    <html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>
    
    <head>
    <meta http-equiv='Content-Type' content='text/html;charset=utf-8' />
    <title>Physician Login Page</title>
    <link rel='stylesheet' href='css.css' />
    <link rel='shortcut icon' type='image/x-icon' href='' />
    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>
    <script type='text/javascript' src='js/script.js'></script>
    <script type='text/javascript' src='js/form.js'></script>
    </head>
   
    <?php
        echo $layout->startBody();
    ?>

    <h3>Physician Login Page</h3>

<?php
    echo "<form action='" . $_SERVER['SCRIPT_NAME'] . "' onsubmit='return doLog(this)' method='post'>
			<div class='container'>
                        <table>
                             <tr><td>User Name</td><td>&nbsp:&nbsp;</td><td>" .$in->text("textbox", "UN"). "</td></tr>
                             <tr><td>Password</td><td>&nbsp:&nbsp;</td><td>" .$in->text("textbox", "PASSWORD"). "</td></tr>
                        </table>
			<input type='submit' value='Login' name='SUBMIT' />
                <div>Default Username, Password: sdoctor, 1</div>
                <a href='../index.php'>Home</a>
			</div>
		</form>
	";

    // End body.
    echo $layout->endBody();
    // Load the footer.
    echo $layout->doFoot();
}
else if (isset($_POST['SUBMIT']) == TRUE)
{
    // Last name value required.
    if (empty($_POST['UN']))
    {
        $error->doGo($_SERVER['SCRIPT_NAME'], "Username is necessary.");
    }
    // Password value required.
    else if (empty($_POST['PASSWORD']))
    {
        $error->doGo($_SERVER['SCRIPT_NAME'], "Password is necessary.");
    }
    else
    {
        // Allow no HTML in the last name.
        $un = $clean->noHTML($_POST['UN']);
        // Encrypt the password.
        $pass = $clean->toPass($_POST['PASSWORD']);
        // Query info.
        $getpatient = "SELECT `id`, `username`, `password` FROM `physicians` WHERE `username` IN ('" . $un . "') AND `password` IN ('" . $pass . "')";
        // Execute the query.
        $query = $database->doQuery($getpatient);
        // Determine if the patient exists.
        $patientexist = $database->doRows($query);

        // If the patient exists...
        if ($patientexist == 1)
        {
            // Get the information pretaining to the patient.
            $getpatientinfo = $database->doArray($query);
            // Set the first session.
            $_SESSION[$var->GetSessionDoctorId()] = $getpatientinfo['id'];
            // Set the second session.
            $_SESSION[$var->GetSessionDoctorName()] = $getpatientinfo['username'];
            // Destory patient session.
            unset($_SESSION[$var->GetSessionUserId()]);
            unset($_SESSION[$var->GetSessionUserName()]);
            // Destroy admin session.
            unset($_SESSION[$var->GetSessionAdminId()]);
            unset($_SESSION[$var->GetSessionAdminName()]);
            // You've logged in.
            $error->doGo("main.php", "You're logged in!");
        }
        else
        {
            $error->doGo($_SERVER['SCRIPT_NAME'], "There is a problem with your credentials. Please check your username and password again.");
        }
    }
}
?>