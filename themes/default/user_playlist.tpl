<div class="col-md-3">
    <div class="page-header">
        <h2>Playlists</h2>
    </div>
    <div class="list-group">
        {section name=i loop=$playlists}
            <a class="list-group-item" href="{$base_url}/{$user_info.user_name}/playlist/{$playlists[i].playlist_name}/1">
                {$playlists[i].playlist_name}
            </a>
        {/section}
    </div>
    <div class="clearfix"></div>

    {if $user_info.user_id eq $smarty.session.UID}
        <form method="post" name="pl-frm" id="pl-frm" action="">
            <div class="form-group">
                <label>Create New Playlist:</label>
                <input type="text" name="playlist_name" id="playlist_name" class="form-control" required>
            </div>
            <div class="form-group">
                <button type="submit" name="create_playlist" id="create" class="btn btn-default">Add</button>
            </div>
        </form>
    {/if}
</div>

<div class="col-md-9">
    {if $playlists|@count eq "0"}
        <center><h4>There is no playlist found.</h4></center>
    {else}
        <div class="media">
            <div class="media-left">
                {if $total gt "0"}
                    <img class="media-object" width="150px" height="85px" src="{$videos[0].video_thumb_url}/thumb/{$videos[0].video_folder}1_{$videos[0].video_id}.jpg" alt="{$videos[0].video_title}">
                {else}
                    <img class="media-object" width="150px" height="85px" src="{$img_css_url}/images/no_thumbnail.gif" alt="No videos">
                {/if}
            </div>
            <div class="media-body">
                <h3 class="margin-no">
                    <b>{$playlist_info.playlist_name}</b>
                </h3>
                <p class="text-muted small">
                    by <a href="{$base_url}/{$user_info.user_name}">{$user_info.user_name}</a>,
                    {$total} videos,
                    {insert name=timediff time=$playlist_info.playlist_add_date}
                    {if $smarty.session.UID eq $playlist_info.playlist_user_id}
                        <p></p>
                        <a class="btn btn-default btn-sm" onclick="Javascript:return confirm('Are you sure you want to delete?');" href="{$base_url}/playlist_delete.php?pl_id={$playlist_info.playlist_id}&action=pl_del">
                            <span class="glyphicon glyphicon-remove"></span> Delete
                        </a>
                    {/if}
                </p>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>

        <div class="video-block video-block-list">
        {section name=i loop=$videos}
            <div class="row">
                {include file="videos_list_view.tpl" video_info=$videos[i]}
                {if $user_info.user_name eq $smarty.session.USERNAME}
                    <div class="col-sm-4 col-md-3 pull-right text-right">
                        <a class="btn btn-danger btn-sm" href="{$base_url}/playlist_delete.php?pl_id={$playlist_info.playlist_id}&action=vdo_del&vid={$videos[i].video_id}&page={$page}" title="Remove from playlist">
                            <span class="glyphicon glyphicon-remove"></span> Remove
                        </a>
                    </div>
                {/if}
            </div>
          <hr>
        {sectionelse}
            <center><h4>There is no video found.</h4></center>
        {/section}
        </div>

        {if $page_links ne ""}
            <div>{$page_links}</div>
        {/if}
    {/if}
</div>