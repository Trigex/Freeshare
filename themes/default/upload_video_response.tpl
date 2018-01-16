<div class="col-md-12">
    <div class="page-header">
        <h1>You are posting a video response to:</h1>
    </div>

    <div class="col-orient-ls-members col-sm-3 col-md-3">
        <div class="thumbnail">
            <div class="preview">
                <a href="{$base_url}/view/{$video_info.video_id}/{$video_info.video_seo_name}/">
                    <img class="img-responsive" src="{$video_info.video_thumb_url}/thumb/{$video_info.video_folder}1_{$video_info.video_id}.jpg">
                </a>
                <div class="badge video-time">{$video_info.video_length}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-7">
        <h5>
            <a href="{$base_url}/view/{$video_info.video_id}/{$video_info.video_seo_name}/">
                {$video_info.video_title}
            </a>
        </h5>
        <p class="text-muted small">{$video_info.video_description|truncate:160}</p>
        <p class="text-muted small">Added on  {$video_info.video_add_date|date_format}</p>
        <p class="text-muted small">
            Views: {$video_info.video_view_number} |
            Comments: {$video_info.video_com_num} |
            Likes: {$video_info.video_rated_by}
        </p>
    </div>
    <div class="col-sm-3 col-md-2 pull-right">
        <div class="thumbnail members">
            {insert name=id_to_name assign=uname un=$video_info.video_user_id}
            <a href="{$base_url}/{$uname}">
                <img class="img-responsive" src="{insert name=member_img_url UID=$video_info.video_user_id}">
            </a>
            <div class="caption">
                <h5>From: <a href="{$base_url}/{$uname}">{$uname}</a></h5>
                {insert name=video_count assign=vdo_count type=public uid=$video_info.video_user_id}
                <p class="text-muted small">Videos: {$vdo_count}</p>
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<hr />


{if $video_response_added eq '0'}
<div class="col-md-5">
    <h3>
        Choose one of your existing videos as a response
        <br>
        <small>* Indicates the video has already been used for another video response. Selecting a video marked as already having been used will remove the old link.</small>
    </h3>
</div>
<div class="col-md-7">
    {if $user_videos|@count gt '0'}
        <form method="post" action="" class="form-horizontal" role="form">
            <input type="hidden" name="video_response_to_video_id" value="{$video_info.video_id}">
            <div class="form-group">
                <select name="video_response_video_id" multiple="multiple" size="10" class="form-control">
                    {section name=i loop=$user_videos}
                        <option value="{$user_videos[i].video_id}">
                            {if $user_videos[i].video_already_response eq '1'}*{/if}
                            {$user_videos[i].video_title}
                        </option>
                    {/section}
                </select>
            </div>
            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-default btn-lg">Use the selected video</button>
            </div>
       </form>
    {else}
        <p class="alert alert-warning">There is no video found.</p>
    {/if}
</div>

{else}
    <div class="alert alert-success">
        <h3>
            You have successfully completed your Video Response!
            <br>
            <small>Your video response will be posted after it has been approved by the video owner.</small>
        </h3>
    </div>
{/if}