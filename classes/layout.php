<?php

/**
 * Class to load site layout (HTML, CSS) as a template
 */
require_once dirname(dirname(__FILE__)) . '\PodiatryAutoloader.php';
spl_autoload_register(array('PodiatryAutoloader', 'autoLoad'));



class Layout
{

    /**
     *
     * This function is used to set up the main HTML header.
     * 
     * @param type $title <p>The title for the page.</p>
     * @param type $dir <p>Directory to .css and .js files.</p>
     * @return string <p>The header.</p>
     */
    public function loadNavBar($title, $dir)
    {
		$session = new SessionManager();
		$loggedInUser = $session->getUserObject();
		$nav = new Navigator();
		$function = new Functions();
		$home = $function->getUserHome($session->getUserObject());
		
		if ($loggedInUser->getRole() == 'Admin')
		{
			$dropdown = "
						<li class='dropdown'>
										<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Admin Actions<b class='caret'></b></a>
										<ul class='dropdown-menu'>
											<li><a href='" . $home . "'>Home</a></li>
											<li class='divider'></li>
											<li class='nav-header'>Doctors</li>		
											<li><a href='" . $dir . "admin/main.php'>View Doctors</a></li>
											<li><a href='" . $dir . "admin/addnewdoctor.php'>Add Doctor</a></li>
											<li class='divider'></li>
											<li class='nav-header'>Patients</li>
											<li><a href='" . $dir . "admin/view_patients.php'>View Patients</a></li>
											<li><a href='" . $dir . "doctor/addnewpatient.php'>Add Patient</a></li>
											<!--<li><a href='" . $dir . "doctor/pat_preop_score.php'>SF-36 Scores</a></li>-->
										</ul>
									</li>
						";
		}
		else
		{
			$dropdown = "
						<li class='dropdown'>
										<a href='#' class='dropdown-toggle' data-toggle='dropdown'>User Actions<b class='caret'></b></a>
										<ul class='dropdown-menu'>
											<li><a href='" . $home . "'>Home</a></li>
										</ul>
						</li>
						";
		}
		$func = "
			<head>
				<meta charset='utf-8'>
				<title>" . $title . " &middot; Podiatry Information System</title>
				<meta name='viewport' content='width=device-width, initial-scale=1.0'>
				<meta name='description' content='Podiatry DB with questionaire forms'>
				<meta name='author' content='Steven Ng'>

				<!-- CSS styles -->
				<link href='" . $dir . "bootstrap/css/bootstrap.css' rel='stylesheet'>
				<link href='" . $dir . "bootstrap/css/bootstrap-responsive.css' rel='stylesheet'>

			</head>
			<body>
				<div class='navbar navbar-inverse navbar-fixed-top'>
					<div class='navbar-inner'>
						<div class='container'>
							<a class='btn btn-navbar' data-toggle='collapse' data-target='.nav-collapse'>
								<span class='icon-bar'></span>
								<span class='icon-bar'></span>
								<span class='icon-bar'></span>
							</a>
							<a class='brand' href='" . $home . "'>Podiatry Information System</a>
							<div class='nav-collapse collapse'>
								<ul class='nav'>
									<!--<li><a href='../../contact.html'>Contact</a></li>-->
									" . $dropdown . "
								</ul>
								<form class='navbar-form pull-right'> 
									<button type='button' onclick='location.href = \"" . $dir . "logout.php\"' class='btn'>Log Out</button> 
								</form>
							</div><!--/.nav-collapse -->
						</div>
					</div>
				</div>
				";

			return $func;
    }


    /**
     *
     * This is used to ensure that HTML closes properly.
     * @param type $dir <p>Directory to .css and .js files.</p> 
	 *
     * @return string <p>The footer.</p>
     */
    public function loadFooter($dir)
    {
		$func = "
		<hr>
		<footer>
                <p align='center'>&copy; Yaw Agyepong & Steven Ng 2013</p>
            </footer>
        </div> <!--/ container -->

        <script src='" . $dir . "bootstrap/js/jquery.js'></script>
        <script src='" . $dir . "bootstrap/js/bootstrap.js'></script>
		";
        return $func;
    }

}

?>