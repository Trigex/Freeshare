function  inappropriate()
{
	$("#video-tools-feedback").slideDown('fast');
}

function inappropriate_cancel()
{
	$("#video-tools-feedback").slideUp('fast');
}

function feedback()
{
	var abuse_type = $("#video-report-form #abuse_type").val();
	var comment = $("#video-report-form #abuse_comments").val();
	if ( abuse_type == "" )
	{
		alert("Please Select Abuse value");
	}
	else if( comment == "" )
	{
		alert("You must enter comment");
	}
	else
	{
		var sUrl = baseurl + '/ajax/video_inappropriate.php';
		var postData = 'vid=' + vid + "&abuse_type=" + abuse_type + "&comment=" + comment;

		$.ajax({
	        type: "POST",
	        url: sUrl,
	        data: postData,
	        dataType: 'json',
	        success: inappropriate_success,
	        error: inappropriate_failure
	    });
	}
}

function inappropriate_success(json)
{
    if (json.messageType == "success") {
        $("#video-tools-result")
            .removeClass("alert-danger")
            .addClass("alert-success")
            .text(json.message)
            .fadeIn("slow");
        inappropriate_cancel();
    } else {
        $("#video-tools-result")
            .removeClass("alert-success")
            .addClass("alert-danger")
            .text(json.message)
            .fadeIn("slow");
    }
}

function inappropriate_failure()
{
    $("#video-tools-result")
        .removeClass("alert-success")
        .addClass("alert-danger")
        .text("Connection failed")
        .fadeIn("slow");
}