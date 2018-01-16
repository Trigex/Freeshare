<h1>View Comments</h1>

<p>Total: {$total}</p>

<table class="table table-striped table-hover">

    <tr>
        <td><b>Video</b></td>
        <td><b>User Name</b></td>
        <td><b>Comments</b></td>
        <td align="center"><b>Action</b></td>
    </tr>

    {foreach from=$comments item=comment}
        <tr>
            <td>
                <a href="video_details.php?id={$comment.comment_video_id}">
                    {$comment.comment_video_id}
                </a>
            </td>
            <td>
                <a href="user_view.php?user_id={$comment.comment_user_id}">
                    {$comment.user_name}
                </a>
            </td>
            <td>
                {$comment.comment_text}
            </td>
            <td align="center">
                <a href='comment_edit.php?action=edit&id={$comment.comment_id}&page={$page}' data-toggle="tooltip" data-placement="bottom" title="Edit">
                    <span class="glyphicon glyphicon-edit"></span>
                </a>
                <a href='comment.php?action=del&id={$comment.comment_id}&page={$page}' onclick='Javascript:return confirm("Are you sure you want to delete?");'>
                    <span class="glyphicon glyphicon-remove-circle" data-toggle="tooltip" data-placement="bottom" title="Delete"></span>
                </a>
            </td>
        </tr>
    {/foreach}

</table>

<div>
    {$links}
</div>

{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
{/literal}
