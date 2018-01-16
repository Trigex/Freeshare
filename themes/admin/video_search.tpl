{if empty($video_info)}

<div class="page-header">
    <h1>Video Search</h1>
</div>

<form action="" method="get" class="form-horizontal" role="form">

    <div class="form-group">
        <label class="col-sm-3 control-label">Video ID:</label>
        <div class="col-sm-5">
            <input class="form-control" type="text" name="id">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label">Video FLV Name:</label>
        <div class="col-sm-5">
            <input class="form-control" type="text" name="video_flv_name">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label">Video Name:</label>
        <div class="col-sm-5">
            <input class="form-control" type="text" name="video_name">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label">Video Title:</label>
        <div class="col-sm-5">
            <input class="form-control" type="text" name="video_title">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label">Video Description:</label>
        <div class="col-sm-5">
            <input class="form-control" type="text" name="video_description">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-5">
            <button type="submit" name="search" class="btn btn-default btn-lg">Search</button>
        </div>
    </div>
</form>

{else}

    <div class="page-header">
        <span class="badge pull-right">Total: {$total}</span>
        <h1>Search Results for: {$search_string}</h1>
    </div>

    <table class="table table-striped table-hover">

        <tr>

            <td>
                <b>Title</b>
                <a href="?search=Search&{$search_query}&sort=video_title+asc">
                    <span class="glyphicon glyphicon-arrow-up"></span>
                </a>
                <a href="?search=Search&{$search_query}&sort=video_title+desc">
                    <span class="glyphicon glyphicon-arrow-down"></span>
                </a>
            </td>
            <td>
                <b>Type</b>
                <a href="?search=Search&{$search_query}&sort=video_type+asc">
                    <span class="glyphicon glyphicon-arrow-up"></span>
                </a>
                <a href="?search=Search&{$search_query}&sort=video_type+desc">
                    <span class="glyphicon glyphicon-arrow-down"></span>
                </a>
            </td>
            <td>
                <b>Duration</b>
                <a href="?search=Search&{$search_query}&sort=video_duration+asc">
                    <span class="glyphicon glyphicon-arrow-up"></span>
                </a>
                <a href="?search=Search&{$search_query}&sort=video_duration+desc">
                    <span class="glyphicon glyphicon-arrow-down"></span>
                </a>
            </td>
            <td>
                <b>Featured</b>
                <a href="?search=Search&{$search_query}&sort=video_featured+asc">
                    <span class="glyphicon glyphicon-arrow-up"></span>
                </a>
                <a href="?search=Search&{$search_query}&sort=video_featured+desc">
                    <span class="glyphicon glyphicon-arrow-down"></span>
                </a>
            </td>
            <td>
                <b>Date</b>
                <a href="?search=Search&{$search_query}&sort=video_add_date+asc">
                    <span class="glyphicon glyphicon-arrow-up"></span>
                </a>
                <a href="?search=Search&{$search_query}&sort=video_add_date+desc">
                    <span class="glyphicon glyphicon-arrow-down"></span>
                </a>
            </td>
            <td align="center">
                <b>Action</b>
            </td>
        </tr>

        {section name=aa loop=$video_info}

            <tr>

                <td>
                    <a href="video_details.php?a={$a}&id={$video_info[aa].video_id}&page={$page}">{$video_info[aa].video_title|truncate:60:"...":true}</a>
                </td>
                <td align="center">
                    {$video_info[aa].video_type}
                </td>
                <td align="center">
                    {$video_info[aa].video_length}
                </td>
                <td align="center">
                    {$video_info[aa].video_featured}
                </td>
                <td align="center">
                    {$video_info[aa].video_add_date|date_format}
                </td>
                <td align="center">
                    <a href="video_edit.php?action=edit&video_id={$video_info[aa].video_id}&sort={$smarty.request.sort}">
                        <span class="glyphicon glyphicon-edit"></span>
                    </a>
                </td>
            </tr>

        {/section}

    </table>

{/if}