{if $signup_verification_msg ne ""}
<div class="col-md-12">
    <div class="page-header">
        <h2>Information</h2>
    </div>
    <p class="lead">{$signup_verification_msg}</p>
    <p><a href="{$base_url}/">Return to the home page</a></p>
</div>
{else}
<div class="col-md-7">
    <div class="panel panel-default">
    <div class="panel-body">
        <h2>
            New Member ? Sign up
        </h2>
        <p class="lead text-muted">Just fill out the account information below:</p>
        <hr>
    <form  method="post" action="{$base_url}/signup/" id="signup-form" class="form-horizontal" role="form">
        <div class="form-group">
            <label for="user_name" class="control-label col-md-3">User Name:</label>
            <div class="col-md-6">
                <input type="text" id="user_name" name="user_name" value="{$signup.user_name}" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="control-label col-md-3">Email:</label>
            <div class="col-md-6">
                <input type="text" name="email" id="email" value="{$signup.email}" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="control-label col-md-3">Password:</label>
            <div class="col-md-6">
                <input type="password" id="password" name="password" value="" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label for="password_confirm" class="control-label col-md-3">Confirm Password:</label>
            <div class="col-md-6">
                <input type="password" id="password_confirm" name="password_confirm"  value="" class="form-control">
            </div>
        </div>

        {if $signup_dob eq "1"}
            <div class="form-group">
                <label class="control-label col-md-3">Date of Birth:</label>
                <div class="col-md-2">
                    <select name="month" class="form-control">
                        <option>mm</option>
                        {foreach from=$months item=month}
                            <option {if $month eq $signup.month} selected {/if}>{$month}</option>
                        {/foreach}
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="day" class="form-control">
                        <option>dd</option>
                        {foreach from=$days item=day}
                            <option {if $day eq $signup.day} selected {/if}>{$day}</option>
                        {/foreach}
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="year" class="form-control">
                        <option>yyyy</option>
                        {foreach from=$years item=year}
                            <option {if $year eq $signup.year} selected {/if}>{$year}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
        {/if}

        {if $captcha_enabled eq "1"}
            <div class="form-group">
                <label class="control-label col-md-3">Verify you are human:</label>
                <div class="col-md-6">
                    {$captcha_html}
                </div>
            </div>
        {/if}

        {if $enable_package eq "yes"}
            <div class="form-group">
                <label class="control-label col-md-3">Available Packages:</label>
                <div class="col-md-6">
                    {section name=i loop=$package}
                        <div class="radio">
                            <label>
                                <input type="radio" name="pack_id" value="{$package[i].package_id}">
                                <b>{$package[i].package_name}</b>
                                <br>
                                <small>
                                {$package[i].package_description}<br />
                                - <font color="#0055CC">{insert name=format_size size=$package[i].package_space}</font> video upload space<br />
                                {if $package[i].package_videos gt "0"}
                                    - Maximum <font color="#0055CC">{$package[i].package_videos}</font> videos upload<br />
                                {/if}
                                {if $package[i].package_price gt "0"}
                                    - Registration cost only <font color="#0055CC">${$package[i].package_price}</font> per {$package[i].package_period|lower}
                                {elseif $package[i].package_trial eq "yes"}
                                    - Free for <font color="#0055CC">{$package[i].package_trial_period} days</font>
                                {/if}
                                </small>
                            </label>
                        </div>
                    {/section}
                </div>
            </div>
        {/if}

       <div class="form-group">
            <div class="col-md-offset-3 col-md-9">
                By signing up you agree to the <a href="{$base_url}/pages/terms.html" target="_blank" class="text-nowrap">Terms of Service</a> and the <a href="{$base_url}/pages/privacy.html" target="_blank" class="text-nowrap">Privacy Policy</a>.
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-3 col-md-3">
                <button type="submit" class="btn btn-default btn-lg" name="submit">Signup</button>
            </div>
        </div>
    </form>
    </div>
    </div>
</div>

<div class="col-md-5">
    <div class="panel panel-default">
    <div class="panel-body">
        <h2>{$site_name} Log In</h2>
        <p class="lead text-muted">Welcome back. Log in to your account</p>
    <hr>
    <form method="post" action="{$base_url}/login/" id="login-form" role="form">
        <div class="form-group">
            <label>User Name:</label>
            <input type="text" name="user_name" value="{$user_name}" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" id="password" name="user_password" class="form-control" required>
        </div>
        <div class="checkbox">
            <label><input type="checkbox" name="autologin">Remember</label>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-default btn-lg" name="action_login">Log In</button>
        </div>
    </form>

    <br>

    <div class="forget-passsword">
        <a href="{$base_url}/recoverpass.php">Forgot your password?</a> <br>
        <a href="{$base_url}/pages/help.html">Need Help? </a>
    </div>
    </div>
    </div>
</div>
{/if}