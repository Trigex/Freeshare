<h1>Activate Video</h1>

<form action="" method="post">

    <div>
        <label>Video ID:</label>
        {$video.video_id}
    </div>

    <div>
        <label>Title:</label>
        {$video.video_title}
    </div>

    <div>
        <label>Description:</label>
        {$video.video_description}
    </tr>

    <div style="clear:both;">
        <label>Keywords:</label>
        {$video.video_keywords}
    </div>

    <div>
        <label>Type:</label>
        {$video.video_type}
    </div>
    
    <div>
        <label>User Name:</label>
        <input type="text" name="user_name" size="30" value="{$username}" />
        <input type="hidden" value="{$video.video_id}" name="video_id" />
    </div>
    
    <div class="submit">
        <input type="submit" name="activate" value="Activate" />
    </div>  

</form>