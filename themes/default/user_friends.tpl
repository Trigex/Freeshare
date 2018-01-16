<div class="col-md-9">
{if $total gt "0"}
    <div class="page-header">
        <h1>
            Friends of <strong>{$user_info.user_name}</strong>
            <small class="pull-right btn font-size-md">Friends {$start_num}-{$end_num} of {$total}</small>
        </h1>
    </div>
    <div class="row">
        {section name=i loop=$friends}
            <div class="col-orient-ls-members col-xs-6 col-sm-4 col-md-3">
                <div class="thumbnail members">
                    <div class="preview">
                        <a href="{$base_url}/{$friends[i].friend_name}">
                            <img class="img-responsive" src="{insert name=member_img_url UID=$friends[i].friend_friend_id}">
                        </a>
                    </div>
                    <div class="caption">
                        <h5>
                        {if $friends[i].friend_status eq "Confirmed"}
                            <a href="{$base_url}/{$friends[i].friend_name}">{$friends[i].friend_name}</a>
                        {else}
                            {$friends[i].friend_name}
                        {/if}
                        </h5>

                        {if $friends[i].friend_status eq "Confirmed"}
                            {insert name=video_count assign=video uid=$friends[i].friend_friend_id}
                            {insert name=favour_count assign=favour uid=$friends[i].friend_friend_id}
                            {insert name=friends_count assign=frnd uid=$friends[i].friend_friend_id}</li>
                            <p class="text-muted small text-nowrap">
                                Videos:
                                {if $video ne "0" and $video ne ""} <a href="{$base_url}/{$friends[i].friend_name}/public/">{$video}</a>
                                {else} 0
                                {/if}
                                | Favorites:
                                {if $favour ne "0"} <a href="{$base_url}/{$friends[i].friend_name}/favorites/">{$favour}</a>
                                {else} 0
                                {/if}
                                | Friends:
                                {if $frnd ne "0"} <a href="{$base_url}/{$friends[i].friend_name}/friends/">{$frnd}</a>
                                {else} 0
                                {/if}
                            </p>
                        {/if}

                        {insert name=showlist assign=showlist id=$friends[i].friend_id}
                        <p class="text-muted small text-nowrap">Lists: {$showlist}</p>
                        <p class="text-muted small text-nowrap">
                            Status: {$friends[i].friend_status}
                            {if $friends[i].friend_status eq "Pending"}
                            ({$friends[i].friend_invite_date|date_format:"%B %e, %Y"})
                            {/if}
                        </p>
                    </div>
                </div>
        	</div>
        {/section}
    </div>

	{if $page_links ne ""}
		<div>{$page_links}</div>
	{/if}

{else}

<div class="col-md-12">
    <div class="alert alert-danger">There is no friends found</div>
</div>

{/if}
</div>

<div class="col-md-3">
   {insert name=advertise adv_name='wide_skyscraper'}
</div>