<?php

/**
 * This class is used to retrieve information with regards to the doctor.
 */
class Doctor
{

    /**
     *
     * The id of the doctor.
     * 
     * @var int <p>Id.</p>
     */
    private $id = 0;
    /**
     *
     * The doctor.
     * 
     * @var object <p>Doctor object.</p>
     */
    private $doctor;

    /**
     *
     * @param type $i <p>Id of the doctor.</p>
     */
    public function __construct($i = 0)
    {
        $sql = new Database();
        $this->id = intval($i);
        $this->doctor = $sql->doQueryArray("SELECT * FROM `physicians` WHERE `id` = '" . ($this->id) . "'");
    }

    /**
     *
     * We are getting the id of the doctor.
     * 
     * @return int <p>Returns the id of the doctor.</p>
     */
    public function GetId()
    {
        return $this->doctor['id'] ? $this->doctor['id'] : "&nbsp;";
    }

    public function GetPassword()
    {
        return $this->doctor['password'] ? $this->doctor['password'] : "&nbsp;";
    }

    /**
     *
     * We are getting the first name of the doctor.
     * 
     * @return string <p>The first name of the doctor.</p>
     */
    public function GetFirstName()
    {
        return $this->doctor['firstname'] ? $this->doctor['firstname'] : "&nbsp;";
    }

    /**
     *
     * We are getting the last name of the doctor.
     * 
     * @return string <p>The last name of the doctor.</p>
     */
    public function GetLastName()
    {
        return $this->doctor['lastname'] ? $this->doctor['lastname'] : "&nbsp;";
    }

    /**
     *
     * We are getting the age of the patient.
     * 
     * @return int <p>Age.</p>
     */
    public function GetAge()
    {
        return $this->doctor['age'] ? $this->doctor['age'] : "&nbsp;";
    }

    /**
     *
     * We are getting the birthday of the patient.
     * 
     * @return int <p>Birth date.</p>
     */
    public function GetBirth()
    {
        return $this->doctor['dob'] ? $this->doctor['dob'] : 0;
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
        $sex = $sql->doQueryArray("SELECT g.sex AS gen FROM gender g LEFT OUTER JOIN physicians p ON (g.id = p.sex) WHERE p.id = '" . $this->GetId() . "' GROUP BY gen");
        // Result.
        return $sex['gen'] ? $sex['gen'] : "&nbsp;";
    }

    /**
     *
     * We are getting the full name of the doctor.
     * 
     * @return string <p>The full name of the doctor.</p>
     */
    public function GetFullName()
    {
        return $this->GetFirstName() && $this->GetLastName() ? $this->GetFirstName() . " " . $this->GetLastName() : "&nbsp;";
    }

    /**
     *
     * We are getting the user name of the doctor.
     * 
     * @return string <p>The username of the doctor.</p>
     */
    public function GetUserName()
    {
        return $this->doctor['username'] ? $this->doctor['username'] : "&nbsp;";
    }

    /**
     *
     * We are getting the street (address) of the patient.
     * 
     * @return string <p>Street (address).</p>
     */
    public function GetStreet()
    {
        return $this->doctor['street'] ? $this->doctor['street'] : "&nbsp;";
    }

    /**
     *
     * We are getting the city (address) of the patient.
     * 
     * @return string <p>City (address).</p>
     */
    public function GetCity()
    {
        return $this->doctor['city'] ? $this->doctor['city'] : "&nbsp;";
    }

    /**
     *
     * We are getting the state (address) of the patient.
     * 
     * @return string <p>State (address).</p>
     */
    public function GetState()
    {
        return $this->doctor['state'] ? $this->doctor['state'] : "&nbsp;";
    }

    /**
     *
     * We are getting the zip (address) of the patient.
     * 
     * @return int <p>Returns the zip (address) of the patient.</p>
     */
    public function GetZip()
    {
        return $this->doctor['zip'] ? $this->doctor['zip'] : "&nbsp;";
    }

    /**
     *
     * This function is special, as it returns the username of the doctor as an image.
     * 
     * @return string <p>We are returning the username of the doctor.</p>
     */
    public function doUserName()
    {
        return $this->doctor['username'];
    }

    /**
     *
     * We are checking to see if the doctor is logged in. If logged in,
     * we are returning true. If logged off, we are returning false.
     * 
     * @global type $sDID <p>Session id for the doctor.</p>
     * @global type $sDUN <p>Session username for the doctor.</p>
     * @return bool <p>Whether the doctor is logged in or out.</p>
     */
    public function isLogged()
    {
        // Access to variables.
        $var = new Variables();
        // Check to see if the session has been set.
        if ((isset($_SESSION[$var->GetSessionDoctorId()]) == TRUE) && (isset($_SESSION[$var->GetSessionDoctorName()]) == TRUE))
        {
            // Get ready to clean the data.
            $clean = new Clean();
            // Make sure the ID is an integer.
            $checkId = $clean->toInt($_SESSION[$var->GetSessionDoctorId()]);
            // Make sure the last name is a string.
            $checkName = $clean->noChars($_SESSION[$var->GetSessionDoctorName()]);

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
     * We are getting the role of the doctor.
     * 
     * @return string <p>The role.</p>
     */
    public function GetRole()
    {
        $sql = new Database();

        $role = $sql->doQueryArray("SELECT r.role AS pos FROM roles r LEFT OUTER JOIN physicians p ON (r.id = p.role) WHERE p.id = '" . $this->GetId() . "' GROUP BY pos");

        return $role['pos'] ? $role['pos'] : "&nbsp;";
    }

    /**
     *
     * <p>We are getting a list of patients that belong to the doctor and throwing each of them
     * into a select box.</p>
     * <p>This function is used in surveys pretaining to the doctor, and is
     * special as a result.</p>
     * 
     * @return string <p>The Doctor's patients.</p>
     */
    public function SelectPatients()
    {
        // Access to database functions.
        $sql = new Database();
        // What we are returning.
        $func = "";
        // We need a query for the patients and doctor.
        $doc_pats = $sql->doQuery("SELECT p.* FROM patients p LEFT OUTER JOIN physicians pp ON (p.doctor = pp.id) WHERE p.doctor = '" . $this->GetId() . "' GROUP BY p.username");

        // Begin the select.
        $func .= "<select name='PATIENTID'>";

        // Select all the patients.
        for ($i = 1; $doc_pat = $sql->doArray($doc_pats); $i++)
        {
            $pat = new Patient($doc_pat['id']);
            $func .= "<option value='" . $pat->GetId() . "'>" . $pat->GetFirstName() . " " . $pat->GetLastName() . "</option>";
        }

        // End the select.
        $func .= "</select>";

        // Return the function.
        return $func;
    }

}

?>