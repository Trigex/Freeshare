<div class="page-header">
    <h1>Add New User</h1>
</div>

<form method="POST" action="" class="form-horizontal">

    <fieldset>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="user_name">Username</label>
        <div class="col-sm-5">
            <input id="user_name" name="user_name" type="text" placeholder="Username" class="form-control input-md" value="{$smarty.post.user_name}" required="">
            <span class="help-block">Enter Username</span>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="user_email">Email</label>
        <div class="col-sm-5">
            <input id="user_email" name="user_email" type="email" placeholder="Email" class="form-control input-md" value="{$smarty.post.user_email}" required="">
            <span class="help-block">Enter email address.</span>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="user_password">Password</label>
        <div class="col-sm-5">
            <input id="user_password" name="user_password" type="text" placeholder="Password" class="form-control input-md" value="{$smarty.post.user_password}" required="">
            <span class="help-block">Enter password</span>
        </div>
    </div>


    {if $enable_package eq "yes"}

    <div class="form-group">
        <label class="col-sm-2 control-label" for="user_package_id">Package</label>
        <div class="col-sm-5">
            <select id="user_package_id" name="user_package_id" class="form-control">
                {section name=i loop=$package}
                <option value="{$package[i].package_id}">{$package[i].package_name}</option>
                {/section}
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="user_package_duration">Duration</label>
        <div class="col-sm-5">
            <input type="text" size="2" name="user_package_duration" id="user_package_duration" value="{$smarty.post.user_package_duration}" class="form-control">
            <select id="user_package_duration_type" name="user_package_duration_type" class="form-control">
                <option value="days">Days</option>
                <option value="months">Months</option>
                <option value="years">Years</option>
            </select>
        </div>
    </div>

    {/if}

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-5">
            <button id="submit" name="submit" class="btn btn-default btn-lg">Add User</button>
        </div>
    </div>

    </fieldset>

</form>
