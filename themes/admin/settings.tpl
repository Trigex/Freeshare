<div class="page-header">
    <h1>Site Settings</h1>
</div>

<form method="post" action="" class="form-horizontal" role="form">

    <fieldset>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="site_name">Site Name:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <input class="form-control" name="site_name" id="site_name" value="{$site_name}" size="40" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/system_settings#site_name" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="meta_keywords">Meta Keywords:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" name="meta_keywords" id="meta_keywords" value="{$meta_keywords}" size="40" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/system_settings#meta_keywords" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="meta_description">Meta Description:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" name="meta_description" id="meta_description" value="{$meta_description}" size="40" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/system_settings#meta_description" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="admin_email">Admin Email:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" name="admin_email" id="admin_email" value="{$admin_email}" size="40" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/system_settings#admin_email" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="items_per_page">List Per Page:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" name="items_per_page" id="items_per_page" value="{$items_per_page}" size="40" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/system_settings#list_per_page" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="rel_video_per_page">Related Videos:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" name="rel_video_per_page" id="rel_video_per_page" value="{$rel_video_per_page}" size="40" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/system_settings#related_videos" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="num_watch_videos">Watch Videos:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" name="num_watch_videos" id="num_watch_videos" value="{$num_watch_videos}" size="40" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/system_settings#watch_videos" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="guest_limit">Guest Limit:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" name="guest_limit" id="guest_limit" value="{$guest_limit}" size="40" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/system_settings#guest_limit" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="cache_enable">Cache</label>
        <div class="col-sm-5">
            <div class="input-group">
                <select class="form-control" name="cache_enable" id="cache_enable">
                    <option value="1" {if $cache_enable eq "1"}selected="selected"{/if}>Yes</option>
                    <option value="0" {if $cache_enable eq "0"}selected="selected"{/if}>No</option>
                </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/system_settings#cache" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="allow_html">Allow Links in comment:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <select class="form-control" name="allow_html" id="allow_html">
                    <option value="1" {if $allow_html eq "1"}selected="selected"{/if}>Yes</option>
                    <option value="0" {if $allow_html eq "0"}selected="selected"{/if}>No</option>
                </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/system_settings#allow_links_in_comment" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="auto_approve">Auto Approve:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <select class="form-control" name="approve" id="auto_approve">
                    <option value="1" {if $approve eq "1"}selected="selected"{/if}>Enable</option>
                    <option value="0" {if $approve eq "0"}selected="selected"{/if}>Disable</option>
                </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/system_settings#auto_approve" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="moderate_video_links">Moderate Uploads with Link:</label>
        <div class="col-sm-5">
            <select class="form-control" name="moderate_video_links" id="moderate_video_links">
                <option value="1" {if $moderate_video_links eq "1"}selected="selected"{/if}>Yes</option>
                <option value="0" {if $moderate_video_links eq "0"}selected="selected"{/if}>No</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="debug">Debug Mode:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <select class="form-control" name="debug" id="debug">
                    <option value="1" {if $debug eq "1"}selected="selected"{/if}>Enable</option>
                    <option value="0" {if $debug eq "0"}selected="selected"{/if}>Disable</option>
                </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/system_settings#debug" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="notify_upload">Notify Upload:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="notify_upload" id="notify_upload">
                <option value="1" {if $notify_upload eq "1"}selected="selected"{/if}>Enable</option>
                <option value="0" {if $notify_upload eq "0"}selected="selected"{/if}>Disable</option>
            </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/system_settings#notify_upload" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="embed_show">Embed Show:</label>
        <div class="col-sm-5">
            <select class="form-control" name="embed_show" id="embed_show">
                <option value="1" {if $embed_show eq "1"}selected="selected"{/if}>Enable</option>
                <option value="0" {if $embed_show eq "0"}selected="selected"{/if}>Disable</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="embed_type">Embed Type:</label>
        <div class="col-sm-5">
            <select class="form-control" name="embed_type" id="embed_type">
                <option value="0" {if $embed_type eq "0"}selected="selected"{/if}>IFRAME</option>
                <option value="1" {if $embed_type eq "1"}selected="selected"{/if}>OBJECT</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="enable_package">Service Type:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <select class="form-control" name="enable_package" id="enable_package">{$service_ops}</select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/system_settings#service_type" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    {if $enable_package eq "yes"}

        <div class="form-group">
            <label class="col-sm-3 control-label">Payment Method:</label>
            <div class="col-sm-5">
            {$payment_method_ops}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">CCBill Account No:</label>
            <div class="col-sm-5">
                <input class="form-control" type="text" name="ccbill_ac_no" value="{$ccbill_ac_no}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">CCBill Sub account No:</label>
            <div class="col-sm-5">
                <input class="form-control" type="text" name="ccbill_sub_ac_no" value="{$ccbill_sub_ac_no}">
            </div>
        </div>

		<div class="form-group">
            <label class="col-sm-3 control-label">CCBill Form Name:</label>
            <div class="col-sm-5">
                <input class="form-control" type="text" name="ccbill_form_name" value="{$ccbill_form_name}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label" for="paypal_receiver_email">Paypal Receiver Email:</label>
            <div class="col-sm-5">
                <input class="form-control" name="paypal_receiver_email" id="paypal_receiver_email" value="{$paypal_receiver_email}" size="40" />
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Enable Test Payment ?</label>
            <div class="col-sm-5">
                <input type=radio name=enable_test_payment value="yes" {if $enable_test_payment eq "yes"}checked="checked"{/if} /> Yes<br />
                <input type=radio name=enable_test_payment value="no" {if $enable_test_payment ne "yes"}checked="checked"{/if} /> No<br />
            </div>
        </div>

    {/if}

    <div class="form-group">
        <label class="col-sm-3 control-label" for="family_filter">Family Filter:</label>
        <div class="col-sm-5">
            <select class="form-control" name="family_filter" id="family_filter">
                <option value="1" {if $family_filter eq "1"}selected="selected"{/if}>Enable</option>
                <option value="0" {if $family_filter eq "0"}selected="selected"{/if}>Disable</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="hotlink_protection">Hotlink Protection:</label>
        <div class="col-sm-5">
            <select class="form-control" name="hotlink_protection">
                <option value="0"{if $hotlink_protection eq "0"} selected="selected"{/if}>Disabled</option>
                <option value="1"{if $hotlink_protection eq "1"} selected="selected"{/if}>Normal Hotlink Protection</option>
                <option value="2"{if $hotlink_protection eq "2"} selected="selected"{/if}>Only Allow Logged in Users</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3">Logo URL:</label>
        <div class="col-md-5">
            <input class="form-control" type="text" name="logo_url_md" id="logo_url_md" value="{$logo_url_md}">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3">Logo Small URL:</label>
        <div class="col-md-5">
            <input class="form-control" type="text" name="logo_url_sm" id="logo_url_sm" value="{$logo_url_sm}">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-5">
            <button type="submit" name="submit" class="btn btn-default btn-lg">Update</button>
        </div>
    </div>

    </fieldset>

</form>
