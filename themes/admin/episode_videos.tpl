<div class="page-header">
    <h1>Videos in episode {$episode_info.episode_name}</h1>
</div>

<div class="col-md-10 row">

<table class="table table-striped">
    <thead>
        <tr>
            <th>Title</th>
            <th width="10%">Action</th>
        </tr>
    </thead>
    <tbody>
        {foreach $episode_videos as $video}
        <tr>
            <td><a href="video_details.php?id={$video.ep_video_vid}">{$video.video_title}</a></td>
            <td>
                <a href="episode_video_delete.php?ep_video_id={$video.ep_video_id}" data-toggle="tooltip" data-placement="bottom" title="Remove from episode" onclick="javascript:return confirm('Are you sure you want to remove this video?');">
                    <span class="glyphicon glyphicon-trash"></span>
                </a>
            </td>
        </tr>
        {foreachelse}
        <tr>
            <td colspan="2">There are no videos found.</td>
        </tr>
        {/foreach}
    </tbody>
</table>

</div>
{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
{/literal}