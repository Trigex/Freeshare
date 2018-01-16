$(function(){
    $("#show-user-videos").on("click", function(){
        var $btnUserVideos = $(this).button("loading");

        if ($("#user-videos-block").attr("data-loaded") != "yes") {
            var user_id = $("#user-videos-block").attr("data-user-id");
            var sUrl = baseurl + "/ajax/user_videos.php";
            var postData = "user_id=" + user_id + "&video_id=" + vid;
            $.ajax({
                type: "GET",
                url: sUrl,
                data: postData,
                dataType: 'html',
                success: function(msg) {
                    $("#user-videos-block").html(msg);
                    $("#user-videos-block").attr("data-loaded", "yes").slideDown("fast");
                },
                error: function() {
                    alert("Connection Failed.");
                }
            });
        } else {
            $("#user-videos-block").slideToggle("fast");
        }

        $btnUserVideos.button("reset");
    });
});