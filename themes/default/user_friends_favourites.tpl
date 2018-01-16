{if $total gt "0"}
    <div class="col-md-9">
        <div class="page-header">
            <h1>
                My Friend's Favorites
                <small class="pull-right font-size-md btn">
                    Videos {$start_num}-{$end_num} of {$total}
                </small>
            </h1>
        </div>

        <div class="video-block video-block-list">
    	{section name=i loop=$answers}
            <div class="row">
                {include file="videos_list_view.tpl" video_info=$answers[i]}
            </div>
            <hr>
    	{/section}
        </div>

    	{if $page_links ne ""}
    		<div>{$page_links}</div>
    	{/if}
    </div>

    <div class="col-md-3">
        {insert name=advertise adv_name='wide_skyscraper'}
    </div>
{else}
    <div class="alert alert-warning">
        <p><strong>You have not invited any friends or family at this time!</strong></p>
        <p><a href="{$base_url}/invite_friends.php">Invite</a> your friends and family to start sharing videos today!</p>
    </div>
{/if}