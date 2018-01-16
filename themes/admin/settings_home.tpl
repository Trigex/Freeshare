<div class="page-header">
    <h1>Home Page Settings</h1>
</div>

<form method="post" action="" class="form-horizontal" role="form">
    <fieldset>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="user_poll">Vote a poll:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="user_poll" id="user_poll">
                <option value="Once" {if $user_poll =='Once'}selected="selected"{/if}>Once</option>
                <option value="Unlimited" {if $user_poll =='Unlimited'}selected="selected"{/if}>Unlimited</option>
            </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/home_page#user_poll" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="home_num_tags">Number of Tags on Home Page:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="home_num_tags" id="home_num_tags" value="{$home_num_tags}" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/home_page#home_num_tags" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

	<div class="form-group">
        <label class="col-sm-3 control-label" for="num_last_users_online">Number of Last Online users:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="num_last_users_online" id="num_last_users_online" value="{$num_last_users_online}" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/home_page#num_last_users_online" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
	</div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="num_new_videos">Number of New Videos:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="num_new_videos" id="num_new_videos" value="{$num_new_videos}" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/home_page#num_new_videos" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="recently_viewed_video">Number of Recently Viewed Videos:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="recently_viewed_video" id="recently_viewed_video" value="{$recently_viewed_video}" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/home_page#recently_viewed_video" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="show_stats">Show Stats:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="show_stats" id="show_stats">
                <option value="1" {if $show_stats eq "1"}selected="selected"{/if}>Enable</option>
                <option value="0" {if $show_stats eq "0"}selected="selected"{/if}>Disable</option>
            </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/home_page#show_stats" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-5">
            <button type="submit" name="submit" class="btn btn-default btn-lg">Update</button>
        </div>
    </div>

    </fieldset>

</form>