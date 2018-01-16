{if $inactive_user eq '1'}

<div class="text-center">
     <a class="btn btn-default btn-lg" href="{$base_url}/resend_activation_mail.php">Resend Activation E-Mail</a>
</div>

{else}

<div class="col-md-7">
    <div class="panel panel-default well">
        <div class="panel-body">
            <h2>What is {$site_name}?</h2>
            <p>{$site_name} is a way to get your videos to the people who matter to you. With {$site_name} you can:</p>

            <ul class="list-unstyled">
                <li><span class="glyphicon glyphicon-ok"></span> Show off your favorite videos to the world</li>
                <li><span class="glyphicon glyphicon-ok"></span> Blog the videos you take with your digital camera or cell phone</li>
                <li><span class="glyphicon glyphicon-ok"></span> Securely and privately show videos to your friends and family around the world</li>
                <li><span class="glyphicon glyphicon-ok"></span>  Build playlists of favorites to watch at any time</li>
                <li><span class="glyphicon glyphicon-ok"></span> and much, much more!</li>
            </ul>

            <p><a class="btn btn-info normal-white-space" href="{$base_url}/signup/"><strong>Sign up Now and open a new account</strong></a></p>
            <p>To learn more about our service, please see our <a href="{$base_url}/pages/help.html">Help</a> section.</p>
        </div>
    </div>
</div>

<div class="col-md-5">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><strong>{$site_name} Log In</strong></h3>
        </div>
        <div class="panel-body">
            <form method="post" action="{$base_url}/login/" id="login-form" role="form">
                <div class="form-group">
                    <label for="user_name">User Name:</label>
                    <input type="text" id="user_name" name="user_name" value="{$user_name}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" size="22" name="user_password" class="form-control" required>
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="autologin"> Remember
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" name="action_login" class="btn btn-default btn-lg">Log In</button>
                </div>
            </form>
            <br>
            <p><a href="{$base_url}/recoverpass.php">Forgot your password?</a></p>
        </div>
    </div>
</div>

{/if}