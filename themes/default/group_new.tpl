<div class="page-header">
    <h1>Create Group</h1>
</div>

<form name="groups_create" method="post" action="{$base_url}/group/new/" id="create-group" class="form-horizontal" role="form">
    <input type="hidden" value="create_group_submit" name="field_command">
	<div class="form-group">
		<label for="group_name" class="control-label col-md-2">Group Name:</label>
        <div class="col-md-5">
		  <input type="text" name="group_name" id="group_name" value="{$group_name}" class="form-control">
        </div>
	</div>
	<div class="form-group">
		<label for="tags" class="control-label col-md-2">Tags:</label>
        <div class="col-md-5">
            <input type="text" name="tags" id="tags" value="{$tags}" class="form-control">
    		<div class="help-block">Enter one or more tags, separated by comma.</div>
        </div>
	</div>
	<div class="form-group">
		<label for="description" class="control-label col-md-2">Description:</label>
        <div class="col-md-5">
            <textarea name="description" id="description" rows="4" class="form-control">{$description}</textarea>
        </div>
	</div>
	<div class="form-group">
		<label for="short_name" class="control-label col-md-2">Choose group URL:</label>
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">{$base_url}/group/</span>
                <input name="short_name" id="short_name" value="{$short_name}" class="form-control">
            </div>
			<div class="help-block">Enter 3-18 characters with no spaces (such as &quot; skateboarding &quot;),
			that will become part of your group's web address. Please note, the group name URL you pick is permanent and can not be
			changed.</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="form-group">
		<label class="control-label col-md-2">Group Channels:</label>
        <div class="col-md-5">
            {section name=i loop=$chinfo}
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="chlist[]" value="{$chinfo[i].channel_id}">{$chinfo[i].channel_name_html}
                </label>
            </div>
            {/section}
            <div class="help-block">
                <strong>Select between 1 to 3 channels that your group belong to.</strong>
                <br />
                It helps to use relevant channels so that others can find your group!
            </div>
        </div>
	</div>
    <div class="form-group">
        <label class="control-label col-md-2">Type:</label>
        <div class="col-md-5">
            <div class="radio">
                <label>
                    <input type="radio" value="public" name="group_type" checked>Public, anyone can join.
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" value="protected" name="group_type">Protected, requires founder approval to join.
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" value="private" name="group_type">Private, by founder invite only, only members can view group details.
                </label>
            </div>
        </div>
    </div>
	<div class="form-group">
		<label class="control-label col-md-2">Video Uploads:</label>
		<div class="col-md-5">
            <div class="radio">
                <label>
                    <input type="radio" checked value="immediate" name="video_upload_type">Post videos immediately.
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" value="owner_approve" name="video_upload_type">Founder approval required before video is available.
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" value="owner_only" name="video_upload_type">Only Founder can add new videos.
                </label>
            </div>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-2">Forum Postings:</label>
		<div class="col-md-5">
            <div class="radio">
                <label>
                    <input type="radio" checked value="immediate" name="forum_upload_type">Post topics immediately.
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" value="owner_approve" name="forum_upload_type">Founder approval required before topic is available.
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" value="owner_only" name="forum_upload_type">Only Founder can create a new topic.
                </label>
            </div>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-2">Group Icon:</label>
		<div class="col-md-5">
            <div class="radio">
                <label>
                    <input type="radio" checked  value="immediate" name="group_icon"> Automatically set group icon to last uploaded video.
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" value="owner_only" name="group_icon"> Let owner pick the video as group icon.
                </label>
            </div>
		</div>
	</div>
	<div class="form-group">
        <div class="col-md-2 col-md-offset-2">
            <button type="submit" class="btn btn-default btn-lg" name="submit">Submit</button>
        </div>
	</div>
</form>