{if $total gt "0"}
<div class="col-md-9">
	<div class="page-header">
        <h1>
            Members of Group
			<small class="pull-right btn font-size-md">
				Members {$start_num}-{$end_num} of {$total}
			</small>
        </h1>
    </div>

    <div class="row">
        {section name=i loop=$group_members}
    		{if $smarty.session.UID eq $group_info.group_owner_id or $group_members[i].group_member_approved eq "yes"}
                <div class="col-orient-ls-members col-xs-6 col-sm-4 col-md-3">
                    <div class="thumbnail members">
                        <div class="preview">
                            {insert name=id_to_name assign=uname un=$group_members[i].group_member_user_id}
                            <a href="{$base_url}/{$uname}">
                                <img class="img-responsive" src="{insert name=member_img_url UID=$group_members[i].group_member_user_id}">
                            </a>
                        </div>
                        <div class="caption">
                            <h5><a href="{$base_url}/{$uname}">{$uname}</a></h5>
                            <p class="small text-muted text-nowrap">member since: {$group_members[i].group_member_since|date_format}</p>
    						{insert name=video_count assign=video uid=$group_members[i].group_member_user_id}
    						{insert name=favour_count assign=favour uid=$group_members[i].group_member_user_id}
    						{insert name=friends_count assign=frnd uid=$group_members[i].group_member_user_id}
                            <p class="small text-muted text-nowrap">
                                Videos: {if $video ne "0" and $video ne ""}<a href="{$base_url}/{$uname}/public/">{$video}</a>{else}0{/if},
                                Favorites: {if $favour ne "0"}<a href="{$base_url}/{$uname}/favorites/">{$favour}</a>{else}0{/if}
                            </p>
                            <p class="small text-muted text-nowrap">
                                Friends: {if $frnd ne "0"}<a href="{$base_url}/{$uname}/friends/">{$frnd}</a>{else}0{/if}
    						</p>
    						<p>
    							{if $smarty.session.UID eq $group_info.group_owner_id and $group_members[i].group_member_approved eq "no"}
    								<form action="{$base_url}/group/{$group_info.group_url}/members/{$page}" method="post" >
    								<input type="hidden" name="AID" value="{$group_members[i].AID}" />
    								<input type="hidden" name="MID" value="{$group_members[i].group_member_user_id}" />
                                    <button type="submit" class="btn btn-default btn-xs" name="approve_mem">Approve {$uname}</button>
    								</form>
    							{/if}

    							{if $smarty.session.UID eq $group_info.group_owner_id and $group_info.group_owner_id ne $group_members[i].group_member_user_id}
    								<form action="{$base_url}/group/{$group_info.group_url}/members/{$page}" method="post" onsubmit="javascript: return confirm('Are you sure to delete this member from the group?');">
    								<input type="hidden" name="member_id" value="{$group_members[i].group_member_user_id}" />
                                    <button type="submit" class="btn btn-default btn-sm" name="remove_mem">Remove From Group</button>
    								</form>
    							{/if}
    						</p>
    					</div>
                    </div>
    			</div>
    		{/if}
        {/section}

    	{if $page_link ne ''}
    		<div>{$page_link}</div>
    	{/if}
    </div>
</div>

{/if}

<div class="col-md-3">
    {insert name=advertise adv_name='wide_skyscraper'}
</div>