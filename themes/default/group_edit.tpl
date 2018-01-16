<div class="page-header">
    <h1>
        Edit Group
        <small class="pull-right btn font-size-md">
            <a href="{$base_url}/group/{$group_info.group_url}/">
                Back to {$group_info.group_name}
            </a>
        </small>
    </h1>
</div>

<form name="group-edit" id="group-edit" method="post" action="{$base_url}/group/{$group_info.group_url}/edit/" class="form-horizontal" role="form">
    <div class="form-group">
        <label for="group_name" class="control-label col-md-2">Group Name:</label>
        <div class="col-md-5">
            <input type="text" name="group_name" id="group_name" class="form-control" value="{$group_info.group_name}">
        </div>
    </div>
    <div class="form-group">
        <label for="group_keyword" class="control-label col-md-2">Tags:</label>
        <div class="col-md-5">
            <input type="text" id="group_keyword" class="form-control" name="group_keyword" value="{$group_info.group_keyword}">
            <div class="help-block">
                <strong>Enter one or more tags, separated by spaces.</strong><br />
                <small>Tags are simply keywords used to describe your group so they are easily searched and organized.<br />
                For example, if you have a group for surfers, you might tag it: surfing beach waves.</small>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="group_description" class="control-label col-md-2">Description:</label>
        <div class="col-md-5">
            <textarea rows="5" name="group_description" id="group_description" class="form-control">{$group_info.group_description}</textarea>
            <div class="help-block">
                <strong>Select between one to three channels that your group belong to.</strong><br />
                <small>It helps to use relevant channels so that others can find your group!</small>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">Group Channels:</label>
        <div class="col-md-5">
            <div class="checkbox">{$ch_checkbox}</div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">Type:</label>
        <div class="col-md-5">
            <div class="radio">
                <label><input type="radio" {if $group_info.group_type eq "public"}checked="checked"{/if} value=public name="group_type" /> Public, anyone can join</label>
            </div>
            <div class="radio">
                <label><input type="radio" {if $group_info.group_type eq "protected"}checked="checked"{/if} value=protected name="group_type" /> Protected, requires founder approval to join.</label>
            </div>
            <div class="radio">
                <label><input type="radio" {if $group_info.group_type eq "private"}checked="checked"{/if} value=private name="group_type" /> Private, by founder invite only, only members can view group details.</label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">Video Uploads:</label>
        <div class="col-md-5">
            <div class="radio">
                <label><input type="radio" {if $group_info.group_upload eq "immediate"}checked="checked"{/if} value="immediate" name="group_upload" />Post videos immediately.</label>
            </div>
            <div class="radio">
                <label><input type="radio" {if $group_info.group_upload eq "owner_approve"}checked="checked"{/if} value="owner_approve" name="group_upload" />Founder approval required before video is available.</label>
            </div>
            <div class="radio">
                <label><input type="radio" {if $group_info.group_upload eq "owner_only"}checked="checked"{/if} value="owner_only" name="group_upload" />Only Founder can add new videos.</label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">Forum Postings:</label>
        <div class="col-md-5">
            <div class="radio">
                <label><input type="radio" {if $group_info.group_posting eq "immediate"}checked="checked"{/if} value="immediate" name="group_posting" />Post topics immediately.</label>
            </div>
            <div class="radio">
                <label><input type="radio" {if $group_info.group_posting eq "owner_approve"}checked="checked"{/if} value="owner_approve" name="group_posting" /> Founder approval required before topic is available.</label>
            </div>
            <div class="radio">
                <label><input type="radio" {if $group_info.group_posting eq "owner_only"}checked="checked"{/if} value="owner_only" name="group_posting" />Only Founder can create a new topic.</label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">Group Icon:</label>
        <div class="col-md-5">
            <div class="radio">
                <label><input type="radio" {if $group_info.group_image eq "immediate"}checked="checked"{/if} value="immediate" name="group_image" /> Automatically set group icon to last uploaded video.</label>
            </div>
            <div class="radio">
                <label><input type="radio" {if $group_info.group_image eq "owner_only"}checked="checked"{/if} value="owner_only" name="group_image" /> Let owner pick the video as group icon.</label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-2 col-md-offset-2">
            <button type="submit" name="submit" class="btn btn-default btn-lg">Update</button>
        </div>
    </div>
</form>