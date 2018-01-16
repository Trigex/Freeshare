{if $is_mem eq "" and $group_info.group_type eq "private"}

    <div class="alert alert-warning">Sorry! You are not allowed to view this private group.</div>

{elseif $total gt "0"}

<div class="col-md-9">
    <div class="page-header">
        <h1>
            {$group_info.group_name} videos
            <small class="pull-right btn font-size-md">Videos {$start_num}-{$end_num} of {$total}</small>
        </h1>
    </div>

    {section name=i loop=$group_videos}
        <div class="row">
            <div class="col-orient-ls col-sm-6 col-md-4">
                <div class="thumbnail">
                    <div class="preview">
                        <a href="{$base_url}/view/{$group_videos[i].video_id}/{$group_videos[i].video_seo_name}/">
                            <img class="img-responsive" width="100%" height="130" src="{$group_videos[i].video_thumb_url}/thumb/{$group_videos[i].video_folder}1_{$group_videos[i].video_id}.jpg" alt="">
                        </a>
                        <div class="badge video-time">{$group_videos[i].video_length}</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <h4>
                    <a href="{$base_url}/view/{$group_videos[i].video_id}/{$group_videos[i].video_seo_name}/">{$group_videos[i].video_title|truncate:40}</a>
                    <br>
                    <small>{$group_videos[i].video_description|truncate:100}</small>
                </h4>
                <p class="text-muted small">
                    <span class="glyphicon glyphicon-tag"></span>
                    {section name=j loop=$group_videos[i].group_video_keywords}
                        <a href="{$base_url}/tag/{$group_videos[i].group_video_keywords[j]}/">{$group_videos[i].group_video_keywords[j]}</a>&nbsp;
                    {/section}
                </p>
                <p class="text-muted small">
                    {insert name=id_to_name assign=user_name un=$group_videos[i].video_user_id}
                    {insert name=time_range assign=added_on time=$group_videos[i].video_add_time}
                    <span class="glyphicon glyphicon-user"></span>
                    <a href="{$base_url}/{$user_name}">{$user_name}</a>,
                    {$added_on}
                    <br />
                    <span class="glyphicon glyphicon-eye-open"></span> Views {$group_videos[i].video_view_number},
                    <span class="glyphicon glyphicon-comment"></span> Comments {$group_videos[i].video_com_num},
                    <span class="text-nowrap">
                        <span class="glyphicon glyphicon-thumbs-up"></span> {$group_videos[i].video_rated_by} Likes
                    </span>
                </p>
            </div>
            <div class="col-md-2">
                {if $smarty.session.UID eq $group_info.group_owner_id and $group_videos[i].group_video_approved eq "no"}
                    <form action="{$base_url}/group_videos.php?group_url={$group_info.group_url}&gid={$group_info.group_id}&page={$page}" method="post">
                        <input type="hidden" name="video_id" value="{$group_videos[i].video_id}" />
                        <button type="submit" class="btn btn-default btn-sm" name="approve_it">Approve it</button>
                    </form>
                {/if}

                {if $smarty.session.UID eq $group_info.group_owner_id}
                    <form action="{$base_url}/group_videos.php?group_url={$group_info.group_url}&gid={$group_info.group_id}&page={$page}" method="post" onsubmit="javascript: return confirm('Are you sure to delete this video from the group?');">
                        <input type="hidden" name="video_id" value="{$group_videos[i].video_id}" />
                        <button type="submit" class="btn btn-default btn-sm" name="remove_image">Remove from group</button>
                    </form>
                    {if $group_info.group_image eq "owner_only"}
                        <form action="{$base_url}/group/{$group_info.group_url}/videos/{$page}" method="post">
                            <input type="hidden" name="video_id" value="{$group_videos[i].video_id}" />
                            <button type="submit" class="btn btn-default btn-sm" name="group_image">Make default image</button>
                        </form>
                    {/if}
                {/if}
            </div>
            </div>
            <hr>
    {/section}

    {if $total gt $items_per_page}
        <div class="page_links">{$page_links}</div>
    {/if}

</div>
<div class="col-md-3">
    <a class="btn btn-default btn-block" href="{$base_url}/invite_members.php?urlkey={$group_info.group_url}">Share your videos</a>

    <div class="page-header">
        <h2>My Tags</h2>
    </div>
    <div class="list-group">
        {section name=jj loop=$view.group_video_keywords_array}
            <a class="list-group-item" href="{$base_url}/tag/{$view.group_video_keywords_array[jj]}/">{$view.group_video_keywords_array[jj]}</a>
        {/section}
    </div>
</div>

{else}

<div class="col-md-12">
    <h4>There is no video in this group</h4>
</div>

{/if}