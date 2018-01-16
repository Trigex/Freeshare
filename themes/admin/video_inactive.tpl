<div class="page-header">
    <h1>Inactive Videos ({$total})</h1>
</div>

{if !empty($videos_inactive_all)}

<table class="table table-striped table-hover">

<tr>
    <td align="center">
        <b>ID</b>
        <a href="?sort=video_id+asc&a={$smarty.request.a}">
            <span class="glyphicon glyphicon-arrow-up"></span>
        </a>
        <a href="?sort=video_id+desc&a={$smarty.request.a}">
            <span class="glyphicon glyphicon-arrow-down"></span>
        </a>
    </td>

    <td>
        <b>Video Title</b>
    </td>

    <td align="center">
        <b>Action</b>
    </td>
</tr>

{foreach from=$videos_inactive_all item=video_inactive}

<tr>
    <td align="center">{$video_inactive.video_id}</td>
    <td><a href="video_details.php?id={$video_inactive.video_id}">{$video_inactive.video_title}</a></td>
    <td align="center">
        <a href="?video_id={$video_inactive.video_id}&page={$smarty.request.page}&action=activate" data-toggle="tooltip" data-placement="bottom" title="Activate">
            <span class="glyphicon glyphicon-ok"></span>
        </a>
    </td>
</tr>

{/foreach}

</table>

<div>
{$links}
</div>

{if $total ne "0"}
<div>
<a href="?action=activate_all">Activate All Videos</a>
</div>
{/if}

{else}

<div class="alert alert-success">
    No inactive video.
</div>

{/if}

{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
{/literal}
