<?php
require_once '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));

session_start();                    // Start Session

$database = new Database();
$nav = new Navigator();

if (array_key_exists(Constants::LOGGED_IN_USER_TYPE, $_SESSION)) { //have the session variables been set
    $nav->redirectUser($_SESSION[Constants::LOGGED_IN_USER_TYPE], Navigator::LOGIN_NAVIGATION_ACTION, "You are already logged in"); //user is already logged in, redirect
}
?>
<!DOCTYPE html> 
<html lang="en"> 
    <head> 
        <meta charset="utf-8"> 
        <title>Log In &middot; Podiatry Information System<</title> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="Podiatry DB with questionaire forms"> 
        <meta name="author" content="Steven Ng"> 

        <!-- Le styles --> 
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet"> 
        <link href="bootstrap/css/loginRegister.css" rel="stylesheet"> 
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet"> 

    </head> 
    <body> 
        <div class="navbar navbar-inverse navbar-fixed-top"> 
            <div class="navbar-inner"> 
                <div class="container"> 
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> 
                        <span class="icon-bar"></span> 
                        <span class="icon-bar"></span> 
                        <span class="icon-bar"></span> 
                    </a> 
                    <a class="brand" href="index.php">Podiatry Information System</a> 
                    <div class="nav-collapse collapse"> 
                        <ul class="nav"> 
                            <!--<li><a href="../../contact.html">Contact</a></li>--> 
                        </ul> 
                        <form class="navbar-form pull-right"> 
                            <!--<button type="button" onclick="location.href='login.php'" class="btn">Log in</button>--> 
                        </form> 
                    </div><!--/.nav-collapse --> 
                </div> 
            </div> 
        </div> 

        <div class="container"> 

            <form id = 'myForm' class='form-signin' action='<?php echo $_SERVER['SCRIPT_NAME'] ?>' method='post' name='login_form'> 
                <h2 class='form-signin-heading'>Please log in</h2> 
                <input type='text' class='input-block-level' name='UN' id='UN' placeholder='Username'/> 
                <input type='password' class='input-block-level' name='PASSWORD' id='password' placeholder='Password'/> 
                <h4>Select your role:</h4>  
                <select name = 'TABLE'> 
                    <option value='<?php echo Patient::tableName; ?>' <?php echo (isset($_POST['TABLE']) && $_POST['TABLE'] == Patient::tableName) ? 'selected = "selected"' : '' ?>>Patient</option> 
                    <option value='<?php echo Physician::tableName; ?>' <?php echo (isset($_POST['TABLE']) && $_POST['TABLE'] == Physician::tableName) ? 'selected = "selected"' : '' ?>>Doctor</option> 
                    <option value='<?php echo Admin::tableName; ?>' <?php echo (isset($_POST['TABLE']) && $_POST['TABLE'] == Admin::tableName) ? 'selected = "selected"' : '' ?>>Administrator</option> 
                </select> 
                <div align='center'> 
                    <input class='btn btn-large btn-primary' type='submit' value='Login' name='SUBMIT' /> 
                </div> 
                <?php
                if (isset($_POST['SUBMIT']) == TRUE) {
                    // user name and password value required. 
                    if (empty($_POST['UN']) || empty($_POST['PASSWORD'])) {
                        echo ' 
        <p style="color:red" align="center"><br>Please check username and password field.</p></form> 
        ';
                    } else {

                        // attempt to log in with given creddentials 
                        if (UserLoginManager::logIn($_POST['UN'], $_POST['PASSWORD'], $_POST['TABLE'], $database)) { //if successful 
                            //redirect user to appropriate page 
                            $nav = new Navigator();
                            $nav->redirectUser($_POST['TABLE'], Navigator::LOGIN_NAVIGATION_ACTION, "You have logged in");
                        } else {
                            echo ' 
                <p style="color:red" align="center"><br>Login credentials are incorrect.</p></form> 
                ';
                        }
                    }
                }
                ?> 

            </form> 

            <p align="center">test username: spatient  | password: 1</p> 
            <p align="center">test doctor username: sdoctor  | password: 1</p> 
            <p align="center">test admin username: admin  | password: admin</p> 

            <hr> 

            <footer> 
                <p align="center">&copy; Yaw Agyepong & Steven Ng 2013</p> 
            </footer> 
        </div> <!--/ container --> 

        <script type="text/javascript" src="js/hachet.js"></script> 
        <script type='text/javascript' src='js/forms.js'></script> 
        <script src="bootstrap/js/jquery.js"></script> 
        <script src="bootstrap/js/bootstrap.js"></script> 

    </body> 
</html> 

