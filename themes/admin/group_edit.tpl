<div class="page-header">
    <h1>Edit Group</h1>
</div>

<form action="group_edit.php?a={$smarty.request.a}&action=edit&gid={$group.group_id}&page={$smarty.request.page}&sort={$smarty.request.sort}" method="post" class="form-horizontal">

	<div class="form-group">
		<label class="col-sm-2 control-label">Group ID:</label>
        <div class="col-sm-5">
            <p class="form-control-static">{$group.group_id}</p>
        </div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Group Name:</label>
        <div class="col-sm-5">
		  <input class="form-control" name="group_name" value="{$group.group_name}">
        </div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Tags:</label>
        <div class="col-sm-5">
		  <input class="form-control" name="keyword" value="{$group.group_keyword}">
        </div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Group Description:</label>
        <div class="col-sm-5">
			<textarea class="form-control" name="gdescn" rows="3">{$group.group_description}</textarea>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">URL Name:</label>
        <div class="col-sm-5">
		<input class="form-control" name="gurl" value="{$group.group_url}">
        </div>
	</div>

	<div class="form-group">
        <label class="col-sm-2 control-label">Channels:</label>
        <div class="col-sm-5">
			{$ch_checkbox}
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Group Type:</label>
        <div class="col-sm-5">
		  <select class="form-control" name="type">{$type_box}</select>
        </div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Video Uploads:</label>
        <div class="col-sm-5">
            <select class="form-control" name="gupload">{$upload_box}</select>
        </div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Forum Postings:</label>
        <div class="col-sm-5">
            <select class="form-control" name="gposting">{$posting_box}</select>
        </div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Group Icon:</label>
        <div class="col-sm-5">
            <select class="form-control" name="gimage">{$icon_box}</select>
        </div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Is Featured?:</label>
        <div class="col-sm-5">
            <select class="form-control" name="featured">{$featured_box}</select>
        </div>
	</div>

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-5">
            <button type="submit" name="submit" class="btn btn-default btn-lg">Update</button>
        </div>
	</div>

</form>