{if $total gt "0"}

<div class="col-md-9">
    <div class="page-header">
        <h1>
            Add Videos: {$group_info.group_name}
            <small class="pull-right btn font-size-md">
                Videos {$start_num}-{$end_num} of {$total}
            </small>
        </h1>
    </div>

    {section name=i loop=$videos}
        <div class="row">
            <div class="col-orient-ls col-sm-6 col-md-4">
                <div class="thumbnail">
                    <div class="preview">
                        <a href="{$base_url}/view/{$videos[i].video_id}/{$videos[i].video_seo_name}/">
                            <img class="img-responsive" width="100%" height="130" src="{$videos[i].video_thumb_url}/thumb/{$videos[i].video_folder}1_{$videos[i].video_id}.jpg" alt="">
                        </a>
                        <div class="badge video-time">{$videos[i].video_length}</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <h4>
                    <a href="{$base_url}/view/{$videos[i].video_id}/{$videos[i].video_seo_name}/">{$videos[i].video_title|truncate:40}</a>
                    <br>
                    <small>{$videos[i].video_description|truncate:100}</small>
                </h4>
                <p class="text-muted small">
                    {insert name=id_to_name assign=user_name un=$videos[i].video_user_id}
                    {insert name=time_range assign=added_on time=$videos[i].video_add_time}
                    <span class="glyphicon glyphicon-user"></span>
                    <a href="{$base_url}/{$user_name}">{$user_name}</a>,
                    {$added_on}
                    <br />
                    <span class="glyphicon glyphicon-eye-open"></span> Views {$videos[i].video_view_number},
                    <span class="glyphicon glyphicon-comment"></span> Comments {$videos[i].video_com_num},
                    <span class="text-nowrap">
                        <span class="glyphicon glyphicon-thumbs-up"></span> {$videos[i].video_rated_by} Likes
                    </span>
                </p>
            </div>
            <div class="col-md-2">
                {if $videos[i].in_group eq "0"}
                    <form name="addVideoForm" action="{$base_url}/group/{$group_info.group_url}/add/{$page}" method="post">
                        <input type="hidden" value="{$videos[i].video_id}" name="video_id" />
                        <button type="submit" class="btn btn-default" name="add_video">Add to group</button>
                    </form>
                {else}
                    <span class="btn btn-success"><b>Already in group</b></span>
                {/if}
            </div>
          </div>
        <hr>
    {/section}

    {if $page_links ne ""}
    <div>{$page_links}</div>
    {/if}
</div>

<div class="col-md-3">
    <div class="page-header">
        <h2>My Tags</h2>
    </div>
    <div class="list-group">
        {section name=i loop=$view.group_add_video_keywords_array}
            <a class="list-group-item" href="{$base_url}/tag/{$view.group_add_video_keywords_array[i]}/">{$view.group_add_video_keywords_array[i]}</a>
        {/section}
    </div>
</div>

{/if}