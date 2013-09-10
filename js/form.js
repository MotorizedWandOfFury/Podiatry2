/** 
* Determines if an objects value is empty.
* @param obj The object in which we are testing.
* @return Returns a boolean.
*/
function empty(obj)
{
    switch(obj)
    {
        case "":
        case 0:
        case "0":
        case undefined:
            return true;
        default:
            return false;
    }
}

/**
* Used for general login purposes to determine if a field is empty or full.
* @param obj Form object.
* @return Returns a boolean.
*/
function doLog(obj)
{
    if (empty(obj.UN.value) == true)
    {
        // This is used to give focus to the particular element.
        obj.UN.focus();
        // Cannot submit the form.
        return false;
    }
	
    if (empty(obj.PASSWORD.value) == true)
    {
        // This is used to give focus to the particular element.
        obj.PASSWORD.focus();
        // Cannot submit the form.
        return false;
    }
	
    // Submit the form.
    return true;
}

/**
 *
 * This function is used with add_patient.php
 *
 * @param obj Form object.
 * @return Returns a boolean.
 */
function doAddPatient(obj)
{
    // FirstName
    if (empty(obj.FN.value) == true)
    {
        obj.FN.focus();
        // Cannot submit the form.
        return false;
    }
    
    // LastName
    if (empty(obj.LN.value) == true)
    {
        obj.LN.focus();
        // Cannot submit the form.
        return false;
    }
    
    // Gender
    if (empty(obj.GENDER.value) == true)
    {
        obj.GENDER.focus();
        // Cannot submit the form.
        return false;
    }
    
    // UserName
    if (empty(obj.USERNAME.value) == true)
    {
        obj.USERNAME.focus();
        // Cannot submit the form.
        return false;
    }
    
    // Password
    if (empty(obj.PASSWORD.value) == true)
    {
        obj.PASSWORD.focus();
        // Cannot submit the form.
        return false;
    }
    
    // Extremity
    if (empty(obj.EXTREMITY.value) == true)
    {
        obj.EXTREMITY.focus();
        // Cannot submit the form.
        return false;
    }
    
    return true;
}

function doEditPatient(obj)
{
    // FirstName
    if (empty(obj.FN.value) == true)
    {
        obj.FN.focus();
        // Cannot submit the form.
        return false;
    }
    
    // LastName
    if (empty(obj.LN.value) == true)
    {
        obj.LN.focus();
        // Cannot submit the form.
        return false;
    }
    
    // Gender
    if (empty(obj.GENDER.value) == true)
    {
        obj.GENDER.focus();
        // Cannot submit the form.
        return false;
    }
    
    // UserName
    if (empty(obj.USERNAME.value) == true)
    {
        obj.USERNAME.focus();
        // Cannot submit the form.
        return false;
    }
    
    // Extremity
    if (empty(obj.EXTREMITY.value) == true)
    {
        obj.EXTREMITY.focus();
        // Cannot submit the form.
        return false;
    }
    
    return true;
}

/**
 * This function is used to generate a username for the patient.
 */
function doUserName(firstname, lastname, obj)
{
    $(obj).val((firstname).substr(0, 1).toLowerCase() + (lastname).toLowerCase());
}