<div class="page-header">
    <h1>Miscellaneous Settings</h1>
</div>

<form method="post" action="" class="form-horizontal" role="form">

    <fieldset>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="video_rating">Rate a video:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="video_rating" id="video_rating">
                <option value="Once" {if $video_rating =='Once'}selected="selected"{/if}>Once</option>
                <option value="Unlimited" {if $video_rating =='Unlimited'}selected="selected"{/if}>Unlimited</option>
            </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/miscellaneous#video_rating" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="admin_listing_per_page">Admin listing per page:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="admin_listing_per_page" id="admin_listing_per_page" size="2" value="{$item_per_page}" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/miscellaneous#admin_listing_per_page" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="num_channel_video">Number of videos in channel:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="num_channel_video" id="num_channel_video" size="2" value="{$num_channel_video}" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/miscellaneous#num_channel_video" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="php_path">PHP Path:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="php_path" id="php_path" value="{$php_path}" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/miscellaneous#php_path" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="recommend_all">Recommend Video:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="recommend_all" id="recommend_all">
                <option value="0" {if $recommend_all =='0'}selected="selected"{/if}>Members Only</option>
                <option value="1" {if $recommend_all =='1'}selected="selected"{/if}>Everyone</option>
            </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/miscellaneous#recommend_all" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="allow_download">Allow Video Download:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="allow_download" id="allow_download">
                <option value="0" {if $allow_download =='0'}selected="selected"{/if}>No</option>
                <option value="1" {if $allow_download =='1'}selected="selected"{/if}>Yes</option>
            </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/miscellaneous#allow_download" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="video_comments_per_page">Video Comments per page:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="video_comments_per_page" id="video_comments_per_page" value="{$video_comments_per_page}" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/miscellaneous#video_comments_per_page" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="video_comment_notify">Video Comment Notification:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="video_comment_notify" id="video_comment_notify">
                <option value="0" {if $video_comment_notify =='0'}selected="selected"{/if}>No</option>
                <option value="1" {if $video_comment_notify =='1'}selected="selected"{/if}>Yes</option>
            </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/miscellaneous#video_comment_notify" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="user_comments_per_page">User Comments per page:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="user_comments_per_page" id="user_comments_per_page" value="{$user_comments_per_page}" /></label>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/miscellaneous#user_comments_per_page" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="mail_abuse_report">Mail Admin on Abuse:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="mail_abuse_report" id="mail_abuse_report">
                <option value="0" {if $mail_abuse_report =='0'}selected="selected"{/if}>No</option>
                <option value="1" {if $mail_abuse_report =='1'}selected="selected"{/if}>Yes</option>
            </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/miscellaneous#mail_abuse_report" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="num_max_channels">Max Channels per video:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="num_max_channels" id="num_max_channels" value="{$num_max_channels}" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/miscellaneous#num_max_channels" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="user_daily_mail_limit">Daily Mail Limit Per User:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="user_daily_mail_limit" id="user_daily_mail_limit" value="{$user_daily_mail_limit}" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/miscellaneous#user_daily_mail_limit" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="dailymotion_api_key">Dailymotion Api Key:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="dailymotion_api_key" id="dailymotion_api_key" value="{$dailymotion_api_key}" />
                <div class="input-group-addon">
                    <a href="https://www.buyscripts.in/docs/vshare/3.0/dailymotion_api_key" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="dailymotion_api_secret">Dailymotion Api Secret:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="dailymotion_api_secret" id="dailymotion_api_secret" value="{$dailymotion_api_secret}" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/miscellaneous#dailymotion_api_key" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="youtube_api_key">Youtube API Key:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="youtube_api_key" id="youtube_api_key" value="{$youtube_api_key}" />
                <div class="input-group-addon">
                    <a href="https://www.buyscripts.in/docs/vshare/3.0/how-to-enable-youtube-data-api" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="episode_enable">Episodes:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <select class="form-control" name="episode_enable" id="episode_enable">
                    <option value="1"{if $episode_enable eq "1"} selected{/if}>Enable</option>
                    <option value="0"{if $episode_enable eq "0"} selected{/if}>Disable</option>
                </select>
                <div class="input-group-addon">
                    <a href="https://www.buyscripts.in/docs/vshare/3.0/miscellaneous#episodes" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
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
