<br>
<div {if $video_count gt '5'}style="height: 432px;overflow: auto;"{/if}>
    {section name=i loop=$user_videos}
        <div class="media">
            <div class="media-left">
                <div class="preview">
                    <a href="{$base_url}/view/{$user_videos[i].video_id}/{$user_videos[i].video_seo_name}/">
                        <img class="media-object" width="130" src="{$user_videos[i].video_thumb_url}/thumb/{$user_videos[i].video_folder}1_{$user_videos[i].video_id}.jpg" alt="{$user_videos[i].video_title}">
                    </a>
                    <span class="badge video-time">{$user_videos[i].video_length}</span>
                </div>
            </div>
            <div class="media-body">
                <h5 class="media-heading text-nowrap">
                    <a href="{$base_url}/view/{$user_videos[i].video_id}/{$user_videos[i].video_seo_name}/" target="_parent">
                        <strong>{$user_videos[i].video_title}</strong>
                    </a>
                </h5>
                <span class="text-muted small">
                    <span class="text-nowrap">
                        <span class="glyphicon glyphicon-eye-open"></span> Views: <strong>{$user_videos[i].video_view_number}</strong>
                    </span>
                    <br>
                    <span class="text-nowrap">
                        <span class="glyphicon glyphicon-comment"></span> Comments: <strong>{$user_videos[i].video_com_num}</strong>
                    </span>
                </span>
                {if $smarty.request.video_id eq $user_videos[i].video_id}
                <div class="clearfix"></div>
                <p class="label label-warning">
                    <span class="glyphicon glyphicon-play"></span> NOW PLAYING!
                </p>
                {/if}
            </div>
        </div>
        <hr>
    {/section}

    {if $video_count gt '20'}
    <div class="text-center">
        <h3><a class="label label-info" href="{$base_url}/{$user_name}/public/1">See all {$video_count} videos</a></h3>
    </div>
    <hr>
    {/if}
</div>