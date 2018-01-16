<div class="col-md-9">
    <div class="page-header">
        <h1>
            {$category}
            <small class="pull-right btn font-size-md">
                Groups {$start_num} - {$end_num} of {$total}
            </small>
        </h1>
    </div>
    <div class="row">
        {section name=i loop=$group_info}
            {insert name=group_image assign=group_image_info gid=$group_info[i].group_id tbl=group_videos}
            {insert name=group_info_count assign=gmemcount tbl=group_members gid=$group_info[i].group_id query="1" field1=group_member_approved field2=group_member_group_id}
            {insert name=group_info_count assign=gvdocount tbl=group_videos gid=$group_info[i].group_id query="1" field1=group_video_approved field2=group_video_group_id}
            <div class="col-orient-ls col-sm-6 col-md-4">
                <div class="thumbnail">
                    <a href="{$base_url}/group/{$group_info[i].group_url}/">
                        {if $group_image_info eq "0"}
                            <img class="img-responsive" width="100%" src="{$img_css_url}/images/no_videos_groups.gif" alt="videos groups">
                        {else}
                            <img class="img-responsive" width="100%" src="{$group_image_info.video_thumb_url}/thumb/{$group_image_info.video_folder}1_{$group_image_info.video_id}.jpg" alt="{$group_image_info.video_folder}">
                        {/if}
                    </a>
                    <div class="caption">
                        <h5>
                            <a href="{$base_url}/group/{$group_info[i].group_url}/">
                                {$group_info[i].group_name}
                            </a>
                            <br>
                            <small>{$group_info[i].group_description}</small>
                        </h5>
                        <p class="text-muted small">
                            on {$group_info[i].group_create_time|date_format}&nbsp;|&nbsp;
                            Status : {$group_info[i].group_type}
                        </p>
                        <p class="text-muted small">
                            <a href="{$base_url}/group/{$group_info[i].group_url}/members/1">{$gmemcount} Members</a> |
                            <a href="{$base_url}/group/{$group_info[i].group_url}/videos/1">{$gvdocount} Videos</a>
                        </p>
                    </div>
                </div>
            </div>
        {/section}
    </div>

    {if $page_links ne ""}
        <div class="page_links">{$page_links}</div>
    {/if}
</div>
<div class="col-md-3">
    <div class="page-header">
        <h2>Browse Groups</h2>
    </div>
    <div class="list-group">
        <a class="list-group-item" href="{$base_url}/groups/featured/1">Featured</a>
        <a class="list-group-item" href="{$base_url}/groups/recent/1">Most Recent</a>
        <a class="list-group-item" href="{$base_url}/groups/members/1">Most Members</a>
        <a class="list-group-item" href="{$base_url}/groups/videos/1">Most Videos</a>
        <a class="list-group-item" href="{$base_url}/groups/topics/1">Most Topics</a>
    </div>

    <div class="page-header">
        <h2>Groups By Channel</h2>
    </div>
    <div class="list-group">
        {section name=k loop=$channels}
            {insert name=group_count assign=gcount chid=$channels[k].channel_id}
            <a class="list-group-item" href="{$base_url}/groups/{$channels[k].channel_id}/{$channels[k].channel_seo_name}/1">
                {$channels[k].channel_name_html}
                <span class="badge">{$gcount}</span>
            </a>
        {/section}
    </div>
</div>