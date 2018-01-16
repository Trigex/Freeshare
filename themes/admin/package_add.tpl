<div class="page-header">
    <h1>Add Package</h1>
</div>

<form method="post" action="" enctype="multipart/form-data" class="form-horizontal" role="form">

    <div class="form-group">
        <label class="col-sm-2 control-label" for="pack_name">Package Name:</label>
        <div class="col-sm-5">
            <input class="form-control" name="pack_name" id="pack_name" value="{$smarty.post.pack_name}" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="pack_desc">Description:</label>
        <div class="col-sm-5">
            <textarea class="form-control" name="pack_desc" id="pack_desc" rows="5">{$smarty.post.pack_desc}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="space">Space (MB):</label>
        <div class="col-sm-5">
            <input class="form-control" name="space" id="space" value="{$smarty.post.space}" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="video_limit">Video Limit:</label>
        <div class="col-sm-5">
            <input class="form-control" name="video_limit" id="video_limit" value="{$smarty.post.video_limit}" />
            <p class="help-block">Leave blank or enter 0 for unlimited upload.</p>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="price">Price (USD):</label>
        <div class="col-sm-5">
            <input class="form-control" name="price" id="price" value="{$smarty.post.price}" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="period">Subscription Period:</label>
        <div class="col-sm-5">
            <select class="form-control" name="period" id="period">{$period_ops}</select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="status">Status:</label>
        <div class="col-sm-5">
            <select class="form-control" name="status" id="status">{$status_ops}</select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-5">
            <button type="submit" name="add_package" class="btn btn-default btn-lg">Add Package</button>
        </div>
    </div>

</form>