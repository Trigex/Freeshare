{if $todo != "finished"}

<div class="page-header">
    <h1>Import Folder Video</h1>
</div>

<form method="post" action="import_folder_form.php" class="form-horizontal" role="form">

    <div class="form-group">
        <label for="file_name" class="control-label col-md-2">File Name:</label>
        <div class="col-md-4">
            <p class="form-control-static">{$video_name}</p>
        </div>
    </div>

    {include file="admin/import_form.tpl"}

    <div class="form-group">
        <input type="hidden" name="video_name" value="{$video_name}">
        <div class="col-md-2 col-md-offset-2">
            <input type="submit" name="submit" value="Import Local Video" class="btn btn-default">
        </div>
    </div>

</form>

{/if}