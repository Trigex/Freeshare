function video_post_comment(video_id) 
{
	var comment_value = $("#user_comment").val();

	if (comment_value=='') 
    {
		alert('You must enter a comment!');
	} 
    else 
    {
        var sUrl = baseurl + "/ajax/video_comment_add.php";
        var postData = "comments_value= " + comment_value + "&video_id=" + video_id;
        $.ajax({
            type: "POST",
            url: sUrl,
            data: postData,
            dataType: 'html',
            success: video_post_comment_success,
            error: video_post_comment_error
        });
	}
}

function video_post_comment_success(msg) 
{
	$("#comment_post_result").html(msg);
	$('#comment_post_result').fadeIn("slow");
	$('#comment_box').slideUp("slow");
	show_comments(vid,1);
}


function video_post_comment_error() 
{
    $("#comment_post_result").html('connection failed.');
	$('#comment_post_result').fadeIn("slow");
}
