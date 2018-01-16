<h1>Channel Videos : {$channel_name}</h1>

<table class="table table-striped table-hover">

    <tr>
        <td>
            <b>ID</b>
            <a href="channel_videos.php?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_id+asc">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="channel_videos.php?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_id+desc">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>

        <td>
            <b>Title</b>
            <a href="channel_videos.php?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_title+asc">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="channel_videos.php?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_title+desc">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>

        <td>
            <b>Type</b>
            <a href="channel_videos.php?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_type+asc">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="channel_videos.php?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_type+desc">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td>
            <b>Duration</b>
            <a href="channel_videos.php?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_duration+asc">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="channel_videos.php?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_duration+desc">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td>
            <b>Featured</b>
            <a href="channel_videos.php?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_featured+asc">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="channel_videos.php?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_featured+desc">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td>
            <b>Date</b>
            <a href="channel_videos.php?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_add_date+asc">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="channel_videos.php?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_add_date+desc">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td align="center">
            <b>Action</b>
        </td>
    </tr>

    {foreach from=$channel_videos_all item=channel_video}

        <tr>
            <td>{$channel_video.video_id}</td>

            <td>
                <a href="video_details.php?id={$channel_video.video_id}&page={$smarty.request.page}">
                    {$channel_video.video_title}
                </a>
            </td>

            <td align="center">{$channel_video.video_type}</td>
            <td align="center">{$channel_video.video_duration|string_format:"%.2f"}</td>
            <td align="center">{$channel_video.video_featured}</td>
            <td align="center">{$channel_video.video_add_date|date_format}</td>

            <td align="center">
                <a href="video_edit.php?action=edit&video_id={$channel_video.video_id}&page={$smarty.request.page}&sort={$smarty.request.sort}">
                    <span class="glyphicon glyphicon-edit"></span>
                </a> &nbsp;
                <a href="channel_videos.php?chid={$smarty.request.chid}&action=del&video_id={$channel_video.video_id}" onClick="Javascript:return confirm('Are you sure you want to remove the video from this channel?');">
                    <span class="glyphicon glyphicon-minus"></span>
                </a>
            </td>

        </tr>
    {/foreach}

</table>

<div>
    {$links}
</div>
