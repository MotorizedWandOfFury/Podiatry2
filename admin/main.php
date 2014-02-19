<?php
require_once dirname(dirname(__FILE__)) . '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));

$session = new SessionManager();
$session->validate();

$database = new Database();
$var = new Variables();
$nav = new Navigator();
$func = new Functions();
$layout = new Layout();

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
		<?php
			echo $layout->loadNavBar('Admin Main', '../');
		?>
		<link href="../bootstrap/css/mainForms.css" rel="stylesheet">
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