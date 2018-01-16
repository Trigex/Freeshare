<br />

<table width="95%" bgcolor="#e0e0e0" align="center" cellpadding="2" cellspacing="2">

	<tr>
		<td colspan="3">
			<b>Group Topics</b> :
			<a href="group_view.php?group_id={$smarty.request.gid}">
				<b>{$group_name}</b>
			</a>
			<hr />
		</td>
	</tr>

	<tr>
	<td width="90" align="center" valign="top">
		<br />
		{if $topic.group_topic_video_id eq "0"}
			<img src="{$img_css_url}/images/no_videos_groups.gif" width="60" height="45" alt="" />
		{else}
			<img src="{$topic.video_thumb_url}/thumb/{$topic.video_folder}1_{$topic.group_topic_video_id}.jpg" width="60" height="45" alt="" />
		{/if}
		<br />
		<br />
	</td>
	<td>
		<b>Topic:</b>
        
		{if $smarty.request.action eq "edit"}
			<form action="group_posts.php?gid={$smarty.request.gid}&TID={$smarty.request.TID}&action=edit" method="post">
				<textarea name="title" rows="5" cols="70">{$topic.group_topic_title}</textarea>
				<br />
				<br />
				<b>Approved: </b>
				<select name="approved">
					<option value="yes" {if $topic.group_topic_approved eq "yes"}selected="selected"{/if}>Yes</option>
					<option value="no" {if $topic.group_topic_approved eq "no"}selected="selected"{/if}>No</option>
				</select>
				<center>
					<input type="submit" name="update" value="Update" />
				</center>
				<br />
			</form>
		{else}
			{$topic.group_topic_title}
			<br />
		{/if}
        
		<b>{$topic.group_topic_add_time|date_format:"%A, %B %e, %Y, %H:%M %p"}</b>
		<br />
		{insert name=id_to_name assign=uname un=$topic.group_topic_user_id}
		<b>Author:</b>
		<a href="user_view.php?user_id={$topic.group_topic_user_id}">
			{$uname}
		</a>
	</td>
	<td align="center" width="50">
		{if $smarty.request.action ne "edit"}
			<a href="group_posts.php?gid={$smarty.request.gid}&TID={$smarty.request.TID}&action=edit">
				Edit
			</a>
		{/if}
	</td>
	</tr>
    
</table>

<br />

<table width="95%" bgcolor="#f5f5f5" align="center" cellpadding="2" cellspacing="2">

	<tr>
		<td colspan="3">
			<b>Comments({$total_post}):</b>
		</td>
	</tr>
    
	{section name=i loop=$post}
    
        <tr>
            <td colspan="3">
                <hr />
            </td>
        </tr>

        <tr>
            <td width="90" align="center" valign="top">
                {if $post[i].group_topic_post_video_id ne "0"}
                    <img src="{$post[i].video_thumb_url}/thumb/{$post[i].video_folder}1_{$post[i].group_topic_post_video_id}.jpg" width="60" height="45" alt="" />
                {else}
                    <img src="{$img_css_url}/images/no_videos_groups.gif" width="60" height="45" alt="" />
                {/if}
            </td>
            <td valign="top">
                {if $smarty.request.action eq "pedit" and $post[i].group_topic_post_id eq $smarty.request.PID}
                    <form action="group_posts.php?gid={$smarty.request.gid}&TID={$smarty.request.TID}&PID={$smarty.request.PID}&action=pedit" method="post">
                        <textarea name="post" rows="5" cols="60">{$post[i].group_topic_post_description}</textarea>
                        <br />
                        <br />
                        <center>
                            <input type="submit" name="Update" value="Update" />
                        </center>
                    </form>
                {else}
                    {$post[i].group_topic_post_description}
                    <br />
                {/if}

                <br />
                {insert name=id_to_name assign=uname un=$post[i].group_topic_post_user_id}
                <a href="user_view.php?user_id={$post[i].group_topic_post_user_id}">
                    {$uname}
                </a>
                ({insert name=timediff value=var time=$post[i].group_topic_post_date})
            </td>
            <td>
                <a href="group_posts.php?gid={$smarty.request.gid}&TID={$smarty.request.TID}&PID={$post[i].group_topic_post_id}&action=pedit">
                    <img src="{$img_css_url}/images/edit.gif" title="Edit" alt="Edit" />
                </a>
                <a href="group_posts.php?gid={$smarty.request.gid}&TID={$smarty.request.TID}&PID={$post[i].group_topic_post_id}&action=pdel" onclick="javascript:return confirm('Are you sure you want to delete?');">
                    <span class="glyphicon glyphicon-remove-circle"></span>
                </a>
            </td>
        </tr>
    
	{/section}
    
	<tr>
		<td colspan="3">
			<hr />
		</td>
	</tr>
    
</table>