<div class="page-header">
    <a class="btn btn-default pull-right" href="javascript:void(0)" onclick="inappropriate_cancel();" title="Close">
        <span class="glyphicon glyphicon-remove"></span>
    </a>
    <h3>Report this video</h3>
</div>
<form id="video-report-form" name="form1" onsubmit="javascript:feedback();" method="post" action="javascript:void(0)" class="form-horizontal">
    <div class="form-group">
        <label class="control-label col-md-2">Type of abuse</label>
        <div class="col-md-4 col-sm-6">
            <select name="abuse_type" id="abuse_type" class="form-control">
                <option value="">Select a category</option>
                <option value="porn">Porn</option>
                <option value="racism">Racism</option>
                <option value="prohibited">Prohibited</option>
                <option value="violent">Violent</option>
                <option value="copyright">Copyright</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">Comments</label>
        <div class="col-md-6 col-sm-6">
            <textarea name="abuse_comments" id="abuse_comments" rows="4" class="form-control"></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-2 col-md-offset-2">
            <button type="submit" class="btn btn-default" name="send">Send</button>
        </div>
    </div>
    <div class="clearfix"></div>
</form>