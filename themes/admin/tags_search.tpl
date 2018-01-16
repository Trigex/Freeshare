<div class="page-header">
    <h1>Search Tags</h1>
</div>

{include file='admin/tags_menu.tpl'}

<form method="post" action="" class="form-inline" role="form">
    <div class="form-group">
        <label class="sr-only" for="search_tag">Tag:</label>
        <input type="text" class="form-control" name="search_tag" id="search_tag" placeholder="Tag" />
    </div>
    <input type="submit" name="submit" value="Search" class="btn btn-default" />
</form>

<div style="margin-bottom: 2em"></div>

{if $tag ne ''}

    <table class="table table-striped">
        <tr>
            <td align="center">
                <b>ID</b>
            </td>
            <td align="center">
                <b>Tag</b>
            </td>
            <td align="center" width="10%">
                <b>Action</b>
            </td>
        </tr>

        {section name=i loop=$tag}

        <tr>
            <td>
                {$tag[i].id}
            </td>
            <td>
                {$tag[i].tag}
            </td>
            <td>
                <form method="post" action="">
                    <input type="hidden" name="action_tag" value="{$tag[i].id}" />
                    {if $tag[i].active eq 1}
                        <input type="submit" name="action" value="Disable" class="btn btn-default btn-lg" />
                    {else if $tag[i].active eq 0}
                        <input type="submit" name="action" value="Activate" class="btn btn-default btn-lg" />
                    {/if}
                </form>
            </td>
        </tr>

        {/section}
    </table>
{/if}
