<div class="col-md-12">
    <div class="page-header">
        <h1>Forgot your password?</h1>
    </div>

    <form method="post" action="{$base_url}/recoverpass.php" id="recover-password" class="form-horizontal" role="form">
        <div class="form-group">
            <label class="control-label col-md-2">User Name:</label>
            <div class="col-md-4">
                <input type="text" name="username" value="{$smarty.post.username}" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-3">-- OR --</div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Email Address:</label>
            <div class="col-md-4">
                <input type="email" name="email" value="{$smarty.post.email}" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-3">
                <button type="submit" name="recover" class="btn btn-default btn-lg">Submit</button>
            </div>
        </div>
    </form>

</div>