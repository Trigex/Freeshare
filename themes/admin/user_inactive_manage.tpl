<div class="page-header">
    <h1>Manage Inactive Users</h1>
</div>

{if $total gt '0'}

<form method="post" id="frm" action="javascript:void(0);">

<table class="table table-striped">
    <thead>
        <tr>
            <th>
                Name
                <a href="user_inactive_manage.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_name+asc&page={$page}">
                    <span class="glyphicon glyphicon-arrow-up"></span>
                </a>
                <a href="user_inactive_manage.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_name+desc&page={$page}">
                    <span class="glyphicon glyphicon-arrow-down"></span>
                </a>
            </th>
            <th>
                IP
                <a href="user_inactive_manage.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_ip+asc&page={$page}">
                    <span class="glyphicon glyphicon-arrow-up"></span>
                </a>
                <a href="user_inactive_manage.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_ip+desc&page={$page}">
                    <span class="glyphicon glyphicon-arrow-down"></span>
                </a>
            </th>
            <th>
                Signed up
                <a href="user_inactive_manage.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_last_login_time+asc&page={$page}">
                    <span class="glyphicon glyphicon-arrow-up"></span>
                </a>
                <a href="user_inactive_manage.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_last_login_time+desc&page={$page}">
                    <span class="glyphicon glyphicon-arrow-down"></span>
                </a>
            </th>
            <th>
                <input type="checkbox" id="check-all">
            </th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$users item=user_info}
        <tr>
            <td>
                <a href="user_view.php?user_id={$user_info.user_id}&page={$smarty.request.page}">
                    {$user_info.user_name}
                </a>
            </td>
            <td>
                {$user_info.user_ip}
            </td>
            <td>
                {date('M j Y H:i A', $user_info.user_join_time)}
            </td>
            <td>
                <input type="checkbox" name="user_ids[]" value="{$user_info.user_id}">
            </td>
        </tr>
        {/foreach}
    </tbody>
</table>

<div class="col-md-5">
    {$links}
</div>
<div class="btn-group pull-right">
    <input type="submit" id="activate" class="btn btn-primary" value="Activate">
    <input type="submit" id="delete" class="btn btn-danger" value="Delete">
</div>

</form>

<script>
$("#check-all").click(function(){
    var checked = $(this).is(":checked");
    $("form#frm input[type=checkbox]").prop("checked", checked);
});
$("form#frm #activate").click(function(e){
    e.preventDefault();
    if (confirm('Are you sure you want to activate?')) {
        $("form#frm").attr("action", "user_activate.php").submit();
    }
});
$("form#frm #delete").click(function(e){
    e.preventDefault();
    if (confirm('Are you sure you want to delete?')) {
        $("form#frm").attr("action", "user_inactive_manage.php").submit();
    }
});
</script>

{else}
<p>No inactive users found.</p>
{/if}