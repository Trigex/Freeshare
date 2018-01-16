<div class="col-md-9">
    <div class="panel panel-default hidden-xs hidden-sm">
        <div class="panel-body">
            <div class="watch-uplod-share clearfix">

                <div class="col-md-4 border-r clearfix">
                <div class="icon"><span class="glyphicon glyphicon-eye-open"></span></div>
                    <a href="{$base_url}/recent/"><h2>Watch</h2></a>
                   Better than TV watch what you want when you want it!

                </div>

                <div class="col-md-4 border-r clearfix">
                    <div class="icon"><span class="glyphicon glyphicon-upload"></span></div>
                    <a href="{$base_url}/upload/"><h2>Upload</h2></a>
                        Quickly upload and tag videos in almost any video format.
                </div>

                <div class="col-md-4">
                    <div class="icon"> <span class="glyphicon glyphicon-share"></span></div>
                    <a href="{$base_url}/friends/invite/"><h2>Share</span> </h2></a>
                      Easily share your videos with everyone,public or private.
                </div>

            </div>
        </div>
    </div>

    <div id="flash_recent_videos" class="hidden-xs hidden-sm"></div>

    <!-- new videos -->

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-film"></span> <strong>New Videos</strong> <span class="pull-right">
            <a href="{$base_url}/recent/"> <span class="glyphicon glyphicon-plus"></span> More</a></span></h3>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="video-block home-videos">
                {section name=i loop=$view.new_videos}
                    <div class="col-orient-ls col-sm-6 col-md-4">
                        <div class="thumbnail">
                            <div class="preview">
                                <a href="{$base_url}/view/{$view.new_videos[i].video_id}/{$view.new_videos[i].video_seo_name}/">
                                    <img class="img-responsive" width="100%" height="130" src="{$view.new_videos[i].video_thumb_url}/thumb/{$view.new_videos[i].video_folder}1_{$view.new_videos[i].video_id}.jpg" alt="{$view.new_videos[i].video_title}" />
                                </a>
                                <span class="badge video-time">{$view.new_videos[i].video_length}</span>
                                <span class="btn btn-default btn-xs video-queue" id="queue_{$view.new_videos[i].video_id}" data-id="{$view.new_videos[i].video_id}" rel="video_queue">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </span>
                            </div>
                            <div class="caption">
                                <h5 class="video-title">
                                    <a href="{$base_url}/view/{$view.new_videos[i].video_id}/{$view.new_videos[i].video_seo_name}/">{$view.new_videos[i].video_title}</a>
                                </h5>
                                <p class="text-muted small">
                                    {insert name=time_range assign=added_on time=$view.new_videos[i].video_add_time}
                                    {$view.new_videos[i].video_view_number} views, {$added_on}
                                </p>
                            </div>
                        </div>
                    </div>
                {sectionelse}
                    <br>
                    <center><h4>There are no videos found.</h4></center>
                {/section}
                </div>
            </div>
       </div>
    </div>

    <!-- popular videos -->

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <span class="glyphicon glyphicon-film"></span> <strong>Popular videos</strong> <span class="pull-right">
                <a href="{$base_url}/rated/"> <span class="glyphicon glyphicon-plus"></span> More</a></span>
            </h3>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="video-block home-videos">
                {section name=i loop=$view.recent_videos}
                    <div class="col-orient-ls col-sm-6 col-md-4">
                        <div class="thumbnail">
                            <div class="preview">
                                <a href="{$base_url}/view/{$view.recent_videos[i].video_id}/{$view.recent_videos[i].video_seo_name}/">
                                    <img class="img-responsive" width="100%" height="130" src="{$view.recent_videos[i].video_thumb_url}/thumb/{$view.recent_videos[i].video_folder}1_{$view.recent_videos[i].video_id}.jpg" alt="{$view.recent_videos[i].video_title}">
                                </a>
                                <span class="badge video-time">{$view.recent_videos[i].video_length}</span>
                                <span class="btn btn-default btn-xs video-queue" id="queue_{$view.recent_videos[i].video_id}" data-id="{$view.recent_videos[i].video_id}" rel="video_queue">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </span>
                            </div>
                            <div class="caption">
                                <h5 class="video-title">
                                    <a href="{$base_url}/view/{$view.recent_videos[i].video_id}/{$view.recent_videos[i].video_seo_name}/">{$view.recent_videos[i].video_title}</a>
                                </h5>
                                <p class="text-muted small">
                                    {insert name=time_range assign=added_on time=$view.recent_videos[i].video_view_time}
                                    {$view.recent_videos[i].video_view_number} views, {$added_on}
                                </p>
                            </div>
                        </div>
                    </div>
                {sectionelse}
                    <br>
                    <center><h4>There are no videos found.</h4></center>
                {/section}
                </div>
            </div>
        </div>
    </div>

    <!-- featured videos -->

    {$view.featured_video_block}


</div> <!--  content -->

<div class="col-md-3">

    <div align="center">
        {insert name=advertise adv_name='home_right_box'}
    </div>

    {if $home_num_tags gt 0}
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-tag"></span> <b> Recent Tags</b></h3>
        </div>
        <div class="panel-body">
            <p>{$view.home_tags}</p>
            <p><a class="text-muted pull-right" href="{$base_url}/tags/"><b>See More Tags</b></a></p>
        </div>
    </div>
    {/if}

    {if $num_last_users_online ne 0}
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-user"></span> <b> Last {$num_last_users_online} Users Online</b></h3>
        </div>
        <div class="panel-body">
            <span class="text-nowrap">
                <span class="glyphicon glyphicon-facetime-video"></span> Videos
            </span> |
            <span class="text-nowrap">
                <span class="glyphicon glyphicon-heart"></span> Favorites
            </span> |
            <span class="text-nowrap">
                <span class="glyphicon glyphicon-user"></span> Friends
            </span>
        </div>

        <ul class="list-group">
            {insert name=recently_active_users assign=recently_active_users}
            {section name=i loop=$recently_active_users}
                {insert name=id_to_name assign=uname un=$recently_active_users[i].user_login_user_id}
                {insert name=video_count assign=vdocount uid=$recently_active_users[i].user_login_user_id}
                {insert name=favour_count assign=favcount uid=$recently_active_users[i].user_login_user_id}
                {insert name=friends_count assign=friends uid=$recently_active_users[i].user_login_user_id}

                <li class="list-group-item">
                    <a href="{$base_url}/{$uname}"><b>{$uname}</b></a>
                    <small class="pull-right">
                        <span class="glyphicon glyphicon-facetime-video"></span>
                        <a href="{$base_url}/{$uname}/public/">({$vdocount})</a>
                        <span class="glyphicon glyphicon-heart"></span>
                        <a href="{$base_url}/{$uname}/favorites/">({$favcount})</a>
                        <span class="glyphicon glyphicon-user"></span>
                        <a href="{$base_url}/{$uname}/friends/">({$friends})</a>
                    </small>
                </li>
            {/section}
        </ul>
    </div>
    {/if}


    {if $show_stats ne "0"}
    {insert name="show_stats" assign="stats"}
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-stats"></span> <b> Site Statistics</b></h3>
        </div>
        <ul class="list-group">
            <li class="list-group-item">Number of Videos: <span class="badge">{$stats.total_video}</span></li>
            <li class="list-group-item">Public Videos:<span class="badge">{$stats.total_public_video}</span></li>
            <li class="list-group-item">Private Videos:<span class="badge">{$stats.total_private_video}</span></li>
            <li class="list-group-item">Number of Users:<span class="badge">{$stats.total_users}</span></li>
            <li class="list-group-item">Number of Channels:<span class="badge">{$stats.total_channel}</span></li>
            <li class="list-group-item">Number of Groups:<span class="badge">{$stats.total_groups}</span></li>
        </ul>
    </div>
    {/if}

    <!-- poll start -->

    {if $pollinganel ne 'Disable' AND $poll_question ne ""}
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <span class="glyphicon glyphicon-comment"></span> <b> Vote Here</b>
            </h3>
        </div>
        <div class="panel-body">
            <div id="poll_body"> <!-- poll start -->
                <div id="poll">
                    <p><strong>{$poll_question}</strong></p>
                    <div id="poll_answers">
                        {section name=i loop=$list}
                            <label>
                                <input type="radio" name="xx" onclick="poll_vote_for('{$list[i]}','user_answer')" />
                                <span> {$list[i]}</span>
                            </label>
                            <br>
                        {/section}
                        <input type="hidden" id="user_answer" value="" />
                        <button type="submit" class="btn btn-default" onclick="poll_vote({$poll_id})"><strong>Cast This</strong></button>
                    </div>

                    {if $list ne ""}
                        <br>
                        <div id="poll_view">
                            <a href="javascript:void(0)" onclick="poll_view({$poll_id})">
                                <strong>View current status</strong>
                            </a>
                        </div>
                    {/if}
                </div> <!-- poll -->

                <div id="poll_loading"></div>
                <div id="poll_result"></div>
            </div>  <!--  poll body -->
        </div>
    </div>
    {/if}

</div> <!-- sidebar -->