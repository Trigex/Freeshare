<div class="page-header">
    <h1>Advertisements</h1>
</div>

<table class="table table-striped table-hover">
    <tr>
        <td width="100">
            <b>ID</b>
            <a href="advertisements.php?sort=adv_id+asc">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="advertisements.php?sort=adv_id+desc">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td>
            <b>Advertise Name</b>
            <a href="advertisements.php?sort=adv_name+asc">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="advertisements.php?sort=adv_name+desc">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td>
            <b>Status</b>
        </td>
        <td width="100" align="center">
            <b>Action</b>
        </td>
    </tr>

    {foreach from=$advertisements_all item=advertisement}

    <tr>
        <td>
            {$advertisement.adv_id}
        </td>
        <td>
            {$advertisement.adv_name}
        </td>
        <td>
            <a href="advertisement_status.php?adv_id={$advertisement.adv_id}&page={$smarty.request.page}&sort={$smarty.request.sort}">{$advertisement.adv_status}</a>
        </td>
        <td align="center">
            <a href="advertisement_edit.php?adv_id={$advertisement.adv_id}&page={$smarty.request.page}&sort={$smarty.request.sort}" data-toggle="tooltip" data-placement="bottom" title="Edit">
                <span class="glyphicon glyphicon-edit"></span>
            </a>
        </td>
    </tr>

    {/foreach}

</table>

{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
{/literal}
