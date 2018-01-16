function success_handler(msg)
{
    $('#section_comment').html(msg);
}

function failure_handler(o) 
{
	alert('failure')
}

function show_comments(video_id,page)
{
	show_loading();
    var postData = "video_id=" + video_id + "&page=" + page;
    var sUrl = baseurl + '/ajax/video_comments_show.php?' + postData;
	dataType: 'html',
    $.ajax({
        type: "GET",
        url: sUrl,
        dataType: 'html',
        success: success_handler,
        error:failure_handler
    });
}

function show_loading() 
{
    var loading = '<div style="margin:2em auto;text-align:center;"><img src=' + baseurl + '/themes/default/images/loading_2.gif></div>';
	$('#section_comment').html(loading);
}
