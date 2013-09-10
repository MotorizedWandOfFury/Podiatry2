<?php

/**
 * This class is important, as it helps with the layout of various pages.
 */
class Layout2
{

    /**
     *
     * This function is used to set up the main HTML header.
     * 
     * @param type $title <p>The title for the page.</p>
     * @param type $dir <p>Directory to .css and .js files.</p>
     * @return string <p>The header.</p>
     */
    public function loadCSS($title, $dir)
    {
        $func = "
			<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
			<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>
				<head>
					<meta http-equiv='Content-Type' content='text/html;charset=utf-8' />
					<title>" . $title . "</title>
					<link rel='stylesheet' href='" .$dir. "css.css' />
					<link rel='shortcut icon' type='image/x-icon' href='' />
					<script type='text/javascript' src='" . $dir . "js/jquery-1.6.2.min.js'></script>
					<script type='text/javascript' src='" . $dir . "js/script.js'></script>
                    <script type='text/javascript' src='" . $dir . "js/form.js'></script>
                        
				</head>
		";

        return $func;
    }

    /**
     *
     * This function is used to help load the body of the HTML page.
     * 
     * @return string <p>The body of the page.</p>
     */
    public function startBody()
    {
        $func = "
            <body>
                <div id='body'>
                <h2>Podiatry Information System</h2>
        ";

        return $func;
    }

    /**
     *
     * <p>This function is used to display the header or title for a page.</p>
     * <p>It is typically used in survey pages.</p>
     * 
     * @param type $head1 <p>Header text for a page. (top)</p>
     * @param type $head2 <p>Header text for a page. (bottom)</p>
     * @return string <p>The header.</p>
    */
    public function doHead($head1, $head2)
    {
        $func = "<div id='header'><div>" . $head1 . "</div><div>" . $head2 . "</div></div>";

        return $func;
    }
    
    /**
     *
     * <p>This function is used to display various links based on user role.</p>
     * <p>The links will be displayed to the left side of the window.</p>
     * 
     * @global type $patient <p>Patient object.</p>
     * @global type $doctor <p>Doctor object.</p>
     * @global type $admin <p>Administrator object.</p>
     * @global type $time <p>Time object.</p>
     * @return string <p>Layout of the page.</p>
     */
    public function doLinks()
    {
        // Global Variables
        global $patient, $doctor, $admin, $time;
        // We need access to a few functions.
        $fun = new Functions();
        // Start links.
        $links = "&nbsp;";
        // Start layout
        $func = "
			<div class='container'>
				<div style='float: left;'>
		";

        /**
         * Patient.
         */
        if ($patient)
        {
            $func .= "
				<div>Logged in as " . $patient->getUserName() . "</div>
				
			";

            $links = "
				<dl>
					
					<dt>" . $fun->doText("", "green") . "</dt>
					<dt>" . $fun->doText("Examinations", "green") . "</dt>
					<dd>" . $fun->doAnchor("demo.php", "Fill", "Demo. Question", 3) . "</dd>
					<dd>" . $fun->doAnchor("pain.php", "Fill out McGill Pain Questionnaire", "McGill Pain", 3) . "</dd>
					<dd>" . $fun->doAnchor("sf36.php", "Fill out SF-36 Questionnaire", "SF-36 Questionnaire", 3) . "</dd>
					<dd>" . $fun->doAnchor("foothealth.php", "Fill out FootHealth Questionnaire", "Foot Health", 3) . "</dd>
				</dl>
			";
        }

        /**
         * Doctor.
         */
        if ($doctor->isLogged() == TRUE)
        {
            $func .= "
				<div>Logged in as: " . $doctor->doUserName() . "</div>
				
			";

            $links = "
				<dl>
					<dt>" . $fun->doText("", "green") . "</dt>
                              <dd>" . $fun->doAnchor("main.php", "", "Physician Main Page", 0) . "</dd>

					<dt>" . $fun->doText("Patients", "green") . "</dt>
					<dd>" . $fun->doAnchor("add_patient.php", "", "Add Patient", 3) . "</dd>
                    <dd id='l5'><span style='color: grey; font-weight: bold;'>Edit Patient</span></dd>
					<dt>" . $fun->doText("Examinations", "green") . "</dt>
                    <dd id='l1'><span style='color: grey; font-weight: bold;'>Pre-Op Eval</span></dd>
					<dd id='l2'><span style='color: grey; font-weight: bold;'>Surgical Data</span></dd>
					<dd id='l3'><span style='color: grey; font-weight: bold;'>X-Ray Evaluation</span></dd>
					<dd id='l4'><span style='color: grey; font-weight: bold;'>Post Evaluation</span></dd>
                    <dt>" . $fun->doText("Statistics", "green") . "</dt>
                    <dd>" . $fun->doAnchor("pat_preop_score.php", "", "SF-36 Scores", 3) . "</dd>
				</dl>
			";
        }

        /**
         * Admin.
         * KK added: Patients and view Patients
         */
        if ($admin->isLogged() == TRUE)
        {
            $func .= "
				<div>Logged in as: " . $admin->doUserName() . "</div>
				
			";
        }

        $func .= "
				</div>
				<div style='float: right;'>
					<div id='timer'>" . $time->doFullDate(time()) . "</div>
				</div>
			</div>
		";

        return $func;
    }

    /**
     * After all of the main content have been loaded, load a footer.
     * @return string <p>The footer.</p>
     */
    public function doLinksFoot()
    {
        $func = "
						</td>
					</tr>
				</table>
			</div>
		";

        return $func;
    }

    /**
     *
     * This function is used to close the body of an HTML page.
     * 
     * @return string <p>The HTML</p>
     */
    public function endBody()
    {
        $func = "
                </div>
            </body>
        ";

        return $func;
    }

    /**
     *
     * This is used to ensure that HTML closes properly.
     * 
     * @return string <p>The footer.</p>
     */
    public function doFoot()
    {
        $func = "
			</html>
		";

        return $func;
    }

}

?>