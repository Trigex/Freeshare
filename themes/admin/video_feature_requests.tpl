<h1>Video Feature Requests ({$total})</h1>

{if $total > 0}

<table class="table table-striped table-hover">

<tr>
    <td align="center">
        <b>ID</b>
        <a href="?sort=feature_request_video_id+asc">
            <span class="glyphicon glyphicon-arrow-up"></span>
        </a>
        <a href="?sort=feature_request_video_id+desc">
            <span class="glyphicon glyphicon-arrow-down"></span>
        </a>
    </td>
    <td align="center">
        <b>Video Title</b>
    </td>
    <td align="center">
        <b>Total Request</b>
        <a href="?sort=feature_request_count+asc">
            <span class="glyphicon glyphicon-arrow-up"></span>
        </a>
        <a href="?sort=feature_request_count+desc">
            <span class="glyphicon glyphicon-arrow-down"></span>
        </a>
    </td>
    <td align="center">
        <b>
            Last Reqeust Date
        </b>
        <a href="?sort=feature_request_date+asc">
            <span class="glyphicon glyphicon-arrow-up"></span>
        </a>
        <a href="?sort=feature_request_date+desc">
            <span class="glyphicon glyphicon-arrow-down"></span>
        </a>
    </td>
    <td align="center">
        <b>Action</b>
    </td>
</tr>

{foreach from=$videos item=video}

    {insert name=getfield assign=title field='video_title' table='videos' qfield='video_id' qvalue=$video.feature_request_video_id}

    <tr>
        <td align="center">
            {$video.feature_request_video_id}
        </td>
        <td>
            <a href="video_details.php?a={$a}&id={$video.feature_request_video_id}&page={$page}">{$title|replace:'\\':''}</a>
        </td>
        <td align="center">
            {$video.feature_request_count}
        </td>
        <td align="center">
            {$video.feature_request_date|date_format}
        </td>
        <td align="center">
            <a href="?vid={$video.feature_request_video_id}&page={$page}&action=approve" data-toggle="tooltip" data-placement="bottom" title="Approve">
                <span class="glyphicon glyphicon-ok"></span>
            </a> &nbsp;
            <a href="?vid={$video.feature_request_video_id}&page={$page}&action=del" data-toggle="tooltip" data-placement="bottom" title="Delete">
                <span class="glyphicon glyphicon-trash"></span>
            </a>
        </td>
    </tr>

{/foreach}

</table>

<div class="row">
    <div class="col-md-10">{$links}</div>
    <div class="col-md-2">
        <a href="?page={$page}&action=delete_all" onclick="javascript:return confirm('Are you sure you want to remove?');" class="btn btn-danger">
            Remove All Requests
        </a>
    </div>
</div>

{else}
    <h5>No feature requests found.</h5>
{/if}

{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
{/literal}
