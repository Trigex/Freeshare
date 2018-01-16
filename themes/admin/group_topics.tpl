<h1>Topics in Group : {$group_name}</h1>

{if $smarty.request.a ne "Search"}
    <p>
        Total: {$grandtotal}
    </p>
{/if}

<table class="table table-striped table-hover">

	<tr>
		<td>
			<b>Topics</b>
			<a href="?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&page={$page}&sort=group_topic_title+asc">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&page={$page}&sort=group_topic_title+desc">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>
		<td>
			<b>Author</b>
		</td>
		<td>
			<b>Posts</b>
		</td>
		<td>
			<b>Created On</b>
			<a href="?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&page={$page}&sort=group_topic_add_time+asc">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&page={$page}&sort=group_topic_add_time+desc">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>
		<td>
			<b>Approved</b>
			<a href="?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&page={$page}&sort=group_topic_approved+asc">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&page={$page}&sort=group_topic_approved+desc">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>
		<td align="center">
			<b>Action</b>
		</td>
	</tr>

	{section name=i loop=$grptps}

        {insert name=id_to_name assign=uname un=$grptps[i].group_topic_user_id}
        {insert name=post_count assign=total_post TID=$grptps[i].group_topic_id}

        <tr>
            <td>
                <a href="group_posts.php?gid={$grptps[i].group_topic_group_id}&TID={$grptps[i].group_topic_id}">
                    {$grptps[i].group_topic_title|truncate:40}
                </a>
            </td>
            <td>
                <a href="user_view.php?user_id={$grptps[i].group_topic_user_id}">
                    {$uname}
                </a>
            </td>
            <td align="center">
                {$total_post}
            </td>
            <td>
                {$grptps[i].group_topic_add_time|date_format}
            </td>
            <td align="center">
                {$grptps[i].group_topic_approved}
            </td>
            <td align="center">
                <a href="group_posts.php?gid={$smarty.request.gid}&action=edit&TID={$grptps[i].group_topic_id}&page={$smarty.request.page}&sort={$smarty.request.sort}">
                    <span class="glyphicon glyphicon-edit"></span>
                </a> &nbsp;
                <a href="?gid={$smarty.request.gid}&action=del&TID={$grptps[i].group_topic_id}" onclick='Javascript:return confirm("Are you sure you want to delete?");'>
                    <span class="glyphicon glyphicon-remove-circle"></span>
                </a>
            </td>
        </tr>

	{/section}

</table>

<div>
	{$link}
</div>
