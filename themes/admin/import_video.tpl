{if $finished eq ''}

<div class="page-header">
    <h1>Import Video</h1>
</div>

<form method="post" action="import_video.php" id="import-video" name="import-video" class="form-horizontal" role="form">

    <div class="form-group">
        <label class="col-sm-2 control-label" for="video_url">Video URL:</label>
        <div class="col-sm-5">
            <input class="form-control" type="url" name="video_url" id="video_url" value="{$smarty.post.video_url}" placeholder="http://site.com/video.mp4" required>
            <span class="help-block">Allowed formats: {$allowed_types}</span>
        </div>
    </div>

    {include file="admin/import_form.tpl"}

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-5">
            <button type="submit" name="submit" class="btn btn-default btn-lg">Download Video</button>
        </div>
    </div>

</form>

{else}

<br>

<center>
    <a href="import_video.php" class="btn btn-default btn-lg">Import Another Video</a>
</center>

{/if}