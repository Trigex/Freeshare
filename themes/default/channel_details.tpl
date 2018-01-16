<link rel="stylesheet" href="{$base_url}/css/offcanvas.css">
<script src="{$base_url}/js/offcanvas.js"></script>

<div class="col-xs-6 col-sm-4 col-md-3 sidebar-offcanvas">
    <div class="list-group">
        <a class="list-group-item disabled">
            <h4>Categories</h4>
        </a>
        {section name=i loop=$channels}
            <a class="list-group-item{if $channels[i].channel_id eq $channel.channel_id} active{/if}" href="{$base_url}/channel/{$channels[i].channel_id}/{$channels[i].channel_seo_name}/">
                {$channels[i].channel_name}
            </a>
        {/section}
    </div>
</div>
<div class="col-sm-8 col-md-9">
    <div class="page-header">
        <h1>
            <button data-toggle="offcanvas" class="btn btn-default btn-sm pull-left visible-xs" type="button" title="Categories">
                <span class="glyphicon glyphicon-menu-right"></span>
            </button>
            &nbsp;{$channel.channel_name}
        </h1>
    </div>

    {if $total gt "0"}

    <div class="page-header">
        <h2>Most active users</h2>
    </div>

    <div class="row">
        {section name=i loop=$most_active_users}
        {insert name=id_to_name assign=user_name un=$most_active_users[i].video_user_id}
        <div class="col-orient-ls-members col-sm-4 col-md-3">
            <div class="thumbnail members">
                <div class="preview">
                    <a href="{$base_url}/{$user_name}">
                        <img class="img-responsive" src="{insert name=member_img_url UID=$most_active_users[i].video_user_id}">
                    </a>
                </div>
                <div class="caption">
                    <h5>
                        <a href="{$base_url}/{$user_name}">{$user_name}</a>
                        <small>({$most_active_users[i].total})</small>
                    </h5>
                </div>
            </div>
        </div>
        {/section}
    </div>

    <div class="page-header">
        <h2>
            Recently added videos
            <small class="pull-right btn font-size-md">
                <a href="{$base_url}/channel/{$channel.channel_id}/{$channel.channel_seo_name}/recent/1">
                    More Videos
                </a>
            </small>
        </h2>
    </div>

    <div class="video-block">
        <div class="row">
            {section name=i loop=$recent_channel_videos}
                {include file="videos_grid_view.tpl" video_info=$recent_channel_videos[i]}
            {/section}
        </div>
    </div>

    <div class="page-header">
        <h2>
            Top watched videos
            <small class="pull-right btn font-size-md">
                <a href="{$base_url}/channel/{$channel.channel_id}/{$channel.channel_seo_name}/viewed/1">
                    More Videos
                </a>
            </small>
        </h2>
    </div>

    <div class="video-block">
        <div class="row">
            {section name=i loop=$mostview}
                {include file="videos_grid_view.tpl" video_info=$mostview[i]}
            {/section}
        </div>
    </div> <!-- section -->

    {else}
        <div class="alert alert-danger">There is no video in this channel</div>
    {/if}
</div>