<h1>Featured Videos ({$total})</h1>

{if !empty($video_featured_all)}

<table class="table table-striped table-hover">
	<tr>
		<td>
			<b>
				ID
			</b>
			<a href="video_featured.php?sort=video_id+asc&a={$smarty.request.a}">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="video_featured.php?sort=video_id+desc&a={$smarty.request.a}">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>
		<td>
			<b>
				Video Title
			</b>
		</td>
		<td align="center">
			<b>
				Action
			</b>
		</td>
	</tr>

	{foreach from=$video_featured_all item=video_featured}

		<tr>
			<td>
				{$video_featured.video_id}
			</td>
			<td>
				<a href="video_details.php?id={$video_featured.video_id}">
					{$video_featured.video_title}
				</a>
			</td>
			<td align="center">
				<a href="video_featured.php?video_id={$video_featured.video_id}&page={$smarty.request.page}&todo=un_feature" onclick="Javascript:return confirm('Are you sure you want to remove?');" data-toggle="tooltip" data-placement="bottom" title="Remove">
					<span class="glyphicon glyphicon-trash"></span>
				</a>
			</td>
		</tr>

	{/foreach}

</table>

<div class="row">
    <div class="col-md-10">{$links}</div>
    <div class="col-md-2">
        <a href="video_featured.php?todo=un_feature_all" onclick="Javascript:return confirm('Are you sure you want to remove all featured videos?');" class="btn btn-danger">
            Remove All Featured
        </a>
    </div>
</div>

{else}

<div class="alert alert-warning">
    No video is featured. To feature a video, go to video edit page, and click
    on the "Feature a video" link at the bottom of the page.
</div>

{/if}

{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
{/literal}
