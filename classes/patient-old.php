<?php

/**
 * Retrieve data from the patient class.
 */
class Patient
{

    // Default id is 0.
    private $id = 0;
    // We need a patient from the database.
    private $patient;

    /**
     *
     * Default constructor.
     * 
     * @param type $i <p>Id of the patient. The default id is 0.</p>
     */
    public function __construct($i = 0)
    {
        $sql = new Database();
        $this->id = intval($i);
        $this->patient = $sql->doQueryArray("SELECT * FROM `patients` WHERE `id` = '" . ($this->id) . "'");
    }

    /**
     *
     * We are getting the id of the patient.
     * 
     * @return int <p>The id.</p>
     */
    public function GetId()
    {
        return $this->patient['id'] ? $this->patient['id'] : "&nbsp;";
    }

    public function GetPassword()
    {
        return $this->patient['password'] ? $this->patient['password'] : "&nbsp;";
    }

    /**
     *
     * We are getting the first name of the patient.
     * 
     * @return string <p>Firstname.</p>
     */
    public function GetFirstName()
    {
        return $this->patient['firstname'] ? $this->patient['firstname'] : "&nbsp;";
    }

    /**
     *
     * We are getting the last name of the patient.
     * 
     * @return string <p>Lastname.</p>
     */
    public function GetLastName()
    {
        return $this->patient['lastname'] ? $this->patient['lastname'] : "&nbsp;";
    }

    /**
     *
     * We are getting the age of the patient.
     * 
     * @return int <p>Age.</p>
     */
    public function GetAge()
    {
        return $this->patient['age'] ? $this->patient['age'] : 0;
    }

    /**
     *
     * We are getting the birthday of the patient.
     * 
     * @return int <p>Birth date.</p>
     */
    public function GetBirth()
    {
        return $this->patient['dob'] ? $this->patient['dob'] : 0;
    }

    /**
     *
     * We are getting the gender of the patient.
     * 
     * @return string <p>Sex.</p>
     */
    public function GetSex()
    {
        // Database function access.
        $sql = new Database();
        // Query.
        $sex = $sql->doQueryArray("SELECT g.sex AS gen FROM gender g LEFT OUTER JOIN patients p ON (g.id = p.sex) WHERE p.id = '" . $this->GetId() . "' GROUP BY gen");
        // Result.
        return $sex['gen'] ? $sex['gen'] : "&nbsp;";
    }

    /**
     *
     * We are getting the full name of the patient.
     * 
     * @return string <p>The full name of the patient.</p>
     */
    public function GetFullName()
    {
        return $this->GetFirstName() && $this->GetLastName() ? $this->GetFirstName() . " " . $this->GetLastName() : "&nbsp;";
    }

    /**
     *
     * We are getting the username of the patient.
     * 
     * @return string <p>Username.</p>
     */
    public function GetUserName()
    {
        return $this->patient['username'] ? $this->patient['username'] : "&nbsp;";
    }

    /**
     *
     * We are getting the street (address) of the patient.
     * 
     * @return string <p>Street (address).</p>
     */
    public function GetStreet()
    {
        return $this->patient['street'] ? $this->patient['street'] : "";
    }

    /**
     *
     * We are getting the city (address) of the patient.
     * 
     * @return string <p>City (address).</p>
     */
    public function GetCity()
    {
        return $this->patient['city'] ? $this->patient['city'] : "&nbsp;";
    }

    /**
     *
     * We are getting the state (address) of the patient.
     * 
     * @return string <p>State (address).</p>
     */
    public function GetState()
    {
        return $this->patient['state'] ? $this->patient['state'] : "&nbsp;";
    }

    /**
     *
     * We are getting the zip (address) of the patient.
     * 
     * @return int <p>Returns the zip (address) of the patient.</p>
     */
    public function GetZip()
    {
        return $this->patient['zip'] ? $this->patient['zip'] : "&nbsp;";
    }

    /**
     *
     * We are getting the extremity of the patient.
     * 
     * @return char <p>Returns the extremity of the patient.</p>
     */
    public function GetExtremity()
    {
        // Access to database functions.
        $sql = new Database();
        // Query
        $ex = $sql->doQueryArray("SELECT e.ex AS extr FROM extremity e LEFT OUTER JOIN patients p ON (p.extremity = e.id) WHERE p.id = '" . $this->GetId() . "' GROUP BY extr");
        // Return
        return $this->patient['extremity'] ? $ex['extr'] : "&nbsp;";
    }

    /**
     *
     * We are getting the weight of the patient.
     * 
     * @return int <p>The weight of the patient.</p>
     */
    public function GetWeight()
    {
        return $this->patient['weight'] ? $this->patient['weight'] : 0;
    }

    /**
     *
     * We are getting the height of the patient.
     * 
     * @return int <p>The height of the patient.</p>
     */
    public function GetHeight()
    {
        return $this->patient['height'] ? $this->patient['height'] : 0;
    }

    /**
     *
     * This special function is used to display the username of the patient as an image.
     * 
     * @return string <p>Displays an image of the patients user name.</p>
     */
    public function doUserName()
    {
        return $this->GetUserName();
    }

    /**
     *
     * <p>We are getting the id of the Patient's doctor.</p>
     * <p>You can create a doctor object to store this id into<br />
     * so that you can retrieve the information of the doctor properly.</p>
     * 
     * @return type <p>Gets the id of the Patients's doctor.</p>
     */
    public function GetDoctor()
    {
        // Acess to database functions.
        $sql = new Database();
        // Query
        $doctor = $sql->doQueryArray("SELECT pp.id as doc FROM physicians pp LEFT OUTER JOIN patients p ON (pp.id = p.doctor) WHERE p.id = '" . $this->GetId() . "' GROUP BY doc");
        // Create a doctor
        $doc = new Doctor($doctor['doc']);
        // Return
        return $doc->GetId() ? $doc->GetId() : "&nbsp;";
    }
    
    public function GetScores()
    {
        $sql = new Database();
        
        $score = $sql->doQuery("SELECT id FROM pre_opscore WHERE pat_id = '" .$this->GetId(). "'");
        
        $string = "";
        
        for ($i = 0; $sco = $sql->doArray($score); $i++)
        {
            if ($i > 0)
            {
                $string .= ",";
            }
            
            $string .= $sco['id'];
        }
        
        return $string;
    }

    /**
     *
     * This function is used to check and see if a patient is logged into a session.
     * 
     * @global type $sID <p>Session id.</p>
     * @global type $sUN <p>Session username</p>
     * @return type bool <p>
     * <p>If logged: returns true</p>
     * <p>If not logged: returns false</p>
     * </p>
     */
    public function isLogged()
    {
        // Access to variables.
        $var = new Variables();
        // Check to see if the session has been set.
        if ((isset($_SESSION[$var->GetSessionUserId()]) == TRUE) && (isset($_SESSION[$var->GetSessionUserName()]) == TRUE))
        {
            // Get ready to clean the data.
            $clean = new Clean();
            // Make sure the ID is an integer.
            $checkId = $clean->toInt($_SESSION[$var->GetSessionUserId()]);
            // Make sure the last name is a string.
            $checkName = $clean->noChars($_SESSION[$var->GetSessionUserName()]);

            // Check to see if the ID and lastname is valid.
            if (($this->GetId() == $checkId) && ($this->GetUserName() == $checkName))
            {
                // You're logged in.
                return TRUE;
            }
            else
            {
                // You're not logged in.
                return FALSE;
            }
        }
        else
        {
            // If the sessions are not set, you're clearly not logged in.
            return FALSE;
        }
    }

    /**
     *
     * We are getting the role of the patient.
     * 
     * @return type string <p>Returns the role of the patient.</p>
     */
    public function GetRole()
    {
        // Database function access.
        $sql = new Database();
        // Query.
        $role = $sql->doQueryArray("SELECT r.role AS pos FROM roles r LEFT OUTER JOIN patients p ON (r.id = p.role) WHERE p.id = '" . $this->GetId() . "' GROUP BY pos");
        // Result.
        return $role['pos'] ? $role['pos'] : "&nbsp;";
    }

    /**
     *
     * We are getting the physical score of the patient.
     * 
     * @return type double <p>Returns the physical score of the patient.</p>
     */
    public function ComputePhysicalFunctioning($dateof)
    {
        // Score of the patient.
        $score = 0.0;
        // The average is based on the questions completed.
        $average = 0;
        // Database function access.

        for($i = 7; $i < 17; $i++) {
                // figure out what the patient's answer was on that question
                $answer_query = sprintf("SELECT answer FROM ans_sf36 WHERE dateof = %d AND
                                                                           ques_num = %d AND
                                                                           pat_id = %d",
                                                                     $dateof, $i, $this->GetId());
                $answer_array = mysql_query($answer_query);             
                $answer = mysql_fetch_array($answer_array);
                
                IF ($answer != FALSE) {                
                      $score += $answer['answer'];
                      $average++;
                }
        }

        if ($average == 0) {
             $nscore = -50;
        }
        else {
               $initial_average = $score / $average;
          
               $nscore = (($score + ($initial_average * (10 - $average)) - 10) / 20 ) * 100;
        }

        return $nscore;
    }

    public function ComputeRolePhysical($dateof)
    {
        $score = 0.0;
        $average = 0;

        for($i = 18; $i < 22; $i++) {
                // figure out what the patient's answer was on that question
                $answer_query = sprintf("SELECT answer FROM ans_sf36 WHERE dateof = %d AND
                                                                           ques_num = %d AND
                                                                           pat_id = %d",
                                                                     $dateof, $i, $this->GetId());
                $answer_array = mysql_query($answer_query);             
                $answer = mysql_fetch_array($answer_array);
                
                IF ($answer != FALSE) {            
                      $score += $answer['answer'];
                      $average++;
                }
        }

        if ($average == 0) {
             $nscore = -50;
        }
        else {
               $initial_average = $score / $average;
          
               $nscore = (($score + ($initial_average * (4 - $average)) - 4) / 4 ) * 100;
        }
       
        return $nscore;
    }

    
    public function ComputeBodilyPain($dateof)
    {
        $pval7 = 0.0;
        $pval8 = 0.0;
        $score = 0.0;

        // Get the patient's answer on questions 27 and 28
        $answer_query_27 = sprintf("SELECT answer FROM ans_sf36 WHERE dateof = %d AND
                                                                   ques_num = 27 AND
                                                                   pat_id = %d",
                                                             $dateof, $this->GetId());
        $answer_array_27 = mysql_query($answer_query_27);             
        $answer_27 = mysql_fetch_array($answer_array_27);

        $answer_query_28 = sprintf("SELECT answer FROM ans_sf36 WHERE dateof = %d AND
                                                                   ques_num = 28 AND
                                                                   pat_id = %d",
                                                             $dateof, $this->GetId());
        $answer_array_28 = mysql_query($answer_query_28);             
        $answer_28 = mysql_fetch_array($answer_array_28);
                
        if ($answer_27 != FALSE) { 
              $average = 1; 
              switch($answer_27['answer']) {
                 case 1:
                      $pval27 = 6.0;
                      break;
                 case 2:
                      $pval27 = 5.4;
                      break;
                 case 3:
                      $pval27 = 4.2;
                      break;
                 case 4:
                      $pval27 = 3.1;
                      break;
                 case 5:
                      $pval27 = 2.2;
                      break;
                 case 6:
                      $pval27 = 1.0;
                      break;
               }
               if ($answer_28 != FALSE) {
                     $average = 2;
                        switch($answer_28['answer']) {
                            case 1:
                                 if ($answer_27['answer'] == 1) {
                                    $pval28 = 6;
                                 } else {
                                     $pval28 = 5;
                                   }
                                 break;
                            case 2:
                                 $pval28 = 4;
                                 break;
                            case 3:
                                 $pval28 = 3;
                                 break;
                            case 4:
                                 $pval28 = 2;
                                 break;
                            case 5:
                                 $pval28 = 1.0;
                                 break;
                       }
                }
              
         }
         else if ($answer_28 != FALSE) {
                $average = 1;
                switch($answer_28['answer']) {
                 case 1:
                      $pval28 = 6.0;
                      break;
                 case 2:
                      $pval28 = 4.75;
                      break;
                 case 3:
                      $pval28 = 3.5;
                      break;
                 case 4:
                      $pval28 = 2.25;
                      break;
                 case 5:
                      $pval28 = 1.0;
                      break;
               }

              }
        if ($average == 0) {
             $score = -50;
        }
        else {
             $initial_average = ($pval27 + $pval28) / $average;
          
             $score = ((($pval27 + $pval28) + ($initial_average * (2 - $average)) - 2) / 10 ) * 100;

        }            
        return $score;
    }

   
    public function ComputeGeneralHealth($dateof)
    {
        $score = 0.0;
        $average = 0;
      
        
        // Process question 1
        $answer_query_1 = sprintf("SELECT answer FROM ans_sf36 WHERE dateof = %d AND
                                                                   ques_num = 4 AND
                                                                   pat_id = %d",
                                                             $dateof, $this->GetId());
        $answer_array_1 = mysql_query($answer_query_1);             
        $answer_1 = mysql_fetch_array($answer_array_1);

        if ($answer_1 != FALSE) { 
              $average = 1; 
              switch($answer_1['answer']) {
                 case 1:
                      $score = 5.0;
                      break;
                 case 2:
                      $score = 4.4;
                      break;
                 case 3:
                      $score = 3.4;
                      break;
                 case 4:
                      $score = 2.0;
                      break;
                 case 5:
                      $score = 1.0;
                      break;
               }
          }

          // Now process the answers to questions 42 to 45

          for($i = 42; $i < 46; $i++) {
                // figure out what the patient's answer was on that question
                $answer_query = sprintf("SELECT answer FROM ans_sf36 WHERE dateof = %d AND
                                                                           ques_num = %d AND
                                                                           pat_id = %d",
                                                                     $dateof, $i, $this->GetId());
                $answer_array = mysql_query($answer_query);             
                $answer = mysql_fetch_array($answer_array);
                
                if ($answer != FALSE) {  
                      if ($i == 42 || $i == 44) {      
                             $score += $answer['answer'];
                      } else {
                          $score = $score + (6 - $answer['answer']);
                        }

                      $average++;
                }

               
           }

        
           if ($average == 0) {
                    $nscore = -50;
           }
           else {
               $initial_average = $score / $average;
          
               $nscore = (($score + ($initial_average * (5 - $average)) - 5) / 20 ) * 100;
           }
           return $nscore;
    }


    public function ComputeVitality($dateof)
    {
        // Score of the patient.
        $score = 0.0;
        // The average is based on the questions completed.
        $average = 0;
        
        // question 31
        $answer_query = sprintf("SELECT answer FROM ans_sf36 WHERE dateof = %d AND
                                                                           ques_num = 31 AND
                                                                           pat_id = %d",
                                                                     $dateof, $this->GetId());
        $answer_array = mysql_query($answer_query);             
        $answer = mysql_fetch_array($answer_array);
                
        if ($answer != FALSE) {  
                    $score = $score + (7 - $answer['answer']);
                    $average++;
                }

        // question 35
        $answer_query = sprintf("SELECT answer FROM ans_sf36 WHERE dateof = %d AND
                                                                           ques_num = 35 AND
                                                                           pat_id = %d",
                                                                     $dateof, $this->GetId());
        $answer_array = mysql_query($answer_query);             
        $answer = mysql_fetch_array($answer_array);
                
        if ($answer != FALSE) {  
                    $score = $score + (7 - $answer['answer']);
                    $average++;
                }

        // question 37
        $answer_query = sprintf("SELECT answer FROM ans_sf36 WHERE dateof = %d AND
                                                                           ques_num = 37 AND
                                                                           pat_id = %d",
                                                                     $dateof, $this->GetId());
        $answer_array = mysql_query($answer_query);             
        $answer = mysql_fetch_array($answer_array);
                
        if ($answer != FALSE) {  
                    $score = $score + $answer['answer'];
                    $average++;
                }

         // question 39
        $answer_query = sprintf("SELECT answer FROM ans_sf36 WHERE dateof = %d AND
                                                                           ques_num = 39 AND
                                                                           pat_id = %d",
                                                                     $dateof, $this->GetId());
        $answer_array = mysql_query($answer_query);             
        $answer = mysql_fetch_array($answer_array);
                
        if ($answer != FALSE) {  
                    $score = $score + $answer['answer'];
                    $average++;
                }

       
         if ($average == 0) {
                    $nscore = -50;
         }
         else {
               $initial_average = $score / $average;
          
               $nscore = (($score + ($initial_average * (4 - $average)) - 4) / 20 ) * 100;
           }
         return $nscore;
   }

  
    public function ComputeSocialFunctioning($dateof)
    {
        $score = 0.0;
        $average = 0;

        // question 26
        $answer_query = sprintf("SELECT answer FROM ans_sf36 WHERE dateof = %d AND
                                                                           ques_num = 26 AND
                                                                           pat_id = %d",
                                                                     $dateof, $this->GetId());

        $answer_array = mysql_query($answer_query);             
        $answer = mysql_fetch_array($answer_array);
                
        if ($answer != FALSE) {  
                    $score = $score + (6 - $answer['answer']);
                    $average++;
                }

         // question 40
        $answer_query = sprintf("SELECT answer FROM ans_sf36 WHERE dateof = %d AND
                                                                           ques_num = 40 AND
                                                                           pat_id = %d",
                                                                     $dateof, $this->GetId() );
        $answer_array = mysql_query($answer_query);             
        $answer = mysql_fetch_array($answer_array);
               
        if ($answer != FALSE) {  
                    $score = $score + $answer['answer'];
                    $average++;
                }

       
           if ($average == 0) {
                    $nscore = -50;
           }
           else {
               $initial_average = $score / $average;
          
               $nscore = (($score + ($initial_average * (2 - $average)) - 2) / 8 ) * 100;
           }
           return $nscore;


    }

 
    public function ComputeRoleEmotional($dateof)
    {
        $score = 0.0;
        $average = 0;
      
         for($i = 23; $i < 26; $i++) {
                // figure out what the patient's answer was on that question
                $answer_query = sprintf("SELECT answer FROM ans_sf36 WHERE dateof = %d AND
                                                                           ques_num = %d AND
                                                                           pat_id = %d",
                                                                     $dateof, $i, $this->GetId());
                $answer_array = mysql_query($answer_query);             
                $answer = mysql_fetch_array($answer_array);
                
                IF ($answer != FALSE) {  
                      $score += $answer['answer'];
                      
                      $average++;
                }

               
           }

        
           if ($average == 0) {
                    $nscore = -50;
           }
           else {
               $initial_average = $score / $average;
          
               $nscore = (($score + ($initial_average * (3 - $average)) - 3) / 3 ) * 100;
           }
           return $nscore;
   }

    
    public function ComputeMentalHealth($dateof)
    {
        // Score of the patient.
        $score = 0.0;
        // The average is based on the questions completed.
        $average = 0;
        
        for($i = 32; $i < 36; $i++) {
                // figure out what the patient's answer was on that question
                $answer_query = sprintf("SELECT answer FROM ans_sf36 WHERE dateof = %d AND
                                                                           ques_num = %d AND
                                                                           pat_id = %d",
                                                                     $dateof, $i, $this->GetId());
                $answer_array = mysql_query($answer_query);             
                $answer = mysql_fetch_array($answer_array);
                
                IF ($answer != FALSE) { 
                   if ($i == 34) {
		      $score = $score + (7 - $answer['answer']);
                      
                      $average++;
                   } else { 
                      $score += $answer['answer'];
                      
                      $average++;
                }

        }      
           }
         // question 38
        $answer_query = sprintf("SELECT answer FROM ans_sf36 WHERE dateof = %d AND
                                                                           ques_num = 38 AND
                                                                           pat_id = %d",
                                                                     $dateof, $this->GetId());
        $answer_array = mysql_query($answer_query);             
        $answer = mysql_fetch_array($answer_array);
                
        IF ($answer != FALSE) {  
                    $score = $score + ( 7 - $answer['answer']);
                    $average++;
                }

       
           if ($average == 0) {
                    $nscore = -50;
           }
           else {
               $initial_average = $score / $average;
          
               $nscore = (($score + ($initial_average * (5 - $average)) - 5) / 25 ) * 100;
           }
           return $nscore;
    }

   
    public function InsertScores($dateof)
    {
        // Database function access.
        $sql = new Database();
        // Physical Functioning.
        $score1 = $this->ComputePhysicalFunctioning($dateof);
        // Role-Physical
        $score2 = $this->ComputeRolePhysical($dateof);
        // Bodily Pain
        $score3 = $this->ComputeBodilyPain($dateof);
        // General Health
        $score4 = $this->ComputeGeneralHealth($dateof);
        // Vitality
        $score5 = $this->ComputeVitality($dateof);
        // Social Functioning
        $score6 = $this->ComputeSocialFunctioning($dateof);
        // Role-Emotional
        $score7 = $this->ComputeRoleEmotional($dateof);
        // Mental Health
        $score8 = $this->ComputeMentalHealth($dateof);
        // Execute the query.
        $sql->doQuery("INSERT INTO pre_opscore (pat_id, dateof, pfunctioning, rphysical, bpain, ghealth, vitality, sfunctioning, remotional, mhealth) VALUES ('" . $this->GetId() . "', '" .$dateof. "', '" . $score1 . "', '" . $score2 . "', '" . $score3 . "', '" . $score4 . "', '" . $score5 . "', '" . $score6 . "', '" . $score7 . "', '" . $score8 . "')");
    }

}

?>