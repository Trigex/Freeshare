<div class="col-md-12">
	<div class="alert alert-warning">
        <span class="glyphicon glyphicon-warning-sign"></span> {$msg_404}
    </div>

	<ul class="list-inline text-center">
        <li><a href="{$base_url}/featured/">Featured Videos</a></li>
        <li><a href="{$base_url}/rated/">Top Rated Videos</a></li>
        <li><a href="{$base_url}/viewed/">Most Watched Videos</a></li>
	</ul>

    <div class="page-header">
        <h1>Featured Videos</h1>
    </div>
    <div class="row">
        {section name=i loop=$video_info}
	        <div class="col-orient-ls col-sm-4 col-md-3">
                <div class="thumbnail">
                    <div class="preview">
                        <a href="{$base_url}/view/{$video_info[i].video_id}/{$video_info[i].video_seo_name}/">
                            <img class="img-responsive" width="100%" height="130" src="{$video_info[i].video_thumb_url}/thumb/{$video_info[i].video_folder}1_{$video_info[i].video_id}.jpg" alt="{$video_info[i].video_title}" />
                        </a>
                        <span class="badge video-time">{$video_info[i].video_length}</span>
                    </div>
                    <div class="caption">
                        <h5 class="video_title">
                            <a href="{$base_url}/view/{$video_info[i].video_id}/{$video_info[i].video_seo_name}/">{$video_info[i].video_title|truncate:30}</a>
                        </h5>
                        <p class="text-muted small">
                            {insert name=id_to_name assign=uname un=$video_info[i].video_user_id}
                            <span class="glyphicon glyphicon-user"></span>
                            <a href="{$base_url}/{$uname}" target="_parent">{$uname}</a>
                            <span class="text-nowrap">on {$video_info[i].video_add_time|date_format}</span>
                        </p>
                        <p class="text-muted small">
                            <span class="glyphicon glyphicon-eye-open"></span> {$video_info[i].video_view_number} views,
                            &nbsp;
                            {insert name=comment_count assign=commentcount vid=$video_info[i].video_id}
                            <span class="glyphicon glyphicon-comment"></span> Comments {$commentcount}
                        </p>
                        <p class="text-muted small">
                            <span class="text-nowrap">
                                <span class="glyphicon glyphicon-star"></span>
                                {if $video_info[i].video_rated_by gt "0"}
                                    {insert name=show_rate assign=rate rte=$video_info[i].video_rate rated=$video_info[i].video_rated_by}
                                    {$rate}
                                {else}
                                    Not yet rated
                                {/if}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        {/section}
    </div>
</div>