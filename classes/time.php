<?php

/**
 * This class is used to display date or time.
 */
class Time
{

    public function __construct()
    {
        date_default_timezone_set("America/New_York");  // Default TimeZone
    }

    public function doFullDate($time)
    {
        return date("m/d/y h:i:s A", $time);
    }

    public function doDate($time)
    {
        return date("m/d/y", $time);
    }

    public function doDay($time)
    {
        return date("d", $time);
    }

    public function doMonth($time)
    {
        return date("m", $time);
    }

    public function doYear($time)
    {
        return date("Y", $time);
    }

    public function CheckDate($pat_id, $table, $later)
    {
        // Access to Database Functions.
        $sql = new Database();
        // Clean out stuff.
        $clean = new Clean();
        
        // Check to see if the patient has filled the survey.
        $checkans = "SELECT max(dateof) as last_date FROM " . $table . " WHERE pat_id IN('" . $pat_id . "') LIMIT 1";
        $query_res = mysql_query($checkans);
      
        if (mysql_num_rows($query_res) != 0)
            {
		     $row = mysql_fetch_assoc($query_res);

                 $time_string = strval($row['last_date']);

                 $survey_date = mktime(0,0,0,(int)substr($time_string, 4,2), 
                                             (int)substr($time_string, 6,2), 
                                             (int)substr($time_string, 0,4));

                 $next_poss_survey_date = $survey_date + ($later * 24 * 60 * 60);

                           
                 if (time() < $next_poss_survey_date)
                 {
                       echo "Completed survey less than " . $later . " days ago.<br />";
                       echo "Cannot complete survey at this time.<br />";
			     echo "The earliest you can complete the survey is " . date("m/d/y", $next_poss_survey_date) . ".";

                       return 1;
                 }
                 else
                       return 0;
                 

        }

    }

    /*
      public function timeInterval($check, $pat) {

      $flag = 0;
      $database = new database();
      $error = new Error();


      // Execute a query.
      $query = $database->doQuery($check);
      // Get the data pretaining to that row.
      $getData = $database->doArray($query);


      $n = $database->doQuery("SELECT * FROM pre_opscore WHERE pat_id ='" . $pat->GetId() . "'");
      $number = $database->doRows($n);

      $y = $this->doYear(time()) - $this->doYear($getData['dateof']);
      $m = abs($this->doMonth(time()) - $this->doMonth($getData['dateof']));


      if ($number == 0) {
      $flag = 1;
      return $flag;
      } else {
      if ($y < 0) {
      $error->doMSG("Your computer doesn't have the right time! please put your clock on time!!!");
      return $flag;
      } else if ($number == 1 && $m == 3) {
      $flag = 3;
      return $flag;
      } else if ($number == 2 && $m == 6) {
      $flag = 6;
      return $flag;
      } else if ($number == 3 && $m == 12) {
      $flag = 12;
      return $flag;
      } else {
      return $flag;
      }
      }
      }
     */
}

?>