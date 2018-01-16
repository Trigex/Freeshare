<div class="col-md-9">
    <div class="page-header">
        <h1>
            Favorites Videos of <strong>{$user_info.user_name}</strong>
            <span class="pull-right btn font-size-md">Videos {$start_num}-{$end_num} of {$total}</span>
        </h1>
    </div>
    <div class="video-block video-block-list">
        {section name=i loop=$favVideos}
            <div class="row">
                {include file="videos_list_view.tpl" video_info=$favVideos[i]}
                {if $smarty.session.USERNAME eq $user_info.user_name}
                    <div class="col-sm-4 col-md-3 pull-right text-right">
                        <form name="USERFAVOUR" method="post" action="">
                            <input type="hidden" name="rvid" value="{$favVideos[i].video_id}" />
                            <button type="submit" class="btn btn-danger btn-sm" name="removfavour">
                                <span class="glyphicon glyphicon-remove"></span> Remove
                            </button>
                        </form>
                    </div>
                {/if}
            </div>
            <hr>
        {sectionelse}
            <br>
            <center><h4>There are no videos found.</h4></center>
        {/section}
    </div>

    <div class="clearfix"></div>
    {if $page_links ne ""}<div>{$page_links}</div>{/if}
</div>

<div class="col-md-3">
    {if $total gt "0"}
        <div class="page-header">
            <h2>My Tags</h2>
        </div>
        <div class="list-group">
            {section name=k loop=$view.video_keywords_all_array}
                <a class="list-group-item" href="{$base_url}/tag/{$view.video_keywords_all_array[k]}/">{$view.video_keywords_all_array[k]}</a>
            {/section}
        </div>
    {/if}

    {insert name=advertise adv_name='wide_skyscraper'}
</div>