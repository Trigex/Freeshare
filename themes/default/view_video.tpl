<div class="col-md-8">
    {insert name=advertise adv_name='player_top'}
    <div class="embed-responsive embed-responsive-16by9" style="z-index: 0;">{$view.VSHARE_PLAYER}</div>
    <p class="clearfix"></p>
    {insert name=advertise adv_name='player_bottom'}

    {if $episode_enable eq '1'}
    <div>{include file="view_video_episodes.tpl"}</div>
    {/if}

    <div class="panel panel-default">
        <div class="panel-body">
            <h1 class="view-video-title">{$view.video_info.video_title}</h1>
            {if $view.owner_video_info ne ''}
                <p class="label label-info">This video is a response to <a href="{$base_url}/view/{$view.owner_video_info.video_id}/{$view.owner_video_info.video_seo_name}/">{$view.owner_video_info.video_title}</a></p>
                <div class="clearfix">&nbsp;</div>
            {/if}

            <div>
                <div class="col-md-2 col-sm-3 col-xs-4">
                    <div class="row">
                        <a class="btn padding-no" data-toggle="popover">
                            <img src="{insert name=member_img_url assign=url UID=$view.video_info.video_user_id type=1}" width="50">
                            {$view.user_info.user_name}
                        </a>
                    </div>
                </div>
                <div class="col-md-10 col-sm-9 col-xs-8">
                    <div class="watch-view-count text-right">
                        {$view.video_info.video_view_number} Views

                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="progress watch-view-progress">
                    <div style="width: {$view.video_info.video_view_number/20}%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="{$view.video_info.video_view_number}" role="progressbar" class="progress-bar progress-bar-info pull-right"></div>
                </div>
            </div>
            <div class="clearfix">&nbsp;</div>

            <div class="btn-toolbar" role="toolbar">
                <div class="btn-group">
                    <div class="btn-group dropdown-pl">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-plus"></span> Add to <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pl-lists" role="menu" aria-labelledby="playlist-form-btn">
                        </ul>
                    </div>
                        <a class="btn btn-default btn-video-share" href="javascript:void(0);">
                            <span class="glyphicon glyphicon-share"></span> Share
                        </a>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="glyphicon glyphicon-option-horizontal"></span> More <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="javascript:void(0);" onclick="feature();">
                                        <span class="glyphicon glyphicon-star"></span> Feature this
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" onclick="inappropriate();">
                                        <span class="glyphicon glyphicon-flag"></span> Report
                                    </a>
                                </li>
                                {if $allow_download == 1}
                                    {if $view.video_info.video_vtype eq 0 && $view.package_allow_video_download eq '1'}
                                        <li>
                                            <a href="{$base_url}/download/{$view.video_info.video_id}/">
                                                <span class="glyphicon glyphicon-download"></span> Download
                                            </a>
                                        </li>
                                    {/if}
                                {/if}
                                {if $smarty.session.UID eq $view.video_info.video_user_id}
                                    <li>
                                        <a href="{$base_url}/edit/video/{$view.video_info.video_id}">
                                            <span class="glyphicon glyphicon-edit"></span> Edit
                                        </a>
                                    </li>
                                {/if}
                            </ul>
                        </div>
                    </div>
                <div class="btn-group" role="group">
                    {insert name=video_like assign=like id=$view.video_info.video_id}{$like}
                </div>
            </div>
            <div class="clearfix">&nbsp;</div>
            <div id="video-tools-result" class="alert" role="alert" style="display: none;"></div>

            <!-- video feedback end -->

            <div id="video-tools-feedback" style="display: none;">
                {include file="view_video_flag.tpl"}
            </div> <!-- video-tools-feedback -->

            <!-- Video share tools -->

            <div id="video-tools-share" style="display: none;">
                {include file="view_video_share.tpl"}
            </div>
        </div>
    </div>

    <div class="hidden" id="user-details-container">
        {include file="view_video_user_details.tpl"}
    </div>
    <script>
    $(function () {
        $('[data-toggle="popover"]').popover({
            placement: 'right',
            trigger: 'click',
            html: 'true',
            content: $("#user-details-container").html()
        });
        $(".btn-video-share").click(function(){
            $("#video-tools-share").slideToggle('fast');
        });
    });
    </script>

    <div class="panel panel-default details-collapse">
        <div class="panel-body">
            <p><strong><span class="glyphicon glyphicon-upload"></span>Added on {$view.video_info.video_add_date|date_format}</strong></p>
            <p>
                <span class="glyphicon glyphicon-time"></span> Length:<strong> {$view.video_info.video_length}</strong> |
                <span class="glyphicon glyphicon-comment"></span> Comments: <strong>{$view.video_info.video_com_num}</strong>
            </p>
            <p class="text-justify view-video-desc">{$view.video_info.video_description}</p>
            <p>
                <span class="glyphicon glyphicon-film"></span> Channels:
                {insert name=video_channel assign=channel vid=$view.video_info.video_id}
                {section name=k loop=$channel}
                    <a href="{$base_url}/channel/{$channel[k].channel_id}/{$channel[k].channel_seo_name}/">{$channel[k].channel_name}</a> &nbsp;
                {/section}
            </p>
            <p>
                <span class="glyphicon glyphicon-tags"></span> Tags:
                {section name=j loop=$view.tags}
                    <a href="{$base_url}/tag/{$view.tags[j]}/">{$view.tags[j]}</a>&nbsp;
                {/section}
            </p>
            <div class="btn-collapse-expand text-center">
                <div class="label label-default">SHOW MORE <span class="glyphicon glyphicon-menu-down"></span></div>
                <div class="label label-default hidden">SHOW LESS <span class="glyphicon glyphicon-menu-up"></span></div>
            </div>
        </div>
    </div>
    <script>
    $(".btn-collapse-expand").on("click", function(){
        $(".details-collapse").toggleClass("details-expand");
        $(".btn-collapse-expand div").toggleClass("hidden");
    });
    </script>

    <div class="panel panel-default">
        <div class="panel-body">
            {insert name=video_response_count video_id=$view.video_info.video_id assign=response_count}
            <h2>
                Video Responses (<a href="{$base_url}/response/{$view.video_info.video_id}/videos/1">{$response_count}</a>)
                <small class="pull-right font-size-md btn">
                    <a href="{$base_url}/video_response_upload/{$view.video_info.video_id}">Post Video Response</a>
                </small>
            </h2>

            <div class="row">
                {section name=i loop=$view.video_responses}
                    <div class="col-orient-ls col-md-4 col-sm-6">
                        <div class="thumbnail">
                            <div class="preview">
                                <a href="{$base_url}/view/{$view.video_responses[i].video_id}/{$view.video_responses[i].video_seo_name}/" title="{$view.video_responses[i].video_title}">
                                    <img class="img-responsive" width="100%" src="{$view.video_responses[i].video_thumb_url}/thumb/{$view.video_responses[i].video_folder}1_{$view.video_responses[i].video_id}.jpg" alt="{$view.video_responses[i].video_title}">
                                </a>
                                <div class="badge video-time">{$view.video_responses[i].video_length}</div>
                            </div>
                            <div class="caption">
                                <h5>
                                    <a href="{$base_url}/view/{$view.video_responses[i].video_id}/{$view.video_responses[i].video_seo_name}/">
                                        {$view.video_responses[i].video_title|truncate:20}
                                    </a>
                                </h5>
                                {insert name=id_to_name assign=uname un=$view.video_responses[i].video_user_id}
                                <p class="text-muted small">
                                    by <a href="{$base_url}/{$uname}">{$uname}</a> |
                                    {$view.video_responses[i].video_view_number} views
                                </p>
                            </div>
                        </div>
                    </div>
                {sectionelse}
                    <center><p>Be the first to post a video response!</p></center>
                {/section}
            </div>

            <h2>Comments: (<span>{$view.video_info.video_com_num}</span>)</h2>

            {if $view.video_info.video_allow_comment eq "yes"}
                <div id="comment_box">
                    <form name="add_comment" method="post" action="" role="form">
                        <div class="form-group">
                            <textarea name="user_comment" id="user_comment" rows="2" class="form-control" placeholder="Your comments"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="button" name="post" class="btn btn-default" onclick="video_post_comment({$view.video_info.video_id})">Post</button>
                        </div>
                    </form>
                </div>
            {/if}

            <div id="comment_post_result" class="alert alert-success" style="display: none;"></div>
            <div id="section_comment"></div>
        </div>
    </div>
</div>

<div class="col-md-4">
    <!-- <div class="clearfix">&nbsp;</div> -->

    <div class="section bg2">
        {insert name=advertise adv_name='video_right_single'}
    </div>
    <div class="clearfix"></div>

    <!-- user videos -->

    <button class="btn btn-default btn-block btn-lg" id="show-user-videos" data-loading-text="Loading...">
        More videos from <strong>{$view.user_info.user_name}</strong> <span class="caret"></span>
    </button>
    <div id="user-videos-block" data-user-id="{$view.video_info.video_user_id}" data-loaded="no" style="display: none;"></div>

    <!-- end user videos -->

    <div class="page-header">
        <h2>Related Videos</h2>
    </div>

    {section name=i loop=$view.related_videos}
    <div class="media">
        <div class="media-left">
            <div class="preview">
                <a href="{$base_url}/view/{$view.related_videos[i].video_id}/{$view.related_videos[i].video_seo_name}/">
                    <img class="media-object" width="130" src="{$view.related_videos[i].video_thumb_url}/thumb/{$view.related_videos[i].video_folder}1_{$view.related_videos[i].video_id}.jpg" alt="{$view.related_videos[i].video_title}">
                </a>
                <span class="badge video-time">{$view.related_videos[i].video_length}</span>
            </div>
        </div>
        <div class="media-body">
            <h5 class="media-heading text-nowrap">
                <a href="{$base_url}/view/{$view.related_videos[i].video_id}/{$view.related_videos[i].video_seo_name}/" target="_parent">
                    <strong>{$view.related_videos[i].video_title}</strong>
                </a>
            </h5>
            <span class="text-muted small">
                {insert name=id_to_name assign=uname un=$view.related_videos[i].video_user_id}
                <span class="text-nowrap">
                    <span class="glyphicon glyphicon-user"></span>
                    by <strong><a href="{$base_url}/{$uname}" target="_parent">{$uname}</a></strong>
                </span>
                <br>
                <span class="text-nowrap">
                    <span class="glyphicon glyphicon-eye-open"></span> Views: <strong>{$view.related_videos[i].video_view_number}</strong> |
                </span>
                <span class="text-nowrap">
                    <span class="glyphicon glyphicon-comment"></span> Comments: <strong>{$view.related_videos[i].video_com_num}</strong>
                </span>
            </span>
        </div>
    </div>
    <hr>
    {/section}

</div> <!-- video-sidebar -->
