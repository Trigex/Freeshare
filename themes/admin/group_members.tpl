<h1>Members in Group : {$group_name}</h1>

{if $smarty.request.a ne "Search"}
    <p>
        Total: {$grandtotal}
    </p>
{/if}

<table class="table table-striped table-hover">

	<tr>
		<td>
			<b>ID</b>
			<a href="?group_id={$smarty.request.group_id}&a={$smarty.request.a}&status={$smarty.request.status}&sort=user_id+asc">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="?group_id={$smarty.request.group_id}&a={$smarty.request.a}&status={$smarty.request.status}&sort=user_id+desc">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>
		<td>
			<b>Name</b>
			<a href="?group_id={$smarty.request.group_id}&a={$smarty.request.a}&status={$smarty.request.status}&sort=user_name+asc">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="?group_id={$smarty.request.group_id}&a={$smarty.request.a}&status={$smarty.request.status}&sort=user_name+desc">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>
		<td>
			<b>Country</b>
			<a href="?group_id={$smarty.request.group_id}&a={$smarty.request.a}&status={$smarty.request.status}&sort=user_country+asc">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="?group_id={$smarty.request.group_id}&a={$smarty.request.a}&status={$smarty.request.status}&sort=user_country+desc">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>
		<td>
			<b>Last Login</b>
			<a href="?group_id={$smarty.request.group_id}&a={$smarty.request.a}&status={$smarty.request.status}&sort=user_last_login_time+asc">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="?group_id={$smarty.request.group_id}&a={$smarty.request.a}&status={$smarty.request.status}&sort=user_last_login_time+desc">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>
		<td>
			<b>Video</b>
		</td>
		<td>
			<b>Status</b>
			<a href="?group_id={$smarty.request.group_id}&a={$smarty.request.a}&status={$smarty.request.status}&sort=user_account_status+asc">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="?group_id={$smarty.request.group_id}&a={$smarty.request.a}&status={$smarty.request.status}&sort=user_account_status+desc">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>
		<td align="center">
			<b>Action</b>
		</td>
	</tr>

	{foreach from=$users item=user}

        <tr>
            <td>{$user.user_id}</td>
            <td><a href="user_view.php?user_id={$user.user_id}">{$user.user_name}</a></td>
            <td>{$user.user_country}</td>
            <td>{$user.user_last_login_time|date_format}</td>
            <td>
                {insert name=video_count assign=vdo uid=$user.user_id}
                {if $vdo ne "0"}<a href="user_videos.php?uid={$user.user_id}">{$vdo}</a>{else}0{/if}
            </td>
            <td>{$user.user_account_status}</td>
            <td align="center">
                <a href="user_edit.php?action=edit&uid={$user.user_id}&page={$smarty.request.page}&sort={$smarty.request.sort}">
                    <span class="glyphicon glyphicon-edit"></span>
                </a> &nbsp;
                <a href="?group_id={$smarty.request.group_id}&a={$smarty.request.a}&action=del&uid={$user.user_id}&page={$smarty.request.page}&sort={$smarty.request.sort}" onclick='Javascript:return confirm("Are you sure you want to remove the member from this group?");'>
                    <span class="glyphicon glyphicon-remove-circle"></span>
                </a> &nbsp;
                <a href="mail_users.php?email={$user.user_email}&uname={$user.user_name}">
                    <span class="glyphicon glyphicon-envelope"></span>
                </a>
            </td>
        </tr>

	{/foreach}

</table>

<div>
    {$link}
</div>