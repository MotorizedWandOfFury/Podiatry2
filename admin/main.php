<?php
require_once dirname(dirname(__FILE__)) . '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));

session_start();                    // Start Session

$database = new Database();
$var = new Variables();
$nav = new Navigator();
$func = new Functions();

if (array_key_exists($var->getLoggedInUserType(), $_SESSION)) { //have the session variables been set
    if (!($_SESSION[$var->getLoggedInUserType()] === Admin::tableName)) {
        $nav->doGo("index.php", "Admins only");
    }
} else { //if session variables have not been set, redirect
    $nav->doGo("index.php", "Authentication Required");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Admin Main &middot; Podiatry Information System<</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Podiatry DB with questionaire forms">
        <meta name="author" content="Steven Ng">

        <!-- Le styles -->
        <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="../bootstrap/css/mainForms.css" rel="stylesheet">
        <link href="../bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

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
                    <a class="brand" href="main.php">Podiatry Information System</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <!--<li><a href="../../contact.html">Contact</a></li>-->
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu Navigation <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li class="nav-header">Doctors</li>
                                    <li><a href="main.php">View Doctors</a></li>
                                    <li><a href="addnewdoctor.php">Add Doctor</a></li>
                                    <li class="divider"></li>
                                    <li class="nav-header">Patients</li>
                                    <li><a href="view_patients.php">View Patients</a></li>
                                    <li><a href="../doctor/addnewpatient.php">Add Patient</a></li>
                                    <!--<li><a href="../doctor/pat_preop_score.php">SF-36 Scores</a></li>-->
                                </ul>
                            </li>
                        </ul>
                        <form class="navbar-form pull-right"> 
                            <button type="button" onclick="location.href = '../logout.php'" class="btn">Log Out</button> 
                        </form>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

        <div class="container" id="mainDiv">
                <table class='table table-striped table-bordered'>
                    <tr>
                        <td style='text-align: center;' colspan='6'><b>Doctors in Database</b></td>
                    </tr>
                    <tr style='text-align: center;'>
                        <td style='width: 5%; text-align: center;'>Id</td>
                        <td style='width: 15%; text-align: center;'>Username</td>
                        <td style='width: 10%; text-align: center;'>First Name</td>
                        <td style='width: 10%; text-align: center;'>Last Name</td>
                        <td style='width: 5%; text-align: center;'>&nbsp;</td>
                        <td style='width: 5%; text-align: center;'> &nbsp;</td>
                    </tr>
                    <?php
                    $allDoctors = new AllDoctorsAssociation();
                    $database->createAssociationObject($allDoctors);
                    foreach ($allDoctors->getPhysiciansArray() as $admin_doc) {
                        echo "<tr>";
                        echo "<td class='row1' style='width: 5%; text-align: center;'>", $admin_doc->getId(), "</td>";
                        echo "<td class='row2' style='width: 15%; text-align: center;'>", $admin_doc->getUserName(), "</td>";
                        echo "<td class='row1' style='width: 10%; text-align: center;'>", $admin_doc->getFirstName() . "</td>";
                        echo "<td class='row2' style='width: 10%; text-align: center;'>", $admin_doc->getLastName(), "</td>";
                        echo "<td class='row1' style='width: 5%; text-align: center;'>", $func->doButton($admin_doc->getId(), $admin_doc->getLastName(), "editDoc", "Edit", 0, 0), "</td>";
                        echo "<td class='row2' style='width: 5%; text-align: center;'>", $func->doButton($admin_doc->getId(), $admin_doc->getLastName(), "viewPatients", "Patients", 1, 0), "</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
            <!--<div id='result'></div>-->
            <hr>
            <footer>
                <p align="center">&copy; Yaw Agyepong & Steven Ng 2013</p>
            </footer>
        </div> <!--/ container -->

        <script src="../bootstrap/js/jquery.js"></script>
        <script src="../bootstrap/js/bootstrap.js"></script>

        <!--remember to rebind js if target page has some-->
        <script src="../bootstrap/js/loadInPage.js"></script>
        <script src="../bootstrap/js/modal.js"></script>

    </body>
</html>