<div class="page-header">
    <h1>Flagged Videos ({$total})</h1>
</div>

<table class="table table-striped">

<tr>
    <td>
    <b>ID</b>
        <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=inappropriate_request_video_id+asc&page={$page}">
            <span class="glyphicon glyphicon-arrow-up"></span>
        </a>
        <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=inappropriate_request_video_id+desc&page={$page}">
            <span class="glyphicon glyphicon-arrow-down"></span>
        </a>
    </td>
    <td>
        <b>Video Title</b>
    </td>
    <td>
        <b>Total Request</b>
        <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=inappropriate_request_count+asc&page={$page}">
            <span class="glyphicon glyphicon-arrow-up"></span>
        </a>
        <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=inappropriate_request_count+desc&page={$page}">
            <span class="glyphicon glyphicon-arrow-down"></span>
        </a>
    </td>
    <td>
        <b>Last Reqeust Date</b>
        <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=inappropriate_request_date+asc&page={$page}">
            <span class="glyphicon glyphicon-arrow-up"></span>
        </a>
        <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=inappropriate_request_date+desc&page={$page}">
            <span class="glyphicon glyphicon-arrow-down"></span>
        </a>
    </td>
    <td align="center">
        <b>Action</b>
    </td>
</tr>

{section name=aa loop=$videos}

{insert name=getfield assign=title field='video_title' table='videos' qfield='video_id' qvalue=$videos[aa].inappropriate_request_video_id}

<tr>
    <td>{$videos[aa].inappropriate_request_video_id}</td>
    <td><a href="video_details.php?id={$videos[aa].inappropriate_request_video_id}">{$title|truncate:50:"...":true}</a></td>
    <td>{$videos[aa].inappropriate_request_count}</td>
    <td>{$videos[aa].inappropriate_request_date|date_format}</td>
    <td align="center">
        <a href="videos_inappropriate.php?a={$smarty.request.a}&action=del&video_id={$videos[aa].inappropriate_request_video_id}&page={$page}&sort={$smarty.request.sort}" onclick='Javascript:return confirm("Are you sure you want to delete?");' data-toggle="tooltip" data-placement="bottom" title="Delete">
            <span class="glyphicon glyphicon-trash"></span>
        </a>
    </td>
</tr>

{/section}

</table>

<div class="row">
    <div class="col-md-10">{$links}</div>
    <div class="col-md-2">
        <a href="?a={$smarty.request.a}&page={$page}&action=delete" onclick='Javascript:return confirm("Are you sure you want to delete?");' class="btn btn-danger">
            Delete All Requests
        </a>
    </div>
</div>

{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
{/literal}
