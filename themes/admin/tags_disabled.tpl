<div class="page-header">
    <h1>Disabled Tags</h1>
</div>

{include file='admin/tags_menu.tpl'}

<table class="table table-striped table-hover">

    <tr>
        <td>
            <b>Tag</b>
        </td>
        <td width="15%">
            <b>Action</b>
        </td>
    </tr>

    {section name=i loop=$tags}

        <tr>
            <td>
                {$tags[i].tag}
            </td>
            <td>
                <form method="post" action="">
                    <input type="hidden" name="action_tag" value="{$tags[i].id}" />
                    <input type="submit" name="action" value="Enable" class="btn btn-success" />
                </form>
            </td>
        </tr>

    {/section}

</table>