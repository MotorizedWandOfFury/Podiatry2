// Allow no HTML in the user name.
        $un = $clean->noHTML($_POST['UN']);
        // Encrypt the password.
        $pass = $clean->toPass($_POST['PASSWORD']);
		//check if the user is logging in as an admin/doctor/patient
		$result = mysql_query("SELECT username FROM login WHERE username = '". $un ."'");
		$result2 = mysql_query("SELECT username FROM physicians WHERE username = '". $un ."'");
		$result3 = mysql_query("SELECT username FROM patients WHERE username = '". $un ."'");
		
		if (mysql_num_rows($result) > 0)
		{
			// Query info.
			$getadmin = "SELECT id, username, password FROM login WHERE username IN ('" . $un . "') AND password IN ('" . $pass . "')";
			// Execute the query.
			$query = $database->doQuery($getadmin);
			// Determine if the patient exists.
			$adminexist = $database->doRows($query);

			// If the patient exists...
			if ($adminexist == 1)
			{
				// Get the information pretaining to the patient.
				$getadmininfo = $database->doArray($query);
				// Set the first session.
				$_SESSION[$var->GetSessionAdminId()] = $getadmininfo['id'];
				// Set the second session.
				$_SESSION[$var->GetSessionAdminName()] = $getadmininfo['username'];
				// Destory patient session.
				unset($_SESSION[$var->GetSessionUserId()]);
				unset($_SESSION[$var->GetSessionUserName()]);
				// Destroy doctor session.
				unset($_SESSION[$var->GetSessionDoctorId()]);
				unset($_SESSION[$var->GetSessionDoctorName()]);
				// You've logged in.
				header('Location: admin/main.php');
			}
			else
			{
				echo '
				<p style="color:red" align="center"><br>Login credentials are incorrect.</p></form>
				';
			}
		}
		//check if the user is logging in as a doctor
		else if (mysql_num_rows($result2) > 0)
		{
		// Query info.
        $getDoc = "SELECT `id`, `username`, `password` FROM `physicians` WHERE `username` IN ('" . $un . "') AND `password` IN ('" . $pass . "')";
        // Execute the query.
        $query = $database->doQuery($getDoc);
        // Determine if the patient exists.
        $docexist = $database->doRows($query);

        // If the patient exists...
        if ($docexist == 1)
        {
            // Get the information pretaining to the patient.
            $getDocinfo = $database->doArray($query);
            // Set the first session.
            $_SESSION[$var->GetSessionDoctorId()] = $getDocinfo['id'];
            // Set the second session.
            $_SESSION[$var->GetSessionDoctorName()] = $getDocinfo['username'];
            // Destory patient session.
            unset($_SESSION[$var->GetSessionUserId()]);
            unset($_SESSION[$var->GetSessionUserName()]);
            // Destroy admin session.
            unset($_SESSION[$var->GetSessionAdminId()]);
            unset($_SESSION[$var->GetSessionAdminName()]);
            // You've logged in.
            header('Location: doctor/main.php');
        }
		else
		{
			echo '
			<p style="color:red" align="center"><br>Login credentials are incorrect.</p></form>
			';
		}
		}
		else if (mysql_num_rows($result3) > 0)
		{
		// Query info.
        $getpatient = "SELECT `id`, `username`, `password` FROM `patients` WHERE `username` IN ('" . $un . "') AND `password` IN ('" . $pass . "')";
        // Execute the query.
        $query = $database->doQuery($getpatient);
        // Determine if the patient exists.
        $patientexist = $database->doRows($query);

        // If the patient exists...
        if ($patientexist == 1)
        {
            // Get the information pretaining to the patient.
            $getpatientinfo = $database->doArray($query);
            // Set the first session.
            $_SESSION[$var->GetSessionUserId()] = $getpatientinfo['id'];
            // Set the second session.
            $_SESSION[$var->GetSessionUserName()] = $getpatientinfo['username'];
            // Destory admin session.
            unset($_SESSION[$var->GetSessionAdminId()]);
            unset($_SESSION[$var->GetSessionAdminName()]);
            // Destroy doctor session.
            unset($_SESSION[$var->GetSessionDoctorId()]);
            unset($_SESSION[$var->GetSessionDoctorName()]);
            // You've logged in.
            header('Location: main.php');
        }
		else
		{
			echo '
			<p style="color:red" align="center"><br>Login credentials are incorrect.</p></form>
			';
		}