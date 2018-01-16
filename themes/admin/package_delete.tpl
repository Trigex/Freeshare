<div class="page-header">
    <h1>Delete Package: {$package_info.package_name}</h1>
</div>

<p class="lead">There are {$subscriber_count} users signed up with this package.</p>

<form method="post" action="" class="form-horizontal">
    {if $subscriber_count gt "0"}
    <div class="form-group">
        <label class="control-label col-md-3">Select another pakage to assign these users.</label>
        <div class="col-md-4">
            <select class="form-control" name="package_id">
                <option value="0">-- Select --</option>
                {section name=i loop=$packages}
                <option value="{$packages[i].package_id}">{$packages[i].package_name}</option>
                {/section}
            </select>
        </div>
    </div>
    {/if}
    <div class="form-group">
        <div class="col-md-4 col-md-offset-3">
            <input type="submit" name="submit" class="btn btn-default btn-lg" value="Continue Deleting">
        </div>
    </div>
</form>