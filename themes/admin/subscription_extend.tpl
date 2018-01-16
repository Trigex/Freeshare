<div class="page-header">
    <h1>Extend Subscription</h1>
</div>

<form method="post" action="" class="form-horizontal" role="form">

    <div class="form-group">
		<label class="col-sm-2 control-label" for="extend_for">Extend:</label>
        <div class="col-sm-5">
            <select class="form-control" name="extend_for" id="extend_for">
                <option value="specific_user" {if $smarty.request.extend_for eq "specif_user"}selected="selected"{/if}>Specific User</option>
                <option value="all_users" {if $smarty.request.extend_for eq "all_users"}selected="selected"{/if}>All Users</option>
                <option value="expired_users" {if $smarty.request.extend_for eq "expired_users"}selected="selected"{/if}>Expired Users</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="username">User Name:</label>
        <div class="col-sm-5">
            <input class="form-control" type="text" name="username" id="username" value="{$smarty.request.username}" size="23" />
        </div>
    </div>

    <div class="form-group">
		<label class="col-sm-2 control-label" for="duration">Duration:</label>
        <div class="col-sm-5">
    		<input class="form-control" type="text" name="duration" id="duration" size="4" value="{$smarty.request.duration}" />
    		<select class="form-control" name="duration_type">
                <option value=""> -- SELECT -- </option>
                <option value="days" {if $smarty.request.duration_type eq "days"}selected="selected"{/if}>Days</option>
                <option value="months" {if $smarty.request.duration_type eq "months"}selected="selected"{/if}>Months</option>
                <option value="years" {if $smarty.request.duration_type eq "years"}selected="selected"{/if}>Years</option>
    		</select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-5">
            <button type="submit" name="submit" class="btn btn-default btn-lg">Submit</button>
        </div>
    </div>

</form>