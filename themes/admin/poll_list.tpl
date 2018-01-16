<div class="page-header">
    <h1>View polls</h1>
</div>

{section name=i loop=$pollArray}

    <p>
        <b>Q: </b>
        {$pollArray[i].poll_qty}
        ( <a href="poll_edit.php?poll_id={$pollArray[i].poll_id}" data-toggle="tooltip" data-placement="bottom" title="Edit">
            <span class="glyphicon glyphicon-edit"></span>
        </a> <a href="poll_list.php?action=delete&poll_id={$pollArray[i].poll_id}" onclick="return confirm('Click OK to delete poll')" data-toggle="tooltip" data-placement="bottom" title="Delete">
            <span class="glyphicon glyphicon-remove-circle"></span>
        </a>)
    </p>

    <table class="table table-striped table-hover">
        {section name=j loop=$poll_info[i]}
        <tr>
            <td>{$poll_info[i][j].answer}</td>
            <td>{$poll_info[i][j].percentage}%</td>
        </tr>
        {/section}
    </table>

    <p><i>Start Date:{$pollArray[i].start_date} End Date:{$pollArray[i].end_date}</i></p>

    <hr size="1" />

{/section}

{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
{/literal}
