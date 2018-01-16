<div class="col-md-12">
    <div class="page-header">
        <h1>Video Upload <small>(Step 1 of 2)</small></h1>
    </div>

    <form id="upload" name="theForm" action="{$base_url}/upload.php" method="post" class="form-horizontal" role="form">
        <div class="form-group">
            <label class="control-label col-md-2">Title:</label>
            <div class="col-md-6">
                <input class="form-control" required name="video_title" value="{$smarty.post.video_title}">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Description:</label>
            <div class="col-md-6">
                <textarea class="form-control" required name="video_description" rows="5">{$smarty.post.video_description}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Tags:</label>
            <div class="col-md-6">
                <input class="form-control" required name="video_keywords" id="video_keywords" value="{$smarty.post.video_keywords}">
                <p class="help-block">Separate tags using a comma.</p>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Video Channels:</label>
            <div class="col-md-6">
                <select class="form-control" name="channel" id="channel" required>
                    <option value="">-- Select --</option>
                    {section name=i loop=$channel_info}
                        <option value="{$channel_info[i].channel_id}">{$channel_info[i].channel_name_html}</option>
                    {/section}
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Broadcast:</label>
            <div class="col-md-6">
                <div class="radio">
                    <label>
                        <input name="field_privacy" required type="radio" value="public" checked="checked">
                        <strong>Public</strong>
                        <span class="text-muted">
                            <small>Share your video with the world! (Recommended)</small>
                        </span>
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input name="field_privacy" required type="radio" value="private">
                        <strong>Private</strong>
                        <span class="text-muted">
                            <small>Only viewable by you and those you share the video with.</small>
                        </span>
                    </label>
                </div>
            </div>
        </div>
        {if Config::get('youtube_api_key') eq ""}
        <input type="hidden" name="upload_from" value="local">
        {else}
        <div class="form-group">
            <label class="control-label col-md-2">Upload From:</label>
            <div class="col-md-6">
                <div class="radio">
                    <label>
                        <input type="radio" required name="upload_from" value="local" checked="checked">
                        <strong>Your PC</strong>
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" required name="upload_from" value="remote">
                        <strong>Remote Server</strong>
                    </label>
                </div>
            </div>
        </div>
        {/if}

        {if $family_filter eq "1"}
            <div class="form-group">
                <label class="control-label col-md-2">Adult Video:</label>
                <div class="col-md-6">
                    <div class="radio">
                        <label>
                            <input type="radio" required name="video_adult" value="0" checked="checked"> <strong>No</strong><br />
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" required name="video_adult" value="1"> <strong>Yes</strong>
                        </label>
                    </div>
                </div>
            </div>
        {else}
            <input type="hidden" name="video_adult" value="0">
        {/if}

        <div class="form-group">
            <div class="col-md-2 col-md-offset-2">
                <button type="submit" name="action_upload" id="upload" class="btn btn-default btn-lg">UPLOAD</button>
            </div>
        </div>
    </form>
</div>