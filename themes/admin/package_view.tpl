<div class="page-header">
    <h1>Packages {if $enable_package eq "no"}(Disabled){/if}</h1>
</div>

<table class="table table-hover table-striped">

<tr>
<td><b>Package Name</b></td>
<td><b>{$package.package_name}</b></td>
</tr>

<tr>
<td><b>Description</b></td>
<td>{$package.package_description}</td>
</tr>

<tr>
<td><b>Space</b></td>
<td>{insert name=format_size size=$package.package_space}</td>
</tr>

<tr>
<td><b>Price</b></td>
<td>${$package.package_price}</td>
</tr>

<tr>
<td><b>Video Limit</b> (Optional)</td>
<td>
    {if $package.package_videos eq "0" or $package.package_videos eq ""}
        (None)
    {else}
        {$package.package_videos}
    {/if}
</td>
</tr>

<tr>
<td><b>Subscription Period</b></td>
<td>
    {if $package.package_trial eq "yes"}
        {$package.package_trial_period} days
    {else}
        {$package.package_period}
    {/if}
</td>
</tr>

<tr>
<td><b>Allow Video Download</b></td>
<td>{if $package.package_allow_download eq '1'} Yes {else} No {/if}</td>
</tr>

<tr>
<td><b>Trial</b></td>
<td class="text-capitalize">{$package.package_trial}</td>
</tr>

<tr>
<td><b>Status</b></td>
<td>{$package.package_status}</td>
</tr>

</table>

<div class="btn-group">
    <a href="packages.php" class="btn btn-default">View Packages</a>
    <a href="package_edit.php?package_id={$package.package_id}" class="btn btn-default">Edit Package</a>
    <a href="package_delete.php?package_id={$package.package_id}" class="btn btn-danger">Delete Package</a>
</div>
