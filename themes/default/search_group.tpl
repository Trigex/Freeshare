<br />
{if $total ne "0"}

<div id="content">

    <div class="section">
    
	    <div class="hd">
			<div class="hd-l">Search Groups</div>
			<div class="hd-r">Results {$start_num}-{$end_num} of {$total}</div>
		</div>

		{section name=i loop=$view.groups}

		{insert name=group_image assign=group_image_info gid=$view.groups[i].group_id tbl=group_videos}

		<div class="video-entry bg2">
		
			<div class="box1">
				<a href="{$base_url}/group/{$view.groups[i].group_url}/">
					{if $group_image_info eq "0"}
						<img src="{$img_css_url}/images/no_videos_groups.gif" />
					{else}
						<img height="90" src="{$group_image_info.video_thumb_url}/thumb/{$group_image_info.video_folder}1_{$group_image_info.video_id}.jpg" />
					{/if}
				</a>
					   
			</div>

			<div class="box2">
			
				<p class="video_title">
					<a href="{$base_url}/group/{$view.groups[i].group_url}/">
						{$view.groups[i].group_name}
					</a>
				</p>

				<p class="video-entry-description">
					{$view.groups[i].group_description}
				</p>
			
				<p class="video-entry-tags">
					<img width="38" height="14" src="{$img_css_url}/images/tags.gif" />:
                    {section name=j loop=$view.groups[i].group_keywords_array}
                        <a href="{$base_url}/search_group.php?search={$view.groups[i].group_keywords_array[j]}">{$view.groups[i].group_keywords_array[j]}</a>
                    {/section}
				</p>
					  
			</div>
			
		</div> <!--video-entry-->
			
		{/section}
		
		{if $page_link ne ""}
			<div class="page_links">
				Pages: {$page_link}
			</div>
		{/if}

	</div> <!-- section -->
	
</div> <!-- content -->

<div id="sidebar">

	<div class="section bg2">
	
		<div class="hd">
			<div class="hd-l">Search Groups</div>
		</div>
		
		<div class="tags">
			<b>Related Tags: </b>
			{section name=i loop=$view.group_keywords_array_all}
				<p>
					<a href="{$base_url}/search_group.php?search={$view.group_keywords_array_all[i]}">
						{$view.group_keywords_array_all[i]}
					</a>
				</p>
			{/section}
		</div>
		
	</div>
	
</div>

{/if}