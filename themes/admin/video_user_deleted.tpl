<div class="page-header">
    <h1>User Deleted Videos ({$total})</h1>
</div>

{if $total > 0}

<script language="JavaScript" type="text/javascript" src="{$base_url}/js/admin_user_deleted_videos.js"></script>

<table class="table table-striped table-hover">

<tr>
<td>
	<b>ID</b>
	<a href="?sort=video_id+asc"><span class="glyphicon glyphicon-arrow-up"></span></a>
	<a href="?sort=video_id+desc"><span class="glyphicon glyphicon-arrow-down"></span></a>
</td>

<td>
	<b>Title</b>
	<a href="?sort=video_title+asc"><span class="glyphicon glyphicon-arrow-up"></span></a>
	<a href="?sort=video_title+desc"><span class="glyphicon glyphicon-arrow-down"></span></a>
</td>

<td>
	<b>Type</b>
	<a href="?sort=video_type+asc"><span class="glyphicon glyphicon-arrow-up"></span></a>
	<a href="?sort=video_type+desc"><span class="glyphicon glyphicon-arrow-down"></span></a>
</td>

<td>
	<b>Duration</b>
	<a href="?sort=video_duration+asc"><span class="glyphicon glyphicon-arrow-up"></span></a>
	<a href="?sort=video_duration+desc"><span class="glyphicon glyphicon-arrow-down"></span></a>
</td>

<td>
	<b>Featured</b>
	<a href="?sort=video_featured+asc"><span class="glyphicon glyphicon-arrow-up"></span></a>
	<a href="?sort=video_featured+desc"><span class="glyphicon glyphicon-arrow-down"></span></a>
</td>

<td>
	<b>Date</b>
	<a href="?sort=video_add_date+asc"><span class="glyphicon glyphicon-arrow-up"></span></a>
	<a href="?sort=video_add_date+desc"><span class="glyphicon glyphicon-arrow-down"></span></a>
</td>

<td align="center"><b>Action</b></td>

</tr>

{section name=aa loop=$videos}

<tr>
	<td>{$videos[aa].video_id}</td>
	<td><a href="video_details.php?a={$a}&id={$videos[aa].video_id}&page={$page}">{$videos[aa].video_title}</a></td>
	<td>{$videos[aa].video_type}</td>
	<td>{$videos[aa].video_length}</td>
	<td>{$videos[aa].video_featured}</td>
	<td>{$videos[aa].video_add_date|date_format}</td>
	<td align="center">
		<a href="video_user_deleted_activate.php?id={$videos[aa].video_id}" data-toggle="tooltip" data-placement="bottom" title="Activate">
        <span class="glyphicon glyphicon-ok"></span>
        </a> &nbsp;
		<a href="video_delete.php?id={$videos[aa].video_id}" onclick='Javascript:return confirm("Are you sure want to delete?");' data-toggle="tooltip" data-placement="bottom" title="Delete Permanently">
            <span class="glyphicon glyphicon-remove-circle"></span>
        </a>
	</td>
</tr>

{/section}

</table>

<div>
    <div class="col-md-10 pull-left">{$links}</div>
    <div class="pull-right">
        <a href="{$base_url}/admin/video_user_deleted_all.php" class="btn btn-danger">
            Delete All
        </a>
    </div>
</div>

{else}

<h5>There are no user deleted videos found.</h5>

{/if}

{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
{/literal}
