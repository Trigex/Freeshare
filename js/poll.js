var loading_image = '<img src="' + baseurl + '/themes/default/images/loading.gif" alt="loading">';

function poll_view(poll_id)
{
   $('#poll_loading').html(loading_image);
    var sUrl = baseurl + '/ajax/poll_view.php?pollid=' + poll_id
	$.ajax({
        type: "GET",
        url: sUrl,
        dataType: 'json',
        success: poll_view_success,
        error:poll_view_error
    });
}

function poll_view_success(json)
{
    $('#poll_view').fadeOut();
    $('#poll_loading').hide();
	if ( json.messageType == 'success' )
    {
        $("#poll_result").html(json.message).slideDown('slow');
    }
	if ( json.messageType == 'error' )
	{
        $("#poll_result").hide().html(json.message).show();
	}
}

function poll_view_error()
{
	$("#poll_result").html('Connection failed.').show();
}

function poll_vote(poll_id)
{
	var user_answer = $('#user_answer').val();

	if (user_answer == '')
	{
		alert('Select any one');
	}
	else
	{
        $('#poll_answers').fadeOut();
        $('#poll_view').fadeOut();
        $('#poll_loading').html(loading_image);
		var sUrl = baseurl + '/ajax/poll_vote_add.php';
		var postData = 'value=' + user_answer + '&poll_id=' + poll_id;
		$.ajax({
	        type: "POST",
	        url: sUrl,
	        data: postData,
	        dataType: 'json',
	        success: poll_vote_success,
	        error:poll_vote_error
	    });
	}
}

function poll_vote_success(json)
{
	if ( json.messageType == 'success' )
    {
		$('#poll_loading').hide();
		$("#poll_result").html(json.message).fadeIn();
    }
	else if ( json.messageType == 'error' )
	{
        $('#poll_loading').hide();
		$("#poll_result").html(json.message).show();
	}
}

function poll_vote_error()
{
	$("#poll_result").html('Ajax connection failed.').show();
}

function poll_vote_for(myValue,thatId)
{
	document.getElementById(thatId).value=myValue;
}
