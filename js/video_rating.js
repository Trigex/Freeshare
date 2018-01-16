var video_rating_loading_msg = '<img src=' + baseurl + '/themes/default/images/loading.gif>';

function video_rating_success(msg)
{
	$('#video-rating').html(msg);
}

function video_rating_error(msg) 
{
	alert('failure')
}

function video_rate(video_id,new_rate) 
{
	video_rating_loading();
	var sUrl = baseurl + '/ajax/video_rating.php';
    var postData = 'video_id=' + video_id + '&new_rate=' + new_rate;
    $.ajax({
        type: "POST",
        url: sUrl,
        data: postData,
        dataType: 'html',
        success: video_rating_success,
        error: video_rating_error
    });
}

function video_rating_loading() {
	$('#video_rating').html(video_rating_loading_msg);
}
