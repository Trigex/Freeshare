var candidate_id = '';

function user_rate(voter,candidate,rate) 
{
	candidate_id = candidate;
	var sUrl = baseurl + "/ajax/user_rate.php";
	var postData = "voter=" + voter + "&candidate=" + candidate + "&rate=" + rate;

	$.ajax({
        type: "POST",
        url: sUrl,
        data: postData,
        dataType: 'json',
        success: rate_result,
        error:vote_error
    });
	
	
}

function rate_result(json) 
{
	if (json.messageType == 'success')
	{
		$('#user_vote_result').html(json.message);
	} 
	else if(json.messageType == 'error')
	{	
		$('#user_vote_result').css('color','red');
		$('#user_vote_result').html(json.message);
	}
	user_rate_show(candidate_id);
}

function vote_error() 
{
	$("#user_vote_result").css('color','red').html('connection failed.');
}

function user_rate_show(candidate_id)
{
	var sUrl = baseurl + "/ajax/user_rate_show.php";
	var postData = "candidate=" + candidate_id;
	$.ajax({
        type: "POST",
        url: sUrl,
        data: postData,
        dataType: 'json',
        success: show_rate,
        error:rate_error
    });
	
}
function show_rate(json)
{
	if (json.messageType == 'success')
	{	
		$('#user_vote_result').css('display','block');
		var c = $('#user_vote_result').html();
		var c2 = c + '<br>' + json.message;
		$('#user_vote_result').html(c2);
	}
	else 
	{
		$('#user_vote_result').css('display','block');
		$('#user_vote_result').html(json.message);
	}
}

function rate_error()
{
	$("#user_vote_result").css('color','red').html('connection failed.');
}