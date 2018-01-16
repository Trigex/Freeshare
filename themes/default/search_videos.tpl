{if $total gt "0"}
 <div class="col-md-9">
        <div class="page-header">
            <h1>
                Search for: <strong>{$search_string}</strong>
                <span class="pull-right btn font-size-md">
                    Results {$start_num}-{$end_num} of {$total}
                </span>
            </h1>
        </div>

            <div class="video-block">
                {section name=i loop=$video_info}
                {include file="videos_grid_view.tpl" video_info=$video_info[i]}
                {sectionelse}
                <br>
                <center><h4>There are no videos found.</h4></center>
                {/section}
            </div>

        {if $page_links ne ""}
            <div>{$page_links}</div>
        {/if}
    </div>
{/if}

<div class="col-md-3">
    {insert name=advertise adv_name='wide_skyscraper'}
</div>