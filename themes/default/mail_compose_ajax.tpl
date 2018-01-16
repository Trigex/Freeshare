<div class="page-header">
    <h2>Compose</h2>
</div>

<form action="javascript:void(0);" id="frm" method="post" onsubmit="javascript:mail.send();" class="form-horizontal" role="form">
    <div class="form-group">
        <label class="control-label col-md-2">Username:</label>
        <div class="col-md-6">
            <input type="text" name="mail_to" id="mail_to" maxlength="40" value="{$mail_to}" class="form-control" required>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">Subject:</label>
        <div class="col-md-6">
            <input type="text" name="mail_subject" id="mail_subject" value="{$mail_subject}" maxlength="200" class="form-control" required>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">Message:</label>
        <div class="col-md-8">
            <textarea name="mail_body" id="mail_body" class="form-control" rows="5">{$mail_body}</textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-2 col-md-offset-2">
            <button type="submit" name="send" class="btn btn-default btn-lg">Send</button>
        </div>
    </div>
</form>