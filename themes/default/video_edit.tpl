<div class="col-md-12">
    <div class="page-header">
        <h1>
            Edit Video
            <small class="pull-right btn font-size-md">
                <a href="{$base_url}/view/{$video_info.video_id}/{$video_info.video_seo_name}/">View Video - {$video_info.video_title}</a>
            </small>
        </h1>
    </div>

    <form action="" method="post" id="video-edit" class="form-horizontal" role="form">
        <input type="hidden" name="video_id" value="{$video_info.video_id}">

        <h2>Video Details:</h2>
        <div class="form-group">
            <label class="control-label col-md-2">Title:</label>
            <div class="col-md-5">
                <input maxlength="60" name="video_title" value="{$video_info.video_title}" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Description:</label>
            <div class="col-md-5">
                <textarea name="video_description" rows="4" class="form-control">{$video_info.video_description}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Tags:</label>
            <div class="col-md-5">
                <input maxlength="120" name="video_keywords" value="{$video_info.video_keywords}" class="form-control">
                <div class="help-block">
                    <strong>Enter one or more tags, separated by comma.</strong> <br />
                    Tags are simply keywords used to describe your video so they are easily searched and organized.<br />
                    For example, if you have a surfing video, you might tag it: surfing beach waves.<br />
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Video Channels:</label>
            <div class="col-md-5">
                {section name=i loop=$channels_all}
                    {assign var="status" value=""}
                    {section name=j loop=$chid}
                        {if $chid[j] eq $channels_all[i].channel_id}
                            {assign var="status" value='checked="checked"'}
                        {/if}
                    {/section}
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="channel_list[]" id="channel_list" value="{$channels_all[i].channel_id}" {$status}>{$channels_all[i].channel_name_html}
                        </label>
                    </div>
                {/section}
                <div class="help-block">Select between 1 to {$num_max_channels} channels that best describe your video.</div>
            </div>
        </div>
        <br>

        <h2>File Details:</h2>
        <div class="form-group">
            <label class="control-label col-md-2">Broadcast:</label>
            <div class="col-md-5">
                <div class="radio">
                    <label>
                        <input type="radio" value="public" name="video_type" {if $video_info.video_type eq "public"}checked="checked"{/if}>
                        <strong>Public:</strong> Share your video with the world! (Recommended)
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" value="private" name="video_type" {if $video_info.video_type eq "private"}checked="checked"{/if}>
                        <strong>Private:</strong> Only viewable by users in your friends list.
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2" class="control-label col-md-2">Allow Comments:</label>
            <div class="col-md-5">
                <div class="radio">
                    <label>
                        <input type="radio" value="yes" name="video_allow_comment" {if $video_info.video_allow_comment eq "yes"}checked="checked"{/if}><strong>Yes:</strong> Allow comments to be added to your video.
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" value="no"  name="video_allow_comment" {if $video_info.video_allow_comment eq  "no"}checked="checked"{/if}><strong>No:</strong> Disallow comments to be added to your video.
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Allow Ratings:</label>
            <div class="col-md-5">
                <div class="radio">
                    <label>
                        <input type="radio" value="yes" name="video_allow_rated" {if $video_info.video_allow_rated eq "yes"}checked="checked"{/if}>
                        <strong>Yes:</strong> Allow people to rate your video.
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" value="no" name="video_allow_rated" {if $video_info.video_allow_rated eq "no"}checked="checked"{/if}>
                        <strong>No:</strong> Disallow people from rating your video.
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Allow Embed This Video:</label>
            <div class="col-md-5">
                <div class="radio">
                    <label>
                        <input type="radio" value="enabled" name="video_allow_embed" {if $video_info.video_allow_embed eq "enabled"}checked="checked"{/if}>
                        <strong>Enabled:</strong> External sites may embed and play this video.
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" value="disabled" name="video_allow_embed" {if $video_info.video_allow_embed eq "disabled"}checked="checked"{/if}>
                        <strong>Disabled:</strong> External sites may NOT embed and play this video.
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-2 col-md-offset-2">
                <button type="submit" name="submit" class="btn btn-default btn-lg">Update Video</button>
            </div>
        </div>
    </form>
</div>