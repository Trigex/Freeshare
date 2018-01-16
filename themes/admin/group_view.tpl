{insert name=group_info_count assign=num_group_members tbl=group_members gid=$group.group_id query="1" field1=group_member_approved field2=group_member_group_id}
{insert name=group_info_count assign=num_group_videos tbl=group_videos gid=$group.group_id query="1" field1=group_video_approved field2=group_video_group_id}
{insert name=group_info_count assign=num_group_topics tbl=group_topics gid=$group.group_id query="1" field1=group_topic_approved field2=group_topic_group_id}
{insert name=id_to_name assign=uname un=$group.group_owner_id}


<div class="row">

<div class="col-md-8">

<form action="" method="post">

	<table class="table table-striped table-hover">

	<tr>
		<td colspan="2">
			{insert name=group_image assign=group_image_info gid=$group.group_id tbl=group_videos}
			{if $group_image_info eq "0"}
				<img src="{$img_css_url}/images/no_videos_groups.gif" width="120" height="90">
			{else}
				<img src="{$group_image_info.video_thumb_url}/thumb/{$group_image_info.video_folder}1_{$group_image_info.video_id}.jpg" width="120" height="90">
			{/if}
		</td>
	</tr>

	<tr>
		<td>Group ID</td>
		<td>{$group.group_id}</td>
	</tr>

	<tr>
		<td>Group Name</td>
		<td>{$group.group_name}</td>
	</tr>

	<tr>
		<td>Owner</td>
		<td><a href="user_view.php?user_id={$group.group_owner_id}">{$uname}</a></td>
	</tr>

	<tr>
		<td>Tags</td>
		<td>{$group.group_keyword}</td>
	</tr>

	<tr>
		<td>Group Description</td>
		<td>{$group.fname} {$group.group_description}</td>
	</tr>

	<tr>
		<td>Group URL</td>
		<td>{$group.group_url}</td>
	</tr>

	<tr>
		<td>Total Video</td>
		<td><a href="group_videos.php?gid={$group.group_id}">{$num_group_videos}</a></td>
	</tr>

	<tr>
		<td>Total Member</td>
		<td><a href="group_members.php?group_id={$group.group_id}">{$num_group_members}</a></td>
	</tr>

	<tr>
		<td>Total Topics</td>
		<td><a href="group_topics.php?gid={$group.group_id}">{$num_group_topics}</a></td>
	</tr>

	<tr>
		<td>Group Type</td>
		<td>{$group.group_type}</td>
	</tr>

	<tr>
		<td>Upload Type</td>
		<td>{$group.group_upload}</td>
	</tr>

	<tr>
		<td>Topic Posting Type</td>
		<td>{$group.group_posting}</td>
	</tr>

	<tr>
		<td>Group Image</td>
		<td>{$group.group_image}</td>
	</tr>

	<tr>
		<td>Is Featured?</td>
		<td>{$group.group_featured}</td>
	</tr>

	<tr>
		<td>Channel</td>
		<td>{$ch_checkbox}</td>
	</tr>

	</table>

</form>

</div>  <!-- //col-md-x -->

</div> <!-- //row -->

<a href="group_edit.php?action=edit&gid={$group.group_id}&page={$smarty.request.page}" class="btn btn-default btn-lg">
	Edit Group
</a>
