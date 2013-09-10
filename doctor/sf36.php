<?php

session_start();                 // Start Session
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

if (isset($_POST['SUBMIT']) == FALSE)
{
    // Load the HTML, CSS.
    echo $layout->loadCSS("", "");
    // Header
    echo $layout->doHead($func->doText("", "grey"), $func->doText("SF-36", "grey"));
    $t = getdate();
    $tday = $t['mday'];
    $tmonth = $t['mon'];
    $tyear = $t['year'];

    echo "
            <form action='" . $_SERVER['SCRIPT_NAME'] . "' method='post'>
                <div class='container'>
                    <div class='greybox'>
                                    <p>1) Patient: " . $patient->GetFullName() . "&nbsp;&nbsp;&nbsp;
                                       2) Date (MM-DD-YYYY) <input type='text' size='2' maxlength='2' name='M' value ='" . $tmonth ."'/>
                                                            -<input type='text' size='2' maxlength='2' name='D' value='" . $tday ."'/>
                                                            -<input type='text' size='4' maxlength='4' name='Y' value='" . $tyear ."'/>&nbsp;&nbsp;&nbsp;
                                       3) Extremity: " . $patient->GetExtremity() . "
                                    </p>
	";

    
    for ($i = 4; $i < 6; $i++)  {
        $question_query = sprintf("SELECT * FROM ques_sf36 WHERE num = %d", $i);
        $question_answer = mysql_query($question_query);
        $question = mysql_fetch_array($question_answer);

        $value_query = sprintf("SELECT * FROM vals_sf36 WHERE ques_num = %d", $i);
        $values = mysql_query($value_query);

        echo "<p>" . $question['num'] . ") " . $question['question'] . "&nbsp;&nbsp;&nbsp;";

        if ($i == 5) {
           echo "<br>&nbsp;&nbsp;&nbsp;";
        } 

        while($value = mysql_fetch_array($values))
        {
            echo "<input type='radio' name ='" . $i . "' value='" . $value['pre_val'] . "'>" . $value['val'] . "&nbsp;&nbsp;&nbsp;";
        }
        
        echo "</p>";
      }

      echo "                            
                            </div>
                        </div>
                        <div class='container'>
                            <div class='whitebox'>
                                <table>
                                    <tr>
                                            <td colspan='4'>6) THE FOLLOWING QUESTIONS ARE ABOUT ACTIVITIES YOU MIGHT DO DURING A TYPICAL DAY. DOES YOUR HEALTH <u>NOW</u> LIMIT YOU IN THESE ACTIVITIES? IF SO, HOW MUCH?</td>
                                    </tr>
                                    <tr style='text-align: center;'>
                                            <td>&nbsp;</td>
                                            <td>Yes, Limited <br />a lot</td>
                                            <td>Yes, Limited <br />a little</td>
                                            <td>No, not <br />limited at all</td>
                                    </tr>
                    ";
      
     for ($i = 7; $i < 17; $i++) {
         echo "<tr><td>";
         $question_query = sprintf("SELECT * FROM ques_sf36 WHERE num = %d", $i);
         $question_answer = mysql_query($question_query);
         $question = mysql_fetch_array($question_answer);

         $value_query = sprintf("SELECT * FROM vals_sf36 WHERE ques_num = %d", $i);
         $values = mysql_query($value_query);

         echo "" . $question['num'] . ") " . $question['question'] . "</td>";
         for($j = 1; $j < 4; $j++)
            {
               echo "<td align='center'><input type='radio' name ='" . $i . "' value='" . $j . "'></td>";
            }
         echo "</tr>";
     }

     echo "
                                </table>
                            </div>
                        </div>
                        <div class='container'>
                            <div class='greybox'>
                             <p>17) DURING THE PAST 4 WEEKS, HAVE YOU HAD ANY OF THE FOLLOWING PROBLEMS WITH YOUR WORK OR OTHER REGULAR DAILY ACTIVITIES AS A RESULT OF YOUR PHYSICAL HEALTH?</p>
                                <table>
                                    
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td align='center'>Yes</td>
                                        <td align='center'>No</td>
                                    </tr>
                    ";

     for ($i = 18; $i < 22; $i++) {
         echo "<tr><td>";
         $question_query = sprintf("SELECT * FROM ques_sf36 WHERE num = %d", $i);
         $question_answer = mysql_query($question_query);
         $question = mysql_fetch_array($question_answer);

         $value_query = sprintf("SELECT * FROM vals_sf36 WHERE ques_num = %d", $i);
         $values = mysql_query($value_query);

         echo "" . $question['num'] . ") " . $question['question'] . "&nbsp;&nbsp;&nbsp;</td>";
         for($j = 1; $j < 3; $j++)
            {
               echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name ='" . $i . "' value='" . $j . "'>&nbsp;&nbsp;&nbsp;</td>";
            }
         echo "</tr>";
     }

     echo "
                                </table>
                            </div>
                        </div>
                        <div class='container'>
                            <div class='whitebox'>
                                <p>22) DURING THE PAST 4 WEEKS, HAVE YOU HAD ANY OF THE FOLLOWING PROBLEMS WITH YOUR WORK OR OTHER REGULAR DAILY ACTIVITIES AS A RESULT OF ANY EMOTIONAL PROBLEMS (SUCH AS FEELING DEPRESSED OR ANXIOUS)?
                                    </p>
                                <table>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td align='center'>Yes</td>
                                        <td align='center'>No</td>
                                    </tr>
                    ";
            
         for ($i = 23; $i < 26; $i++) {
           echo "<tr><td>";
           $question_query = sprintf("SELECT * FROM ques_sf36 WHERE num = %d", $i);
           $question_answer = mysql_query($question_query);
           $question = mysql_fetch_array($question_answer);

           $value_query = sprintf("SELECT * FROM vals_sf36 WHERE ques_num = %d", $i);
           $values = mysql_query($value_query);

           echo "" . $question['num'] . ") " . $question['question'] . "&nbsp;&nbsp;&nbsp;</td>";
           while($value = mysql_fetch_array($values))
            {
               echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name ='" . $i . "' value='" . $value['pre_val'] . "'>&nbsp;&nbsp;&nbsp;</td>";
            }
           echo "</tr>";
         }
             
      echo "
                            </table>
                        </div>
                    </div>
                    <div class='container'>
                        <div class='greybox'>";
                            
                            echo "<table>";
                            for($i = 26; $i < 29; $i++) {
                                  $question_query = sprintf("SELECT * FROM ques_sf36 WHERE num = %d", $i);                                                              
                                  $question_answer = mysql_query($question_query);
                                  $question = mysql_fetch_array($question_answer);

                                  echo "<tr><td colspan='7'>";
                                  echo $question['num'] . ") " . $question['question'] . "&nbsp;&nbsp;&nbsp;</td></tr><tr><td>&nbsp;&nbsp;&nbsp;</td>";
                                  for($j = 1; $j < 7; $j++) {
                                     $value_query = sprintf("SELECT * FROM vals_sf36 WHERE ques_num = %d AND pre_val = %d", $i, $j);
                                     $values = mysql_query($value_query);
                                     $value = mysql_fetch_array($values);

                                     if ($value != FALSE) {
                                         echo "<td><input type='radio' name ='" . $i . "' value='" . $value['pre_val'] . "'>" . $value['val'] . "&nbsp;&nbsp;&nbsp;";
                                     }
                                   }
                                   echo "</tr>";
                             }
                             echo "</table>";
                                
                

      echo "
                            </table>
                        </div>
                    </div>
                    <div class='container'>
                        <div class='whitebox'>
                            <table>
                                <tr>
                                    <td colspan='7'>29) THESE QUESTIONS ARE ABOUT HOW YOU FEEL AND HOW THINGS HAVE BEEN WITH YOU DURING THE <u>PAST 4 WEEKS</u>. FOR EACH QUESTION, PLEASE GIVE THE ONE ANSWER THAT COMES CLOSEST TO THE WAY YOU HAVE BEEN FEELING.<br /><br /></td>
                                </tr>
                                <tr>
                                    <td colspan='7'>30) HOW MUCH OF THE TIME DURING THE <u>PAST 4 WEEKS</u>...</td>
                                </tr>
                                <tr style='text-align: center;'>
                                        <td>&nbsp;</td>
                                        <td>All of the time</td>
                                        <td>Most of the time</td>
                                        <td>A good bit of the time</td>
                                        <td>Some of the time</td>
                                        <td>A little of the time</td>
                                        <td>None of the time</td>
                                </tr>
                ";
                 for ($i = 31; $i < 40; $i++) {
                   echo "<tr><td>";
                   $question_query = sprintf("SELECT * FROM ques_sf36 WHERE num = %d", $i);
                   $question_answer = mysql_query($question_query);
                   $question = mysql_fetch_array($question_answer);

                   $value_query = sprintf("SELECT * FROM vals_sf36 WHERE ques_num = %d", $i);
                   $values = mysql_query($value_query);

                   echo "" . $question['num'] . ") " . $question['question'] . "&nbsp;&nbsp;&nbsp;</td>";
                   while($value = mysql_fetch_array($values))
                   {
                             echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name ='" . $i . "' value='" . $value['pre_val'] . "'>&nbsp;&nbsp;&nbsp;</td>";
                   }
                   echo "</tr>";
                 }
                 $i = 40;
                 echo "
                                </table>
                            </div>
                        </div>
                        <div class='container'>
                            <div class='greybox'>
                            
                                <table>";
                                    $question_query = sprintf("SELECT * FROM ques_sf36 WHERE num = %d", $i);
                                    $question_answer = mysql_query($question_query);
                                    $question = mysql_fetch_array($question_answer);

                                    $value_query = sprintf("SELECT * FROM vals_sf36 WHERE ques_num = %d", $i);
                                    $values = mysql_query($value_query);

 
                                    echo"
                                    <tr>
                                        <td colspan='6'>" . $question['num'] . ") " . $question['question'] . ":</td>
                                    </tr>
                                    <tr style='text-align: center;'>
                                        <td>&nbsp;</td>
                                        <td>All of the time</td>
                                        <td>Most of the time</td>
                                        <td>Some of the time</td>
                                        <td>A little of the time</td>
                                        <td>None of the time</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>";

                                        while($value = mysql_fetch_array($values))
                                        {
                                               echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name ='" . $i . "' value='" . $value['pre_val'] . "'>&nbsp;&nbsp;&nbsp;</td>";
                                        }
                                    echo "</tr>";
                                   
                                    echo "<tr>
                                    <td colspan='6'>41) HOW TRUE OR FALSE IS <u>EACH</u> OF THE FOLLOWING STATEMENTS FOR YOU?</td></tr>
                                    <tr style='text-align: center;'>
                                          <td>&nbsp;</td>
                                          <td>Definitely true</td>
                                          <td>Mostly true</td>
                                          <td>Don't know</td>
                                          <td>Mostly false</td>
                                          <td>Definitely false</td>
                                    </tr>";
                                    for ($i = 42; $i < 46; $i++) {
                                             echo "<tr><td>";
                                             $question_query = sprintf("SELECT * FROM ques_sf36 WHERE num = %d", $i);
                                             $question_answer = mysql_query($question_query);
                                             $question = mysql_fetch_array($question_answer);

                                             $value_query = sprintf("SELECT * FROM vals_sf36 WHERE ques_num = %d", $i);
                                             $values = mysql_query($value_query);

                                             echo "" . $question['num'] . ") " . $question['question'] . "&nbsp;&nbsp;&nbsp;</td>";
                                             for ($j = 1; $j < 6; $j++) {
                                                        echo "<td align='center'>&nbsp;&nbsp;&nbsp;<input type='radio' name ='" . $i . "' value='" . $j . "'>&nbsp;&nbsp;&nbsp;</td>";
                                             }
                                    echo "</tr>";
                 }
                    
     echo "
                        </table>
                    </div>
                </div>
                <div class='container'>
                    <div><input type='submit' name='SUBMIT' value='Finish Questionaire' /></div>
                </div>
            </form>
	";

    echo $layout->doFoot();
}
else if (isset($_POST['SUBMIT']) == TRUE)
{
    
    if (empty($_POST['Y']))
    {
        $error->doGo("main.php", "Fill in the date.");
    }
    if (empty($_POST['M']))
    {
        $error->doGo("main.php", "Fill in the date.");
    }
    if (empty($_POST['D']))
    {
        $error->doGo("main.php", "Fill in the date.");
    }
    // Date of when you submitted the answers.
    $dateof = mktime(0, 0, 0, $clean->toInt($_POST['M']), $clean->toInt($_POST['D']), $clean->toInt($_POST['Y']));
        
    // Add answers to database.
    for ($i = 4; $i <= 46; $i++)
     {
        if (!empty($_POST[$i]))
        {
          $insert_query = sprintf("INSERT INTO ans_sf36 (dateof, answer, ques_num, pat_id) VALUES (%d, %d, %d, %d)",
                                                                                                   $dateof,
                                                                                                   $_POST[$i],
                                                                                                   $i,
                                                                                                   $patient->GetId());
          mysql_query($insert_query);
            
        }
    }

    // Insert Patient Scores.
    $patient->InsertScores($dateof);
    // Redirect
    $error->doGo("main.php", "Success!");
}
?>