<div class="page-header">
    <h1>Video Settings</h1>
</div>

<form method="post" action="" class="form-horizontal" role="form">

    <fieldset>

    {if $video_output_format ne 'mp4'}
    <div class="form-group">
        <label class="col-sm-3 control-label" for="video_output_format">Video Output Format:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="video_output_format" id="video_output_format">
                <option value="mp4" {if $video_output_format eq 'mp4'}selected="selected"{/if}>MP4</option>
                <option value="flv" {if $video_output_format eq 'flv'}selected="selected"{/if}>FLV</option>
            </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/video_settings#video_output_format" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>
    {else}
        <input type="hidden" name="video_output_format" value="mp4">
    {/if}

    <div class="form-group">
        <label class="col-sm-3 control-label" for="process_upload">Video Processing:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="process_upload" id="process_upload">
                <option value="0" {if $process_upload =='0'}selected="selected"{/if}>Batch Processing</option>
                <option value="1" {if $process_upload =='1'}selected="selected"{/if}>Realtime Processing</option>
                <option value="2" {if $process_upload =='2'}selected="selected"{/if}>Background Processing</option>
            </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/video_settings#process_upload" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="tool_video_thumb">Make Video Thumbnails with:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="tool_video_thumb" id="tool_video_thumb">
                <option value="mplayer" {if $tool_video_thumb =='mplayer'}selected="selected"{/if}>mplayer</option>
                <option value="ffmpeg" {if $tool_video_thumb =='ffmpeg'}selected="selected"{/if}>ffmpeg</option>
                <option value="ffmpeg-php" {if $tool_video_thumb =='ffmpeg-php'}selected="selected"{/if}>ffmpeg-php</option>
            </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/video_settings#tool_video_thumb" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
       <label class="col-sm-3 control-label" for="flv_metadata">Metadata:</label>
       <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="flv_metadata" id="flv_metadata">
                <option value="yamdi" {if $flv_metadata =='yamdi'}selected="selected"{/if}>yamdi</option>
                <option value="flvtool" {if $flv_metadata =='flvtool'}selected="selected"{/if}>flvtool</option>
                <option value="none" {if $flv_metadata =='none'}selected="selected"{/if}>None</option>
            </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/video_settings#flv_metadata" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="process_notify_user">Notify user after processing:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="process_notify_user" id="process_notify_user">
                <option value="0" {if $process_notify_user =='0'}selected="selected"{/if}>No</option>
                <option value="1" {if $process_notify_user =='1'}selected="selected"{/if}>Yes</option>
            </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/video_settings#process_notify_user" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="video_flv_delete">Delete FLV from Server:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="video_flv_delete" id="video_flv_delete">
                <option value="0" {if $video_flv_delete =='0'}selected="selected"{/if}>No</option>
                <option value="1" {if $video_flv_delete =='1'}selected="selected"{/if}>Yes</option>
            </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/video_settings#video_flv_delete" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="guest_upload">Allow Guest Uploads:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="guest_upload" id="guest_upload">
                <option value="0" {if $guest_upload =='0'}selected="selected"{/if}>No</option>
                <option value="1" {if $guest_upload =='1'}selected="selected"{/if}>Yes</option>
            </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/video_settings#guest_upload" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="guest_upload_user" >Guest Upload Added to:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="guest_upload_user" id="guest_upload_user" value="{$guest_upload_user}" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/video_settings#guest_upload_user" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="upload_progress_bar">Upload Progress bar:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="upload_progress_bar" id="upload_progress_bar">
                <option value="none" {if $upload_progress_bar =='none'}selected="selected"{/if}>None</option>
                <option value="uber" {if $upload_progress_bar =='uber'}selected="selected"{/if}>Uber-Uploader</option>
                <option value="html5" {if $upload_progress_bar =='html5'}selected="selected"{/if}>HTML5</option>
            </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/video_settings#upload_progress_bar" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="img_max_width">Maximum Thumbnail Width:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="img_max_width" id="img_max_width" value="{$img_max_width}">
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/video_settings#max_thumb_width" target="_blank">
                        <span class="glyphicon glyphicon-question-sign"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="img_max_height">Maximum Thumbnail Height:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="img_max_height" id="img_max_height" value="{$img_max_height}">
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/video_settings#max_thumb_height" target="_blank">
                        <span class="glyphicon glyphicon-question-sign"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-5">
            <button type="submit" name="submit" class="btn btn-default btn-lg">Update</button>
        </div>
    </div>

    </fieldset>

</form>
