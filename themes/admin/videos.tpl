<div class="page-header">
    <h1>{$smarty.request.a|capitalize} Videos ({$total})</h1>
</div>

{if $total gt 0}

{if $a eq "embedded"}
<form method="post" action="" onsubmit="javascript:return confirm('Are you sure you want to delete?');">
{/if}

<table class="table table-striped table-hover">
    <tr>
    {if $a eq "embedded"}
        <td><input type="checkbox" id="check_all" /></td>
    {/if}
        <td>
            <b>ID</b>
            <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=video_id+asc&page={$page}">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=video_id+desc&page={$page}">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>

        <td>
            <b>Title</b>
            <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=video_title+asc&page={$page}">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=video_title+desc&page={$page}">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td>
            <b>Type</b>
            <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=video_type+asc&page={$page}">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=video_type+desc&page={$page}">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td>
            <b>Duration</b>
            <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=video_duration+asc&page={$page}">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=video_duration+desc&page={$page}">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td>
            <b>Featured</b>
            <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=video_featured+asc&page={$page}">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=video_featured+desc&page={$page}">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td>
            <b>Views</b>
            <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=video_view_number+asc&page={$page}">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=video_view_number+desc&page={$page}">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td>
            <b>Date</b>
            <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=video_add_date+asc&page={$page}">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=video_add_date+desc&page={$page}">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td align="center">
            <b>Action</b>
        </td>
    </tr>

    {section name=aa loop=$videos}

        <tr>
        {if $a eq "embedded"}
            <td><input type="checkbox" name="video_id_arr[]" value="{$videos[aa].video_id}" rel="video_ids" /></td>
        {/if}
            <td>{$videos[aa].video_id}</td>
            <td><a href="video_details.php?a={$a}&id={$videos[aa].video_id}&page={$page}">{$videos[aa].video_title|truncate:50:"...":true}</a></td>
            <td>{$videos[aa].video_type}</td>
            <td>{$videos[aa].video_length}</td>
            <td>{$videos[aa].video_featured}</td>
            <td>{$videos[aa].video_view_number}</td>
            <td>{$videos[aa].video_add_date|date_format}</td>
            <td align="center">
                <a href="video_edit.php?a={$a}&action=edit&video_id={$videos[aa].video_id}&page={$page}&sort={$smarty.request.sort}" data-toggle="tooltip" data-placement="bottom" title="Edit">
                    <span class="glyphicon glyphicon-edit"></span>
                </a>
                {if $episode_enable eq '1'}
                &nbsp;
                <a href="episode.php?video_id={$videos[aa].video_id}" data-toggle="tooltip" data-placement="bottom" title="Add to Episode">
                    <span class="glyphicon glyphicon-plus"></span>
                </a>
                {/if}
            </td>
        </tr>

    {/section}

</table>

{if $links ne ""}
<div>
    {$links}
</div>
{/if}

{if $a eq "embedded"}
    <input type="submit" name="submit" id="video_del" value="Delete Selected Videos" class="btn btn-default btn-lg">
</form>
{/if}

{else}

    <div class="alert alert-warning">No videos found.</div>

{/if}


{literal}
<script type="text/javascript">
$("input#check_all").click(function(){
    var checked = $("input#check_all").is(":checked");
    $("input[rel=video_ids]").prop("checked", checked);
});
</script>
{/literal}

{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
{/literal}
