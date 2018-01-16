<div class="page-header">
    <h1>Edit Package - {$package.package_name}</h1>
</div>

<form method="post" action="" class="form-horizontal" role="form">

    <input type="hidden" name="package_id" value="{$package.package_id}">

    <div class="form-group">
        <label class="col-sm-2 control-label" for="package_name">Package Name:</label>
        <div class="col-sm-5">
            <input class="form-control" name="package_name" id="package_name" value="{$package.package_name}" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="package_description">Description:</label>
        <div class="col-sm-5">
            <textarea class="form-control" name="package_description" id="package_description" rows="5">{$package.package_description}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="package_space">Space (MB):</label>
        <div class="col-sm-5">
            <input class="form-control" name="package_space" id="package_space" value="{$package.package_space}" />
        </div>
    </div>

    {if $package.package_trial ne "yes"}
        <div class="form-group">
            <label class="col-sm-2 control-label" for="package_price">Price (US $):</label>
            <div class="col-sm-5">
                <input class="form-control" name="package_price" id="package_price" value="{$package.package_price}" />
            </div>
        </div>
    {/if}

    <div class="form-group">
        <label class="col-sm-2 control-label" for="package_videos">Video Limit:</label>
        <div class="col-sm-5">
            <input class="form-control" name="package_videos" id="package_videos" value="{$package.package_videos}" />
            <p class="help-block">Leave blank or enter 0 for unlimited upload</p>
        </div>
    </div>

    {if $package.package_trial ne "yes"}
        <div class="form-group">
            <label class="col-sm-2 control-label" for="package_period">Subscription Period</label>
            <div class="col-sm-5">
                <select class="form-control" name="package_period" id="package_period">{$period_ops}</select>
            </div>
        </div>
    {else}
        <div class="form-group">
            <label class="col-sm-2 control-label" for="package_trial_period">Trial Period (Day):</label>
            <div class="col-sm-5">
                <input class="form-control" name="package_trial_period" id="package_trial_period" value="{$package.package_trial_period}" />
            </div>
        </div>
    {/if}

    <div class="form-group">
        <label class="col-sm-2 control-label" for="allow_download">Allow Video Download:</label>
        <div class="col-sm-5">
            <select class="form-control" name="allow_download" id="allow_download">{$download_ops}</select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="package_trial">Trial Package:</label>
        <div class="col-sm-5">
            <select class="form-control" name="package_trial">
                <option value="yes"{if $package.package_trial eq "yes"} selected{/if}>Yes</option>
                <option value="no"{if $package.package_trial eq "no"} selected{/if}>No</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="package_status">Status:</label>
        <div class="col-sm-5">
            <select class="form-control" name="package_status" id="package_status">{$status_ops}</select>
        </div>
    </div>

    <div class="submit">
        <div class="col-sm-offset-2 col-sm-5">
            <button type="submit" name="submit" class="btn btn-default btn-lg">Update</button>
        </div>
    </div>

</form>