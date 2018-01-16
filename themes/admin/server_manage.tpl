<div class="page-header">
    <h1>Manage Server</h1>
</div>

<table class="table table-striped table-hover">

<tr>
    <td><b>Server Ip</b></td>
    <td><b>Server Url</b></td>
    <td><b>Username</b></td>
    <td><b>Password</b></td>
    <td><b>Folder Name</b></td>
    <td><b>Status</b></td>
    <td><b>Server Type</b></td>
    <td><b>Action</b></td>
</tr>

{foreach from=$server_info item=server_details}

<tr>
    <td>{$server_details.ip}</td>
    <td>{$server_details.url}</td>
    <td>{$server_details.user_name}</td>
    <td>{$server_details.password}</td>
    <td>{$server_details.folder}</td>
    <td>
        <a href="{$base_url}/admin/server_manage_status.php?server_id={$server_details.id}">
            {if $server_details.status == "0"}
                Disabled
            {elseif $server_details.status == "1"}
                Enabled
            {/if}
        </a>
    </td>
    <td>
        {if $server_details.server_type == "0"}
            VIDEO SERVER
        {elseif $server_details.server_type == "1"}
            THUMBNAIL SERVER
        {elseif $server_details.server_type == "2"}
            SECDOWNLOAD
        {elseif $server_details.server_type == "3"}
            ngx_http_secure_link_module
        {/if}
    </td>
    <td>
        <a href="{$base_url}/admin/server_manage_edit.php?id={$server_details.id}" data-toggle="tooltip" data-placement="bottom" title="Edit">
            <span class="glyphicon glyphicon-edit"></span>
        </a> &nbsp;
        <a href="{$base_url}/admin/server_manage_delete.php?id={$server_details.id}" onclick="return confirm('Are you sure you want to remove ?');" data-toggle="tooltip" data-placement="bottom" title="Delete">
            <span class="glyphicon glyphicon-remove-circle"></span>
        </a>
    </td>
</tr>

{/foreach}

</table>

{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
{/literal}
