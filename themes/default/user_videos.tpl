<div class="col-md-9">
    <div class="page-header">
        <h1>
            {if $smarty.request.type eq "private"}Private videos
            {else}Public videos
            {/if}
             of <strong>{$user_info.user_name}</strong>
            <small class="pull-right btn font-size-md">
                Videos {$start_num}-{$end_num} of {$total}
            </small>
        </h1>
    </div>
    <div class="video-block video-block-list">
        {section name=i loop=$view.videos}
            <div class="row">
                {include file="videos_list_view.tpl" video_info=$view.videos[i] hide_owner_info=1}

                {if $user_info.user_name == $smarty.session.USERNAME}
                    <div class="col-sm-4 col-md-3 pull-right text-right">
                        <form name="editVideoForm" action="{$base_url}/video_edit.php" method="GET" style="display: inline;">
                            <input type="hidden" value={$view.videos[i].video_id} name="video_id" />
                            <input type="hidden" value={$page} name="page" />
                            <button type="submit" class="btn btn-default btn-sm" title="Edit">
                                <span class="glyphicon glyphicon-edit"></span> Edit
                            </button>
                        </form>
                        <form name="removeVideoForm" action="" method="POST" style="display: inline;margin-left: 1em;">
                            <input type="hidden" value="1" name="remove_video" />
                            <input type="hidden" value="{$view.videos[i].video_id}" name="VID" />
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to remove this video?');">
                                <span class="glyphicon glyphicon-remove"></span> Delete
                            </button>
                        </form>
                   </div>
                {/if}
            </div>
            <hr>
        {sectionelse}
            <br>
            <center><h4>There are no videos found.</h4></center>
        {/section}
    </div>

    <div class="clearfix"></div>
    {if $page_links ne ""}<div>{$page_links}</div>{/if}
</div> <!-- content -->

<div class="col-md-3">

    {if $total gt "0"}
        <div class="page-header">
            <h2>My Tags:</h2>
        </div>
        <div class="list-group">
            {section name=k loop=$view.video_keywords_array_all}
                <a class="list-group-item" href="{$base_url}/tag/{$view.video_keywords_array_all[k]}/">{$view.video_keywords_array_all[k]}</a>
            {/section}
        </div>
    {/if}

    {insert name=advertise adv_name='wide_skyscraper'}
</div>