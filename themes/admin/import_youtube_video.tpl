{if Config::get('youtube_api_key') eq ""}
    <div class="alert alert-warning">
        <span class="glyphicon glyphicon-warning-sign"></span>
        <a href="settings_miscellaneous.php#youtube_api_key"  class="alert-link">
            You need to set Youtube API Key to add youtube videos.
        </a>
    </div>
{else}

<div class="page-header">
    <h1>Add Youtube Video</h1>
</div>

<form method="post" action="" class="form-horizontal">
    <div class="form-group">
        <label class="control-label col-md-2">Youtube Video URL</label>
        <div class="col-md-4">
            <input type="url" name="url" id="url" class="form-control" value="{$video_url}" required placeholder="https://www.youtube.com/watch?v=XXXXXXXX">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">User</label>
        <div class="col-md-4">
            <input type="text" name="user" id="user" class="form-control" value="{$user}" required placeholder="Username">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">Channels</label>
        <div class="col-md-4">
            <select id="channel" name="channel" class="form-control" required="required">
                <option value="">--SELECT--</option>
                {foreach Channel::get() as $channel}
                <option value="{$channel['channel_id']}">{$channel['channel_name']}</option>
                {/foreach}
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">Privacy</label>
        <div class="col-md-4">
            <select name="privacy" id="privacy" class="form-control" required>
                <option value="public" selected>Public</option>
                <option value="private">Private</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-2 col-md-offset-2">
            <input type="submit" name="submit" value="Import" class="btn btn-default btn-lg">
        </div>
    </div>
</form>
{/if}