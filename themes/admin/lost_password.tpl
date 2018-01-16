<!DOCTYPE html>
<html lang="en">
<head>
<title>vShare Admin - Reset Password</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="{$base_url}/css/bootstrap.min.css" rel="stylesheet">
<body>

<div class="container">
    <div class="col-md-5 col-md-offset-2">
        <div class="page-header">
            <h1>Admin Password Reset</h1>
        </div>

        {if $smarty.request.submit eq ""}

        <span class="help-block">Click the button below to reset admin password.</span>

        <form method="post" action="">
            <input type="submit" name="submit" value="Reset Admin Password" class="btn btn-default btn-lg" />
        </form>

        {else}
            <div class="alert alert-success">Email sent to your admin email address with password reset information.</b>
        {/if}
    </div>
</div>

</body>
</html>