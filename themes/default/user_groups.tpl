{if $total ne "0"}
    <div class="col-md-9">
        <div class="page-header">
            <h1>
                <strong>{$user_info.user_name}</strong>'s Groups
                <small class="pull-right btn font-size-md">Results {$start_num}-{$end_num} of {$total}</small>
            </h1>
        </div>

        <div class="row">
            {section name=i loop=$groups}
                {insert name=group_image assign=group_image_info gid=$groups[i].group_id tbl=group_videos}
                {insert name=time_to_date assign=todate tm=$groups[i].group_create_time}
                {insert name=group_info_count assign=gvdocount tbl=group_videos gid=$groups[i].group_id query="1" field1=group_video_approved field2=group_video_group_id}
                {insert name=group_info_count assign=gmemcount tbl=group_members gid=$groups[i].group_id query="1" field1=group_member_approved field2=group_member_group_id}
                <div class="col-orient-ls col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <a href="{$base_url}/group/{$groups[i].group_url}/">
                            {if $group_image_info eq "0"}
                                <img class="img-responsive" width="100%" src="{$img_css_url}/images/no_videos_groups.gif" alt="{$groups[i].group_name}">
                            {else}
                                <img class="img-responsive" width="100%" src="{$group_image_info.video_thumb_url}/thumb/{$group_image_info.video_folder}1_{$group_image_info.video_id}.jpg" alt="{$groups[i].group_name}">
                            {/if}
                        </a>
                        <div class="caption">
                            <h5>
                                <a href="{$base_url}/group/{$groups[i].group_url}/">
                                    {$groups[i].group_name}
                                </a>
                                <br>
                                <small>{$groups[i].group_description|truncate:60}</small>
                            </h5>
                            <p class="text-muted small">
                                on {$groups[i].group_create_time|date_format}&nbsp;|&nbsp;
                                Status : {$groups[i].group_type}
                            </p>
                            <p class="text-muted small">
                                <a href="{$base_url}/group/{$groups[i].group_url}/members/1">{$gmemcount} Members</a> |
                                <a href="{$base_url}/group/{$groups[i].group_url}/videos/1">{$gvdocount} Videos</a> |
                                {if $groups[i].group_owner_id eq $smarty.session.UID}
                                     <span class="label label-success">Group owner</span>
                                {/if}
                            </p>
                        </div>
                    </div>
                </div>
            {/section}
        </div>

        {if $page_links ne ""}
            <div>{$page_links}</div>
        {/if}

    </div>

    <div class="col-md-3">
        <div class="page-header">
            <h2>Group Tags:</h2>
        </div>
        <div class="list-group">
            {section name=i loop=$view.user_group_keywords_array}
                <a class="list-group-item" href="{$base_url}/tag/{$view.user_group_keywords_array[i]}/">{$view.user_group_keywords_array[i]}</a>
            {/section}
        </div>
    </div>

{else}

        <div align="center">
            <h3>
            {if $smarty.session.USERNAME == $user_info.user_name} Hi {$smarty.session.USERNAME}, {/if}  You are not a member of any groups.
            </h3>

            {if $smarty.session.USERNAME == $user_info.user_name}
            <p class="lead text-muted text-center">Click the below button to create your group and share videos with group members </p>

            <a href="{$base_url}/group/new/" class="btn btn-success btn-lg">Create a group now</a>
            {/if}

        </div>

{/if}