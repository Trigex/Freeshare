{insert name=video_count assign=publicvdo uid=$user_info.user_id type=public}
{insert name=video_count assign=privatvdo uid=$user_info.user_id type=private}
{insert name=favour_count assign=favcount uid=$user_info.user_id}
{insert name=group_count assign=grpcount uid=$user_info.user_id}
{insert name=friends_count assign=friendcount uid=$user_info.user_id}
{insert name=playlist_count assign=playcount uid=$user_info.user_id}
<ul class="list-inline text-center">
	<li><a href="{$base_url}/{$user_info.user_name}">Profile</li>
	<li><a href="{$base_url}/{$user_info.user_name}/public/">Public Videos ({$publicvdo})</a></li>
	<li><a href="{$base_url}/{$user_info.user_name}/private/">Private Videos ({$privatvdo})</a></li>
	{if $allow_favorite eq '1'}
	<li><a href="{$base_url}/{$user_info.user_name}/favorites/">Favorites ({$favcount})</a></li>
	{/if}
	<li><a href="{$base_url}/{$user_info.user_name}/friends/">Friends ({$friendcount})</a></li>
	{if $allow_playlist eq '1'}
	<li><a href="{$base_url}/{$user_info.user_name}/playlist/">Playlist ({$playcount})</a></li>
	{/if}
	<li class="last"><a href="{$base_url}/{$user_info.user_name}/groups/">Groups ({$grpcount})</a></li>
</ul>