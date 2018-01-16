<div class="page-header">
    <h1>Reserved User Names</h1>
</div>

{if !empty($disallow)}

<table class="table table-striped table-hover">

    <tr>
        <td><b>User Names</b></td>
        <td align="center"><b>ACTION</b></td>
    </tr>

    {foreach from=$disallow item=reserved_name}
    <tr>
        <td>{$reserved_name.disallow_username}</td>
        <td align="center">
            <a href="?action=del&id={$reserved_name.disallow_id}" onClick='Javascript:return confirm("Are you sure you want to delete?");' data-toggle="tooltip" data-placement="bottom" title="Remove">
                <span class="glyphicon glyphicon-remove-circle"></span>
            </a>
        </td>
    </tr>
    {/foreach}

</table>

{else}

<div class="alert alert-info">
    No user name reserved.
</div>

{/if}

<hr>

<form method="post" action="" class="form-inline">

    <input type="hidden" name="action" value="add" />
    <div class="form-group">
        <label class="sr-only" for="name">Reserve a User Name:</label>
        <div class="col-sm-5">
            <input class="form-control" type="text" name="name" id="name" placeholder="Reserve a User Name" required>
        </div>
    </div>

    <button type="submit" name="submit" class="btn btn-default">Reserve</button>

</form>


{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
{/literal}
