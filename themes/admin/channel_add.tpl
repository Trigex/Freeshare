<div class="page-header">
    <h1>Add Channel</h1>
</div>

<form action="" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">

    <div class="form-group">
        <label class="col-sm-2 control-label" for="channel_name">Channel Name:</label>
        <div class="col-sm-5">
            <input class="form-control" name="channel_name" id="channel_name" value="{$smarty.post.channel_name}" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="channel_description">Channel Description:</label>
        <div class="col-sm-5">
            <textarea class="form-control" ea name="channel_description" id="channel_description" rows="3">{$smarty.post.channel_description}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="channel_image">Channel Image:</label>
        <div class="col-sm-5">
            <input class="form-control" type="file" name="channel_image" id="channel_image" />
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-5">
            <button type="submit" name="add_channel" class="btn btn-default btn-lg">Add Channel</button>
        </div>
    </div>

</form>