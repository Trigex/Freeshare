<div class="page-header">
    <h1>Approve Videos ({$total})</h1>
</div>

{if $total > 0}

<table class="table table-striped table-hover">
	<tr>
		<td>
			<b>ID</b>
			<a href="?sort=video_id+asc">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="?sort=video_id+desc">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>

		<td>
			<b>Title</b>
			<a href="?sort=video_title+asc">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="?sort=video_title+desc">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>

		<td class="text-center">
			<b>Type</b>
			<a href="?sort=video_type+asc">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="?sort=video_type+desc">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>

		<td class="text-center">
			<b>Duration</b>
			<a href="?sort=video_duration+asc">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="?sort=video_duration+desc">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>

		<td class="text-center">
			<b>Featured</b>
			<a href="?sort=video_featured+asc">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="?sort=video_featured+desc">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>

		<td class="text-center">
			<b>Date</b>
			<a href="?sort=video_add_date+asc">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="?sort=video_add_date+desc">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>
		<td class="text-center">
			<b>Action</b>
		</td>
	</tr>

	{section name=i loop=$videos}

	<tr>
		<td>
			{$videos[i].video_id}
		</td>
		<td>
			<a href="video_details.php?id={$videos[i].video_id}&page={$page}">
				{$videos[i].video_title|truncate:40:"...":true}
			</a>
		</td>
		<td class="text-center">
			{$videos[i].video_type}
		</td>
		<td class="text-center">
			{$videos[i].video_length}
		</td>
		<td class="text-center">
			{$videos[i].video_featured}
		</td>
		<td class="text-center">
			{$videos[i].video_add_date|date_format}
		</td>
		<td class="text-center">
			<a href="?action=approve&video_id={$videos[i].video_id}&page={$smarty.request.page}&sort={$smarty.request.sort}">
                <span class="glyphicon glyphicon-ok"></span>
            </a>
		</td>
	</tr>

	{/section}

</table>

<div class="row">
    <div class="col-md-10">{$links}</div>
    <div class="col-md-2">
        <a href="?action=approve_all" class="btn btn-default btn-lg"  data-toggle="tooltip" data-placement="bottom" title="Approve All">Approve All</a>
    </div>
</div>

{else}

<div class="alert alert-success">
	No videos currently awaiting approval.
</div>

{/if}

{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
{/literal}
