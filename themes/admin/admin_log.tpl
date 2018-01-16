<div class="page-header">
    <h1>Admin Log</h1>
</div>

<table class="table table-striped table-hover">

    <tr>
        <td width="15%"><b>USERNAME</b></td>
        <td width="15%">
            <b>USER IP</b>
            <a href="admin_log.php?sort=admin_log_ip+asc&page={$page}">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="admin_log.php?sort=admin_log_ip+desc&page={$page}">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td width="20%">
            <b>TIME</b>
            <a href="admin_log.php?sort=admin_log_time+asc&page={$page}">
            <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="admin_log.php?sort=admin_log_time+desc&page={$page}">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td>
            <b>PAGE REQUESTED</b>
        </td>

    </tr>

    {section name=i loop=$admin_log_info}
    <tr>
        <td>
        {if $admin_log_info[i].admin_log_user_id eq '0'}
            Admin
        {else}
            {insert name=id_to_name un=$admin_log_info[i].admin_log_user_id assign=user_name}
            <a href="user_view.php?user_id={$admin_log_info[i].admin_log_user_id}">{$user_name}</a>
        {/if}
        </td>
        <td>{$admin_log_info[i].admin_log_ip}</td>
        <td>{$admin_log_info[i].admin_log_time|date_format:"%B %e, %Y %H:%M:%S"}</td>
        <td>{$admin_log_info[i].admin_log_script}{if $admin_log_info[i].admin_log_extra ne ''}?{$admin_log_info[i].admin_log_extra}{/if}</td>
    </tr>
    {/section}
</table>

<div class="row">
    <div class="col-md-10">{$links}</div>
    <div class="col-md-2"><a href="{$base_url}/admin/admin_log_delete.php" class="btn btn-danger btn-lg">Delete Old Logs</a></div>
</div>
