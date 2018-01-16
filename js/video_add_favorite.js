function video_add_favorite(video_id)
{
	var sUrl = baseurl + '/ajax/video_add_favorite.php';
	var postData = "video_id=" + video_id;

    $.ajax({
        type: "POST",
        url: sUrl,
        data: postData,
        dataType: 'json',
        success: video_add_favorite_success,
        error: video_add_favorite_error
    });
}

function video_add_favorite_success(msg)
{
    if (msg.messageType == 'error') {
        $("#video-tools-result")
            .removeClass("alert-success")
            .addClass("alert-danger")
            .text(msg.message)
            .fadeIn("slow");
    } else {
        $("#video-tools-result")
            .removeClass("alert-danger")
            .addClass("alert-success")
            .text(msg.message)
            .fadeIn("slow");
    }
}

function video_add_favorite_error()
{
	alert('Ajax Error');
}