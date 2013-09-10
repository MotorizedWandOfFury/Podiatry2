/*
Author: Steven Ng
JS for loading a PHP file within a another PHP document
*/
function loadIn(id, btnId, lastName)
{
	
	if (btnId == viewPatients)
	{
		$('#mainDiv').load('view_doctors_patients.php?lastName='+lastName+'&id='+id);
	}
	
	else if (btnId == editDoc)
	{
		$('#mainDiv').load('editdoctor.php?id='+id+'&lastName='+lastName);
	}
	
	else
	{
		$('#mainDiv').load('#');
	}
}

function loadInSelector(id)
{
	$('#mainDiv').load('../sf36selection.php?patid='+id);
}