<div class="col-md-12">
    <div class="col-md-3">
        <div class="thumbnail">
            <div class="preview">
                <a href="{$base_url}/view/{$video_info.video_id}/{$video_info.video_seo_name}/">
                    <img class="img-response" width="100%" src="{$video_info.video_thumb_url}/thumb/{$video_info.video_folder}1_{$video_info.video_id}.jpg">
                </a>
                <div class="badge video-time">{$video_info.video_length}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
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
            Rating: {insert name=show_rate assign=rate rte=$video_info.video_rate rated=$video_info.video_rated_by}{$rate}
        </p>
        <div>
            <center>
                <form action="" method="post">
                    <button type="submit" name="accept" class="btn btn-default btn-lg">Accept this video</button>
                    <button type="submit" name="reject" class="btn btn-danger btn-lg" onclick="return confirm('Are you sure you want to reject this request?');">Reject this video</button>
                </form>
            </center>
        </div>
    </div>
    <div class="col-md-3">
        <div class="thumbnail">
            {insert name=id_to_name assign=uname un=$video_info.video_user_id}
            <a href="{$base_url}/{$uname}">
                {insert name=member_img UID=$video_info.video_user_id}
            </a>
            <div class="caption">
                <h5>
                    From: <a href="{$base_url}/{$uname}">{$uname}</a>
                </h5>
                {insert name=video_count assign=vdo_count type=public uid=$video_info.video_user_id}
                <p class="text-muted small">Videos: {$vdo_count}</p>
            </div>
        </div>
    </div>
</div>