var topicId = '';

function add_topics()
{
    var frm = document.add_group_topic;
    var group_id = frm.group_id.value;
    var topic_title = frm.topic_title.value;
    var topic_video = frm.topic_video.value;
    if(topic_title == '') 
    {
        alert('Please insert topic title');
    }
    else if(topic_title.length <4)
    {
        alert('Topic is too short');
    }
    else 
    {
        var now = new Date();
        var sUrl = baseurl + "/ajax/group_topics.php";
        var postData = "group_id= " + group_id + "&topic_video=" + topic_video + '&topic_title=' + topic_title + '&add_topic=' + now;
        $.ajax({
            type: "POST",
            url: sUrl,
            data: postData,
            dataType: 'json',
            success: add_topic_response,
            error:add_topic_error
        });
    }

}

function add_topic_response(json)
{
    if (json.messageType == 'success')
    {
        $('#add_topic_msg').css('display','block').html(json.message);
        $('#add_topic').slideUp("slow");
        display_topics(1);
    } 
    else if(json.messageType == 'error')
    {
        $('#add_topic_msg').css('color','red');
        $('#add_topic_msg').css('display','block').html(json.message);
    }
}

function add_topic_error()
{
    $('#add_topic_msg').css('color','red');
    $("#add_topic_msg").css('display','block').html('connection failed.');
}

function display_topics(page)
{
    if (page<=0)
    {
        page = 1;
    }

    var sUrl = baseurl + "/ajax/group_topics_display.php?group_id="+group_id+"&page="+page;
    $.ajax({
        type: "GET",
        url: sUrl,
        dataType: 'json',
        success: display_response,
        error:display_error
    });
    
}

function display_response(json)
{
    if (json.messageType == 'success') 
    {
        $('#display_topics').html(json.message);
    }
    else if (json.messageType == 'error') 
    {
        $('#display_topics').css('color','red').html(json.message);
    }
    
}

function display_error()
{
    $('#display_topics').css('color','red').html('connection error');
}

function delete_topic(topic_id)
{
    if (confirm('Are you sure you want to remove this topic?'))
    {
        topicId = topic_id;
        var sUrl = baseurl + "/ajax/group_topics_delete.php?group_id="+group_id+"&topic_id="+topic_id;
        $.ajax({
            type: "GET",
            url: sUrl,
            dataType: 'json',
            success: delete_response,
            error: delete_error
        });
    }
}

function delete_response(json)
{
    if (json.messageType == 'success')
    {
        for(i=1;i<=6;i++){
            Id = i + '_' + topicId;
            $('#' + Id).fadeOut("slow");
        }
        setTimeout(display_topics,600);
        $("#add_topic_msg").fadeOut("slow");
    }
    else 
    {
        $("#add_topic_msg").css('display','block').html(json.message);
    }
}

function delete_error()
{
    $('#add_topic_msg').css('color','red').html('connection error');
}

function approve_topic(topic_id)
{   
    topicId = topic_id;
    var sUrl = baseurl + "/ajax/group_topics_approve.php?group_id="+group_id+"&topic_id="+topic_id;
    $.ajax({
        type: "GET",
        url: sUrl,
        dataType: 'json',
        success: approve_response,
        error: approve_error
    });
}

function approve_response(json)
{
    if (json.messageType == 'success')
    {   
        for(i=1;i<=6;i++){
            Id = i + '_' + topicId;
            $('#' + Id).fadeOut("slow");
            $('#' + Id).fadeIn("slow");
        }
        setTimeout(display_topics,800);
    }
    else 
    {
        $("#add_topic_msg").css('display','block').html(json.message);
    }
} 

function approve_error()
{
    $('#add_topic_msg').css('color','red').html('connection error');
}
