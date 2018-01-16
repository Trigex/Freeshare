<h1>Channels ({$total})</h1>

<table class="table table-striped">

    <tr>
        <td>
            <b>Name</b>
            <a href="?a={$smarty.request.a}&status={$smarty.request.status}&sort=channel_name+asc&page={$page}">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="?a={$smarty.request.a}&status={$smarty.request.status}&sort=channel_name+desc&page={$page}">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td><b>Description</b></td>
        <td><b>Videos</b></td>
        <td><b>Groups</b></td>
        <td width="100" align="center"><b>Action</b></td>
    </tr>

    {section name=aa loop=$channels}

        {insert name=channel_count assign=count cid=$channels[aa].channel_id}

        <tr>
            <td><a href="channel_search.php?id={$channels[aa].channel_id}&action=search">{$channels[aa].channel_name}</a></td>
            <td>{$channels[aa].channel_description}</td>
            <td>{if $count[1] ne "0"}<a href="channel_videos.php?chid={$channels[aa].channel_id}">{$count[1]}</a>{else}0{/if}</td>
            <td>{if $count[2] ne "0"}<a href="channel_groups.php?chid={$channels[aa].channel_id}">{$count[2]}</a>{else}0{/if}</td>
            <td align="center">
            <a href="channel_edit.php?action=edit&chid={$channels[aa].channel_id}&page={$page}&sort={$smarty.request.sort}" data-toggle="tooltip" data-placement="bottom" title="Edit">
                <span class="glyphicon glyphicon-edit"></span>
            </a> &nbsp;
            <a href="?a={$smarty.request.a}&action=del&chid={$channels[aa].channel_id}&page={$page}&sort={$smarty.request.sort}" onclick="Javascript:return confirm('Are you sure you want to delete?');" data-toggle="tooltip" data-placement="bottom" title="Delete">
                <span class="glyphicon glyphicon-remove-circle"></span>
            </a>
            </td>
        </tr>

    {/section}

</table>

<div>
    {$links}
</div>

{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
{/literal}
