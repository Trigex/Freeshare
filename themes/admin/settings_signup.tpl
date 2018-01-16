<div class="page-header">
    <h1>Signup Settings</h1>
</div>

<form method="post" action="" class="form-horizontal" role="form">

    <fieldset>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="signup">Allow Signup:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="signup" id="signup">
                <option value="1" {if $signup_enable =='1'}selected="selected"{/if}>Yes</option>
                <option value="0" {if $signup_enable =='0'}selected="selected"{/if}>No</option>
            </select>
                <div class="input-group-addon">
                    <a href="https://www.buyscripts.in/docs/vshare/3.0/signup_settings#signup_enable" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="signup_verify">Signup Verification:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="signup_verify" id="signup_verify">
                <option value="1" {if $signup_verify eq "1"}selected="selected"{/if}>Enable</option>
                <option value="0" {if $signup_verify eq "0"}selected="selected"{/if}>Disable</option>
                <option value="2" {if $signup_verify eq "2"}selected="selected"{/if}>Admin</option>
            </select>
                <div class="input-group-addon">
                    <a href="https://www.buyscripts.in/docs/vshare/3.0/signup_settings#signup_verify" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="notify_signup">Notify Signup:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="notify_signup" id="notify_signup">
                <option value="1" {if $notify_signup eq "1"}selected="selected"{/if}>Enable</option>
                <option value="0" {if $notify_signup eq "0"}selected="selected"{/if}>Disable</option>
            </select>
                <div class="input-group-addon">
                    <a href="https://www.buyscripts.in/docs/vshare/3.0/signup_settings#notify_signup" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group recaptcha-keys">
        <label class="col-sm-3 control-label" for="recaptcha_sitekey">reCaptcha Site Key:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input type="text" name="recaptcha_sitekey" id="recaptcha_sitekey" value="{$recaptcha_sitekey}" class="form-control">
                <div class="input-group-addon">
                    <a href="https://www.buyscripts.in/docs/vshare/3.0/how_to_enable_captcha" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group recaptcha-keys">
        <label class="col-sm-3 control-label" for="recaptcha_secretkey">reCaptcha Secret Key:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input type="text" name="recaptcha_secretkey" id="recaptcha_secretkey" value="{$recaptcha_secretkey}" class="form-control">
                <div class="input-group-addon">
                    <a href="https://www.buyscripts.in/docs/vshare/3.0/how_to_enable_captcha" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="signup_dob">Date of Birth:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="signup_dob" id="signup_dob">
                <option value="0" {if $signup_dob =='0'}selected="selected"{/if}>No</option>
                <option value="1" {if $signup_dob =='1'}selected="selected"{/if}>Yes</option>
            </select>
                <div class="input-group-addon">
                    <a href="https://www.buyscripts.in/docs/vshare/3.0/signup_settings#signup_dob" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="signup_age_min">Age Minimum:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="signup_age_min" value="{$signup_age_min}" id="signup_age_min">
                <div class="input-group-addon">
                    <a href="https://www.buyscripts.in/docs/vshare/3.0/signup_settings#signup_age_min" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

     <div class="form-group">
        <label class="col-sm-3 control-label" for="signup_age_min_enforce">Enforce Age Minimum:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="signup_age_min_enforce" id="signup_age_min_enforce">
                <option value="0" {if $signup_age_min_enforce =='0'}selected="selected"{/if}>No</option>
                <option value="1" {if $signup_age_min_enforce =='1'}selected="selected"{/if}>Yes</option>
            </select>
                <div class="input-group-addon">
                    <a href="https://www.buyscripts.in/docs/vshare/3.0/signup_settings#signup_age_min_enforce" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="signup_auto_friend">Default Friend:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="signup_auto_friend" id="signup_auto_friend" value="{$signup_auto_friend}" />
                <div class="input-group-addon">
                    <a href="https://www.buyscripts.in/docs/vshare/3.0/signup_settings#signup_auto_friend" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="spam_filter">Spam Filter:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <select class="form-control" name="spam_filter" id="spam_filter">
                    <option value="0" {if $spam_filter =='0'}selected="selected"{/if}>Disable</option>
                    <option value="1" {if $spam_filter =='1'}selected="selected"{/if}>Enable</option>
                </select>
                <div class="input-group-addon">
                    <a href="https://www.buyscripts.in/docs/vshare/3.0/signup_settings#spam_filter" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
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
