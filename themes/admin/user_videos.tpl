<div class="page-header">
	<h1>Videos By User : <a href="user_view.php?user_id={$user_id}">{$user_name}</a> ({$total})</h1>
</div>

{if $total > 0}

<table class="table table-striped">

<tr>
	<td>
		<b>ID</b>
		<a href="?uid={$smarty.request.uid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_id+asc">
			<span class="glyphicon glyphicon-arrow-up"></span>
		</a>
		<a href="?uid={$smarty.request.uid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_id+desc">
			<span class="glyphicon glyphicon-arrow-down"></span>
		</a>
	</td>

	<td>
		<b>Title</b>
		<a href="?uid={$smarty.request.uid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_title+asc">
			<span class="glyphicon glyphicon-arrow-up"></span>
		</a>
		<a href="?uid={$smarty.request.uid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_title+desc">
			<span class="glyphicon glyphicon-arrow-down"></span>
		</a>
	</td>
	<td>
		<b>Type</b>
		<a href="?uid={$smarty.request.uid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_type+asc">
			<span class="glyphicon glyphicon-arrow-up"></span>
		</a>
		<a href="?uid={$smarty.request.uid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_type+desc">
			<span class="glyphicon glyphicon-arrow-down"></span>
		</a>
	</td>
	<td>
		<b>Duration</b>
		<a href="?uid={$smarty.request.uid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_duration+asc">
			<span class="glyphicon glyphicon-arrow-up"></span>
		</a>
		<a href="?uid={$smarty.request.uid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_duration+desc">
			<span class="glyphicon glyphicon-arrow-down"></span>
		</a>
	</td>
	<td>
		<b>Featured</b>
		<a href="?uid={$smarty.request.uid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_featured+asc">
			<span class="glyphicon glyphicon-arrow-up"></span>
		</a>
		<a href="?uid={$smarty.request.uid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_featured+desc">
			<span class="glyphicon glyphicon-arrow-down"></span>
		</a>
	</td>
	<td>
		<b>Date</b>
		<a href="?uid={$smarty.request.uid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_add_date+asc">
			<span class="glyphicon glyphicon-arrow-up"></span>
		</a>
		<a href="?uid={$smarty.request.uid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_add_date+desc">
			<span class="glyphicon glyphicon-arrow-down"></span>
		</a>
	</td>
	<td align="center">
		<b>Action</b>
	</td>
</tr>

{foreach from=$videos item=video}
<tr>
	<td>{$video.video_id}</td>
	<td><a href="video_details.php?id={$video.video_id}">{$video.video_title|truncate:60:"...":true}</a></td>
	<td>{$video.video_type}</td>
	<td>{$video.video_length}</td>
	<td>{$video.video_featured}</td>
	<td>{$video.video_add_date|date_format}</td>
	<td align="center">
		<a href="video_edit.php?action=edit&video_id={$video.video_id}&page={$smarty.request.page}&sort={$smarty.request.sort}" data-toggle="tooltip" data-placement="bottom" title="Edit">
			<span class="glyphicon glyphicon-edit"></span>
		</a> &nbsp;
		<a href="video_delete.php?id={$video.video_id}" onclick='Javascript:return confirm("Are you sure you want to delete?");' data-toggle="tooltip" data-placement="bottom" title="Delete">
			<span class="glyphicon glyphicon-remove-circle"></span>
		</a>
	</td>
</tr>

{/foreach}

</table>

<div>
    {$links}
</div>

{else}

<div class="alert alert-warning">
	There is no video uploaded by user {$user_name}
</div>

{/if}

{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
{/literal}
