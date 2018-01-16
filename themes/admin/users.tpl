<div class="page-header">
    {if $smarty.get.a eq 'Inactive'}
        <div class="btn-group pull-right">
            <a class="btn btn-default" href="user_inactive_manage.php">Manage Inactive Users</a>
        </div>
    {/if}
    <h1>{$smarty.request.a} Users ({$total})</h1>
</div>

{if $total > 0}

<table class="table table-striped">

	<tr>
		<td>
			<b>Name</b>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_name+asc&page={$page}">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_name+desc&page={$page}">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>
		<td>
			<b>Country</b>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_country+asc&page={$page}">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_country+desc&page={$page}">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>
		<td>
			<b>Last Login</b>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_last_login_time+asc&page={$page}">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_last_login_time+desc&page={$page}">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>
		<td>
			<b>Video</b>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_videos+asc&page={$page}">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_videos+desc&page={$page}">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
		</td>
		{if $enable_package eq "yes"}
		<td>
			<b>Package</b>
		</td>
		{/if}
		<td>
			<b>Status</b>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_account_status+asc&page={$page}">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_account_status+desc&page={$page}">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>
		<td align="left">
			<b>Action</b>
		</td>
	</tr>

	{foreach from=$users item=user_info}
		<tr>
			<td>
				<a href="user_view.php?user_id={$user_info.user_id}&page={$smarty.request.page}">
					{$user_info.user_name}
				</a>
			</td>
			<td>
				{$user_info.user_country}
			</td>
			<td>
				{$user_info.user_last_login_time|date_format}
			</td>
			<td>
                {if $user_info.user_videos gt "0"}
                <a href="user_videos.php?uid={$user_info.user_id}">
                    {$user_info.user_videos}
                </a>
                {else}
                0
                {/if}
			</td>
			{if $enable_package eq "yes"}
            {insert name=subscriber_info assign=pack uid=$user_info.user_id}
			<td>
				{$pack.package_name}
			</td>
			{/if}
			<td>
                {if $user_info.user_account_status eq 'Active'}
                <span class="label label-success">
                {else if $user_info.user_account_status eq 'Inactive'}
                <span class="label label-warning">
                {else if $user_info.user_account_status eq 'Suspended'}
                <span class="label label-danger">
                {/if}
                {$user_info.user_account_status}</span>
			</td>
			<td align="left">
				<a href="user_edit.php?action=edit&uid={$user_info.user_id}&page={$smarty.request.page}&sort={$smarty.request.sort}" data-toggle="tooltip" data-placement="bottom" title="Edit">
                    <span class="glyphicon glyphicon-edit"></span>
                </a>
                &nbsp;
				<a href="mail_users.php?email={$user_info.user_email}&uname={$user_info.user_name}" data-toggle="tooltip" data-placement="bottom" title="Email User">
                    <span class="glyphicon glyphicon-envelope"></span>
                </a>
            </td>
		</tr>
	{/foreach}

</table>

<div>
    {$links}
</div>

{else}

<h5>No inactive users found.</h5>

{/if}

{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>
{/literal}
