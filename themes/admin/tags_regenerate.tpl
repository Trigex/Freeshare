<div class="page-header">
    <h1>Re-generate Tags</h1>
</div>

<p>This will regenerate all the tags based on the video keywords in the database.</p>

<br>

<form method="get" action="" class="form-horizontal" role="form">

    <div class="form-group">
        <label class="col-sm-4 control-label" for="items_per_page">Number of videos to process per cycle:</label>
        <div class="col-sm-5">
            <input class="form-control" type="text" name="items_per_page" id="items_per_page" value="{$result_per_page}">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-5">
            <button type="submit" name="tags_regenerate" class="btn btn-default btn-lg">Generate</button>
        </div>
    </div>

</form>


<div style="margin-top:4em"></div>