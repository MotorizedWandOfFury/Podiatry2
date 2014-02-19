/*
Author: Steven Ng
JS for loading a PHP file in a modal
*/
/*function displayModal(id, btnId)
{	
	if (btnId == 'patProfile')
	{
		$('#myModal').modal('show')
		$('#modalBody').load('../doctor/pat_profile.php?patid='+id)
	}
}*/

$('#myModal').on('hidden', function () {
  $(this).removeData('modal');
});