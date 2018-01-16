<div class="col-md-9">
<div class="page-header">
    <h1>
        Videos with tag <strong>{$search_string}</strong>
        <small class="pull-right font-size-md btn">Results {$start_num} - {$end_num} of {$total}</small>
        <div class="btn-group col-md-offset-1">
            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                Sort by <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="{$base_url}/tag/{$smarty.get.search_string}/?sort=adddate">Date added</a></li>
                <li><a href="{$base_url}/tag/{$smarty.get.search_string}/?sort=viewnum">View count</a></li>
                <li><a href="{$base_url}/tag/{$smarty.get.search_string}/?sort=rate">Rating</a></li>
            </ul>
        </div>
    </h1>
</div>

    <div class="video-block clearfix">
        {section name=i loop=$video_info}
        {include file="videos_grid_view.tpl" video_info=$video_info[i]}
        {sectionelse}
        <br>
        <center><h4>There are no videos found.</h4></center>
        {/section}
    </div>

{if $page_links ne ""}
    <div class="page_links">{$page_links}</div>
{/if}
</div>

<div class="col-md-3">
    {insert name=advertise adv_name='wide_skyscraper'}
</div>