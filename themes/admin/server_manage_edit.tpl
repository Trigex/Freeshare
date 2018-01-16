<div class="page-header">
    <h1>Edit Server</h1>
</div>

<form method="post" action="server_manage_edit.php" class="form-horizontal" role="form">

    <fieldset>

    <input type="hidden" name="server_id" value="{$server_info.id}" />

    <div class="form-group">
        <label class="col-sm-3 control-label" for="server_url">Server URL</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" name="server_url" id="server_url" value="{$server_info.url}" size="50" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/add_server#server_url" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
            <p class="help-block">No trailing slash. Eg: http://video1.site.com</p>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="server_ip">Server IP</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" name="server_ip" id="server_ip" value="{$server_info.ip}" size="50" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/add_server#server_ip" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="user_name">Username</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" name="user_name" id="user_name" value="{$server_info.user_name}" size="50" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/add_server#server_username" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="password">Password</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" name="password" id="password" value="{$server_info.password}" size="50" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/add_server#server_password" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="folder">Folder Name</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" name="folder" id="folder" value="{$server_info.folder}" size="50" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/add_server#server_folder" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="server_type">Server Type</label>
        <div class="col-sm-5">
            <div class="input-group">
            {if $server_info.server_type != "1"}
                <select class="form-control" name="server_type" id="server_type" onchange="server_type_change(this.value);">
                    <option value="0" {if $server_info.server_type == "0"}selected="selected"{/if}>VIDEO SERVER</option>
                    <option value="2" {if $server_info.server_type == "2"}selected="selected"{/if}>MOD_SECDOWNLOAD (LIGHTTPD)</option>
                    <option value="3" {if $server_info.server_type == "3"}selected="selected"{/if}>ngx_http_secure_link_module</option>
                </select>
            {else}
                <input class="form-control" type="hidden" name="server_type" value="1" />
                <input class="form-control" type="text" value="THUMBNAIL SERVER" disabled>
            {/if}
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/add_server#server_type" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group" {if $server_info.server_type == 2 || $server_info.server_type == 3}style="display:block"{else}style="display:none"{/if} id="secdownload_secret_div">
        <label class="col-sm-3 control-label" for="server_secdownload_secret">secdownload.secret</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="server_secdownload_secret" id="server_secdownload_secret" size="50" value="{$server_info.server_secdownload_secret}" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/add_server#server_type" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
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

{literal}
<script>
function server_type_change(value)
{
	if (value == 2 || value == 3)
	{
		$('#secdownload_secret_div').fadeIn('slow');
	}
	else
	{
		$('#secdownload_secret_div').fadeOut('slow');
	}
}
</script>
{/literal}