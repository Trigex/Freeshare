{if $total gt "0"}
	<div class="col-md-9">
        <div class="page-header">
            <h1>
                My Friends Videos
                <small class="pull-right font-size-md btn">
                    Videos {$start_num}-{$end_num} of {$total}
                </small>
            </h1>
        </div>

        <div class="video-block video-block-list">
        {section name=i loop=$videoRows}
            <div class="row">
                {include file="videos_list_view.tpl" video_info=$videoRows[i]}
            </div>
            <hr>
		{/section}
        </div>

        {if $page_links ne ""}
            <div>{$page_links}</div>
        {/if}
	</div>

	<div class="col-md-3">
        <div class="page-header">
            <h2>My Tags</h2>
        </div>
        <div class="list-group">
            {section name=k loop=$view.video_keywords_array_all}
                <a class="list-group-item" href="{$base_url}/tag/{$view.video_keywords_array_all[k]}/">{$view.video_keywords_array_all[k]}</a>
            {/section}
        </div>
        {insert name=advertise adv_name='wide_skyscraper'}
	</div>
{else}
	<div class="alert alert-warning">
        <p><strong>You have not invited any friends or family at this time!</strong></p>
        <p><a href="{$base_url}/invite_friends.php">Invite</a> your friends and family to start sharing videos today!</p>
    </div>
{/if}