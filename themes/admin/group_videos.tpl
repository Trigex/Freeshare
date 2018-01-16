<h1>Videos in Group: {$group_name}</h1>

{if $smarty.request.a ne "Search"}
    <p>
        Total: {$grandtotal}
    </p>
{/if}

<table class="table table-striped table-hover">

    <tr>
        <td>
            <b>ID</b>
            <a href="group_videos.php?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_id+asc">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="group_videos.php?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_id+desc">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>

        <td>
            <b>Title</b>
            <a href="group_videos.php?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_title+asc">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="group_videos.php?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_title+desc">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td>
            <b>Type</b>
            <a href="group_videos.php?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_type+asc">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="group_videos.php?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_type+desc">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td>
            <b>Duration</b>
            <a href="group_videos.php?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_duration+asc">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="group_videos.php?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_duration+desc">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td>
            <b>Featured</b>
            <a href="group_videos.php?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_featured+asc">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="group_videos.php?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_featured+desc">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td>
            <b>Date</b>
            <a href="group_videos.php?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_add_date+asc">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="group_videos.php?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_add_date+desc">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td align="center">
            <b>Action</b>
        </td>
    </tr>

    {section name=aa loop=$videos}
    <tr>
        <td>
            {$videos[aa].video_id}
        </td>
        <td>
            <a href="video_details.php?id={$videos[aa].video_id}">
                {$videos[aa].video_title}
            </a>
        </td>
        <td align="center">
            {$videos[aa].video_type}
        </td>
        <td align="center">
            {$videos[aa].video_length}
        </td>
        <td align="center">
            {$videos[aa].video_featured}
        </td>
        <td align="center">
            {$videos[aa].video_add_date|date_format}
        </td>
        <td align="center">
            <a href="video_edit.php?action=edit&video_id={$videos[aa].video_id}&page={$smarty.request.page}&sort={$smarty.request.sort}">
                <span class="glyphicon glyphicon-edit"></span>
            </a> &nbsp;
            <a href="group_videos.php?gid={$smarty.request.gid}&action=del&video_id={$videos[aa].video_id}" onclick="Javascript:return confirm('Are you sure you want to remove the video from this group?');">
                <span class="glyphicon glyphicon-remove-circle"></span>
            </a>
        </td>
    </tr>
    {/section}

</table>

<div>
    {$link}
</div>
