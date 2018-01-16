function display_user_comments(page)
{
   var url = baseurl + '/ajax/user_comment_display.php?user_id=' + user_id + '&page=' + page;
   $.ajax({
       type: "GET",
       url: url,
       dataType: 'html',
       success: user_comment_display_success,
       error: user_comment_display_error
   });
}

function user_comment_display_success(response)
{
	$('#user_comment_display').html(response);
}

function user_comment_display_error()
{
    $('#comm_result').html('connection failed');
}