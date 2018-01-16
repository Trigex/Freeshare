<div class="page-header">
    <h1>Change Admin Password</h1>
</div>


<form method="post" action="" class="form-horizontal" role="form">

    <fieldset>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="admin_name">Admin Name:</label>
        <div class="col-sm-5">
            <input class="form-control" name="admin_name" value="{$admin_name}" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="password">Current Password:</label>
        <div class="col-sm-5">
            <input class="form-control" type="password" name="password" id="password" autocomplete="off" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="password_new">New Password:</label>
        <div class="col-sm-5">
            <input class="form-control" type="password" name="password_new" id="password_new" autocomplete="off" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="password_confirm">Confirm Password:</label>
        <div class="col-sm-5">
            <input class="form-control" type="password" name="password_confirm" id="password_confirm" autocomplete="off" />
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-5">
            <button type="submit" name="submit" class="btn btn-default btn-lg">Change Password</button>
        </div>
    </div>

    </fieldset>

</form>

