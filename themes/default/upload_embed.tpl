<div class="col-md-12">
    <div class="page-header">
        <h1>Video Upload</h1>
    </div>

    <form id="upload" name="theForm" action="{$base_url}/upload/embed/" method="post" class="form-horizontal">
        <div class="form-group">
            <label class="control-label col-md-3">Youtube/Dailymotion Video URL:</label>
            <div class="col-md-5">
                <input name="url" value="{$smarty.post.url}" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">Video Channel:</label>
            <div class="col-md-3">
                <select name="channel" class="form-control">
                    {section name=i loop=$channel_info}
                        <option value="{$channel_info[i].channel_id}">{$channel_info[i].channel_name_html}</option>
                    {/section}
                </select>
            </div>
        </div>

	<!--

        <div>
            <label>Broadcast:</label>
            <div class="indent">
                <input name="field_privacy" type="radio" value="public" checked="checked" /> <strong>Public:</strong> Share your video with the world! (Recommended)<br />
                <input name="field_privacy" type="radio" value="private" /> <strong>Private:</strong> Only viewable by you and those you share the video with.
            </div>
        </div>

	-->

        <div class="form-group">
            <div class="col-md-2 col-md-offset-3">
                <button type="submit" name="action_upload" id="upload" class="btn btn-default btn-lg">UPLOAD</button>
            </div>
        </div>
    </form>
</div>