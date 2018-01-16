function video_comment_delete(vid, comment_id)
{
    var sUrl = baseurl + '/ajax/video_comment_delete.php';
    var postData = 'comment_id=' + comment_id + '&video_id=' + vid;

    $.ajax({
        type: "POST",
        url: sUrl,
        data: postData,
        dataType: 'json',
        success: delete_comment_success,
        error: delete_comment_error
    });
}

function delete_comment_success(json) 
{
    if (json.messageType == 'success')
    {
        $('#' + json.message).slideUp('slow');
        $('#comment_post_result').html('Comment deleted successfully.').fadeIn('slow');
    }
    else
    {
        $("#comment_post_result").css('display','block').html('Comment delete failed.');
    }
    show_comments(vid, 1);
}

function delete_comment_error()
{
    $("#comm_result").css('display','block').html('connection failed.');
}