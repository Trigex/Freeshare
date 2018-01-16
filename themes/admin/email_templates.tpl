<div class="page-header">
    <h1>Email Templates</h1>
</div>

<table class="table table-striped">

    <tr>
        <td width="60">
            <b>Email ID</b>
            <a href="?a={$smarty.request.a}&status={$smarty.request.status}&sort=email_id+asc">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="?a={$smarty.request.a}&status={$smarty.request.status}&sort=email_id+desc">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td>
            <b>Email Subject</b>
            <a href="?a={$smarty.request.a}&status={$smarty.request.status}&sort=email_subject+asc">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="?a={$smarty.request.a}&status={$smarty.request.status}&sort=email_subject+desc">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td>
            <b>Comments</b>
        </td>
        <td width="100" align="center">
            <b>Action</b>
        </td>
    </tr>

    {foreach from=$email_templates_all item=email_template}

        <tr>
            <td>{$email_template.email_id}</td>
            <td>{$email_template.email_subject}</td>
            <td>{$email_template.comment}</td>
            <td align="center">
                <a href="email_edit.php?action=edit&email_id={$email_template.email_id}" data-toggle="tooltip" data-placement="bottom" title="Edit">
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
