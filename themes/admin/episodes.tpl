<div class="page-header">
    <h1>Episodes</h1>
</div>

<div class="col-md-10 row">

<table class="table table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th width="15%">Videos</th>
            <th width="15%">Action</th>
        </tr>
    </thead>
    <tbody>
        {foreach $episodes as $episode}
        <tr>
            <td>{$episode.episode_name}</td>
            <td><a href="episode_videos.php?eid={$episode.episode_id}">{EpisodeVideo::count($episode.episode_id)}</a></td>
            <td>
                <a href="episode_edit.php?id={$episode.episode_id}" data-toggle="tooltip" data-placement="bottom" title="Edit">
                    <span class="glyphicon glyphicon-edit"></span>
                </a>
                &nbsp;
                <a href="episode_delete.php?id={$episode.episode_id}" data-toggle="tooltip" data-placement="bottom" title="Delete" onclick="javascript:return confirm('Are you sure you want to delete?');">
                    <span class="glyphicon glyphicon-trash"></span>
                </a>
            </td>
        </tr>
        {foreachelse}
        <tr>
            <td colspan="3">There are no episodes found.</td>
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