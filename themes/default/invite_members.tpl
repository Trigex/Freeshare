{if $allow_invite eq "1"}
<div class="page-header">
    <h1>Invite Friends to {$group_info.group_name}</h1>
</div>

<form action="{$base_url}/group/{$group_info.group_url}/invite/" id="invite-members-forum" name="invite-members-forum" method="post" onsubmit="return false;" class="form-horizontal" role="form">
    <input type="hidden" name="send" value="send" />
    <div class="col-md-4">
        <select name="myfriends" id="myfriends" size="10" class="form-control">
            {$fname}
        </select>
    </div>
    <div class="col-md-4 text-center">
        <button name="add_all" class="btn btn-default" onclick="invite_mem_addall();">Add All <span class="glyphicon glyphicon-forward"></span></button><br><br>
        <button name="add" class="btn btn-default" onclick="invite_mem_add();">Add <span class="glyphicon glyphicon-triangle-right"></span></button><br><br>
        <button name="remove" class="btn btn-default" onclick="invite_mem_remove();"><span class="glyphicon glyphicon-triangle-left"></span> Remove</button><br><br>
        <button name="remove_all" class="btn btn-default" onclick="invite_mem_removeall();"><span class="glyphicon glyphicon-backward"></span> Remove All</button><br><br>
    </div>
    <div class="col-md-4">
        <select name="flist[]" id="invitefriends" size="10" class="form-control">
        </select>
        <div id="friends_div"></div>
    </div>

    <div class="clearfix"></div>
    <div class="page-header">
        <h2>Invite New Friends</h2>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">Email Address:</label>
        <div class="col-md-6">
            <textarea id="recipients" name="recipients" rows="4" class="form-control">{$smarty.request.recipients}</textarea>
            <div class="help-block">Enter Email Addresses separated by commas</div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">Your Message:</label>
        <div class="col-md-6">
            <div class="help-block">Enter your message below:</div>
            <textarea name="message" rows="5" class="form-control">{$message}</textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-3 col-md-offset-2">
            <button name="action_invite" onclick="invite_mem_send();" class="btn btn-default btn-lg">Send</button>
        </div>
	</div>
</form>

{else}

<div align="center">
	Sorry! You are not allowed to invite members.
</div>

{/if}