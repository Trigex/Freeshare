<div class="page-header">
    <a class="btn btn-primary pull-right" href="package_add.php">Add New Package</a>
    <h1>Packages {if $enable_package eq "no"}(Disabled){/if}</h1>
</div>

<table class="table table-striped table-hover">

    <tr>
        <td><b>Package Name</b></td>
        <td><b>Space</b></td>
        <td><b>Price</b></td>
        <td><b>Video Limit</b></td>
        <td><b>Period</b></td>
        <td><b>Download</b></td>
        <td><b>Trial</b></td>
        <td><b>Status</b></td>
        <td><b>Action</b></td>
    </tr>

    {section name=aa loop=$packages}
    <tr {if $packages[aa].package_trial eq "yes"} class="info" {/if}>
        <td><a href="package_view.php?package_id={$packages[aa].package_id}">{$packages[aa].package_name}</a></td>
        <td>{insert name=format_size size=$packages[aa].package_space}</td>
        <td>{if $packages[aa].is_trial eq "yes"}No{else}${$packages[aa].package_price}{/if}</td>
        <td>{if $packages[aa].package_videos eq "0" or $packages[aa].package_videos eq ""}No{else}{$packages[aa].package_videos}{/if}</td>
        <td>{if $packages[aa].package_trial eq "yes"}{$packages[aa].package_trial_period} days{else}{$packages[aa].package_period}{/if}</td>
        <td>{if $packages[aa].package_allow_download eq '1'} Yes {else} No {/if}</td>
        <td class="text-capitalize">{$packages[aa].package_trial}</td>
        <td>{$packages[aa].package_status}</td>
        <td>
            <a href="package_edit.php?package_id={$packages[aa].package_id}" data-toggle="tooltip" data-placement="bottom" title="Edit Package">
                <span class="glyphicon glyphicon-edit"></span>
            </a>
            &nbsp;
            <a href="package_delete.php?package_id={$packages[aa].package_id}" data-toggle="tooltip" data-placement="bottom" title="Delete Package">
                <span class="glyphicon glyphicon-trash"></span>
            </a>
        </td>
    </tr>
    {/section}

</table>

{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
{/literal}
