<div class="col-md-12">
    <div class="row">
        <div class="col-md-9">
            <h1>
            {$title} Members
            <small class="font-size-md btn">(Members {$start_num}-{$end_num} of {$total})</small>
            </h1>
        </div>

        <div class="col-md-3">
        <br>
            <div class="input-group">
                <span class="input-group-addon">Sort by</span>
                <select name="sort" onchange="javascript:window.location.href='{$base_url}/members/' + this.value + '/';" class="form-control">
                <option value="recent" {if $sort eq 'recent'}selected{/if}>Most Recent</option>
                <option value="video_uploaded" {if $sort eq 'video_uploaded'}selected{/if}>Most Video Uploaded</option>
                <option value="profile_viewed" {if $sort eq 'profile_viewed'}selected{/if}>Most Profile Viewed</option>
                <option value="video_viewed" {if $sort eq 'video_viewed'}selected{/if}>Most Video Viewed</option>
                </select>
            </div>
        </div>
    </div>

<hr>

    <div class="clarfix"></div>
    <div class="row">
        {section name=i loop=$members}
            <div class="col-orient-ls-members col-xs-6 col-sm-4 col-md-2">
                <div class="thumbnail members">
                    <div class="preview">
                        <a href="{$base_url}/{$members[i].user_name}/">
                            <img class="img-responsive" src="{$members[i].photo_url}" alt="{$members[i].user_name}">
                            <h4 class="user-title">{$members[i].user_name}</h4>
                        </a>
                    </div>
                    <div class="caption">
                        <p class="text-muted small text-nowrap">
                            Joined: {insert name=timediff assign=stime time=$members[i].user_join_time}<b>{$stime}</b>
                        </p>

                        <p class="text-muted small text-nowrap">
                            Last Login: {insert name=timediff assign=rtime time=$members[i].user_last_login_time}<b>{$rtime}</b>
                        </p>
                        <p class="text-muted small text-nowrap">
                            <span class="glyphicon glyphicon-facetime-video"></span> Videos: {insert name=video_count uid=$members[i].user_id assign=video_num}<b><a href="{$base_url}/{$members[i].user_name}/public/1">{$video_num}</a></b> &nbsp;
                            <span class="glyphicon glyphicon-heart"></span> Favorites: {insert name=favour_count assign=favour_num uid=$members[i].user_id}<b><a href="{$base_url}/{$members[i].user_name}/favorites/1">{$favour_num}</a></b>
                        </p>
                        {if $sort eq "profile_viewed"}
                            <p class="text-muted small text-nowrap">
                                <span class="glyphicon glyphicon-eye-open"></span> Profile Viewed: <b>{$members[i].user_profile_viewed}</b>
                            </p>
                        {elseif $sort eq "video_viewed"}
                            <p class="text-muted small text-nowrap">
                                <span class="glyphicon glyphicon-eye-open"></span> Video Viewed: <b>{$members[i].user_watched_video}</b>
                            </p>
                        {elseif $sort eq "subscribed"}
                            <p class="text-muted small text-nowrap">
                                <span class="glyphicon glyphicon-user"></span> Subscribers: <b>{$members[i].total}</b>
                            </p>
                        {else}
                            <p class="text-muted small text-nowrap">
                                <span class="glyphicon glyphicon-user"></span> My Friends: {insert name=friends_count assign=friends_num uid=$members[i].user_id}<b><a href="{$base_url}/{$members[i].user_name}/friends/1">{$friends_num}</a></b>
                            </p>
                        {/if}
                    </div>
        		</div>
            </div>
        {/section}
    </div>

    {if $page_links ne ''}
    <div>{$page_links}</div>
    {/if}
</div>

