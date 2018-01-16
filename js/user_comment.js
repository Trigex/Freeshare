function post_profile_comment(profile_id) 
{
    var comment_value = $('#user_comment').val();
    var sUrl = baseurl + "/ajax/user_comment_add.php";
    var postData = "profile_id=" + profile_id + "&comment_value=" + comment_value;
    
    $.ajax({
        type: "POST",
        url: sUrl,
        data: postData,
        dataType: 'json',
        success: post_profile_comment_success,
        error:post_profile_comment_error
    });
}

function post_profile_comment_success(json) 
{
    if (json.messageType == 'success')
    {
        $('#comment_box').fadeOut();
        $('#comm_result').attr("class", "alert alert-success");
    } else {
        $('#comm_result').attr("class", "alert alert-danger");
    }
    $('#comm_result').css('display','block').html(json.message).fadeIn('slow');
    display_user_comments(1);
   
}

function post_profile_comment_error() {
    $("#comm_result").css('display','block').html('connection failed.');
}

function delete_comment(comment_id) 
{
    var sUrl = baseurl+"/ajax/user_comment_delete.php";
    var postData = "comment_id=" + comment_id;
    $.ajax({
        type: "POST",
        url: sUrl,
        data: postData,
        dataType: 'json',
        success: delete_comment_success,
        error:delete_comment_error
    });
}

function delete_comment_success(jsonObj) 
{
    if (jsonObj.messageType == 'success')
    {
        var div_id = jsonObj.message;
		div_id = "#cid-"+div_id;
		$(div_id).slideUp('slow');
        $('#comm_result').attr("class", "alert alert-success");
	} else {
        $('#comm_result').attr("class", "alert alert-danger");
    }

    $("#comm_result").css('display','block').html('Comment deleted successfully.');
}

function delete_comment_error()
{
    $("#comm_result").css('display','block').html('connection failed.');
}
