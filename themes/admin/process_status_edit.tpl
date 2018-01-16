<div class="page-header">
    <h1>Process Queue Edit</h1>
</div>




<form method="post" action="{$base_url}/admin/process_status_edit.php?page={$page}" class="form-horizontal" role="form">

    <input type="hidden" name="id" value="{$video_info.id}">

    <div class="form-group">
        <label class="col-sm-2 control-label"><b>Status : </b></label>
        <div class="col-sm-5">
            <p class="form-control-static">
                {if $video_info.status == 0}
                    Video is added to process queue, not yet processed.
                {elseif $video_info.status == 1}
                    Started downloding the video.
                {elseif $video_info.status == 2}
                    Video downloaded successfully.
                {elseif $video_info.status == 3}
                    Error in downloading video. Check if the video exists and server firewall is not blocking the download.
                {elseif $video_info.status == 4}
                    Conversion of video to FLV format started.
                {elseif $video_info.status == 5}
                    Video converted and added to the site.
                {elseif $video_info.status == 6}
                    Error in converting video to FLV format.
                {/if}
            </p>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Edit Status:</label>
        <div class="col-sm-5">
            <select class="form-control" name="status" id="status_value">
                <option value="{$video_info.status}">No Change</option>
                {if $video_info.url != ""}
                    <option value="0">Download Again</option>
                {/if}
                <option value="2">Convert Again</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-5">
            <button type="submit" name="submit" class="btn btn-default btn-lg">Update</button>
        </div>
    </div>

</form>