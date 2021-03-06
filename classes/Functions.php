<?php

class Functions {

    /**
     *  
     * We are using this function to convert a string into an image.  
     *   
     * @return string <p>We are returning the string as an image.</p>  
     */
    public static function doText($string) {
        return "<b><em>" . $string . "</em></b>";
    }

    public function doReq($string) {
        return $string;
    }

    /**
     *  
     * This method is used to indicate a table row class in a table. Use this  
     * method in an iterator.  
     *   
     * @param type $i <p>Iterator.</p>  
     * @return string <p>The class name.</p>  
     */
    function doRows($i) {
        switch (abs($i) % 2) {
            case 0: return "row1";
                break;
            case 1: return "row2";
                break;
        }
    }

    /**
     *   
     * This displays an anchor tag for a user to click on.   
     *    
     * @param type $url <p>URL to the next page.</p>   
     * @param type $alt <p>Hovering text over a link for a better description.</p>   
     * @param type $text <p>The text in which you will click on.</p>   
     * @param type $target <p>Which anchor you would like to use. 0 = Normal; 1 = New Page; 3 = Embedded Page.</p>   
     * @return string <p>The anchor.</p>   
     */
    public function doAnchor($url, $alt, $text, $target, $page = "#page") {
        switch ($target) {
            case 0:
                return '<a href="' . $url . '">' . $text . '</a>';
                break;
            case 1:
                return '<a href="' . $url . '" alt="' . $alt . '" target="_BLANK">' . $text . '</a>';
                break;
            case 3:
                //return "<a onclick='doLoad(\"" . $url . "\", false, \"" . $page . "\")' >" . $text . "</a>";    
                return "<a class='btn btn-info' href='" . $url . "'>" . $text . "</a>"; //new anchor tag format so link works w/bootstrap. works for the main.php for the 3 user types (maybe). the above is the old anchor type.   
                break;
        }
    }
	public function doFormButtonDefault($userId, $lastN, $text)
	{
		return '<div class="btn-group">   
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">' . $text . '
                <span class="caret"></span>  
                </a>  
                <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dLabel">   
                    <li class="nav-header">' . $lastN . '\'s Forms</li>      
                    <li class="dropdown-submenu">  
                        <a tabindex="0" href="#"> Pre-Op Eval Actions</a>  
                        <ul class="dropdown-menu">  
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../doctor/addneweval.php?patid=' . $userId . '">Fill Pre-Op Evaluation</a>  
                            </li>  
                        </ul>  
                    </li> 
                    <li class="dropdown-submenu">  
                        <a tabindex="1" href="#"> Demographic Actions</a>  
                        <ul class="dropdown-menu">  
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../addnewdemo.php?patid=' . $userId . '">Fill Demographic</a>  
                            </li>  
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../viewandmodifydemo.php?patid=' . $userId . '">View/Edit Demographic</a>  
                            </li>  
                        </ul>  
                    </li>   
                </ul>';
	}
	
	public function doFormButton($userId, $lastN, $text, $extremity)
	{
		return '<div class="btn-group">   
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">' . $text . '
                <span class="caret"></span>  
                </a>  
                <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dLabel">   
                    <li class="nav-header">' . $lastN . '\'s Forms</li>      
                    <li class="dropdown-submenu">  
                        <a tabindex="0" href="#"> Pre-Op Eval Actions</a>  
                        <ul class="dropdown-menu">  
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../doctor/addneweval.php?patid=' . $userId . '">Fill Pre-Op Evaluation</a>  
                            </li>  
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../doctor/viewandmodifyeval.php?patid=' . $userId . '&extremity=' . $extremity .'">View/Edit Pre-Op Evaluation</a>
                            </li>
                        </ul>  
                    </li> 
                    <li class="dropdown-submenu">  
                        <a tabindex="1" href="#"> Demographic Actions</a>  
                        <ul class="dropdown-menu">  
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../addnewdemo.php?patid=' . $userId . '">Fill Demographic</a>  
                            </li>  
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../viewandmodifydemo.php?patid=' . $userId . '">View/Edit Demographic</a>  
                            </li>  
                        </ul>  
                    </li> 
                    <li class="dropdown-submenu">  
                        <a tabindex="2" href="#"> McGill Pain Actions</a>  
                        <ul class="dropdown-menu">  
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../addnewmcgillpain.php?patid=' . $userId . '&type=1&extremity=' . $extremity .'">Fill Pre-Op McGill Pain</a>  
                            </li> 
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../addnewmcgillpain.php?patid=' . $userId . '&type=2&extremity=' . $extremity .'">Fill Post-Op McGill Pain</a>  
                            </li> 
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../addnewmcgillpain.php?patid=' . $userId . '&type=3&extremity=' . $extremity .'">Fill 3 Month McGill Pain</a>  
                            </li> 
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../addnewmcgillpain.php?patid=' . $userId . '&type=4&extremity=' . $extremity .'">Fill 6 Month McGill Pain</a>  
                            </li> 
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../addnewmcgillpain.php?patid=' . $userId . '&type=5&extremity=' . $extremity .'">Fill 12 Month McGill Pain</a>  
                            </li> 
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../formselection.php?patid=' . $userId . '&form=1&extremity=' . $extremity .'">View/Edit McGill Pain</a>  
                            </li>  
                        </ul>  
                    </li> 
                    <li class="dropdown-submenu">  
                        <a tabindex="3" href="#"> SF36 Actions</a>  
                        <ul class="dropdown-menu">  
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../addnewsf36.php?patid=' . $userId . '&type=1&extremity=' . $extremity .'">Fill Pre-Op SF36</a>  
                            </li> 
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../addnewsf36.php?patid=' . $userId . '&type=3&extremity=' . $extremity .'">Fill 3 Month SF36</a>  
                            </li> 
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../addnewsf36.php?patid=' . $userId . '&type=4&extremity=' . $extremity .'">Fill 6 Month SF36</a>  
                            </li> 
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../addnewsf36.php?patid=' . $userId . '&type=5&extremity=' . $extremity .'">Fill 12 Month SF36</a>  
                            </li> 
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../formselection.php?patid=' . $userId . '&form=2&extremity=' . $extremity . '">View/Edit SF36</a>
                            </li>  
                        </ul>  
                    </li> 
                    <li class="dropdown-submenu">  
                        <a tabindex="4" href="#"> Foot Health Actions</a>  
                        <ul class="dropdown-menu">  
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../addnewfoot.php?patid=' . $userId . '&type=1&extremity=' . $extremity .'">Fill Pre-Op Foot Health</a>  
                            </li> 
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../addnewfoot.php?patid=' . $userId . '&type=3&extremity=' . $extremity .'">Fill 3 Month Foot Health</a>  
                            </li> 
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../addnewfoot.php?patid=' . $userId . '&type=4&extremity=' . $extremity .'">Fill 6 Month Foot Health</a>  
                            </li> 
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../addnewfoot.php?patid=' . $userId . '&type=5&extremity=' . $extremity .'">Fill 12 Month Foot Health</a>  
                            </li> 
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../formselection.php?patid=' . $userId . '&form=3&extremity=' . $extremity . '">View/Edit Foot Health</a>  
                            </li>  
                        </ul>  
                    </li> 
                    <li class="dropdown-submenu">  
                        <a tabindex="5" href="#"> X-ray Actions</a>  
                        <ul class="dropdown-menu">  
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../doctor/addnewxray.php?patid=' . $userId . '&type=1&extremity=' . $extremity .'">Fill Pre-Op X-ray</a>  
                            </li> 
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../doctor/addnewxray.php?patid=' . $userId . '&type=3&extremity=' . $extremity .'">Fill 3 Month X-ray</a>  
                            </li> 
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../doctor/addnewxray.php?patid=' . $userId . '&type=4&extremity=' . $extremity .'">Fill 6 Month X-ray</a>  
                            </li> 
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../doctor/addnewxray.php?patid=' . $userId . '&type=5&extremity=' . $extremity .'">Fill 12 Month X-ray</a>  
                            </li> 
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../formselection.php?patid=' . $userId . '&form=4&extremity=' . $extremity . '">View/Edit X-ray</a>  
                            </li>  
                        </ul>  
                    </li> 
                    <li class="dropdown-submenu">  
                        <a tabindex="6" href="#"> Surgical Data Actions</a>  
                        <ul class="dropdown-menu">  
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../doctor/addnewsurgical.php?patid=' . $userId . '&extremity=' . $extremity .'">Fill Surgical Data</a>  
                            </li>  
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../doctor/viewandmodifysurgical.php?patid=' . $userId . '&extremity=' . $extremity . '">View/Edit Surgical Data</a>  
                            </li>  
                        </ul>   
                    </li> 
                    <li class="dropdown-submenu">  
                        <a tabindex="7" href="#"> Post-Evaluation Actions</a>  
                        <ul class="dropdown-menu">  
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../doctor/addnewposteval.php?patid=' . $userId . '&type=2&extremity=' . $extremity .'">Fill Post-Op Evaluation</a>  
                            </li> 
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../doctor/addnewposteval.php?patid=' . $userId . '&type=3&extremity=' . $extremity .'">Fill 3 Month Evaluation</a>  
                            </li> 
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../doctor/addnewposteval.php?patid=' . $userId . '&type=4&extremity=' . $extremity .'">Fill 6 Month Evaluation</a>  
                            </li> 
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../doctor/addnewposteval.php?patid=' . $userId . '&type=5&extremity=' . $extremity .'">Fill 12 Month Evaluation</a>  
                            </li> 
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../formselection.php?patid=' . $userId . '&form=5&extremity=' . $extremity . '">View/Edit Post-Evaluation</a>  
                            </li>  
                        </ul>       
                    </li>
					<li class="dropdown-submenu">  
                        <a tabindex="7" href="#"> Complications Action</a>  
                        <ul class="dropdown-menu">  
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../doctor/addnewcomplications.php?patid=' . $userId . '&type=2&extremity=' . $extremity .'">Fill Comp. Evaluation</a>  
                            </li> 
                            <li>  
                                <a role="menuitem" tabindex="-1" href="../doctor/viewandmodifycomplications.php?patid=' . $userId . '&extremity=' . $extremity . '">View/Edit Comp. Evaluation</a>  
                            </li>  
                        </ul>       
                    </li>
                </ul>';
	}
    //new way to display the buttons on the table for the admin(tentative) page to select the doctor's patients and editing a doctor   
    public function doButton($userId, $lastN, $btnId, $text, $select, $modalNum) {
        switch ($select) {
            case 0://returns a button for viewing the patients that belong to a doctor   
                return '<button type="button" id="' . $btnId . '" class="btn btn-info" onclick="loadIn(' . $userId . ',' . $btnId . ',\'' . $lastN . '\')">' . $text . '';
                break;
            case 1://returns a button for editing a doctor   
                return '<button type="button" id="' . $btnId . '" class="btn btn-info" onclick="loadIn(' . $userId . ',' . $btnId . ',\'' . $lastN . '\')">' . $text . '';
                break;
            case 2://returns a button that will display a modal for viewing a patient's profile   
				return '
				<a href="../doctor/pat_profile.php?patid=' . $userId . '" data-target="#myModal' . $modalNum . '" role="button" class="btn btn-info" id=' . $btnId . ' data-toggle="modal">' . $text . '</a>
				<div class="modal fade hide" id="myModal' . $modalNum . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
				<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 id="myModalLabel">Profile</h3>
				</div>
				<div class="modal-body">
				</div>
				<div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="location.href=\'../doctor/editpatient.php?patid=' . $userId . '\';">Edit Patient</button> 
					<button type="button" class="btn btn-info" onclick="location.href=\'../doctor/patscore.php?patid=' . $userId . '\';">Patient Scores</button> 
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>     
                  
                </div>';
                break;
        }
    }

    public static function disableElement($mode) {
        return ($mode === 'view') ? "disabled='disabled'" : "";
    }

    public static function formTitle($type, $formName, $extremity = "", $withHTML = true) {
        $title = "";
        
        $extremityText = ""; 
        if($extremity == 1){
            $extremityText = "(L)";
        } else if($extremity == 2) { 
            $extremityText = "(R)";
        }
        
        if ($formName == "POST-OPERATIVE Evaluation") {
            switch ($type) {
                case Constants::POST_OP:
                    $title = $title;
                    break;
                case Constants::THREE_MONTH:
                    $title = $title . "THREE MONTH";
                    break;
                case Constants::SIX_MONTH:
                    $title = $title . "SIXTH MONTH";
                    break;
                case Constants::TWELVE_MONTH:
                    $title = $title . "TWELVETH MONTH";
                    break;
            }
        } else {
            switch ($type) {
                case Constants::PRE_OP:
                    $title = $title . "PRE-OPERATIVE";
                    break;
                case Constants::POST_OP:
                    $title = $title . "POST-OPERATIVE";
                    break;
                case Constants::THREE_MONTH:
                    $title = $title . "THREE MONTH";
                    break;
                case Constants::SIX_MONTH:
                    $title = $title . "SIXTH MONTH";
                    break;
                case Constants::TWELVE_MONTH:
                    $title = $title . "TWELVETH MONTH";
                    break;
                default: 
                    $title = "";
            }
        }
        $title = $title . " " . $formName . " " . $extremityText;
        return ($withHTML ? Functions::doText($title) : $title);
    }
    
    public static function getUserHome(DatabaseUserObject $user){
        
        switch($user->getRole()){
            case 1:
                return Constants::PROJECT_PATH ."/main.php";
                break;
            case 2:
                return Constants::PROJECT_PATH . "/" . Constants::DOCTOR_DIRECTORY . "/main.php";
                break;
            case 3:
                return Constants::PROJECT_PATH . "/" . Constants::ADMIN_DIRECTORY . "/main.php";
                break;
            default: 
                return "";
        }
    }
    
    public static function isValidDate($month, $day, $year){
        if(empty($month) || empty($day) || empty($year)){
            return false;
        }
        if(!filter_var($month, FILTER_VALIDATE_INT) 
                || !filter_var($day, FILTER_VALIDATE_INT) 
                || !filter_var($year, FILTER_VALIDATE_INT)){
            return false;
        }
        
        return checkdate($month, $day, $year);
    }
    

}