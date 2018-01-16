<h1>Channel Sort Order</h1>

<form method="post" action="channel_sort.php">

    <table class="table table-striped table-hover">

        <tr>
            <td width="10%"><b>ID</b></td>
            <td width="70%"><b>Channel Name</b></td>
            <td width="20%">
                <b>Sort Order</b>
                <a href="channel_sort.php?sort=asc&page={$page}">
                    <span class="glyphicon glyphicon-arrow-up"></span>
                </a>
                <a href="channel_sort.php?sort=desc&page={$page}">
                    <span class="glyphicon glyphicon-arrow-down"></span>
                </a>
            </td>
        </tr>

        {section name=aa loop=$channels}

        <tr>
            <td>
                {$channels[aa].channel_id}
            </td>
            <td>
                {$channels[aa].channel_name}
            </td>
            <td align="center">
                <input type="hidden" name="id[]" value="{$channels[aa].channel_id}" />
                <input type="text" name="sortorder[]" value="{$channels[aa].channel_sort_order}" size="4" />
            </td>
        </tr>

        {/section}

    </table>

    <div class="row">
        <div class="col-md-10">
            {$link}
        </div>
        <div class="col-md-2">
            <input type="submit" name="submit" value="Update Sort Order" class="btn btn-default btn-lg" />
        </div>
    </div>

</form>
