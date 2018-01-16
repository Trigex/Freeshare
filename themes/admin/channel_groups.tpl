<h1>Groups by Channel : {$channel_name}</h1>

{if $smarty.request.a ne "Search"}
    <p>Total: {$grandtotal}</p>
{/if}

<table class="table table-striped table-hover">

    <tr>
        <td>
            <b>ID</b>
            <a href="?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=group_id+asc">
            <span class="glyphicon glyphicon-arrow-up"></span></a>
            <a href="?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=group_id+desc">
            <span class="glyphicon glyphicon-arrow-down"></span></a>
        </td>
        <td>
            <b>Name</b>
            <a href="?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=group_name+asc">
            <span class="glyphicon glyphicon-arrow-up"></span></a>

            <a href="?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=group_name+desc">
            <span class="glyphicon glyphicon-arrow-down"></span></a>
        </td>
        <td>
            <b>Owner</b>
        </td>
        <td>
            <b>Video</b>
        </td>
        <td>
            <b>Member</b>
        </td>
        <td>
            <b>Topics</b>
        </td>
        <td align="center">
            <b>Type</b>
            <a href="?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=group_type+asc">
            <span class="glyphicon glyphicon-arrow-up"></span></a>

            <a href="?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=group_type+desc">
            <span class="glyphicon glyphicon-arrow-down"></span></a>
        </td>
        <td align="center">
            <b>Featured</b>
            <a href="?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=group_featured+asc">
            <span class="glyphicon glyphicon-arrow-up"></span></a>

            <a href="?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=group_featured+desc">
            <span class="glyphicon glyphicon-arrow-down"></span></a>
        </td>
        <td align="center">
            <b>Action</b>
        </td>
    </tr>

    {section name=aa loop=$groups}

        {insert name=group_info_count assign=gmemcount tbl=group_members gid=$groups[aa].group_id query="1" field1=group_member_approved field2=group_member_group_id}
        {insert name=group_info_count assign=gvdocount tbl=group_videos gid=$groups[aa].group_id query="1" field1=group_video_approved field2=group_video_group_id}
        {insert name=group_info_count assign=gtpscount tbl=group_topics gid=$groups[aa].group_id query="1" field1=group_topic_approved field2=group_topic_group_id}

        {insert name=id_to_name assign=uname un=$groups[aa].group_owner_id}

        <tr>
            <td>
                {$groups[aa].group_id}
            </td>
            <td>
                <a href="group_view.php?group_id={$groups[aa].group_id}">
                    {$groups[aa].group_name}
                </a>
            </td>
            <td>
                <a href="user_view.php?user_id={$groups[aa].group_owner_id}">
                    {$uname}
                </a>
            </td>
            <td align="right">
                {$gvdocount}
            </td>
            <td align="right">
                {$gmemcount}
            </td>
            <td align="right">
                {$gtpscount}
            </td>
            <td align="center">
                {$groups[aa].group_type}
            </td>
            <td align="center">
                {$groups[aa].group_featured}
            </td>
            <td align="center">
                <a href="group_edit.php?action=edit&gid={$groups[aa].group_id}&page={$smarty.request.page}&sort={$smarty.request.sort}">
                    <span class="glyphicon glyphicon-edit"></span>
                </a> &nbsp;
                <a href="?chid={$smarty.request.chid}&action=del&gid={$groups[aa].group_id}&page={$smarty.request.page}&sort={$smarty.request.sort}" onclick="Javascript:return confirm('Are you sure you want to remove the group from this channel?');">
                     <span class="glyphicon glyphicon-remove-circle"></span>
                </a>
            </td>
        </tr>

    {/section}

</table>

<div>
    {$link}
</div>
