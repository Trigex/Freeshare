<div class="page-header">
    <h1>Edit comment</h1>
</div>

<form method="post" action="comment_edit.php?id={$comid}&page={$page}" class="form-horizontal">

    <input type="hidden" name="vid" value="{$vid}" />

    <div class="form-group">
        <label class="col-sm-2 control-label">Comment id:</label>
        <div class="col-sm-5">
            <p class="form-control-static">{$comid}</p>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">vid:</label>
        <div class="col-sm-5">
            <p class="form-control-static">{$vid}</p>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Comment:</label>
        <div class="col-sm-5">
            <textarea class="form-control" name="comments" rows="3">{$comments}</textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-5">
            <button type="submit" name="submit" class="btn btn-default btn-lg">Update</button>
        </div>
    </div>

</form>
