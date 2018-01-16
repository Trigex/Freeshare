<div>
    <div class="row">
        <a href="{$base_url}/{$view.user_info.user_name}">
            <img src="{insert name=member_img_url UID=$view.video_info.video_user_id}" width="200">
        </a>
    </div>
    <h4>
        <a href="{$base_url}/{$view.user_info.user_name}">{$view.user_info.user_name}</a>
        {if $view.user_info.user_about_me ne ""}
        <br>
        <small>{$view.user_info.user_about_me|truncate: 100}</small>
        {/if}
        {if $view.user_info.user_website ne ""}
        <br>
        <small><a href="{$view.user_info.user_website}" target="_blank">{$view.user_info.user_website}</a></small>
        {/if}
    </h4>

    {insert name=video_count assign=vdocount uid=$view.video_info.video_user_id}
    {insert name=favour_count assign=favcount uid=$view.video_info.video_user_id}
    {insert name=friends_count assign=friendcount uid=$view.video_info.video_user_id}

    <p class="text-muted small text-center">
        <span class="text-nowrap"><a href="{$base_url}/{$view.user_info.user_name}/public/">{$vdocount} Videos</a> |</span>
        <span class="text-nowrap"><a href="{$base_url}/{$view.user_info.user_name}/favorites/">{$favcount} Favorites</a> |</span>
        <span class="text-nowrap"><a href="{$base_url}/{$view.user_info.user_name}/friends/">{$friendcount} Friends</a></span>
    </p>
    <p class="text-muted small text-center">
        <span class="text-nowrap">
            (<a href="{$base_url}/mail.php?folder=compose&receiver={$view.user_info.user_name}">Send Me a Private Message!</a>)
        </span>
    </p>
</div>