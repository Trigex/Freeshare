function check(value)
{
    x = document.user_deleted_videos.elements.length;
    
    for(i=0;i<x;i++)
    {
        if (document.user_deleted_videos.elements[i].name == 'user_deleted_video_id[]')
        {
            document.user_deleted_videos.elements[i].checked = value;
        }
    }
}

function validate_frm()
{
    var j = 0;
    x = document.user_deleted_videos.elements.length;
    
    for (i=0; i<x; i++)
    {
        if(document.user_deleted_videos.elements[i].name == 'user_deleted_video_id[]' && document.user_deleted_videos.elements[i].checked != true)
        {
            j=j+1;
        }
    }
    
    if(j==x)
    {
        alert('Please select any one');
        return false;
    } 
    else 
    {
        return true;
    } 
}
