<div class="col-md-9">
    <div class="page-header">
        <h1>
            Group Posts
            <a href="{$base_url}/group/{$group_url}/">
                {$group_info.group_name}
            </a>
        </h1>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="thumbnail">
                {if $topic.group_topic_video_id eq 0}
                    <img class="img-responsive" src="{$img_css_url}/images/no_videos_groups.gif" alt="">
                {else}
                    {insert name=getfield assign=seo_name field='video_seo_name' table='videos' qfield='video_id' qvalue=$topic.group_topic_video_id}
                    <a href="{$base_url}/view/{$topic.group_topic_video_id}/{$seo_name}/">
                        <img class="img-responsive" src="{$topic.video_thumb_url}/thumb/{$topic.video_folder}1_{$topic.group_topic_video_id}.jpg" alt="">
                    </a>
                {/if}
            </div>
        </div>
        <div class="col-md-9">
            <p>
                <b>Topic:</b> {$topic.group_topic_title}
                <br />
                {$topic.group_topic_add_time|date_format:"%A, %B %e, %Y, %H:%M %p"}
            </p>
            <p>
                {insert name=id_to_name assign=user_name un=$topic.group_topic_user_id}
                <b>Author:</b> <a href="{$base_url}/{$user_name}">{$user_name}</a>
            </p>
        </div>
    </div>

    {section name=i loop=$post}
        <div class="row">
            <div class="col-md-3">
                <div class="thumbnail">
                    {if $post[i].group_topic_post_video_id ne "0"}
                        {insert name=getfield assign=title field='video_seo_name' table='videos' qfield='video_id' qvalue=$post[i].group_topic_post_video_id}
                        <a href="{$base_url}/view/{$post[i].group_topic_post_video_id}/{$title}/">
                            <img class="img-responsive"  src="{$post[i].video_thumb_url}/thumb/{$post[i].video_folder}1_{$post[i].group_topic_post_video_id}.jpg" alt="">
                        </a>
                    {else}
                        <img class="img-responsive" src="{$img_css_url}/images/no_videos_groups.gif" alt="">
                    {/if}
                </div>
            </div>
           <div class="col-md-9">
                <p>{$post[i].group_topic_post_description}</p>
                <p>
                    {insert name=id_to_name assign=user_name un=$post[i].group_topic_post_user_id}
                    Posted by: <a href="{$base_url}/{$user_name}">{$user_name}</a>
                    On: {$post[i].group_topic_post_date|date_format:"%A, %B %e, %Y, %H:%M %p"}
                </p>
            </div>
            <hr>
        </div>   <!-- video-entry end -->
    {/section}

    {if $smarty.session.UID ne ""}
        {insert name=check_group_mem assign=checkmem gid=$group_info.group_id}
        {if $checkmem ne "0"}
            <div>Add New Comment:</div>
            <div>
                <form name="add_group_post" action="{$base_url}/group/{$group_url}/topic/{$group_topic_id}" method="post" class="form-horizontal">
                    <textarea name="topic_title" rows="4" class="form-control"></textarea>
                    <br>Attach a video:
                    <select name="topic_video" class="form-control">
                        {$video_ops}
                    </select>
                    <button type="submit" class="btn btn-default btn-lg" name="add_topic">Add Comment</button>
                </form>
            </div>
        {else}
            <div>
                <form name="Joingroup" id="Joingroup" method="GET" action="{$base_url}/group_join.php" class="form-horizontal">
                    <input type="hidden" name="action" value="join">
                    <input type="hidden" name="group_id" value="{$group_info.group_id}">
                    <button type="submit" name="submit" class="btn btn-default btn-lg">Join this group to post comment</button>
                </form>
            </div>
        {/if}
    {else}
       <div class="text-center">
          Please <a href="{$base_url}/login/">Login</a> to post your comment
       </div>
    {/if}
</div>

<div class="col-md-3">
   {insert name=advertise adv_name='wide_skyscraper'}
</div>