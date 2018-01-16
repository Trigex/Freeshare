$(function(){
    $(".btn-like").click(function(){
        var btnLike = $(this);
        btnLike.addClass("disabled");

        $.get(baseurl + "/ajax/video_like.php?video_id=" + vid).done(function(msg){
            if (msg.messageType == "error") {
                $("div#video-tools-result").addClass("alert-danger").html(msg.message).show();
            } else {
                var likeCount = btnLike.children("span#like-count").html();
                likeCount = parseInt(likeCount) + 1;
                btnLike.children("span#like-count").html(likeCount);
                btnLike.removeClass("btn-default").addClass("btn-success");
            }
        });
    });
});