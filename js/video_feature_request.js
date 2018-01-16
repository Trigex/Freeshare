function feature() {

	var sUrl = baseurl + "/ajax/video_feature_request.php";
	var postData = 'vid=' + vid;

	$.ajax({
        type: "POST",
        url: sUrl,
        data: postData,
        dataType: 'json',
        success: feature_success,
        error:feature_failure
    });

}

function feature_success(json) {

	if (json.messageType == 'success')
	{
        $("#video-tools-result")
            .removeClass("alert-danger")
            .addClass("alert-success")
            .text(json.message)
            .fadeIn("slow");
	}
	else if(json.messageType == 'error')
	{
        $("#video-tools-result")
            .removeClass("alert-success")
            .addClass("alert-danger")
            .text(json.message)
            .fadeIn("slow");
	}

}

function feature_failure() {
    $("#video-tools-result")
        .removeClass("alert-success")
        .addClass("alert-danger")
        .text("Connection failed.")
        .fadeIn("slow");
}