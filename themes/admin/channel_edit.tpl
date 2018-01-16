<div class="page-header">
    <h1>Edit Channel</h1>
</div>


<form action="channel_edit.php" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">

    <input type="hidden" name="id" value="{$channel.channel_id}">

    <div class="form-group">
        <label class="col-sm-2 control-label" for="channel_name">Channel Name:</label>
        <div class="col-sm-5">
            <input class="form-control" name="name" id="channel_name" value="{$channel.channel_name}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="channel_description">Channel Description:</label>
        <div class="col-sm-5">
            <textarea class="form-control" name="descrip" id="channel_description" rows="3">{$channel.channel_description}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Channel Image:</label>
        <div class="col-sm-5">
            <img src="{$base_url}/chimg/{$channel.channel_id}.jpg" alt="">
            <input class="form-control" type="file" name="picture">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-5">
            <button type="submit" name="edit_channel" class="btn btn-default btn-lg">Update</button>
        </div>
    </div>

</form>