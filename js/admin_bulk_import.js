$(function()
{ 
	$("#select_all").click(function() 
	{
		var checked_status = this.checked;
		$("input[name='video_id[]']").each(function(){
			this.checked = checked_status; 
		});
	}); 
});

function validate_frm()
{
	var j=0;
	x = document.bulk_import.elements.length;
	for(i=0;i<x;i++)
    {
		if (document.bulk_import.elements[i].name == 'video_id[]' && document.bulk_import.elements[i].checked == true)
        {
			j++;
		}
	}

	if(j==0)
    {
		alert('You need to select video before importing.');
		return false;
	} else {
		return true;
	} 
}

function validate_bulk_import_search_form()
{
    $('#bulk-import-search').validate({
                rules: {
    				keyword:"required",
                    user_name: "required",
                    channel: "required"
                },
                messages: {
                	keyword: "Please enter keyword",
                    user_name: "Please enter a username",
                    channel: "Please select a channel"
                }
        }); 
 }