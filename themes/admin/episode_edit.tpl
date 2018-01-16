<div class="page-header">
    <h1>Edit episode {$episode_info.episode_name}</h1>
</div>

<form class="form-horizontal" method="post" action="">
    <div class="form-group">
        <label class="control-label col-md-2">Name:</label>
        <div class="col-md-4">
            <input class="form-control" name="episode_name" id="episode_name" value="{$episode_info.episode_name}" required>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-2 col-md-offset-2">
            <input class="btn btn-default btn-lg" type="submit" name="submit" value="Save">
        </div>
    </div>
</form>