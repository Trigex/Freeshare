<div class="page-header">
    <h1>Delete Inactive Users</h1>
</div>

<p>This will delete all users who have signed up before 30 days and have account status 'Inactive' and have no videos/comments etc.</p>

<br>

<form method="get" action="" class="form-horizontal" role="form">
    <input type="hidden" name="action" value="delete">

    <div class="form-group">
        <label class="col-md-4 control-label">Number of Users to process per cycle:</label>
        <div class="col-md-2">
            <input class="form-control" type="text" name="items_per_page" id="items_per_page" value="{$result_per_page}">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-2 col-md-offset-4">
            <button type="submit" class="btn btn-default btn-lg" name="submit">Delete Users</button>
        </div>
    </div>
</form>