<link rel="stylesheet" href="{$base_url}/css/offcanvas.css">
<script src="{$base_url}/js/offcanvas.js"></script>

<div class="col-xs-6 col-sm-4 col-md-3 sidebar-offcanvas">
    <div class="list-group">
        <span class="list-group-item disabled">
            <h4>Categories</h4>
        </span>
        {section name=i loop=$view.channels}
            <a class="list-group-item{if $view.channels[i].channel_id eq $smarty.get.chid} active{/if}" href="{$base_url}/channel/{$view.channels[i].channel_id}/{$view.category}/{$view.view_type}/1">
                {$view.channels[i].channel_name}
            </a>
        {/section}
    </div>
</div>

<div class="col-sm-8 col-md-9">
    <div class="page-header row">
        <div class="col-md-9">
            <h2>
                <button data-toggle="offcanvas" class="btn btn-default btn-sm pull-left visible-xs" type="button" title="Categories">
                    <span class="glyphicon glyphicon-menu-right"></span>
                </button>
                {$view.display_order}
                {if $channel_name ne ''}
                {$channel_name} videos
                {/if}
            </h2>
        </div>
        <div class="col-md-3 text-right">
            <br>
            <div class="btn-group btn-group-sm">
                {if $channel_name ne ""}
                    <a class="btn btn-default{if $view.view_type eq 'basic'} disabled{/if}" href="{$base_url}/{if $channel_name ne ''}channel/{$smarty.get.chid}/{/if}{$view.category}/basic/{$view.page}" title="Grid view">
                        <span class="glyphicon glyphicon-th-large"></span>
                    </a>
                    <a class="btn btn-default{if $view.view_type eq 'detailed'} disabled{/if}" href="{$base_url}/{if $channel_name ne ''}channel/{$smarty.get.chid}/{/if}{$view.category}/detailed/{$view.page}" title="List view">
                        <span class="glyphicon glyphicon-th-list"></span>
                    </a>
                {else}
                    <a class="btn btn-default{if $view.view_type eq 'basic'} disabled{/if}" href="{$base_url}/{$view.category}/{$view.page}" title="Grid view">
                        <span class="glyphicon glyphicon-th-large"></span>
                    </a>
                    <a class="btn btn-default{if $view.view_type eq 'detailed'} disabled{/if}" href="{$base_url}/detailed/{$view.category}/{$view.page}" title="List view">
                        <span class="glyphicon glyphicon-th-list"></span>
                    </a>
                {/if}
            </div>
            <small class="text-muted">&nbsp; Videos {$view.start_num}-{$view.end_num} of {$view.total}</small>
        </div>
    </div>

    {if $smarty.request.view_type eq "" or $smarty.request.view_type eq "basic"}
    <div class="video-block">
        <div class="row">
            {section name=i loop=$view.videos}
                {include file="videos_grid_view.tpl" video_info=$view.videos[i]}
            {sectionelse}
                <br>
                <center><h4>There are no videos found.</h4></center>
            {/section}
        </div>
    </div>
    {else}
    <div class="video-block video-block-list">
        {section name=i loop=$view.videos}
            <div class="row">
                {include file="videos_list_view.tpl" video_info=$view.videos[i]}
            </div>
             <hr>
        {sectionelse}
            <br>
            <center><h4>There are no videos found.</h4></center>
        {/section}
    </div>
    {/if}

    {if $view.page_links ne ""}
    <div class="page_links">{$view.page_links}</div>
    {/if}
</div>