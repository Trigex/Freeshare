<div class="page-header">
    <h1>Tags ({$total})</h1>
</div>

{include file='admin/tags_menu.tpl'}

<table class="table table-striped">

    <tr>
        <td><b>Tag</b></td>
        <td width="10%"><b>Action</b></td>
    </tr>

    {section name=tag loop=$tags}

    <tr>
        <td>
            {$tags[tag].tag}
        </td>
        <td>
            <form method="post" action="">
                <input type="hidden" name="action_tag" value="{$tags[tag].id}" />
                {if $tags[tag].active eq 1}
                    <input type="submit" name="action" value="Disable" class="btn btn-warning" />
                {else if $tags[tag].active eq 0}
                    <input type="submit" name="action" value="Enable" class="btn btn-success" />
                {/if}
            </form>
        </td>
    </tr>

    {/section}

</table>

<div>
    {$links}
</div>
