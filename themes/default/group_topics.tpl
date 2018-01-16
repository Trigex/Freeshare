{if $group_topics eq ""}
	<div class="alert alert-info">There is no topics for this group!</div>
{else}
	<table class="table table-striped">
        <thead>
    		<tr>
    			<th>Topics</th>
    			<th>Author</th>
    			<th>Posts</th>
    			<th>Created On</th>
    			<th>Last Post</th>
    		</tr>
        </thead>
        <tbody>
    		{section name=i loop=$group_topics}
        		{insert name=post_count assign=total_post TID=$group_topics[i].group_topic_id}
        		{insert name=getfield assign='lastpost' field='group_topic_post_date' table='group_topic_posts' qfield='group_topic_post_topic_id' qvalue=$group_topics[i].group_topic_id order='order by group_topic_post_id desc'}
        		<tr>
        			<td id="1_{$group_topics[i].group_topic_id}">
                        <a href="{$base_url}/group/{$group_info.group_url}/topic/{$group_topics[i].group_topic_id}">{$group_topics[i].group_topic_title|truncate:210}</a>
                    </td>
        			<td id="2_{$group_topics[i].group_topic_id}">
                        <a href="{$base_url}/{$group_topics[i].user_name}">{$group_topics[i].user_name}</a>
                    </td>
        			<td id="3_{$group_topics[i].group_topic_id}" align="center">{$total_post}</td>
        			<td id="4_{$group_topics[i].group_topic_id}" align="center">{$group_topics[i].group_topic_add_time}</td>
        			<td id="5_{$group_topics[i].group_topic_id}">{if $lastpost eq ""}N/A{else}{insert name=timediff time=$lastpost}{/if}</td>

        			{if $smarty.session.UID eq $group_info.group_owner_id }
        			<td id="6_{$group_topics[i].group_topic_id}">
                        <a href="javascript:void(0);" onclick="delete_topic({$group_topics[i].group_topic_id});">
                            <img src="{$img_css_url}/images/del.gif" border="0" alt="">
                        </a>
                        {if $smarty.session.UID eq $group_info.group_owner_id and $group_topics[i].group_topic_approved eq "no"}
                        <a href="javascript:void(0);" onclick="approve_topic({$group_topics[i].group_topic_id});">
                            <img src="{$img_css_url}/images/ok.gif" border="0" alt="">
                        </a>
                        {/if}
                    </td>
        			{/if}
        		</tr>
    		{/section}
    		{if $topics_links ne ""}
        		<tr>
        			<td colspan="5" align="right">Page: <b>{$topics_links}</b></td>
        		</tr>
    		{/if}
        </tbody>
	</table>
{/if}