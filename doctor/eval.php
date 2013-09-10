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

if ($doctor->isLogged() == FALSE)
    $error->doGo("index.php", "Only for doctors.");

if (empty($_GET['id']))
    $error->doGo("index.php", "Id not specified.");

// Clean Id.
$pat_id = $clean->toInt($_GET['id']);
// Get Patient
$pat = new Patient($pat_id);

$query = "SELECT * FROM ans_eval WHERE pat_id = " . $pat_id;

$result = mysql_query($query);

if (FALSE) {
   
    }
else

{
// Create a query for the questions
// $questions = $database->doQuery("SELECT * FROM ques_eval");

if (isset($_POST['SUBMIT']) == FALSE) {
    // Load the HTML, CSS.
    echo $layout->loadCSS("PRE-OPERATIVE Evaluation", "../");
    // Header
    // echo $layout->doHead($func->doText("PRE-OPERATIVE EVALUATION", "grey"), $func->doText("Evaluation", "grey"));

    $query = "SELECT * FROM ans_eval WHERE pat_id = " . $pat_id;
    $result = mysql_query($query);

    if (mysql_num_rows($result) > 0) {
   
        $row = mysql_fetch_array($result);
        echo "<p>RESULTS FOR PRE-OPERATIVE EVALUATION CONDUCTED ";
        echo date("M d Y", $row['dateofexam']);
        echo "</p>";
    }

    echo"<form action='" . $_SERVER['SCRIPT_NAME'] . "?id=" . $pat_id . "' method='post'>
            <div class='container'>
                <div class='greybox'>
                    <table>
                        <tr>
                            <td><b>1) Last Name:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td><td> " . $pat->GetLastName() . "&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td><b>2) First Name:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td><td> " . $pat->GetFirstName() . "&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <tr>
                            <td><b>3) Surgeon:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td><td> " . $doctor->GetFullName() . "&nbsp;&nbsp;&nbsp;&nbsp;</td>";
			    
     if ($row) {
                 $datearray = getdate($row['dateofexam']);
                 $d = $datearray['mon'];
                 $y = $datearray['year'];
                 $m = $datearray['mday'];
     }
                     echo "<td><b>4) Date of exam (MM-DD-YYYY)</b></td>
                            <td><input type='text' size='2' name='M' value=" . $m . ">-
                                <input type='text' size='2' name='D' value=" . $d . ">-
                                <input type='text' size='4' name='Y' value=" . $y . ">
                             </td>
 			     <td><b>5) Extremity:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>" . $pat->GetExtremity(). "&nbsp;&nbsp;&nbsp;&nbsp;</td>
                         </tr>
                         <tr>
                             <td><b>6) Age:</b></td><td>" . $pat->GetAge() . "&nbsp;&nbsp;&nbsp;&nbsp;</td>
                             <td><b>7) Sex:</b></td><td>" . $pat->GetSex() . "&nbsp;&nbsp;&nbsp;&nbsp;</td>
                             <td><b>8) Height:</b></td><td>" . $pat->GetHeight(). " in&nbsp;&nbsp;&nbsp;&nbsp;</td>
                             <td><b>9) Weight:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>" . $pat->GetWeight() ." lbs</td>
                          </tr>
                     </table>
                </div>
            </div>
            <div class='container'>
                <div class='whitebox'>
                     <table>";

        for($num = 10; $num < 15; $num++) { 
                
                    // get the relevant question information
                    $question_query = sprintf("SELECT * FROM ques_eval WHERE num = %d", $num);
                    $question_array = mysql_query($question_query);
                    $question = mysql_fetch_array($question_array);

                    
                   
                    echo "
                          <tr>
                               <td><b>" . $question['num'] . ") " . $question['question'] . ":</b>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>
                           ";
                    
                    
                    $values = mysql_query("SELECT * FROM vals_eval WHERE ques_num = '" . $question['num'] . "'");

                    while($value = mysql_fetch_array($values)) {
                        // Get answer, if any, for current patient
                        $query = sprintf("SELECT * FROM ans_eval WHERE pat_id = %d
                                                                   AND ques_num = %d
                                                                   AND answer = %d",
                                         $pat_id, $num, $value['id']); 
                        $previous_answer =  mysql_query($query);

                        if (mysql_num_rows($previous_answer) == 1) {
                           $input_box = sprintf("<input type = 'radio'
                                                         name = %d checked='checked'
                                                         value = %d>
                                                   %s &nbsp;&nbsp;&nbsp;&nbsp;",
                                                   $num, $value['id'], $value['val']);
                           }
                        else {
                            $input_box = sprintf("<input type = 'radio'
                                                         name = %d
                                                         value = %d>
                                                   %s &nbsp;&nbsp;&nbsp;&nbsp;",
                                                   $num, $value['id'], $value['val']);
                        } 
                        echo $input_box;

                    }
                 echo "</tr>";
             }

           
            $question_array = mysql_query("SELECT * FROM ques_eval WHERE num = 15");
            $question = mysql_fetch_array($question_array);
             
            $res = mysql_query("SELECT * FROM ans_eval WHERE ques_num = 15 AND pat_id = " . $pat_id);
            $row = mysql_fetch_array($res);
	    echo "
                               <tr>
                                    <td><b>" . $question['num'] . ") " . $question['question'] . ":</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td>
                                   <input type='text' name='15' value=" . $row['answer'] . "> months
                                     </td>
                                  </tr>
                                      ";



           echo "                      </table>
                   </div>
               </div>
               <div class='container'>
                  <div class='greybox'>
                     <table>
                    ";

                $questions = mysql_query("SELECT * FROM ques_eval WHERE num= 16"); 

                    $question = mysql_fetch_array($questions);

                    echo "
                          <tr>
                               <td><b>" . $question['num'] . ") " . $question['question'] . ":</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                           ";
                    
                    $values = mysql_query("SELECT * FROM vals_eval WHERE ques_num = '" . $question['num'] . "'");

                    while($value = mysql_fetch_array($values)) {
                        // Get answer, if any, for current patient
                        $query = sprintf("SELECT * FROM ans_eval WHERE pat_id = %d
                                                                   AND ques_num = %d
                                                                   AND answer = %d",
                                         $pat_id, $num, $value['id']); 
                        $previous_answer =  mysql_query($query);

                        if (mysql_num_rows($previous_answer) == 1) {
                           $input_box = sprintf("<td><input type = 'radio'
                                                         name = %d checked='checked'
                                                         value = %d>
                                                   %s &nbsp;&nbsp;&nbsp;&nbsp;</td>",
                                                   $num, $value['id'], $value['val']);
                           }
                        else {
                            $input_box = sprintf("<td><input type = 'radio'
                                                         name = %d
                                                         value = %d>
                                                   %s &nbsp;&nbsp;&nbsp;&nbsp;</td>",
                                                   $num, $value['id'], $value['val']);
                        } 
                        echo $input_box;
                     }

            for($num = 17; $num < 19; $num++) {
                    $questions = mysql_query("SELECT * FROM ques_eval WHERE num=" . $num); 

                    $question = mysql_fetch_array($questions);

                    echo "
                          <tr>
                               <td><b>" . $question['num'] . ") " . $question['question'] . ":</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                           ";
 
                    $values = mysql_query("SELECT * FROM vals_eval WHERE ques_num = '" . $question['num'] . "'");

                    $i = 0;
                    while($value = mysql_fetch_array($values)) {
                        // Get answer, if any, for current patient
                        $query = sprintf("SELECT * FROM ans_eval WHERE pat_id = %d
                                                                   AND ques_num = %d
                                                                   AND answer = %d",
                                         $pat_id, $num, $value['id']); 
                        $previous_answer =  mysql_query($query);

                        if (mysql_num_rows($previous_answer) == 0) {
                           $input_box = sprintf("<td><input type = 'checkbox'
                                                         name = %d[]
                                                         value = %d>
                                                   %s &nbsp;&nbsp;&nbsp;&nbsp;</td>",
                                                   $num, $value['id'], $value['val']);
                           }
                        else {
                            $input_box = sprintf("<td><input type = 'checkbox'
                                                         name = %d[] checked='checked'
                                                         value = %d>
                                                   %s &nbsp;&nbsp;&nbsp;&nbsp;</td>",
                                                   $num, $value['id'], $value['val']);
                        } 
                        echo $input_box;
                        $i++;

                        if($i == 4 || $i == 8) {
                          echo "</td></tr><tr><td>";
                        }

                    }
                 echo "</tr>";
             }
?>
            
         </table>
       </div>
       
      
       <div class='whitebox'>
                             <h4>Pre-op ROM:<img style='width: 200px; height: 200px;' src='picture.bmp' align='right'/></h4>
                             <p>If above long axis of metatarsal enter a positive value.<br>
                             If below long axis of metatarsal enter a negative value.</p>
                                <table><tr>
               <?php
                    for($num = 19; $num < 21; $num++) {
                            $questions = mysql_query("SELECT * FROM ques_eval WHERE num=" . $num); 
                            $question = mysql_fetch_array($questions);

                            $res = mysql_query("SELECT * FROM ans_eval WHERE ques_num =". $num . " AND pat_id = " . $pat_id);
                            $row = mysql_fetch_array($res);
		
                            echo "
                                <tr><td><b>" . $question['num'] . ") " . $question['question'] . ":</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td>
                                   <input type='text' name=" . $num . " value=" . $row['answer'] . "> 
                            </td>
                         </tr>
                    ";
                   }
 

             for($num = 21; $num < 24; $num++) {
                    $questions = mysql_query("SELECT * FROM ques_eval WHERE num=" . $num); 

                    $question = mysql_fetch_array($questions);

                    echo "
                          <tr>
                               <td><b>" . $question['num'] . ") " . $question['question'] . ":</b>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>
                           ";                  
                    $values = mysql_query("SELECT * FROM vals_eval WHERE ques_num = '" . $question['num'] . "'");

                    while($value = mysql_fetch_array($values)) {
                        // Get answer, if any, for current patient
                        $query = sprintf("SELECT * FROM ans_eval WHERE pat_id = %d
                                                                   AND ques_num = %d
                                                                   AND answer = %d",
                                         $pat_id, $num, $value['id']); 
                        $previous_answer =  mysql_query($query);

                        if (mysql_num_rows($previous_answer) == 1) {
                           $input_box = sprintf("<input type = 'radio'
                                                         name = %d checked='checked'
                                                         value = %d>
                                                   %s &nbsp;&nbsp;&nbsp;&nbsp;",
                                                   $num, $value['id'], $value['val']);
                           }
                        else {
                            $input_box = sprintf("<input type = 'radio'
                                                         name = %d
                                                         value = %d>
                                                   %s &nbsp;&nbsp;&nbsp;&nbsp;",
                                                   $num, $value['id'], $value['val']);
                        } 
                        echo $input_box;

                    }
                 echo "</tr>";
             }

              ?>
          </table>
        </div>

       <div class='greybox'>
       <table>
            <?php
                for($num = 24; $num < 28; $num++) {
                    $questions = mysql_query("SELECT * FROM ques_eval WHERE num=" . $num); 

                    $question = mysql_fetch_array($questions);

                    echo "
                          <tr>
                               <td><b>" . $question['num'] . ") " . $question['question'] . ":</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                           ";
 
                    $values = mysql_query("SELECT * FROM vals_eval WHERE ques_num = '" . $question['num'] . "'");

                    if ($question['mult'] == 1) {
                         $type = "checkbox";
                         $name = sprintf("%d[]", $num);
                    }
                    else {
                         $type = "radio";
                         $name = sprintf("%d", $num);
                    }

                    $i = 0;
                    while($value = mysql_fetch_array($values)) {
                           // Get answer, if any, for current patient
                           $query = sprintf("SELECT * FROM ans_eval WHERE pat_id = %d
                                                                   AND ques_num = %d
                                                                   AND answer = %d",
                                            $pat_id, $num, $value['id']); 
                           $previous_answer =  mysql_query($query);

                           if (mysql_num_rows($previous_answer) == 0) {
                              $input_box = sprintf("<td><input type = '%s'
                                                         name = '%s'
                                                         value = '%d'>
                                                   %s &nbsp;&nbsp;&nbsp;&nbsp;</td>",
                                                   $type, $name, $value['id'], $value['val']);
                              }
                           else {
                               $input_box = sprintf("<td><input type = '%s'
                                                         name = '%s' checked='checked'
                                                         value = '%d'>
                                                   %s &nbsp;&nbsp;&nbsp;&nbsp;</td>",
                                                   $type, $name, $value['id'], $value['val']);
                           } 
                           echo $input_box;
                           
                       }

                       echo "</tr>";
             }

 

            echo "
                    </table>
                </div>
            </div>
            <div class='container'>
                    <div><input type='submit' name='SUBMIT' value='Submit Data'></div>
            </div>
        </form>";

} 
else if (isset($_POST['SUBMIT']) == TRUE) {
    
    //Get rid of the values we already stored for this patient
    $del_query = sprintf("DELETE FROM ans_eval WHERE pat_id = %d", $pat_id);
    mysql_query($del_query);
   
    // Date form submitted
    $dateof = time();

    if (empty($_POST['Y']) || empty($_POST['M']) ||  empty($_POST['D'])) {
        $dateofexam = $dateof;
    }
    else {
        $dateofexam = mktime(0, 0, 0, $_POST['M'], $_POST['D'], $_POST['Y']);
    }
   
    for ($i == 0; $i < 28; $i++) {

         // Find out whether question allows for multiple answers
         $question_query = sprintf("SELECT * FROM ques_eval WHERE num = %d", $i);
         $question_res = mysql_query($question_query);

         if (mysql_num_rows($question_res) > 0) {
            $question_row = mysql_fetch_array($question_res);

            // Check if the question allows for multiple answers.  If not, proceed

            if ($question_row['mult'] == 0) {
               $query = sprintf ("INSERT INTO ans_eval (dateof, dateofexam, answer, ques_num, pat_id, sur_id) 
                                           VALUES      (%d,     %d,         %d,     %d,       %d,       %d)",
                                             $dateof, 
                                             $dateofexam, 
                                             $_POST[$i], 
                                             $i, 
                                             $pat_id, 
                                             @$_SESSION[$var->GetSessionDoctorId()]);
                 mysql_query($query);
             }
             // If it does, process the checkbox array
             else {
                $ans_array = $_POST[$i];
                $end = count($ans_array);

                for($j = 0; $j < $end; $j++) {
                   $query = sprintf ("INSERT INTO ans_eval (dateof, dateofexam, answer, ques_num, pat_id, sur_id) 
                                               VALUES      (%d,     %d,         %d,     %d,       %d,       %d)",
                                             $dateof, 
                                             $dateofexam, 
                                             $ans_array[$j], 
                                             $i, 
                                             $pat_id, 
                                             @$_SESSION[$var->GetSessionDoctorId()]);
                   mysql_query($query);
                }
                
             }
          }
    }

    $error->doGo("main.php", sprintf("Pre-operative evaluation for %s %s stored", $pat->GetFirstName(), $pat->GetLastName()));
   }
}
?>
