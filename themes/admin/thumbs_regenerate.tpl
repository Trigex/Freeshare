<div class="page-header">
    <h1>Regenerate Video Thumbnails</h1>
</div>

<form method="get" action="" class="form-horizontal" role="form">
    <div class="form-group">
        <label class="col-sm-4 control-label" for="items_per_page">Number of videos to process per cycle:</label>
        <div class="col-sm-5">
            <input class="form-control" type="text" name="items_per_page" id="items_per_page" value="{$result_per_page}">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-5">
            <button type="submit" name="thumbs_regenerate" class="btn btn-default btn-lg">Generate</button>
        </div>
    </div>
</form>