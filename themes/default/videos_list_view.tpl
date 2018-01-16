<div class="col-orient-ls col-sm-6 col-md-4">
    <div class="thumbnail">
        <div class="preview">
            <a href="{$base_url}/view/{$video_info.video_id}/{$video_info.video_seo_name}/">
                <img class="img-responsive" width="100%" height="130" src="{$video_info.video_thumb_url}/thumb/{$video_info.video_folder}1_{$video_info.video_id}.jpg" alt="{$video_info.video_title}">
            </a>
            <span class="badge video-time">{$video_info.video_length}</span>
        </div>
    </div>
</div>
<div class="col-orient-ls col-sm-6 col-md-8">
    <h4 class="video-title">
        <a href="{$base_url}/view/{$video_info.video_id}/{$video_info.video_seo_name}/">{$video_info.video_title}</a>
    </h4>
    <p class="text-muted small">
        {if !isset($hide_owner_info)}
            {insert name=id_to_name assign=user_name un=$video_info.video_user_id}
            by <a href="{$base_url}/{$user_name}">{$user_name}</a>
            <br>
        {/if}
       {$video_info.video_view_number} views,
       {insert name=time_range assign=added_on time=$video_info.video_add_time}
       {$added_on}
   </p>
   <p class="text-muted small">
       {$video_info.video_description|truncate: 200:"...":true}
       </p>
</div>
