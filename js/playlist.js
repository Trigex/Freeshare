$(".dropdown-pl").on("shown.bs.dropdown", function(){
    show_playlists();
});

function create_playlist() {
	var playlist_name = $("form#pl-frm input#playlist_name").val();

	if (playlist_name == '') {
		return true;
	}

	var sUrl = baseurl + "/ajax/playlist.php";
	var postData = "action=create_playlist&playlist_name=" + playlist_name;

	$.ajax({
	    type: "GET",
	    url: sUrl,
	    data: postData,
	    dataType: 'json',
	    success: function(msg) {
            if (msg.messageType == "error") {
                $("#video-tools-result")
                    .removeClass("alert-success")
                    .addClass("alert-danger")
                    .text(msg.message)
                    .fadeIn("slow");
            } else {
                $("form#pl-frm input#playlist_name").val('');
                if (isNaN(parseInt(msg.message))) {
                    $("#video-tools-result")
                        .removeClass("alert-danger")
                        .addClass("alert-success")
                        .text(msg.message)
                        .fadeIn("slow");
                } else {
                    add_video_playlist(msg.message);
                }
            }
		},
	    error: function() {
			//$("#video-tools-result").html('connection failed').show();
		}
	});
    $(".dropdown-pl").toggleClass('open');
    return true;
}

function show_playlists() {
    $(".dropdown-pl .pl-lists").html('<img src="' + baseurl + '/themes/default/images/loading.gif">');
	var sUrl = baseurl + "/ajax/playlist.php";
	var postData = "action=show_playlist&user_id=" + user_id + "&video_id=" + vid;

	$.ajax({
	    type: "GET",
	    url: sUrl,
	    data: postData,
	    dataType: 'json',
	    success: function(msg) {
            if (msg.messageType == "error") {
                $("#video-tools-result")
                    .removeClass("alert-success")
                    .addClass("alert-danger")
                    .text(msg.message)
                    .fadeIn("slow");
                $(".pl-lists").hide();
            } else {
                $(".pl-lists").html(msg.message);
            }
		},
	    error: function() {
			//$("#video-tools-result").html('connection failed').show();
		}
	});
}

function add_video_playlist(pl_id) {
	var playlist_id = pl_id;

	if (playlist_id == 0) {
		playlist_id = $("form#show-pl-frm select#playlist_id").val();
	}

	var sUrl = baseurl + "/ajax/playlist.php";
	var postData = "action=add_playlist_video&video_id=" + vid + "&playlist_id=" + playlist_id;

	if (playlist_id == '') {
		return false;
	}

	$.ajax({
		type: "GET",
		url: sUrl,
		data: postData,
		dataType: 'json',
		success: function(msg) {
            if (msg.messageType == "error") {
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
		},
		error: function() {
			//$("#video-tools-result").html('connection failed').show();
		}
	});
    return true;
}