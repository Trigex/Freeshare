<div class="page-header">
    <h1>List Pages</h1>
</div>

<table class="table table-striped table-hover">

<tr>
    <td><b>Id</b></td>
    <td><b>Name</b></td>
    <td><b>Title</b></td>
    <td><b>Counter</b></td>
    <td><b>Members Only</b></td>
    <td align="center"><b>Action</b></td>
</tr>

{section name=i loop=$pages}

<tr>
    <td>{$pages[i].page_id}</td>
    <td>{$pages[i].page_name}</td>
    <td>{$pages[i].page_title}</td>
    <td>{$pages[i].page_counter}</td>
    <td>{if $pages[i].page_members_only eq "1"}Yes{else}No{/if}</td>
    <td align="center">
        <a href="{$base_url}/pages/{$pages[i].page_name}.html" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Preview">
            <span class="glyphicon glyphicon-file"></span>
        </a> &nbsp;
        <a href='page_edit.php?id={$pages[i].page_id}' data-toggle="tooltip" data-placement="bottom" title="Edit">
            <span class="glyphicon glyphicon-edit"></span>
        </a> &nbsp;
        <a href='page.php?action=del&id={$pages[i].page_id}' onclick='Javascript:return confirm("Are you sure want to delete?");' data-toggle="tooltip" data-placement="bottom" title="Delete">
            <span class="glyphicon glyphicon-remove-circle"></span>
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
