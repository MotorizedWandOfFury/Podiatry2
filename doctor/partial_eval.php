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

echo $pat_id;

// check if we have come here via a submission

if (isset($_POST['pre-op-eval']) == TRUE)

{
    

    // Date form submitted
    $dateof = time();
    
    if (empty($_POST['Y']) || empty($_POST['M']) || empty($_POST['D'])) {
        $dateofexam = $dateof;
    }
    else {
          $dateofexam = mktime(0, 0, 0, $clean->toInt($_POST['M']), $clean->toInt($_POST['D']), $clean->toInt($_POST['Y']));
    }

    // Days of pain meds.
    $durofsymp = $clean->toInt($_POST[15]);
    // Max dorsiflexion.
    $maxdors = $clean->toInt($_POST[19]);
    // Max plantarflexion
    $maxplans = $clean->toInt($_POST[20]);

    $ins_query = "INSERT INTO ans_eval (dateof, dateofexam, durofsymp, maxdors, maxplans, answer, ques_num, pat_id) VALUES (3,3,3,3,3,3,3,3)"; 
    echo $ins_query;

    mysql_query($ins_query);

   }

else

if (isset($_POST['pre_op_eval']) == FALSE) {

       // First we figure out whether we have already done a pre-op for this patient

       $query = "SELECT * FROM ans_eval WHERE pat_id = " . $pat_id;

       $result = mysql_query($query);

       // We already have done a pre-op eval and we display the results now
       if (mysql_num_rows($result) > 0)
       {
           //get the date of the exam and show it in the header of the page

           $row = mysql_fetch_assoc($result);

           ?>

    <p>RESULTS FOR PRE-OPERATIVE EVALUATION CONDUCTED <?php echo date("Y M d", $row['dateofexam']); ?></p>

    <div class='greybox'>
        <table style="padding-left:15px">
             <tr>
                <td><b>1) Last Name:&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                <td><?php echo $pat->GetLastName(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td><b>2) First Name:&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                <td><?php echo $pat->GetFirstName();?></td>
             </tr>
             <tr>
                 <td><b>3) Surgeon:&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                 <td><?php echo $doctor->GetFullName(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                 <td><b>4) Exam Date:&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                 <td><?php echo date("Y M d", $row['dateofexam']);?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                 <td><b>5) Extremity:&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                 <td><?php echo $pat->GetExtremity();?></td>
             </tr> 
             <tr>
                 <td><b>6) Age:&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                 <td><?php echo $pat->GetAge(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                 <td><b>7) Sex:&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                 <td><?php echo $pat->GetSex();?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                 <td><b>8) Height:&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                 <td><?php echo $pat->GetHeight();?> in&nbsp;&nbsp;&nbsp;&nbsp;</td>
                 <td><b>9) Weight:&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                 <td><?php echo $pat->GetWeight();?> lbs</td>
             </tr> 
         </table>
      </div>
    
      <div class='whitebox'>
        <table style="padding-left:15px">
           <tr>
             <td><b>10) Chief bunion complaint:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
             <td>
                  <?php
                      // get the answer for that patient to question 10
                      $res = mysql_query("SELECT * FROM ans_eval WHERE ques_num = 10 AND pat_id = " . $pat_id);

                      // derive from that the value of the primary key in the vals_eval table
                      while($row = mysql_fetch_array($res)) {
                          $ans = $row['answer'];
                          // look the value of this up in vals_eval table
                          $text_query = mysql_query("SELECT * FROM vals_eval WHERE id = " . $ans);
                          // get the text
                          $arow = mysql_fetch_array($text_query);
                          // and finally display it
                          echo $arow['val'];
                       }
                  ?>
             </td>
           </tr>
           <tr>
             <td><b>11) Second bunion complaint:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
             <td>
                  <?php
                      // get the answer for that patient to question 11
                      $res = mysql_query("SELECT * FROM ans_eval WHERE ques_num = 11 AND pat_id = " . $pat_id);

                      // derive from that the value of the primary key in the vals_eval table
                      while($row = mysql_fetch_array($res)) {
                          $ans = $row['answer'];
                          // look the value of this up in vals_eval table
                          $text_query = mysql_query("SELECT * FROM vals_eval WHERE id = " . $ans);
                          // get the text
                          $arow = mysql_fetch_array($text_query);
                          // and finally display it
                          echo $arow['val'];
                       }
                  ?>          
             </td>
           </tr>
           <tr>
             <td><b>12) Sub two pain:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
             <td>
                  <?php
                      // get the answer for that patient to question 12
                      $res = mysql_query("SELECT * FROM ans_eval WHERE ques_num = 12 AND pat_id = " . $pat_id);

                      // derive from that the value of the primary key in the vals_eval table
                      while($row = mysql_fetch_array($res)) {
                          $ans = $row['answer'];
                          // look the value of this up in vals_eval table
                          $text_query = mysql_query("SELECT * FROM vals_eval WHERE id = " . $ans);
                          // get the text
                          $arow = mysql_fetch_array($text_query);
                          // and finally display it
                          echo $arow['val'];
                       }
                  ?>
             </td>
           </tr>
           <tr>
             <td><b>13) Second IPK:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
             <td>

                  <?php
                      // get the answer for that patient to question 13
                      $res = mysql_query("SELECT * FROM ans_eval WHERE ques_num = 13 AND pat_id = " . $pat_id);

                      // derive from that the value of the primary key in the vals_eval table
                      while($row = mysql_fetch_array($res)) {
                          $ans = $row['answer'];
                          // look the value of this up in vals_eval table
                          $text_query = mysql_query("SELECT * FROM vals_eval WHERE id = " . $ans);
                          // get the text
                          $arow = mysql_fetch_array($text_query);
                          // and finally display it
                          echo $arow['val'];
                       }
                  ?>
           </td>
           </tr>
           <tr>
             <td><b>14) Hammertoe 2nd:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
             <td>
                  <?php
                      // get the answer for that patient to question 14
                      $res = mysql_query("SELECT * FROM ans_eval WHERE ques_num = 14 AND pat_id = " . $pat_id);

                      // derive from that the value of the primary key in the vals_eval table
                      while($row = mysql_fetch_array($res)) {
                          $ans = $row['answer'];
                          // look the value of this up in vals_eval table
                          $text_query = mysql_query("SELECT * FROM vals_eval WHERE id = " . $ans);
                          // get the text
                          $arow = mysql_fetch_array($text_query);
                          // and finally display it
                          echo $arow['val'];
                       }
                  ?>

             </td>
           </tr>
           <tr>
             <td><b>15) Duration of complaints:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
             <td>
                  <?php
                      // get the answer for that patient to question 15
                      $res = mysql_query("SELECT * FROM ans_eval WHERE pat_id = " . $pat_id);

                      // derive from that the value of the primary key in the vals_eval table
                      $row = mysql_fetch_array($res);
                      echo $row['durofsymp'];
                   ?> mths</td>
           </tr>
         </table>
       </div>

     <div class='greybox'>
        <table style="padding-left:15px">
           <tr>
             <td><b>16) Current tobacco use:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
             <td>
                  <?php
                      // get the answer for that patient to question 16
                      $res = mysql_query("SELECT * FROM ans_eval WHERE ques_num = 16 AND pat_id = " . $pat_id);

                      while($row = mysql_fetch_array($res)) {
                          $ans = $row['answer'];
                          // look the value of this up in vals_eval table
                          $text_query = mysql_query("SELECT * FROM vals_eval WHERE id = " . $ans);
                          // get the text
                          $arow = mysql_fetch_array($text_query);
                          // and finally display it
                          echo $arow['val'];
                       }
                  ?>
             </td>
           </tr>
           <tr>
             <td><b>17) Illnesses:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
             <td>
                  <?php
                      // get the answer for that patient to question 17
                      $res = mysql_query("SELECT * FROM ans_eval WHERE ques_num = 17 AND pat_id = " . $pat_id);

                      // Display the first answer
                      $row = mysql_fetch_array($res);
                      $ans = $row['answer'];
                      $text_query = mysql_query("SELECT * FROM vals_eval WHERE id = " . $ans);
                      $arow = mysql_fetch_array($text_query);
                      echo $arow['val'];

                      // if there are any more, insert a break and display them

                      while($row = mysql_fetch_array($res)) {
                          echo "<br />";
                          $ans = $row['answer'];
                          // look the value of this up in vals_eval table
                          $text_query = mysql_query("SELECT * FROM vals_eval WHERE id = " . $ans);
                          // get the text
                          $arow = mysql_fetch_array($text_query);
                          // and finally display it
                          echo $arow['val'];
                       }
                  ?>          
             </td>
           </tr>
           <tr>
             <td><b>18) Medications:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
             <td>
                  <?php
                      // get the answer for that patient to question 18
                      $res = mysql_query("SELECT * FROM ans_eval WHERE ques_num = 18 AND pat_id = " . $pat_id);

                      // Display the first answer
                      $row = mysql_fetch_array($res);
                      $ans = $row['answer'];
                      $text_query = mysql_query("SELECT * FROM vals_eval WHERE id = " . $ans);
                      $arow = mysql_fetch_array($text_query);
                      echo $arow['val'];

                      // if there are any more, insert a break and display them

                      while($row = mysql_fetch_array($res)) {
                          echo "<br />";
                          $ans = $row['answer'];
                          // look the value of this up in vals_eval table
                          $text_query = mysql_query("SELECT * FROM vals_eval WHERE id = " . $ans);
                          // get the text
                          $arow = mysql_fetch_array($text_query);
                          // and finally display it
                          echo $arow['val'];
                       }
                  ?>          
             </td>
           </tr>
         </table>
       </div>
       
       <div class='whitebox'>
       <table>
           <tr>
              <td><b>19) Maximum dorsiflexion to metatarsal</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
              <td>
                    <?php
                      $res = mysql_query("SELECT * FROM ans_eval WHERE pat_id = " . $pat_id);

                      $row = mysql_fetch_array($res);
                      echo $row['maxdors'];
                      
                     ?>       
                </td>
            </tr>
            <tr>
                <td><b>20) Maximum platarflexion to metatarsal</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td>
                    <?php
                      $res = mysql_query("SELECT * FROM ans_eval WHERE pat_id = " . $pat_id);

                      $row = mysql_fetch_array($res);
                      echo $row['maxplans'];
                    ?> 
                 </td>
            </tr>
            <tr>
             <td><b>21) Previous treatment:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
             <td>
                  <?php
                      // get the answer for that patient to question 21
                      $res = mysql_query("SELECT * FROM ans_eval WHERE ques_num = 21 AND pat_id = " . $pat_id);

                      // Display the first answer
                      $row = mysql_fetch_array($res);
                      $ans = $row['answer'];
                      $text_query = mysql_query("SELECT * FROM vals_eval WHERE id = " . $ans);
                      $arow = mysql_fetch_array($text_query);
                      echo $arow['val'];

                      // if there are any more, insert a break and display them

                      while($row = mysql_fetch_array($res)) {
                          echo "<br />";
                          $ans = $row['answer'];
                          // look the value of this up in vals_eval table
                          $text_query = mysql_query("SELECT * FROM vals_eval WHERE id = " . $ans);
                          // get the text
                          $arow = mysql_fetch_array($text_query);
                          // and finally display it
                          echo $arow['val'];
                       }
                  ?>          
             </td>
            </tr>
	    <tr>
             <td><b>22) Prior HAV surgery same foot:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
             <td>
                  <?php
                      // get the answer for that patient to question 22
                      $res = mysql_query("SELECT * FROM ans_eval WHERE ques_num = 22 AND pat_id = " . $pat_id);

                      // Display the first answer
                      $row = mysql_fetch_array($res);
                      $ans = $row['answer'];
                      $text_query = mysql_query("SELECT * FROM vals_eval WHERE id = " . $ans);
                      $arow = mysql_fetch_array($text_query);
                      echo $arow['val'];

                  ?>          
             </td>
            </tr>
            <tr>
             <td><b>23) Prior HAV surgery opposite foot:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
             <td>
                  <?php
                      // get the answer for that patient to question 23
                      $res = mysql_query("SELECT * FROM ans_eval WHERE ques_num = 23 AND pat_id = " . $pat_id);

                      // Display the first answer
                      $row = mysql_fetch_array($res);
                      $ans = $row['answer'];
                      $text_query = mysql_query("SELECT * FROM vals_eval WHERE id = " . $ans);
                      $arow = mysql_fetch_array($text_query);
                      echo $arow['val'];
                  ?>          
             </td>
            </tr>
          </table>
        </div>

       <div class='greybox'>
       <table>
           <tr>
              <td><b>24) Family history bunions</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
              <td>
                    <?php
                      // get the answer for that patient to question 24
                      $res = mysql_query("SELECT * FROM ans_eval WHERE ques_num = 24 AND pat_id = " . $pat_id);

                      // Display the first answer
                      $row = mysql_fetch_array($res);
                      $ans = $row['answer'];
                      $text_query = mysql_query("SELECT * FROM vals_eval WHERE id = " . $ans);
                      $arow = mysql_fetch_array($text_query);
                      echo $arow['val'];

                      // if there are any more, insert a break and display them

                      while($row = mysql_fetch_array($res)) {
                          echo "<br />";
                          $ans = $row['answer'];
                          // look the value of this up in vals_eval table
                          $text_query = mysql_query("SELECT * FROM vals_eval WHERE id = " . $ans);
                          // get the text
                          $arow = mysql_fetch_array($text_query);
                          // and finally display it
                          echo $arow['val'];
                       }
                  ?>            
                </td>
            </tr>
            <tr>
                <td><b>25) Work:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td>
                    <?php
                      // get the answer for that patient to question 25
                      $res = mysql_query("SELECT * FROM ans_eval WHERE ques_num = 25 AND pat_id = " . $pat_id);

                      // Display the first answer
                      $row = mysql_fetch_array($res);
                      $ans = $row['answer'];
                      $text_query = mysql_query("SELECT * FROM vals_eval WHERE id = " . $ans);
                      $arow = mysql_fetch_array($text_query);
                      echo $arow['val'];
                  ?>        
            </tr>
            <tr>
             <td><b>26) Exercise:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
             <td>
                  <?php
                      // get the answer for that patient to question 26
                      $res = mysql_query("SELECT * FROM ans_eval WHERE ques_num = 26 AND pat_id = " . $pat_id);

                      // Display the first answer
                      $row = mysql_fetch_array($res);
                      $ans = $row['answer'];
                      $text_query = mysql_query("SELECT * FROM vals_eval WHERE id = " . $ans);
                      $arow = mysql_fetch_array($text_query);
                      echo $arow['val'];

                     
                  ?>          
             </td>
            </tr>
	    <tr>
             <td><b>27) Type of exercise:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
             <td>
                  <?php
                      // get the answer for that patient to question 27
                      $res = mysql_query("SELECT * FROM ans_eval WHERE ques_num = 27 AND pat_id = " . $pat_id);

                      // Display the first answer
                      $row = mysql_fetch_array($res);
                      $ans = $row['answer'];
                      $text_query = mysql_query("SELECT * FROM vals_eval WHERE id = " . $ans);
                      $arow = mysql_fetch_array($text_query);
                      echo $arow['val'];

                      // if there are any more, insert a break and display them

                      while($row = mysql_fetch_array($res)) {
                          echo "<br />";
                          $ans = $row['answer'];
                          // look the value of this up in vals_eval table
                          $text_query = mysql_query("SELECT * FROM vals_eval WHERE id = " . $ans);
                          // get the text
                          $arow = mysql_fetch_array($text_query);
                          // and finally display it
                          echo $arow['val'];
                       }
                  ?>          
             </td>
            </tr>
        </table>
        </div>


<?php
      }

      else
      // We do not have patient information yet and we therefore need to fill in the form and we did not get here before
      // of a completed form
      {

    ?>

    <p>ENTER DATA FOR PRE-OPERATIVE EVALUATION</p>

    <form action='process_eval.php' method='post'>
            <div class='container'>
                <div class='greybox'>
                    <table>
                        <tr>
                            <td><b>1) Last Name:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td><?php echo $pat->GetLastName(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td><b>2) First Name:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td><?php echo $pat->GetFirstName(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <tr>
                            <td><b>3) Surgeon:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td><?php echo $doctor->GetFullName(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
			    <td><b>4) Date of exam (YYYY-MM-DD)</b></td>
                            <td><input class='text' type='text' size='4' maxlength='4' name='Y' />-
                                <input class='text' type='text' size='2' maxlength='2' name='M' />-
                                <input class='text' type='text' size='2' maxlength='2' name='D' />
                             </td>
 			     <td><b>5) Extremity:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td><td><?php echo $pat->GetExtremity(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                         </tr>
                         <tr>
                             <td><b>6) Age:</b></td><td><?php echo $pat->GetAge(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                             <td><b>7) Sex:</b></td><td><?php echo $pat->GetSex(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                             <td><b>8) Height:</b></td><td><?php echo $pat->GetHeight(); ?> in&nbsp;&nbsp;&nbsp;&nbsp;</td>
                             <td><b>9) Weight:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td><td><?php echo $pat->GetWeight(); ?> lbs</td>
                          </tr>
                          </table>
                      </div>
                </div>


                <div class='whitebox'>
                     <table>
                          <tr>
                              <td><b>10) 
                                    <?php
                                          // Get the text from question 10
                                          $values = mysql_query("SELECT * FROM ques_eval WHERE num = 10");
                                          $row = mysql_fetch_array($values);
                                          // and display it
                                          echo $row['question'];
                                     ?>
                                   :</b>&nbsp;&nbsp;&nbsp;&nbsp;
                               </td>
                               <td>
                                   <?php
                                          // Get the alternative answers
				          $values = mysql_query("SELECT * FROM vals_eval WHERE ques_num = 10");
                                          $row = mysql_fetch_array($values);
                                          echo "<input type='radio' name=10 value='" . $row[id] . "'>" . $row[val];
                                          While($row = mysql_fetch_array($values)) {
						echo "&nbsp;&nbsp;<input type='radio' name=10 value='" . $row[id] . "'>" . $row[val];
                                          }
                                    ?>
                                </td>
                           </tr>
                           <tr>
                              <td><b>11) 
                                    <?php
                                          // Get the text from question 11
                                          $values = mysql_query("SELECT * FROM ques_eval WHERE num = 11");
                                          $row = mysql_fetch_array($values);
                                          // and display it
                                          echo $row['question'];
                                     ?>
                                   :</b>&nbsp;&nbsp;&nbsp;&nbsp;
                               </td>
                               <td>
                                   <?php
                                          // Get the alternative answers
				          $values = mysql_query("SELECT * FROM vals_eval WHERE ques_num = 11");
                                          $row = mysql_fetch_array($values);
                                          echo "<input type='radio' name=11 value='" . $row[id] . "'>" . $row[val];
                                          While($row = mysql_fetch_array($values)) {
						echo "&nbsp;&nbsp;<input type='radio' name=10 value='" . $row[id] . "'>" . $row[val];
                                          }
                                    ?>
                                </td>
                           </tr>
                           <tr>
                              <td><b>12) 
                                    <?php
                                          // Get the text from question 12
                                          $values = mysql_query("SELECT * FROM ques_eval WHERE num = 12");
                                          $row = mysql_fetch_array($values);
                                          // and display it
                                          echo $row['question'];
                                     ?>
                                   :</b>&nbsp;&nbsp;&nbsp;&nbsp;
                               </td>
                               <td>
                                   <?php
                                          // Get the alternative answers
				          $values = mysql_query("SELECT * FROM vals_eval WHERE ques_num = 12");
                                          $row = mysql_fetch_array($values);
                                          echo "<input type='radio' name=12 value='" . $row[id] . "'>" . $row[val];
                                          While($row = mysql_fetch_array($values)) {
						echo "&nbsp;&nbsp;<input type='radio' name=10 value='" . $row[id] . "'>" . $row[val];
                                          }
                                    ?>
                                </td>
                           </tr>
                           <tr>
                              <td><b>13) 
                                    <?php
                                          // Get the text from question 13
                                          $values = mysql_query("SELECT * FROM ques_eval WHERE num = 13");
                                          $row = mysql_fetch_array($values);
                                          // and display it
                                          echo $row['question'];
                                     ?>
                                   :</b>&nbsp;&nbsp;&nbsp;&nbsp;
                               </td>
                               <td>
                                   <?php
                                          // Get the alternative answers
				          $values = mysql_query("SELECT * FROM vals_eval WHERE ques_num = 13");
                                          $row = mysql_fetch_array($values);
                                          echo "<input type='radio' name=13 value='" . $row[id] . "'>" . $row[val];
                                          While($row = mysql_fetch_array($values)) {
						echo "&nbsp;&nbsp;<input type='radio' name=10 value='" . $row[id] . "'>" . $row[val];
                                          }
                                    ?>
                                </td>
                           </tr>
			   <tr>
                              <td><b>14) 
                                    <?php
                                          // Get the text from question 14
                                          $values = mysql_query("SELECT * FROM ques_eval WHERE num = 14");
                                          $row = mysql_fetch_array($values);
                                          // and display it
                                          echo $row['question'];
                                     ?>
                                   :</b>&nbsp;&nbsp;&nbsp;&nbsp;
                               </td>
                               <td>
                                   <?php
                                          // Get the alternative answers
				          $values = mysql_query("SELECT * FROM vals_eval WHERE ques_num = 14");
                                          $row = mysql_fetch_array($values);
                                          echo "<input type='radio' name=14 value='" . $row[id] . "'>" . $row[val];
                                          While($row = mysql_fetch_array($values)) {
						echo "&nbsp;&nbsp;<input type='radio' name=10 value='" . $row[id] . "'>" . $row[val];
                                          }
                                    ?>
                                </td>
                           </tr>
			   <tr>
                              <td><b>15) 
                                    <?php
                                          // Get the text from question 15
                                          $values = mysql_query("SELECT * FROM ques_eval WHERE num = 15");
                                          $row = mysql_fetch_array($values);
                                          // and display it
                                          echo $row['question'];
                                     ?>
                                   :</b>&nbsp;&nbsp;&nbsp;&nbsp;
                               </td>
                               <td>
                                   <input type='text' name=15> months
                               </td>
                           </tr>
                       </table>
               </div>
                 
               <div class='greybox'>
                     <table>
                          <tr>
                              <td><b>16) 
                                    <?php
                                          // Get the text from question 16
                                          $values = mysql_query("SELECT * FROM ques_eval WHERE num = 16");
                                          $row = mysql_fetch_array($values);
                                          // and display it
                                          echo $row['question'] . ":";
                                     ?>
                                   </b>&nbsp;&nbsp;&nbsp;&nbsp;
                               </td>
                               <td>
                                   <?php
                                          // Get the alternative answer
                                          $values = mysql_query("SELECT * FROM vals_eval WHERE ques_num = 16");
                                          $row = mysql_fetch_array($values);
                                          echo "<input type='radio' name=16 value='" . $row[id] . "'>" . $row[val];
                                          While($row = mysql_fetch_array($values)) {
						echo "&nbsp;&nbsp;<input type='radio' name=16 value='" . $row[id] . "'>" . $row[val];
                                          }
                                    ?>
                                </td>
                           </tr> 
                           <tr>
                              <td><b>17) 
                                    <?php
                                          // Get the text from question 17
                                          $values = mysql_query("SELECT * FROM ques_eval WHERE num = 17");
                                          $row = mysql_fetch_array($values);
                                          // and display it
                                          echo $row['question'] . ":";
                                     ?>
                                   </b>&nbsp;&nbsp;&nbsp;&nbsp;
                               </td>
                               <td>
                                   <?php
                                          // Get the alternative answers
				          $c1 = 0;
                                          $values = mysql_query("SELECT * FROM vals_eval WHERE ques_num = 17");
                                          echo "<table>";
                                          $row = mysql_fetch_array($values);
                                          echo "<tr><td><input type='checkbox' name=17 value='" . $row[id] . "'>" . $row[val] . "&nbsp;&nbsp;</td>";
                                          While($row = mysql_fetch_array($values)) {
                                                $c1++;
                                                if($c1 == 4 || $c1 == 8)
                                                    echo "</tr><tr>";
						echo "<td><input type='checkbox' name=17 value='" . $row[id] . "'>" . $row[val] . "&nbsp;&nbsp;</td>";
                                          }
                                    ?>
                                      </tr>
                                    </table>
                                </td>
                           </tr> 
                           <tr>
                              <td><b>18) 
                                    <?php
                                          // Get the text from question 18
                                          $values = mysql_query("SELECT * FROM ques_eval WHERE num = 18");
                                          $row = mysql_fetch_array($values);
                                          // and display it
                                          echo $row['question'] . ":";
                                     ?>
                                   </b>&nbsp;&nbsp;&nbsp;&nbsp;
                               </td>
                               <td>
                                   <?php
                                          // Get the alternative answers
				          $values = mysql_query("SELECT * FROM vals_eval WHERE ques_num = 18");
                                          $row = mysql_fetch_array($values);
                                          echo "<input type='checkbox' name=18 value='" . $row[id] . "'>" . $row[val];
                                          While($row = mysql_fetch_array($values)) {
						echo "&nbsp;&nbsp;<input type='checkbox' name=18 value='" . $row[id] . "'>" . $row[val];
                                          }
                                    ?>
                                </td>
                           </tr> 
                   </table>
             </div>

             <div class='whitebox'>
                  <div>Pre-op ROM</div>
                  <img align="right" style='width: 200px; height: 200px;' src='picture.bmp' />
                  <table>
                          <tr>
                              <td><b>19) 
                                    <?php
                                          // Get the text from question 19
                                          $values = mysql_query("SELECT * FROM ques_eval WHERE num = 19");
                                          $row = mysql_fetch_array($values);
                                          // and display it
                                          echo $row['question'];
                                     ?>
                                   :</b>&nbsp;&nbsp;&nbsp;&nbsp;
                               </td>
                               <td>
                                   <input type='text' name=19> 
                               </td>
                           </tr>
                           <tr>
                              <td><b>20) 
                                    <?php
                                          // Get the text from question 20
                                          $values = mysql_query("SELECT * FROM ques_eval WHERE num = 20");
                                          $row = mysql_fetch_array($values);
                                          // and display it
                                          echo $row['question'];
                                     ?>
                                   :</b>&nbsp;&nbsp;&nbsp;&nbsp;
                               </td>
                               <td>
                                   <input type='text' name=20> 
                               </td>
                           </tr>
                           <tr>
                                    <td colspan='2'>If above long axis of metatarsal enter a positive value.</td>
                           </tr>
                           <tr>
                                    <td colspan='2'>If below long axi of metatarsal enter a negative value.</td>
                           </tr>
                           <tr>
                              <td><b>21) 
                                    <?php
                                          // Get the text from question 21
                                          $values = mysql_query("SELECT * FROM ques_eval WHERE num = 21");
                                          $row = mysql_fetch_array($values);
                                          // and display it
                                          echo $row['question'] . ":";
                                     ?>
                                   </b>&nbsp;&nbsp;&nbsp;&nbsp;
                               </td>
                               <td>
                                   <?php
                                          // Get the alternative answers
				          $values = mysql_query("SELECT * FROM vals_eval WHERE ques_num = 21");
                                          $row = mysql_fetch_array($values);
                                          echo "<input type='checkbox' name=21 value='" . $row[id] . "'>" . $row[val];
                                          While($row = mysql_fetch_array($values)) {
						echo "&nbsp;&nbsp;<input type='checkbox' name=21 value='" . $row[id] . "'>" . $row[val];
                                          }
                                    ?>
                                </td>
                           </tr>
                           <tr>
                              <td><b>22) 
                                    <?php
                                          // Get the text from question 22
                                          $values = mysql_query("SELECT * FROM ques_eval WHERE num = 22");
                                          $row = mysql_fetch_array($values);
                                          // and display it
                                          echo $row['question'] . ":";
                                     ?>
                                   </b>&nbsp;&nbsp;&nbsp;&nbsp;
                               </td>
                               <td>
                                   <?php
                                          // Get the alternative answers
				          $values = mysql_query("SELECT * FROM vals_eval WHERE ques_num = 21");
                                          $row = mysql_fetch_array($values);
                                          echo "<input type='radio' name=22 value='" . $row[id] . "'>" . $row[val];
                                          While($row = mysql_fetch_array($values)) {
						echo "&nbsp;&nbsp;<input type='radio' name=22 value='" . $row[id] . "'>" . $row[val];
                                          }
                                    ?>
                                </td>
                           </tr> 
                           <tr>
                              <td><b>23) 
                                    <?php
                                          // Get the text from question 23
                                          $values = mysql_query("SELECT * FROM ques_eval WHERE num = 23");
                                          $row = mysql_fetch_array($values);
                                          // and display it
                                          echo $row['question'] . ":";
                                     ?>
                                   </b>&nbsp;&nbsp;&nbsp;&nbsp;
                               </td>
                               <td>
                                   <?php
                                          // Get the alternative answers
				          $values = mysql_query("SELECT * FROM vals_eval WHERE ques_num = 23");
                                          $row = mysql_fetch_array($values);
                                          echo "<input type='radio' name=23 value='" . $row[id] . "'>" . $row[val];
                                          While($row = mysql_fetch_array($values)) {
						echo "&nbsp;&nbsp;<input type='radio' name=23 value='" . $row[id] . "'>" . $row[val];
                                          }
                                    ?>
                                </td>
                           </tr>  
                  </table>
              </div>
               <div class='greybox'>
                     <table>
                          <tr>
                              <td><b>24) 
                                    <?php
                                          // Get the text from question 24
                                          $values = mysql_query("SELECT * FROM ques_eval WHERE num = 24");
                                          $row = mysql_fetch_array($values);
                                          // and display it
                                          echo $row['question'] . ":";
                                     ?>
                                   </b>&nbsp;&nbsp;&nbsp;&nbsp;
                               </td>
                               <td>
                                   <?php
                                          // Get the alternative answers
				          $values = mysql_query("SELECT * FROM vals_eval WHERE ques_num = 24");
                                          $row = mysql_fetch_array($values);
                                          echo "<input type='checkbox' name=24 value='" . $row[id] . "'>" . $row[val];
                                          While($row = mysql_fetch_array($values)) {
						echo "&nbsp;&nbsp;<input type='checkbox' name=24 value='" . $row[id] . "'>" . $row[val];
                                          }
                                    ?>
                                </td>
                           </tr> 
                           <tr>
                              <td><b>25) 
                                    <?php
                                          // Get the text from question 25
                                          $values = mysql_query("SELECT * FROM ques_eval WHERE num = 25");
                                          $row = mysql_fetch_array($values);
                                          // and display it
                                          echo $row['question'] . ":";
                                     ?>
                                   </b>&nbsp;&nbsp;&nbsp;&nbsp;
                               </td>
                               <td>
                                   <?php
                                          // Get the alternative answers
				          $values = mysql_query("SELECT * FROM vals_eval WHERE ques_num = 25");
                                          $row = mysql_fetch_array($values);
                                          echo "<input type='radio' name=25 value='" . $row[id] . "'>" . $row[val];
                                          While($row = mysql_fetch_array($values)) {
						echo "&nbsp;&nbsp;<input type='radio' name=25 value='" . $row[id] . "'>" . $row[val];
                                          }
                                    ?>
                                </td>
                           </tr>
                           <tr>
                              <td><b>26) 
                                    <?php
                                          // Get the text from question 26
                                          $values = mysql_query("SELECT * FROM ques_eval WHERE num = 26");
                                          $row = mysql_fetch_array($values);
                                          // and display it
                                          echo $row['question'] . ":";
                                     ?>
                                   </b>&nbsp;&nbsp;&nbsp;&nbsp;
                               </td>
                               <td>
                                   <?php
                                          // Get the alternative answers
				          $values = mysql_query("SELECT * FROM vals_eval WHERE ques_num = 26");
                                          $row = mysql_fetch_array($values);
                                          echo "<input type='checkbox' name=26 value='" . $row[id] . "'>" . $row[val];
                                          While($row = mysql_fetch_array($values)) {
						echo "&nbsp;&nbsp;<input type='checkbox' name=26 value='" . $row[id] . "'>" . $row[val];
                                          }
                                    ?>
                                </td>
                           </tr> 
                           <tr>
                              <td><b>27) 
                                    <?php
                                          // Get the text from question 27
                                          $values = mysql_query("SELECT * FROM ques_eval WHERE num = 27");
                                          $row = mysql_fetch_array($values);
                                          // and display it
                                          echo $row['question'] . ":";
                                     ?>
                                   </b>&nbsp;&nbsp;&nbsp;&nbsp;
                               </td>
                               <td>
                                   <?php
                                          // Get the alternative answers
				          $values = mysql_query("SELECT * FROM vals_eval WHERE ques_num = 27");
                                          $row = mysql_fetch_array($values);
                                          echo "<input type='checkbox' name=27 value='" . $row[id] . "'>" . $row[val];
                                          While($row = mysql_fetch_array($values)) {
						echo "&nbsp;&nbsp;<input type='checkbox' name=27 value='" . $row[id] . "'>" . $row[val];
                                          }
                                    ?>
                                </td>
                           </tr>  
                    </table>
                </div>                               
                <input type="submit" name="pre-op-eval" value="Finish Questionaire">
           </form>


<?php
         }
} 
?>
