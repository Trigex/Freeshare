{if $activation_mail_sent eq ""}

<div class="col-md-12">
    <div class="page-header">
        <h1>Send Activation E-Mail</h1>
    </div>

    <p class="lead text-muted">This is the email associated with your account. Once you click the "Resend Activation Mail" button, you will get mail with activation link. If you do not see activation mail in Inbox, check your spam box also.</p>
    <p class="lead text-muted">If you can't get email on email address used to register, just change the email address below and click "Resend Activation Mail" button.</p>

    <form action="" method="post" class="form-horizontal" role="form">
        <div class="form-group">
            <label class="control-label col-md-2">E-Mail Address:</label>
            <div class="col-md-4">
                <input type="email" name="email" value="{$user_email}" maxlength="100" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-2 col-md-offset-2">
                <button type="submit" name="submit" class="btn btn-default btn-lg">Resend Activation Mail</button>
            </div>
        </div>
    </form>

</div>

{else}

<center><h4>The activation e-mail has been sent to your e-mail address.</h4></center>

{/if}