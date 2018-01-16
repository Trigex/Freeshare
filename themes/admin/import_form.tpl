<div class="form-group">
    <label class="col-sm-2 control-label" for="video_user">Add Video to User:</label>
    <div class= "col-sm-5">
        <input class="form-control" type="text" name="video_user" id="video_user" value="{if isset($smarty.post.video_user)}{$smarty.post.video_user}{/if}" required>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="video_title">Title:</label>
    <div class="col-sm-5">
        <input class="form-control" type="text" name="video_title" id="video_title" value="{if isset($smarty.post.video_title)}{$smarty.post.video_title}{/if}" required>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="video_description">Description:</label>
    <div class="col-sm-5">
        <textarea class="form-control" name="video_description" id="video_description" rows="4" required>{if isset($smarty.post.video_description)}{$smarty.post.video_description}{/if}</textarea>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="video_keywords">Tags:</label>
    <div class="col-sm-5">
        <input class="form-control" type="text" name="video_keywords" id="video_keywords" value="{if isset($smarty.post.video_keywords)}{$smarty.post.video_keywords}{/if}" required>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="chlist">Video Channel:</label>
    <div class="col-sm-5">
        <select name="channel" id="channel" class="form-control" required>
            <option value="">-- Select --</option>
            {foreach from=$channels item=channel}
            <option value="{$channel.channel_id}"{if isset($smarty.post.channel) && $smarty.post.channel eq $channel.channel_id} selected{/if}>{$channel.channel_name}</option>
            {/foreach}
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Video Type:</label>
    <div class="col-sm-5">
        <select class="form-control" name="video_privacy" required>
            <option value="public"{if $smarty.post.video_privacy eq 'public'} selected{/if}>Public</option>
            <option value="private"{if $smarty.post.video_privacy eq 'private'} selected{/if}>Private</option>
        </select>
    </div>
</div>