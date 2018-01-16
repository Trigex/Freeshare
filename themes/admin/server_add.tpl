<div class="page-header">
    <h1>Add FTP Server</h1>
</div>

<form method="post" action="" class="form-horizontal" role="form">

    <fieldset>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="server_url">Server URL:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="server_url" id="server_url" value="{$smarty.post.server_url}" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/add_server#server_url" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
            <p class="help-block">No trailing slash. Eg: http://video1.site.com</p>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="server_ip">FTP Server IP:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="server_ip" id="server_ip" value="{$smarty.post.server_ip}" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/add_server#server_ip" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="server_username">FTP Server Username:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="server_username" id="server_username" value="{$smarty.post.server_username}" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/add_server#server_username" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="server_password">FTP Server Password:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="server_password" id="server_password" value="{$smarty.post.server_password}" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/add_server#server_password" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="server_folder">FTP Server Folder Name:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="server_folder" id="server_folder" value="{$smarty.post.server_folder}" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/add_server#server_folder" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="server_type">Server Type:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <select class="form-control" name="server_type" id="server_type" onchange="server_type_change(this.value);">
                    <option value="0" {if $smarty.post.server_type == "0"}selected="selected"{/if}>VIDEO SERVER</option>
                    <option value="1" {if $smarty.post.server_type == "1"}selected="selected"{/if}>THUMBNAIL SERVER</option>
                    <option value="2" {if $smarty.post.server_type == "2"}selected="selected"{/if}>MOD_SECDOWNLOAD (LIGHTTPD)</option>
                    <option value="3" {if $smarty.post.server_type == "3"}selected="selected"{/if}>ngx_http_secure_link_module</option>
                </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/add_server#server_type" target="_blank">
                        <span class="glyphicon glyphicon-question-sign"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group" {if $smarty.post.server_type == 2}style="display:block"{else}style="display:none"{/if} id="secret_div">
        <label class="col-sm-3 control-label" for="server_secdownload_secret">secret</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="server_secdownload_secret" id="server_secdownload_secret" value="{$smarty.post.secdownload_secret}" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/add_server#server_type" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-5">
            <button type="submit" name="submit" class="btn btn-default btn-lg">Add Server</button>
        </div>
    </div>

    </fieldset>

</form>


{literal}

<script type="text/javascript">

function server_type_change(obj_id) {
	if (obj_id == "2" || obj_id == "3") {
		$('#secret_div').fadeIn('slow');
	} else {
		$('#secret_div').fadeOut('slow');
	}
}

</script>

{/literal}
